<?php

/*
 * 退换货--计划任务执行脚本 每十分钟执行一次
 * 相关内容: 
 *    1会员申请 退款或者退货 后,七天内商家不操作,默认审核不通过
 *    2会员申请 退货 商家审核通过后,若会员在七天内不提交物流信息,默认取消该申请
      3退货过程中, 会员上传物流信息后, 商家在十天内不处理,默认自动退款 
 */

class ExchangeGoodsCommand extends CConsoleCommand{

    public function actionRun() {
		$time   = time();//当前时间
		$seven  = 86400*7;//七天
		$ten    = Order::EX_CHANGE_TIME;//十天
        $reason = '超过系统指定时间,系统自动操作';//退换货不通过的理由
		
        //读取要操作的内容
		$sql = "SELECT order_id,exchange_id,exchange_type,exchange_status,exchange_apply_time,exchange_examine_time "
			   ."FROM {{order_exchange}} "
			   ."WHERE exchange_status IN (".Order::EXCHANGE_STATUS_WAITING.",".Order::EXCHANGE_STATUS_RETURN.",".Order::EXCHANGE_STATUS_REFUND.")";
			   
        $command = Yii::app()->db->createCommand($sql);
		$result  = $command->queryAll();
		if(!empty($result)){//如果有要处理的内容
			echo 'find total:'.count($result)."\r\n";
			foreach($result as $v){
				
				//退款不退货 超过七天商家不处理,状态改为审核不通过
				if($v['exchange_type'] == Order::EXCHANGE_TYPE_REFUND){
					$expire = $v['exchange_apply_time']+$seven;
                    //退款不退货的订单，商家还没审核的情况下，而且是超过规定时间没有操作才能进入到这里方法来。之所以会走到这里来
					if($v['exchange_status'] == Order::EXCHANGE_STATUS_WAITING && $time >= $expire){
					    $sql = "UPDATE {{order_exchange}} SET exchange_done_time='$time',exchange_examine_reason='$reason',exchange_status='".Order::EXCHANGE_STATUS_NO."' WHERE exchange_id='$v[exchange_id]'";
						Yii::app()->db->createCommand($sql)->execute();//更新gw_order_exchange表
						
						$sql = "UPDATE {{order}} SET refund_status='".Order::REFUND_STATUS_FAILURE."' WHERE id='$v[order_id]'";
						Yii::app()->db->createCommand($sql)->execute();//更新ge_order表
						echo '退款不退货 超过七天商家不处理,状态改为审核不通过:'.$v['order_id']."\r\n";
					}else{
						echo '10.情况未知'.$v['order_id']."\r\n";
					}
				
				//退货 分三种情况处理
				}else if($v['exchange_type'] == Order::EXCHANGE_TYPE_RETURN){
					$expire  = $v['exchange_apply_time']+$seven;
					$expire1 = $v['exchange_examine_time']+$seven;
					$expire2 = $v['exchange_examine_time']+$ten;
					
					//情况一: 会员申请了, 商家超过七天还没审核的, 状态改为审核不通过
					if($v['exchange_status'] == Order::EXCHANGE_STATUS_WAITING && $time >= $expire){
						$sql    = "UPDATE {{order_exchange}} SET exchange_done_time='$time',exchange_examine_reason='$reason',exchange_status='".Order::EXCHANGE_STATUS_NO."' WHERE exchange_id='$v[exchange_id]'";
						Yii::app()->db->createCommand($sql)->execute();//更新gw_order_exchange表
						
						$sql = "UPDATE {{order}} SET return_status='".Order::RETURN_STATUS_FAILURE."' WHERE id='$v[order_id]'";
						Yii::app()->db->createCommand($sql)->execute();//更新ge_order表
						echo '会员申请了, 商家超过七天还没审核的, 状态改为审核不通过:'.$v['order_id']."\r\n";
					//情况二: 商家通过审核, 但是七天内会员没有将货物退还并填写物流信息, 状态改为取消退货
					}else if($v['exchange_status'] == Order::EXCHANGE_STATUS_RETURN && $time >= $expire1){
						$sql    = "UPDATE {{order_exchange}} SET exchange_done_time='$time',exchange_examine_reason='$reason',exchange_status='".Order::EXCHANGE_STATUS_CANCEL."' WHERE exchange_id='$v[exchange_id]'";
						Yii::app()->db->createCommand($sql)->execute();//更新gw_order_exchange表
						
						$sql = "UPDATE {{order}} SET return_status='".Order::RETURN_STATUS_CANCEL."' WHERE id='$v[order_id]'";
						Yii::app()->db->createCommand($sql)->execute();//更新ge_order表
						echo '商家通过审核, 但是七天内会员没有将货物退还并填写物流信息, 状态改为取消退货:'.$v['order_id']."\r\n";
					//情况三: 会员填写了物流信息, 但是十天内商家没有处理, 状态改为退货成功并退款给会员
					}else if($v['exchange_status'] == Order::EXCHANGE_STATUS_REFUND && $time >= $expire2){
						$sql    = "UPDATE {{order_exchange}} SET exchange_done_time='$time',exchange_examine_reason='$reason',exchange_status='".Order::EXCHANGE_STATUS_DONE."' WHERE exchange_id='$v[exchange_id]'";
						Yii::app()->db->createCommand($sql)->execute();//更新gw_order_exchange表
						
						//$sql = "UPDATE {{order}} SET return_status='".Order::RETURN_STATUS_SUCCESS."',return_time='$time',status='".Order::STATUS_CLOSE."' WHERE id='$v[order_id]'";
						//Yii::app()->db->createCommand($sql)->execute();//更新ge_order表
						
						//退款给会员,并更新流水
						$order = Yii::app()->db->createCommand()->select('*')->from('{{order}}')->where('id=:id', array(':id' => $v['order_id']))->queryRow();
						
						$storeFields = array('m.gai_number', 'm.type_id', 'm.mobile', 'c.id', 'c.member_id', 'c.name');
						$store =  Yii::app()->db->createCommand()->select($storeFields)
								  ->from('{{store}} c')
								  ->leftJoin('{{member}} m', 'm.id = c.member_id')
								  ->where('c.id=:id', array(':id' => $order['store_id']))->queryRow();
						ExchangeReturn::operate($order, null, $store);
						echo '会员填写了物流信息, 但是十天内商家没有处理, 状态改为退货成功并退款给会员:'.$v['order_id']."\r\n";
					}else{
						echo '1.情况未知'.$v['order_id']."\r\n";
					}
					
				}else{
					echo '2.情况未知'.$v['order_id']."\r\n";
				}
			}
		}else{
			echo 'order_exchange null';
		}
	}
}
?>