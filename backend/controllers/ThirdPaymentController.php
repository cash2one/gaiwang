<?php

/**
 * 代收付管理控制器
 * 操作（代收付，查询）
 * @date 2016-12-16
 * @date 2016-09-02
 * @author wyee <yanjie.wang@g-emall.com>
 */
class ThirdPaymentController extends Controller {
    
    public $defaultAction = '';
    
    public function filters() {
        return array(
                'rights',
        );
    }
    
    /**
     * 高汇通代付
     */
    public function actionGhtPay() {
    	if($this->isAjax()){
    		//锁表
    	 //Yii::app()->db->createCommand()->setText("lock tables {{payment}} WRITE")->execute();
          $payBatchId=$this->getParam('id');
          $payInfo=Payment::getBatchPayment($payBatchId);
          $thirdPayment=new ThirdPartyPayment();
          $thirdPayment->privateKye=Yii::getPathOfAlias('common').'/rsaFile/ght/000000000100443.pfx';
          $thirdPayment->publicKey=Yii::getPathOfAlias('common').'/rsaFile/ght/000000000100443.txt';     
          if(!empty($payInfo)){
          	foreach($payInfo as $k => $v){
          		if($v['money'] != $v['amount']){
          			$log=array('id'=>$v['cash_id'],'msg'=>'该条企业提现金额与代付金额无法匹配：提现金额是'.$v['money'].'，代付金额是'.$v['amount']);
          			PaymentLog::saveLog($log);
          			continue;
          		 }
          		 if(!empty($v['req_id'])){
          		
          		 	$queryInfo=array(
          		 			'order_id'=>$v['req_id'],
          		 	);
          		 	$thirdPayment->set_data($queryInfo,'query');
          		 	$thirdPayment->curl_access();
          		 	$result=$thirdPayment->verify_ret();
          		 	if($result['status']){
          		 		$xml_obj=$result['info'];
          		 		$info = (array)$xml_obj->INFO;
          		 		if($info['RET_CODE'] == '0000') {
          		 		  $log=array('id'=>$v['cash_id'],'msg'=>'该企业代付已成功');
          		 		  PaymentLog::saveLog($log);
          		 		  Yii::app()->db->createCommand()->update('{{payment}}', array(
          		 		  'status' => Payment::STATUS_SUCCESS, 
          		 		  ), 'id=:pid', array(':pid' => $v['id']));
          		 			continue;	
          		     }
          		   } 
          		 }
          		$cashHistory = CashHistory::model()->findByPk($v['cash_id']);
          		$member = Member::model()->findByPk($v['member_id']);
          		$flag = CashHistoryProcess::enterpriseCashEnd($cashHistory->attributes, $member->attributes);
          		//待考虑：积分扣除和高汇通代付成功一个，失败一个，现情况：先以扣除积分成功后，再走代付，如果代付失败，记录日志，后期再根据情况操作
          		if(!$flag){
          			/**记录日志**/
          			$log=array('id'=>$v['cash_id'],'msg'=>'积分代付失败'.$v['cash_id']);
          			PaymentLog::saveLog($log);
          			continue;
          			/**记录日志**/
          		}else{
		          	$ghtOrderId=Tool::buildOrderNo(19,'DF');//交易流水号 待入库
		          	$info['order_id']=$ghtOrderId;
		          	$info['trxCode']='100005';
		          	$info['businessCode']='09100';//代付汇款类  09101资金分流类
		          	$info['bank_code']=$v['bank_code'];
		          	$info['account_no']=$v['account'];
		          	$info['account_name']=$v['account_name'];
		          	$info['amount']=$v['amount']*100;
		          	$info['num']=$k;
		          	$thirdPayment->set_data($info,'pay');
		          	$thirdPayment->curl_access();
		          	$result=$thirdPayment->verify_ret();
		          	$logArr=array();
	          	    $tips=2;
	          	    if($result['status']){
	          	 	  $xml_obj=$result['info'];
	          	 	  $info = (array)$xml_obj->INFO;
	          	 	  if ($info['RET_CODE'] == '0000') {
	          	 		$ret_code = (string)$xml_obj->BODY->RET_DETAILS->RET_DETAIL->RET_CODE;
	          	 		if ($ret_code == '0000'){
	          	 			$tips=1;
	          	 		}	
	          	 	  }
	          	 	 $logArr['status']=$result['status'];
	          	 	 $logArr['info']=$result['res'];
	          	 }else{
	          	 	$logArr=$result; 
	          	  }	          	 
	          	 /**记录日志**/
	          	 $log=array('id'=>$v['cash_id'],'msg'=>serialize($logArr));
	          	 PaymentLog::saveLog($log);
	          	 /**记录日志**/
	           Yii::app()->db->createCommand()->update('{{payment}}', array(
	          	   'status' => $tips,
	          	   'req_id'=>$ghtOrderId,
	          	   'payment_time'=>time(),
	          	 ), 'id=:pid', array(':pid' => $v['id']));
             }
             //是否已经执行过批量代付
             $res=Yii::app()->db->createCommand()->update('{{payment_batch}}', array(
             'status' => PaymentBatch::STATUS_SUCCESS,
            ), 'id=:id', array(':id' => $payBatchId));
             @SystemLog::record(Yii::app()->user->name . $result['msg'].":". $payBatchId);  
            } 
          }
          //Yii::app()->db->createCommand()->setText("unlock tables")->execute();
          $returnMsg=array('msg'=>'执行完毕！','flag'=>'1');
          echo json_encode($returnMsg);
    	}
    }
    
    
    /**
     * 查询
     */
    public function ActionOrderQuery(){
              
         if(isset($_GET['id']) && !empty($_GET['id'])){
            $order_id=$_GET['id'];
            $thirdPayment=new ThirdPartyPayment();
            $info=array(
                    'order_id'=>$order_id,
            );
            //$thirdPayment->privateUrl=Yii::getPathOfAlias('common').'/rsaFile/ght/000000000100443.pfx';
            //$thirdPayment->publicKey=Yii::getPathOfAlias('common').'/rsaFile/ght/000000000100443.txt';
            $thirdPayment->privateUrl=Yii::getPathOfAlias('common').'/rsaFile/ght/TESTUSER.pfx';
            $thirdPayment->publicKey=Yii::getPathOfAlias('common').'/rsaFile/ght/TESTUSER.txt';
            $thirdPayment->set_data($info,'query');
            $thirdPayment->curl_access();
            $result=$thirdPayment->verify_ret();
            if($result['status']){
                $xml_obj=$result['info'];
                $info = (array)$xml_obj->INFO;
                if ($info['RET_CODE'] == '0000') { 
                    $this->setFlash('success','对账成功');
                }else{
                    $this->setFlash('error',$info['ERR_MSG']);
                }
            }else{
                $this->setFlash('error','对账失败');
            }
        }else{
            $this->setFlash('error','流水号不存在');
        } 
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
}
