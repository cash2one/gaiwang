<?php

/**
 * 会员积分额度等级控制器 
 * 操作 (添加,修改,删除)
 * @author wyee <yanjie.wang@g-emall.com>
 */
class MemberPointGradeController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 添加会员积分额度级别
     */
    public function actionCreate() {
        $model = new MemberPointGrade();
        $this->performAjaxValidation($model);
        if (isset($_POST['MemberPointGrade'])) {
            $model->attributes = $_POST['MemberPointGrade'];
            $model->admin=$this->getUser()->id;
            $model->create_time=time();
            $model->update_time=time();
            if ($model->save()) {
            	@SystemLog::record(Yii::app()->user->name."添加会员积分额度级别：".$model->grade_name);
                $this->setFlash('success', Yii::t('member', '添加会员积分额度成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 修改会员积分额度级别
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        $oldGradePoint = $model->grade_point;
        $oldDayUsablePoint = $model->day_usable_point;
        $oldMonthUsablePoint = $model->month_usable_point;
        if (isset($_POST['MemberPointGrade'])) {
            $model->attributes = $_POST['MemberPointGrade'];
            $model->admin=$this->getUser()->id;
            $model->update_time=time();
            if ($model->save()) {
            	if(($oldGradePoint !=  $model->grade_point) || ($oldDayUsablePoint !=  $model->day_usable_point) ||($oldMonthUsablePoint !=  $model->month_usable_point)){
            		self::ResetGradeType($model->id);
            	}
            	@SystemLog::record(Yii::app()->user->name."修改会员积分额度级别：".$model->grade_name);
                $this->setFlash('success', Yii::t('member', '修改会员积分额度级别成功'));
                $this->redirect(array('admin'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 会员积分额度级别管理
     */
    public function actionAdmin() {
        $model = new MemberPointGrade('search');
        $model->unsetAttributes();
        if (isset($_GET['MemberPointGrade']))
            $model->attributes = $_GET['MemberPointGrade'];
        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    
    /**
     * ajax获取某个级别配置的日月可用额度
     */
    public function actionGetPoint(){
    	
    	$gradeId = $this->getPost('GradeId');
    	$gradeRes = $goods =Yii::app()->db->createCommand()
					->select('day_usable_point,month_usable_point')
					->from(MemberPointGrade::model()->tablename())
					->where('id = :id',array(":id"=>$gradeId))
					->queryRow();
    	exit(json_encode($gradeRes));
    	
    }
    
    
    /**
     * 更新某个级别的会员日月可用额度
     * @gradeId 级别配置表的ID
     */
    private static function ResetGradeType($gradeId){
    	set_time_limit(800);
    	$db = Yii::app()->db;
    	
    	//获取等级配置表的信息
    	$gradeInfo = $db->createCommand()->select("*")->from(MemberPointGrade::model()->tablename())->where("id = {$gradeId}")->queryRow();
   
    	//获取会员配置表中的信息
    	$GradememberInfo = $db->createCommand()->select("t.id as pid,t.day_point,t.month_point,t.day_limit_point,t.month_limit_point")
    	->from(MemberPoint::model()->tablename() ." as t")
    	->where("t.special_type = ".MemberPoint::SPECIAL_TYPE_AUTO." and t.grade_id = {$gradeId}")
    	->queryAll();
    	
    	//变量初始化
    	$sqlArr = array();
    	$number = 0;
    	$time = time();
    	$admin = YII::app()->user->id;
    	$id = "";
    	$gradeIdWhen = "";$dayLimitPointWhen = "";$monthLimitPointWhen = "";$dayPoint = "";$monthPoint = "";
    	
    	foreach ($GradememberInfo as $key=>$val){
    		$id .= $val["pid"].",";
    		$number++;
    		//日可用额度  配置表的日可用额度-（会员配置表的日额度-会员配置表的日可用额度）
    		$tempDayLimitPoint = $gradeInfo["day_usable_point"] - ($val["day_point"] - $val["day_limit_point"]);
    		$dayLimitPointWhen .= " when {$val["pid"]} then {$tempDayLimitPoint}";
    		//月可用额度
    		$tempMonthLimitPoint = $gradeInfo["month_usable_point"] - ($val["month_point"] - $val["month_limit_point"]);
    		$monthLimitPointWhen .= " when {$val["pid"]} then {$tempMonthLimitPoint}";
    		//日额度
    		$dayPoint .= " when {$val["pid"]} then {$gradeInfo["day_usable_point"]}";
    		//月额度
    		$monthPoint .= " when {$val["pid"]} then {$gradeInfo["month_usable_point"]}";
    		if((($number % 80000) == 0) || ($key == (count($GradememberInfo) - 1))){
    			$id = substr($id,0,-1);
    			$sql = "UPDATE gw_member_point SET
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
    	foreach ($sqlArr as $sqlVal){
    		 $db->createCommand($sqlVal)->execute();
    	}
    	
    }

}
