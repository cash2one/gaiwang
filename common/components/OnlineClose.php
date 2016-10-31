<?php

/**
 * 线上订单(支付成功),卖家关闭
 * @author binbin.liao <277250538@qq.com>
 */
class OnlineClose extends OnlineOperate {

    /**
     * 检查订单是否满足订单关闭
     * @param $order
     * @throws Exception
     */
    public static function checkOrder($order){
        if($order['status']!=Order::STATUS_NEW){
            throw new Exception('订单状态异常');
        }
        if($order['refund_status']==Order::REFUND_STATUS_SUCCESS ){
            throw  new Exception('订单退款状态异常');
        }
        if($order['return_status']==Order::RETURN_STATUS_SUCCESS){
            throw  new Exception('订单退货状态异常');
        }
        if($order['is_comment']!=Order::IS_COMMENT_NO){
            throw  new Exception('订单评论状态异常');
        }
    }
    /**
     * 关闭订单
     * @param array $order 订单信息
     * @param array $member 会员信息
     * @param array $inCome 订单分配金额
     *
     * array(
     * 'totalAssign' => , //总分配金额
     * 'gaiBaseIncome' => , //盖网首次收益金额
     * 'surplusAssign' => , //可分配金额
     * 'gaiPrice' => , //供货价
     * 'freight' => , //运费
     * );
     *
     * @param array $return 会员待返还
     * array(
     * 'memberIncome' => $consumerIncome,
     * 'gaiIncome' => bcsub($originalIncome, $consumerIncome, self::$median)
     * )
     *
     *
     * @return array|bool
     */
    public static function operate($order, $member) {
        // 当前客户端IP
        $flowTableName = AccountFlow::monthTable(); //流水日志表名
        $flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志历史表名
        $flowLog = array(); //流水日志
        $trans = Yii::app()->db->beginTransaction();
        try {

            self::checkOrder($order);

            $returnPrice = $order['pay_price'];
            //余额
            $balanceOnlineOrder = CommonAccount::getOnlineAccount(); //分配总账户
            //会员账户余额表
            $memberArr = array(
                'account_id' => $member['id'],
                'type' => AccountBalance::TYPE_CONSUME,
                'gai_number' => $member['gai_number'],
            );
            $balanceMember = AccountBalance::findRecord($memberArr);

            if ($balanceOnlineOrder['today_amount'] - $returnPrice < 0) {
                throw new Exception('c202');
            }

            $msg = array();

            //更新状态
            $updateArr = array('status' => Order::STATUS_CLOSE, 'refund_status' => Order::REFUND_STATUS_SUCCESS, 'close_time' => time());
            if (!Yii::app()->db->createCommand()->update('{{order}}', $updateArr, 'id = :orderId', array(':orderId' => $order['id']))) {
                throw new Exception('退款异常');
            }
            
            if($returnPrice < 0)
            {
            	throw new Exception('退款异常');
            }

            //更新(会员)余额
            if ($returnPrice > 0) {
            	//收回退货款  用户--@author LC将流水调整到条件以后2015-05-13
            	$flowLog['member'] = AccountFlow::mergeFlowData($order, $balanceMember, array(
            			'debit_amount' => -$returnPrice,
            			'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_CLOSE,
            			'remark' => '会员支付成功，卖家关闭订单，退款金额：￥' . $returnPrice,
            			'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_CLOSE_RETURN_CASH,
            			'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CANCEL,
            	));
                if (!AccountBalance::calculate(array('today_amount' => $returnPrice), $balanceMember['id'])) {
                    throw new Exception('UPDATE MEMBERACCOUNT ERROR');
                }
            }

            //线上(盖网分配总账户)余额表
            if ($returnPrice > 0) {
            	//退还订单金额  线上总帐户--@author LC将流水调整到条件以后2015-05-13
            	$flowLog['onlineOrder'] = AccountFlow::mergeFlowData($order, $balanceOnlineOrder, array(
            			'credit_amount' => -$returnPrice,
            			'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_CLOSE,
            			'remark' => '会员支付成功，卖家关闭订单，退款金额：￥' . $returnPrice,
            			'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_CLOSE_REWARD_CANCEL,
            			'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CANCEL,
            	));
                if (!AccountBalance::calculate(array('today_amount' => -$returnPrice), $balanceOnlineOrder['id'])) {
                    throw new Exception('UPDATE OnlineAccount ERROR');
                }
            }

            //插入流水
            foreach ($flowLog as $log) {
                Yii::app()->db->createCommand()->insert($flowTableName, $log);
            }

            //红包订单
            if ($order['source_type'] == Order::SOURCE_TYPE_HB) {
                $flowLog = array(
                    'debit_amount' => -$order['other_price'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_CLOSE,
                    'remark' => '会员支付成功，卖家关闭订单，收回使用红包金额：￥' . $order['other_price'],
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_CLOSE_CALL_RED,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CANCEL,
                );
                self::callOtherPriceWithClose($flowHistoryTableName, $order, $flowLog);
            }

            // 检测借贷平衡
            if (!DebitCredit::checkFlowByCode($flowTableName, $order['code'])) {
                throw new Exception('DebitCredit Error!', '009');
            }

            $msg['info'] = array('success' => '关闭交易成功');
            $msg['flag'] = $flag = true;
            //还原库存
            self::ReductionInventory($order['id']);
            $trans->commit();
        } catch (Exception $e) {
            $trans->rollback();
            $msg['info'] = array('error' => 'c203' . $e->getMessage());
            $msg['flag'] = $flag = false;
        }
        //发送短信
        if ($flag) {
            $merchant = Yii::app()->db->createCommand()
            ->select('c.name as store_name')
            ->from('{{store}} as c')
            ->where('c.id = :cid', array(':cid' => $order['store_id']))
            ->queryRow();
            $totalMoney = AccountBalance::getAccountAllBalance($balanceMember['gai_number'], AccountInfo::TYPE_CONSUME);

            //尊敬的{0}用户，商家{1}关闭并终止了{2}订单的交易，退还您{3}积分。当前剩余{4}积分。
            $msgKey = 'refund_succeed_buyer';
            $temp = Tool::getConfig('smsmodel', 'cancelSucceedBuyer');
            $smsContent = strtr($temp, array(
                '{0}' => $member['gai_number'],
                '{1}' => !empty($merchant['store_name']) ? $merchant['store_name'] : '',
                '{2}' => $order['code'],
                '{3}' => Common::convertSingle($returnPrice, $member['type_id']),
                '{4}' => Common::convertSingle($totalMoney, $member['type_id']),
            ));
            $tmpId = Tool::getConfig('smsmodel','cancelSucceedBuyerId');
            $datas = array($member['gai_number'],!empty($merchant['store_name']) ? $merchant['store_name'] : '',$order['code'],Common::convertSingle($returnPrice, $member['type_id']),Common::convertSingle($totalMoney, $member['type_id']));
            if (is_numeric($member['mobile'])) {
                
                SmsLog::addSmsLog($member['mobile'], $smsContent, $order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true, $datas , $tmpId);
            }
        }
        return $msg;
    }

    /**
     * 关闭订单,红包金额的处理
     * @param 表名 $flowTableName
     * @param array $order
     * @param array $arr
     * @throws Exception
     */
    public static function callOtherPriceWithClose($flowTableName, array $order, array $arr) {
        OnlineOperate::callOtherPrice($flowTableName, $order, $arr);
        //关闭订单,要把会员金额退回给会员
        $otherPrice = $order['other_price']; //红包使用金额
        if (!MemberAccount::model()->updateCounters(array('money' => $otherPrice), 'member_id=:member_id', array(':member_id' => $order['member_id']))) {
            throw new Exception('UPDATE MEMBERACCOUNT ERROR');
        }
    }

}
