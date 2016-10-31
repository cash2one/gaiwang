<?php

/**
 * 会员积分额度控制器 
 * 操作 (添加,修改,删除)
 * @author  wyee<yanjie.wang@g-emall.com>
 */
class MemberPointController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 添加会员积分额度
     */
    public function actionCreate() {
        $model = new MemberPoint();
        $this->performAjaxValidation($model);
        if (isset($_POST['MemberPoint'])) {
	            $model->attributes = $_POST['MemberPoint'];
	            $memGw=$_POST['MemberPoint']['member_id'];
	            $memInfo=Member::getUserInfoByGw($memGw,'id');
            if(!$memInfo){
               $this->setFlash('error', Yii::t('member', '会员不存在'));
            }else{
	            $model->member_id=$memInfo['id'];
	            $model->admin=$this->getUser()->id;
	            $model->create_time=time();
	            $model->update_time=time();
	            if ($model->save()) {
	            	@SystemLog::record(Yii::app()->user->name."添加会员积分额度：".$memGw);
	                $this->setFlash('success', Yii::t('member', '添加会员积分额度')); 
	            }
           }
           $this->redirect(array('admin'));
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改会员级别
     */
     public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $memberInfo=Member::getInfoById($model->member_id,'gai_number');
        $model->member_id=$memberInfo['gai_number'];
/*         $gradeArr=MemberPointGrade::getGradeName($model->grade_id);
        $model->grade_id=$gradeArr['grade_name']; */
        $this->performAjaxValidation($model);
        if (isset($_POST['MemberPoint'])) {
            $oldDayPoint = $model->day_point;
            $oldMonthPoint = $model->month_point;
            $model->attributes = $_POST['MemberPoint'];
            $memberInfo=Member::getUserInfoByGw($model->member_id,'id');
            $model->member_id = $memberInfo["id"];
            $model->admin=$this->getUser()->id;
            $model->update_time=time();

            //更新时计算日可用和月可用
            $model->day_limit_point = $model->day_point - ($oldDayPoint - $model->day_limit_point);
            $model->month_limit_point = $model->month_point - ($oldMonthPoint - $model->month_limit_point);

            if ($model->save(false)) {

              @SystemLog::record(Yii::app()->user->name."修改会员级别：".$model->member_id);
                $this->setFlash('success', Yii::t('member', '修改会员级别成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 会员级别管理
     */
    public function actionAdmin() {
        $model = new MemberPoint('search');
        $model->unsetAttributes();
        if (isset($_GET['MemberPoint']))
            $model->attributes = $_GET['MemberPoint'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionResetGrade(){
    	try {
    		set_time_limit(800);
    		$db = Yii::app()->db;
    		//获取会员配置表中需要重置的会员余额等信息
    		$GradememberInfo = $db->createCommand()->select("t.id as pid,t.day_point,t.month_point,t.day_limit_point,t.month_limit_point,m.gai_number,m.id,m.type_id,m.mobile,m.username")->from(MemberPoint::model()->tablename() ." as t")
    		->leftjoin(Member::model()->tablename() ." as m","t.member_id = m.id")
    		//->rightjoin("account.gw_account_balance as ac","ac.gai_number = m.gai_number")
    		//->rightjoin("account.gw_account_balance_history as ach","ach.gai_number = m.gai_number")
    		->where("t.special_type = ".MemberPoint::SPECIAL_TYPE_AUTO)
    		->queryAll();

    		$data=MemberPointGrade::getAllGrade();//获取等级配置信息
    		if(!$data){//无等级配置信息
    			exit(json_encode(array("result"=>true)));
    		}
    		//变量初始化
    		$sqlArr = array();
    		$number = 0;
    		$time = time();
    		$admin = $this->getUser()->id;
    		$id = "";
    		$gradeIdWhen = "";$dayLimitPointWhen = "";$monthLimitPointWhen = "";$dayPoint = "";$monthPoint = "";
    		
    		foreach ($GradememberInfo as $key=>$val){
    			$id .= $val["pid"].",";
    			$number++;
    			
    			 $memberArray = array(
                    'id' => $val['id'],
                    'gai_number' => $val['gai_number'],
                    'type_id' => $val['type_id'],
                    'mobile' => $val['mobile'],
                    'username' => $val['username'],
                    'account_id'=>$val['id'],
                    'type'=>AccountInfo::TYPE_CONSUME,
            );
    			//当前会员余额(旧余额+新余额)
    			$balance = AccountBalance::findRecord($memberArray,true);//会员消费账户
    			$balanceHistory = AccountBalanceHistory::findRecord($memberArray,true); //会员历史消费账户
    			if($balanceHistory){
    				$accountMoney = $balanceHistory['today_amount'] + $balance['today_amount'];
    			}else{
    				$accountMoney = $balance['today_amount'];
    			}
    			$totalMoney = $accountMoney;//$val["today_amount"] + $val["history_today_amount"];
    			$gradeData = MemberPointGrade::getGradeInfo($totalMoney,$data);
    			
    			//级别
    			$gradeIdWhen .= " when {$val["pid"]} then {$gradeData["id"]}";
    			//日可用额度  配置表的日可用额度-（会员配置表的日额度-会员配置表的日可用额度）
    			$tempDayLimitPoint = $gradeData["day_usable_point"] - ($val["day_point"] - $val["day_limit_point"]);
    			$dayLimitPointWhen .= " when {$val["pid"]} then {$tempDayLimitPoint}";
    			//月可用额度
    			$tempMonthLimitPoint = $gradeData["month_usable_point"] - ($val["month_point"] - $val["month_limit_point"]);
    			$monthLimitPointWhen .= " when {$val["pid"]} then {$tempMonthLimitPoint}";
    			//日额度
    			$dayPoint .= " when {$val["pid"]} then {$gradeData["day_usable_point"]}";
    			//月额度
    			$monthPoint .= " when {$val["pid"]} then {$gradeData["month_usable_point"]}";
    			if((($number % 80000) == 0) || ($key == (count($GradememberInfo) - 1))){
    				$id = substr($id,0,-1);
					$sql = "UPDATE gw_member_point SET 
					grade_id = CASE id
					   {$gradeIdWhen}
					END,
					day_limit_point = CASE id
					   {$dayLimitPointWhen}
					END,
					month_limit_point = CASE id
					   {$monthLimitPointWhen}
					END,
					day_point = case id
					    {$dayPoint}
					END,
					month_point = case id
					    {$monthPoint}  
					END,
					update_time = '{$time}',
					admin = '{$admin}' 
					where id in ({$id})";
					$number = 0; $gradeIdWhen = ""; $dayLimitPointWhen = ""; $monthLimitPointWhen = "";$dayPoint = "";$monthPoint = "";$id = "";
					array_push($sqlArr, $sql);
    			}
    		}
    		$transaction = $db->beginTransaction();
    		foreach ($sqlArr as $sqlVal){
    			$db->createCommand($sqlVal)->execute();
    		}
    		$transaction->commit();
    		exit(json_encode(array("result"=>true)));
    	} catch (Exception $e) {
    		$transaction->rollBack();
    		exit(json_encode(array("result"=>false,"message"=>$e->getMessage())));
    	}
    }

}
