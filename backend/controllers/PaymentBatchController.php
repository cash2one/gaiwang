<?php

/**
 * 代付管理-代付批次
 * 操作（代付，查询）
 * @date 2016-08-09
 * @author wyee <yanjie.wang@g-emall.com>
 */
class PaymentBatchController extends Controller {
    
    public $defaultAction = '';
    
    public function filters() {
        return array(
                'rights',
        );
    }
    
    
    /**
     * 代收付批次列表
     */
    public function actionAdmin() {  
    	$model = new PaymentBatch('search');
    	$model->unsetAttributes();
    	if (isset($_GET['PaymentBatch']))
    	    $model->attributes = $_GET['PaymentBatch'];
    	$this->render('admin', array('model'=>$model));
    }

    
    /**
     * 审核批量代付
     */
    public function actionEnterpriseCheckedDfBatch(){
    	if (Yii::app()->request->isAjaxRequest) {
    		$ids = $this->getPost('ids');
    		$idArr=explode(',', $ids);
    		$check = (int)$this->getPost('check');
    		$num=$this->getPost('num'); 
    		//批次号
    		if(empty($num)){
    			$num='P'.time();
    		 }		
    		$cashMember=array();
    		$cashMember=Yii::app()->db->createCommand()
                      ->select('id,member_id,money')
                      ->from('{{cash_history}}')
                      ->where(array('in', 'id', $idArr))
                      ->order('id DESC')
                      ->queryAll();
    		
    		if(count($idArr) != count($cashMember)){
    			echo Yii::t('cashHistory', '数据有误，请重新审核！');exit;
    		}
    		
    		//事务执行
    		$trans = Yii::app()->db->beginTransaction();
    		try {
    			if($check===CashHistory::CHECK_YES){
    				$flag = Yii::app()->db->createCommand()->update('{{cash_history}}',array('is_check'=>$check),'id in('.$ids.')');
    			    if(!$flag){
    			    	echo Yii::t('cashHistory', '批量操作插入批次失败！');exit;
    			    }
    			}else{
    				echo Yii::t('cashHistory', '批量操作插入批次失败！');exit;
    			}
    	      //批次号,如果存在，则不执行插入
    	      $bres=PaymentBatch::model()->find(array('condition' => 'batch_number = :num','params' => array(':num' => $num)));
    		   if(!$bres){
    		   	    $this->setCookie('batchNum',$num,24*60*60);
    				Yii::app()->db->createCommand()->insert('{{payment_batch}}', array(
    				'batch_number' => $num,
    				'create_time' => time(),
    				'author_id' => $this->getUser()->id,
    				'author_ip' => Tool::ip2int($this->clientIp()),
    				));
    				$batchId=Yii::app()->db->getLastInsertID();
    			 }else{
    				  $batchId=$bres->id;
    			}
    			foreach($cashMember as $k=>$v){
    				Yii::app()->db->createCommand()->insert('{{payment}}', array(
    				'cash_id' => $v['id'],
    				'member_id' => $v['member_id'],
    				'amount' => $v['money'],
    				'batch_id' => $batchId,
    				'create_time' => time(),
    			  ));
    			}	
    			$trans->commit();
    			@SystemLog::record(Yii::app()->user->name . "批量操作代付成功：" . $ids);
    			echo  Yii::t('cashHistory', '批量操作代付成功');
    		}catch (Exception $e){
    			$trans->rollback();
    			@SystemLog::record(Yii::app()->user->name . "批量操作代付失败：" . $ids);
    			echo Yii::t('cashHistory', $e->getMessage());
    		}
    	}
      		
    }
    
    /**
     * 修改代付批次的状态
     */
    public function actionChangeStatus()
    {
    	if($this->isAjax()){
    		 $id=$this->getParam('id');
    		 $status=$this->getParam('st');
    		 $res= Yii::app()->db->createCommand()->update('{{payment_batch}}', array(
	    		 'status' => $status,
	    		 'audit_time'=>time(),
	    		 'auditor_id' => $this->getUser()->id,
	    		 'auditor_ip' => Tool::ip2int($this->clientIp()),
	    		 ), 'id=:id', array(':id' => $id));	
    		$result=array();	 
    	  if($res){
    	  	if($status==PaymentBatch::STATUS_PASS){
    	  	    $result=array('msg'=>'审核通过成功！','flag'=>'1');
    	  	}else{
    	  		$result=array('msg'=>'审核不通过成功！','flag'=>'1');
    	  	}
    	  }else{
    	  	if($status==PaymentBatch::STATUS_PASS){
    	  	    $result=array('msg'=>'审核通过失败！','flag'=>'2');
    	  	}else{
    	  		$result=array('msg'=>'审核不通过失败！','flag'=>'2');
    	  	}  	
    	  	
    	  }	 
    	  @SystemLog::record(Yii::app()->user->name . $result['msg'].":". $id);
    	   echo json_encode($result); 	 
    	}

    }
    
    /**
     * 修改代付信息为转账状态
     */
    public function actionChangePayStatus()
    {
    	if($this->isAjax()){
    		$id=$this->getParam('id');
    		$status=$this->getParam('st');
    		$res= Yii::app()->db->createCommand()->update('{{payment_batch}}', array(
    				'status' => PaymentBatch::STATUS_PAYING,
    				'audit_time'=>time(),
    				'auditor_id' => $this->getUser()->id,
    				'auditor_ip' => Tool::ip2int($this->clientIp()),
    		), 'id=:id', array(':id' => $id));
    		$result=array();
    		if($res){
    			  $result=array('msg'=>'转账成功！','flag'=>'1');
    		}else{
    			  $result=array('msg'=>'转账失败！','flag'=>'2');
    		}
    		@SystemLog::record(Yii::app()->user->name . $result['msg'].":". $id);
    		echo json_encode($result);
    	}
    
    }
    
    /**
     * 代付日志列表
     */
    public function actionPayLog(){
    	$this->breadcrumbs = array(Yii::t('order', '高汇通代付 '), Yii::t('order', '代付日志'));
    	$model=new PaymentLog('search');
    	$model->unsetAttributes();  // clear any default values
    	if(isset($_GET['PayResult']))
    		$model->attributes=$_GET['PayResult'];
    
    	$this->render('paylog',array(
    			'model'=>$model,
    	));
    } 
    /**
     * 代付日志列表
     */
    public function actionLogView($id){
    	$this->breadcrumbs = array(Yii::t('order', '代付日志 '), Yii::t('order', '查看日志'));
        $model = PaymentLog::model()->findByPk($id);
        $this->render('logview',array(
            'model'=>$model,
        ));
    }
     
}
