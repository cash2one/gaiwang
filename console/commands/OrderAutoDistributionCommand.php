<?php 

/**
 * 订单签收后自动执行分配动作
 * 执行条件：
 * 已支付、已签收、订单完成、未分配
 * @author wyee<yanjie.wang@g-emall.com>
 */

class OrderAutoDistributionCommand extends CConsoleCommand {
	
	/**
	 * 分配操作
	 */ 
	public function actionDistribution() {	
		
		$msg=array();
		
		$criteria = new CDbCriteria();
		$criteria->condition='status=:s AND delivery_status=:d AND pay_status=:p AND is_distribution=:ib';
		$criteria->params=array(':s' => Order::STATUS_COMPLETE, ':d' => Order::DELIVERY_STATUS_RECEIVE,':p'=>Order::PAY_STATUS_YES,':ib'=>Order::IS_DISTRIBUTION_NO);
		//$criteria->addInCondition('refund_status',array(Order::REFUND_STATUS_NONE, Order::REFUND_STATUS_FAILURE));
		//$criteria->addInCondition('return_status',array(Order::RETURN_STATUS_NONE, Order::RETURN_STATUS_FAILURE,Order::RETURN_STATUS_CANCEL));
		$orders = Order::model()->findAll($criteria);
	
		if(!empty($orders)){
		  foreach($orders as $orderModel){	  	
			//订单店铺信息
			$storeFields = array('m.gai_number', 'm.type_id', 'm.mobile', 'c.id', 'c.member_id', 'c.name',
					'c.province_id', 'c.city_id', 'c.district_id', 'c.referrals_id','c.mobile as store_mobile');
			$store = Yii::app()->db->createCommand()->select($storeFields)
			  ->from('{{store}} c')
			  ->leftJoin('{{member}} m', 'm.id = c.member_id')
			  ->where('c.id=:id', array(':id' => $orderModel->store_id))->queryRow();

			//订单所属会员信息
			$member= Yii::app()->db->createCommand()
			   ->select('id,gai_number,type_id,mobile,username,referrals_id')->from('{{member}} ')->where('id=:mid', array(':mid' => $orderModel->member_id))->queryRow();
			
			$orderGoods=$orderModel->orderGoods;
			$order=$orderModel->attributes;
			
			$msg = OnlineSign::order($order, $orderGoods, $member, $store,false,true);
			echo $order['code'],$msg['info']."\r\n";
			
		   }	
		
		} 	
	
	}
		
	
}


?>