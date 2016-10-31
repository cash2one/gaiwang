<?php
/**
*
* @author: yanjie.wang
* @date: 201609281030
* 商城订单号 H2016092111501779910294由于重复使用积分支付，故需执行退款操作
*/
class ErrorHotelOrderCommand extends CConsoleCommand
{
	
	public function actionCancle()
	{
		$code = 'H2016092111501779910294';
		$sql = "select * from {{hotel_order}} where code = '".$code."'";
		$order = Yii::app()->db->createCommand($sql)->queryRow();
		$member = Yii::app()->db->createCommand()
		->select('id,gai_number,type_id,mobile,username')
		->from('{{member}}')
		->where('id=:id', array(':id' => $order['member_id']))
		->queryRow();
		$fee = 0;
		$deduct = false;
		$sendSms = true;

		$lotteryPrice = $order['is_lottery'] == HotelOrder::IS_LOTTERY_YES ? $order['lottery_price'] : 0; // 抽奖支付金额
		$finalRefundPrice = $realityRefundPrice = bcadd($order['total_price'], $lotteryPrice, HotelCalculate::SCALE); // 订单总支付金额
		
		$monthFlowTable ='account.gw_account_flow_201609';// 当月流水表名
		
		// 线上总账户
		$onlineAccount = CommonAccount::getOnlineAccount();
		
		// 会员消费账户余额
		$consumerBalance = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountInfo::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
		
		// 借方（会员消费账户）
		$debit = AccountFlow::mergeFlowData($order, $consumerBalance, array(
		        'debit_amount' => "-{$finalRefundPrice}",
		        'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_CANCEL,
		        'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_CANCEL,
		        'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CANCEL,
		        'remark' => "酒店订单取消，退还订单支付金额：￥{$order['total_price']}" . ($lotteryPrice > 0 ? "，及抽奖支付金额：￥{$lotteryPrice}" : ""),
		));
		// 贷方（线上总账户）
		$credit = AccountFlow::mergeFlowData($order, $onlineAccount, array(
		        'credit_amount' => "-{$finalRefundPrice}",
		        'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_CANCEL,
		        'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_CANCEL_RETURN,
		        'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CANCEL,
		        'remark' => "酒店订单取消，线上总账户支出：￥{$finalRefundPrice}",
		));
		
		// 如果会线上总账户余额不足以扣除
		if ($onlineAccount['today_amount'] < $finalRefundPrice) {
		    throw new Exception('账户余额不足！');
		}
		// 会员消费账户余额更新
		if (!AccountBalance::calculate(array('today_amount' => $finalRefundPrice), $consumerBalance['id'])) {
		    throw new Exception('会员账户收款失败！');
		}
		// 线上总账户余额更新
		if (!AccountBalance::calculate(array('today_amount' => "-{$finalRefundPrice}"), $onlineAccount['id'])) {
		    throw new Exception('线上总账户扣款失败！');
		}
		
		// 记录流水
		if (!Yii::app()->db->createCommand()->insert($monthFlowTable, $debit) ||
		!Yii::app()->db->createCommand()->insert($monthFlowTable, $credit)) {
		    throw new Exception('流水记录失败！');
		}
		
		// 验证流水表发生额
		if (!DebitCredit::checkFlowByCode($monthFlowTable, $order['code'])) {
		    throw new Exception('流水表发生额不平衡！', '090603');
		}	
		HotelCancle::sendSms($order, $member, $realityRefundPrice, $sendSms, $fee, $deduct); // 发送短信
	    echo "success!";
	}
		
}