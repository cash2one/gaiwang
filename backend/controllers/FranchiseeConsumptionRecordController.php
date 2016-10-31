<?php
//Yii::app()->end();
class FranchiseeConsumptionRecordController extends Controller {

    public function filters() {
        return array(
            'rights',
            'postRequest + confirm',
        );
    }

	/**
	 * 不作权限控制的action
	 * @return string
	 */
	public function allowedActions() {
		return 'examineInfo';
	}

    /**
     * Manages all models.
     * 加盟商对账
     */
    public function actionAdmin() {
        $model = new FranchiseeConsumptionRecord('search');
        $model->unsetAttributes();  // clear any default values
        $model->setScenario(DbCommand::DB);//从数据
        if (isset($_GET['FranchiseeConsumptionRecord']))
        {
        	$model->attributes = $_GET['FranchiseeConsumptionRecord'];
//        	$model->data_style = $_GET['FranchiseeConsumptionRecord']['data_style'];
            $model->gai_number = $_GET['FranchiseeConsumptionRecord']['gai_number'];
            /*
            if($model->end_time == false){
                $model->end_time = date('Y-m-d H:i:s');
            }
            if($model->start_time == false){
                $this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '必须设定账单时间的开始时间进行查询!'));
                $this->redirect(array('admin'));
            }elseif(strtotime($model->end_time) - strtotime($model->start_time) > (30*86400)){
                $this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '由于数据量太大,请账单时间范围不要超出30天!'));
                $this->redirect(array('admin'));
            }*/
        }else{
            $model->start_time = date('Y-m-d',time()-180*86400);
        }
            
        $this->showExport = true;
        $this->exportAction = 'adminExport';

        $totalCount = $model->search()->getTotalItemCount();
        $page = new CPagination($totalCount);
        $page->pageVar = 'FranchiseeConsumptionRecord_page';
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'franchiseeConsumptionRecord/adminExport';
        $exportPage->params = array_merge(array('exportType' => 'Excel5', 'grid_mode' => 'export'),$_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('admin', array(
            'model' => $model,
        	'page'=>$page,
            'exportPage' => $exportPage,
        	'totalCount'=>$totalCount,
        ));
    }
    
    
	/**
     * Manages all models.
     * 加盟商对账导出excel
     */
    public function actionAdminExport() {
        set_time_limit(0);
        $model = new FranchiseeConsumptionRecord('search');
        $model->unsetAttributes();  // clear any default values
        $model->setScenario(DbCommand::DB);//从数据

        if (isset($_GET['FranchiseeConsumptionRecord'])){
            $model->attributes = $_GET['FranchiseeConsumptionRecord'];
            $model->gai_number = $_GET['FranchiseeConsumptionRecord']['gai_number'];
            @SystemLog::record(Yii::app()->user->name."导出加盟商对账列表");

            $model->isExport = 1;
            $this->render('adminExport', array(
                'model' => $model,
            ));
        }else{
            $this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '由于数据量太大,请在导出前设置查询条件!'));
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }
    

    /**
     * 加盟商对账确认单 
     */
    public function actionConfirm() {
        $ids = $this->getQuery('batchReconciliation_ids');  //要对账的记录id
        if ($ids) {
            $ids = explode(',', $ids);
            $records = FranchiseeConsumptionRecord::batchReconciliation($ids);
            $this->render('confirm', array('records' => $records));
        }
        if (isset($_POST['record_ids'])) {
            $record_ids = $this->getPost('record_ids');

            //未对账       申请对账       对账       申请撤销         撤销 
	        if (!empty($record_ids)){
	    		$sql = "select id from ".FranchiseeConsumptionRecord::model()->tableName()." where id in (".$record_ids.") and is_distributed = ".FranchiseeConsumptionRecord::STATUS_NOTCHECK;
	    		$ids_arr = Yii::app()->db->createCommand($sql)->queryAll();
	    		if (empty($ids_arr)){
	    			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '申请对账失败!该记录已对账或已撤销'));
	    		}else{
	    			$table = FranchiseeConsumptionRecordConfirm::model()->tableName();
	    			$reback_ids_arr = IntegralOfflineNew::getRebackData($record_ids);				//获取状态为撤销或者申请中的线下交易记录
	    			$consumption_ids_arr = IntegralOfflineNew::getConsumptionData($record_ids);		//获取状态为对账或者申请对账中的线下交易记录
	    			
	    			$is_wrong = false;
	    			$sqlValue = "";
	    			$serial_number = Tool::buildOrderNo(20,'SQDZ');
	    			$user_id = Yii::app()->user->id;
	    			$time = time();
	    			foreach ($ids_arr as $key=>$val){
		    			if (in_array($val['id'], $reback_ids_arr)){			//如果已经申请撤销或已经撤销
		    				$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '申请对账失败!有记录已申请撤销或已经撤销'));
		    				$is_wrong = true;
		    				break;
		    			}
		    			if (in_array($val['id'], $consumption_ids_arr)){	//如果已经申请对账，或已经对账
		    				$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '申请对账失败!有记录已申请对账'));
		    				$is_wrong = true;
		    				break;
		    			}
		    			$sqlValue.= "('".$serial_number."',".$val['id'].",".Yii::app()->user->id.",".$time.",0),";
	    			}
	    			
	    			if (!$is_wrong && $sqlValue != ''){
		    			$sql = "insert into ".$table."(serial_number,record_id,apply_user_id,apply_time,status) values".substr($sqlValue, 0, -1);
						$result = Yii::app()->db->createCommand($sql)->execute();
						if ($result){
		    				$this->setFlash('success', Yii::t('franchiseeConsumptionRecord', '申请对账成功!'));
						}else{
							$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '申请对账失败!'));
						}
	    			}
	    		}
	    	}
	    	$this->redirect(array('franchiseeConsumptionRecord/admin'));
        }
    }

	/**
	 * ajax获取申请对账、撤销对账审核信息
	 */
	public function actionExamineInfo(){
		if ($this->isAjax() && $this->isPost()) {
			$userTable = User::model()->tableName();
			$id = $this->getPost('id');
			$type = $this->getPost('type');
			$status = $this->getPost('status');
			if($type == 'confirm'){
				$table = FranchiseeConsumptionRecordConfirm::model()->tableName();
			}
			elseif($type == 'repeal'){
				$table = FranchiseeConsumptionRecordRepeal::model()->tableName();
			}
			else exit(json_encode(array('error'=>'请求非法')));

			if($status == FranchiseeConsumptionRecordConfirm::STATUS_PASS){
				$select = 'u.username,t.agree_time as time,t.status';
				$leftJoin = " t.agree_user_id = u.id";
			}elseif($status == FranchiseeConsumptionRecordConfirm::STATUS_REFUSE){
				$select = 'u.username,t.refuse_time as time,t.status';
				$leftJoin = " t.refuse_user_id = u.id";
			} elseif($status == FranchiseeConsumptionRecordConfirm::STATUS_AUDITI){
				$select = 'u.username,t.auditi_time as time,t.status';
				$leftJoin = " t.auditi_user_id = u.id";
			}else exit(json_encode(array('error'=>'请求非法')));
			$result = Yii::app()->db->createCommand()
								->select($select)
								->from($table . ' as t')
								->leftJoin($userTable . ' as u', $leftJoin)
								->where('t.id='.$id)
 								->queryRow();
			if(!empty($result)){
				exit(json_encode(array('username'=>$result['username'],
										'time'=>date('Y-m-d H:i:s', $result['time']),
										'status'=>$type == 'confirm'?FranchiseeConsumptionRecordConfirm::getApplyStatus($result['status']) : FranchiseeConsumptionRecordRepeal::getBackStatus($result['status']),
				)));
			}else exit;
		}
	}
    
    /**
     * 加盟商对账申请
     */
    public function actionConsumptionApply(){
    	$model = new FranchiseeConsumptionRecordConfirm();
    	
    	
    	if (isset($_GET['FranchiseeConsumptionRecordConfirm']))
        {
        	$model->attributes = $_GET['FranchiseeConsumptionRecordConfirm'];
        	$model->franchisee_name = $_GET['FranchiseeConsumptionRecordConfirm']['franchisee_name'];
        	$model->franchisee_code = $_GET['FranchiseeConsumptionRecordConfirm']['franchisee_code'];
        	$model->franchisee_mobile = $_GET['FranchiseeConsumptionRecordConfirm']['franchisee_mobile'];
        	$model->franchisee_province_id = $_GET['FranchiseeConsumptionRecordConfirm']['franchisee_province_id'];
        	$model->franchisee_city_id = $_GET['FranchiseeConsumptionRecordConfirm']['franchisee_city_id'];
        	$model->franchisee_district_id = $_GET['FranchiseeConsumptionRecordConfirm']['franchisee_district_id'];
        	$model->status = $_GET['FranchiseeConsumptionRecordConfirm']['status'];
        	$model->start_time = $_GET['FranchiseeConsumptionRecordConfirm']['start_time'];
        	$model->end_time = $_GET['FranchiseeConsumptionRecordConfirm']['end_time'];
            $model->gai_number = $_GET['FranchiseeConsumptionRecordConfirm']['gai_number'];
        }
        
    	$totalCount = $model->search()->getTotalItemCount();
        $page = new CPagination($totalCount);
        $lists = $model->search();
        $lists_data = $lists->getData();
        $page = $lists->pagination;
    	$this->render('consumptionapply',array('model'=>$model,'page'=>$page));
    }

    /**
     * 加盟商对账同意
     */
    public function actionConsumptionPass(){
        try {
        	$pass_ids = $_POST['pass_ids'];
        	if (strpos($pass_ids ,",")){
        		$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '对账申请通过失败!一次只能通过一个对账申请!'));
        		$this->redirect(array('franchiseeConsumptionRecord/consumptionApply'));
        		Yii::app()->end();
        	}
    		$table = FranchiseeConsumptionRecordConfirm::model()->tableName();
    		
    		$language = Yii::app()->language;
    		
    		$sql = "select record_id from ".$table." where id = '".$pass_ids."' and status = ".FranchiseeConsumptionRecordConfirm::STATUS_AUDITI;
    		$record_id = Yii::app()->db->createCommand($sql)->queryScalar();
    		
    		if (empty($record_id)){	//判断在申请对账的表中的对应记录的状态是不是申请
    			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '请先审核对账!'));
        		$this->redirect(array('franchiseeConsumptionRecord/consumptionApply'));
        		Yii::app()->end();
    		}
    		
    		$rs = OfflineAccountNew::balanceAccount($record_id);
    		Yii::app()->language = $language;
         	if($rs === true){
    			$this->setFlash('success', Yii::t('franchiseeConsumptionRecord', '对账成功！'));
    		}else{
    			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', $rs['content']));
    		}
        	$this->redirect(array('franchiseeConsumptionRecord/consumptionApply'));
        }catch (Exception $e){
            $this->setFlash('error', Yii::t('franchiseeConsumptionRecord', $e->getMessage()));
            $this->redirect(array('franchiseeConsumptionRecord/consumptionApply'));
            Yii::app()->end();
        }
    }
    
    /**
     * 加盟商对账拒绝
     */
    public function actionConsumptionFail(){
    	$fail_ids = $_POST['fail_ids'];
    	if (strpos($fail_ids ,",")){
    		$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '拒绝对账申请失败!一次只能拒绝一个!'));
    		$this->redirect(array('franchiseeConsumptionRecord/consumptionApply'));
    		Yii::app()->end();
    	}
		$table = FranchiseeConsumptionRecordConfirm::model()->tableName();
		
    	$sql = "select id from ".$table." where id = ".$fail_ids." and (status = ".FranchiseeConsumptionRecordConfirm::STATUS_APPLY. " or status =".FranchiseeConsumptionRecordConfirm::STATUS_AUDITI.")";
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
		
    	if (empty($id)){
			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '拒绝对账申请失败!对账申请记录状态改变,请刷新重试!'));
    		$this->redirect(array('franchiseeConsumptionRecord/consumptionApply'));
    		Yii::app()->end();
		}
		
		$sqlUpdate = "update ".$table." 
		set status = ".FranchiseeConsumptionRecordConfirm::STATUS_REFUSE.", 
		refuse_user_id = ".Yii::app()->user->id.",
		refuse_time = ".time()." 
		where id = ".$id;
		
		$result = Yii::app()->db->createCommand($sqlUpdate)->execute();
		
		if ($result) {
			$this->setFlash('success', Yii::t('franchiseeConsumptionRecord', '拒绝对账申请成功!'));
		}else{
			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '拒绝对账申请失败!'));
		}
		$this->redirect(array('franchiseeConsumptionRecord/consumptionApply'));
    }
    
    /**
     * 加盟商消费撤销
     */
    public function actionReBack(){
    	$ids = $this->getPost('reback_ids');
    	if (strpos($ids ,",")){
    		$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '申请撤销失败!一次只能撤销一个!'));
    		$this->redirect(array('franchiseeConsumptionRecord/admin'));
    		Yii::app()->end();
    	}
    	if (!empty($ids)){
    		$sql = "select id from ".FranchiseeConsumptionRecord::model()->tableName()." where id = ".$ids." and is_distributed = ".FranchiseeConsumptionRecord::STATUS_NOTCHECK;
    		$ids_arr = Yii::app()->db->createCommand($sql)->queryRow();
    		if (empty($ids_arr)){
    			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '申请撤销失败!该记录已对账或已经撤销'));
    		}else{
    			$table = FranchiseeConsumptionRecordRepeal::model()->tableName();
    			$reback_ids_arr = IntegralOfflineNew::getRebackData($ids);				//获取状态为撤销或者申请中的线下交易记录
	    		$consumption_ids_arr = IntegralOfflineNew::getConsumptionData($ids);		//获取状态为对账或者申请对账中的线下交易记录
	    			
    			
    			if (in_array($ids_arr['id'], $reback_ids_arr)){
    				$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '申请撤销失败!该记录已申请撤销或已经撤销'));
    			}else if(in_array($ids_arr['id'], $consumption_ids_arr)){
    				$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '申请撤销失败!该记录已申请对账或已经对账'));
    			}else{
    				$serial_number = Tool::buildOrderNo(20,'CX');
	    			$sql = "insert into ".$table."(serial_number,record_id,apply_user_id,apply_time,status) values";
	    			$sql.= "('".$serial_number."',".$ids_arr['id'].",".Yii::app()->user->id.",".time().",0)";
					$result = Yii::app()->db->createCommand($sql)->execute();
					if ($result){
	    				$this->setFlash('success', Yii::t('franchiseeConsumptionRecord', '申请撤销成功!'));
					}else{
						$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '申请撤销失败!'));
					}
    			}
    		}
    	}
    	$this->redirect(array('franchiseeConsumptionRecord/admin'));
    }
    
    /**
     * 线下消费撤销订单列表
     */
    public function actionRebackApply(){
    	$model = new FranchiseeConsumptionRecordRepeal();
    	
    	if (isset($_GET['FranchiseeConsumptionRecordRepeal']))
        {
        	$model->attributes = $_GET['FranchiseeConsumptionRecordRepeal'];
        	$model->franchisee_name = $_GET['FranchiseeConsumptionRecordRepeal']['franchisee_name'];
        	$model->franchisee_code = $_GET['FranchiseeConsumptionRecordRepeal']['franchisee_code'];
        	$model->franchisee_mobile = $_GET['FranchiseeConsumptionRecordRepeal']['franchisee_mobile'];
        	$model->franchisee_province_id = $_GET['FranchiseeConsumptionRecordRepeal']['franchisee_province_id'];
        	$model->franchisee_city_id = $_GET['FranchiseeConsumptionRecordRepeal']['franchisee_city_id'];
        	$model->franchisee_district_id = $_GET['FranchiseeConsumptionRecordRepeal']['franchisee_district_id'];
        	$model->status = $_GET['FranchiseeConsumptionRecordRepeal']['status'];
        	$model->start_time = $_GET['FranchiseeConsumptionRecordRepeal']['start_time'];
        	$model->end_time = $_GET['FranchiseeConsumptionRecordRepeal']['end_time'];
            $model->gai_number = $_GET['FranchiseeConsumptionRecordRepeal']['gai_number'];
        }
        
    	$totalCount = $model->search()->getTotalItemCount();
        $page = new CPagination($totalCount);
        $lists = $model->search();
        $lists_data = $lists->getData();
        $page = $lists->pagination;
        
    	$this->render('rebackapply',array('model'=>$model,'page'=>$page,));
    }
    
    /**
     * 线下消费同意撤销订单
     */
    public function actionPass(){
		$pass_ids = $_POST['pass_ids'];
    	if (strpos($pass_ids ,",")){
    		$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '撤销通过失败!一次只能通过一个撤销申请!'));
    		$this->redirect(array('franchiseeConsumptionRecord/rebackApply'));
    		Yii::app()->end();
    	}
		$table = FranchiseeConsumptionRecordRepeal::model()->tableName();
		
		$sql = "select id,record_id from ".$table." where id = ".$pass_ids." and status = ".FranchiseeConsumptionRecordRepeal::STATUS_AUDITI;
		$id_arr = Yii::app()->db->createCommand($sql)->queryRow();
		if (empty($id_arr)){
			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '请先审核对账!'));
    		$this->redirect(array('franchiseeConsumptionRecord/rebackApply'));
    		Yii::app()->end();
		}
		
    		
    		$language = Yii::app()->language;
    		
    		$result = IntegralOfflineNew::reback($id_arr['record_id'], $id_arr['id']);
    		
    		Yii::app()->language = $language;
    		
    		if ($result === true) {
    			$this->setFlash('success', Yii::t('franchiseeConsumptionRecord', '撤销通过成功!'));
    		}else{
    			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', $result['content']));
    		}
    	$this->redirect(array('franchiseeConsumptionRecord/rebackApply'));
    }
    
    /**
     * 线下消费拒绝撤销订单
     * 将订单从申请撤销的表里面删除
     */
    public function actionFail(){
		$fail_ids = $_POST['fail_ids'];

    	if (strpos($fail_ids ,",")){
    		$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '拒绝撤销失败!一次只能拒绝一个!'));
    		$this->redirect(array('franchiseeConsumptionRecord/rebackApply'));
    		Yii::app()->end();
    	}
		$table = FranchiseeConsumptionRecordRepeal::model()->tableName();
    	$sql = "select id from ".$table." where id = ".$fail_ids." and (status = ".FranchiseeConsumptionRecordRepeal::STATUS_APPLY. " or status =".FranchiseeConsumptionRecordRepeal::STATUS_AUDITI.")";
		$id_arr = Yii::app()->db->createCommand($sql)->queryRow();

    	if (empty($id_arr)){
			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '拒绝撤销失败!撤销记录状态改变,请刷新重试!'));
    		$this->redirect(array('franchiseeConsumptionRecord/rebackApply'));
    		Yii::app()->end();
		}
		
		$sqlUpdate = "update ".$table." 
		set status = ".FranchiseeConsumptionRecordRepeal::STATUS_REFUSE.", 
		refuse_user_id = ".Yii::app()->user->id.",
		refuse_time = ".time()." 
		where id = ".$id_arr['id'];
		
		$result = Yii::app()->db->createCommand($sqlUpdate)->execute();
		
		if ($result) {
			$this->setFlash('success', Yii::t('franchiseeConsumptionRecord', '拒绝撤销成功!'));
		}else{
			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '拒绝撤销失败!'));
		}
		$this->redirect(array('franchiseeConsumptionRecord/rebackApply'));
    
    }
    
    /**
     * 加盟商对账审核
     * 
     */
    public function actionConsumptionAuditing(){
        	$auditing_ids = $_POST['auditing_ids'];
    	if (strpos($auditing_ids ,",")){
    		$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '审核对账申请失败!一次只能审核一个!'));
    		$this->redirect(array('franchiseeConsumptionRecord/consumptionApply'));
    		Yii::app()->end();
    	}
		$table = FranchiseeConsumptionRecordConfirm::model()->tableName();
		
    	$sql = "select id from ".$table." where id = ".$auditing_ids." and status = ".  FranchiseeConsumptionRecordConfirm::STATUS_APPLY;
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
                
    	if (empty($id)){
			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '审核对账申请失败!对账申请记录状态改变,请刷新重试!'));
    		$this->redirect(array('franchiseeConsumptionRecord/consumptionApply'));
    		Yii::app()->end();
		}
		
		$sqlUpdate = "update ".$table." 
		set status = ".FranchiseeConsumptionRecordConfirm::STATUS_AUDITI.", 
		auditi_user_id = ".Yii::app()->user->id.",
		auditi_time = ".time()." 
		where id = ".$id;
		
		$result = Yii::app()->db->createCommand($sqlUpdate)->execute();
		
		if ($result) {
			$this->setFlash('success', Yii::t('franchiseeConsumptionRecord', '审核对账申请成功!'));
		}else{
			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '审核对账申请失败!'));
		}
		$this->redirect(array('franchiseeConsumptionRecord/consumptionApply'));
    }
    
      /**
     * 加盟商对账撤销审核
     * 
     */
    public function actionAuditing(){
        	$auditing_ids = $_POST['auditing_ids'];
    	if (strpos($auditing_ids ,",")){
    		$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '审核对账申请失败!一次只能审核一个!'));
    		$this->redirect(array('franchiseeConsumptionRecord/rebackApply'));
    		Yii::app()->end();
    	}
				$table = FranchiseeConsumptionRecordRepeal::model()->tableName();
		
    	$sql = "select id from ".$table." where id = ".$auditing_ids." and status = ".FranchiseeConsumptionRecordRepeal::STATUS_APPLY;
		$id = Yii::app()->db->createCommand($sql)->queryScalar();
		
    	if (empty($id)){
			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '审核对账撤销失败!对账申请记录状态改变,请刷新重试!'));
    		$this->redirect(array('franchiseeConsumptionRecord/rebackApply'));
    		Yii::app()->end();
		}
		
		$sqlUpdate = "update ".$table." 
		set status = ".FranchiseeConsumptionRecordRepeal::STATUS_AUDITI.", 
		auditi_user_id = ".Yii::app()->user->id.",
		auditi_time = ".time()." 
		where id = ".$id;
		
		$result = Yii::app()->db->createCommand($sqlUpdate)->execute();
		
		if ($result) {
			$this->setFlash('success', Yii::t('franchiseeConsumptionRecord', '审核对账撤销成功!'));
		}else{
			$this->setFlash('error', Yii::t('franchiseeConsumptionRecord', '审核对账撤销失败!'));
		}
		$this->redirect(array('franchiseeConsumptionRecord/rebackApply'));
    }
    
}
