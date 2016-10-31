<?php

/**
 * 线上订单退款操作类 从原来的程序拷过来修改
 * @author wenhao.li <441671421@qq.com>
 */
class ExchangeRefund extends OnlineOperate {

    /**
     *
     * @param array $order //订单信息
     * @param array $member //会员信息
     * @param array $store //商家数据
     * @return boolean
     * @throws Exception
     */
    public static function operate($order, $member = null, $store) {

        if (empty($order)) {
            throw new Exception('订单数据异常');
        }

        if (!$member) {
            $member = Yii::app()->db->createCommand()
                ->select()
                ->from('{{member}}')
                ->where('id=:id', array(':id' => $order['member_id']))
                ->queryRow();
        }

        //V2.0版可以不全额退款,所以金额不能用pay_price来算
        $refundMoney =  Yii::app()->db->createCommand()->select('exchange_money,exchange_id')->from('{{order_exchange}}')->where('order_id=:id', array(':id' => $order['id']))->order('exchange_id DESC')->limit(1)->queryRow();

        /*if($refundMoney){
            $returnPrice = $refundMoney['exchange_money'];
        }else{
            $returnPrice = $order['pay_price'];
        }*/
        $returnPrice = $order['pay_price'];

        $flowTableName = AccountFlow::monthTable(); //流水按月分表日志表名
        $flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志历史表名
        //流水记录
        $flowLog = array();
        $trans = Yii::app()->db->beginTransaction(); // 事务执行
        try {
            //再次查询订单状态,并加行锁,避免重复操作
            $sql = "select code,id,refund_status from {{order}} where id = {$order['id']} limit 1 for update";
            $data = Yii::app()->db->createCommand($sql)->queryRow();
            if ($data['refund_status'] == Order::REFUND_STATUS_SUCCESS)
                throw new Exception($order['code'] . '订单已经退款成功,请不要重复操作');
            //余额账户
            $balanceMember = self::getMemberAccountInfo($member, AccountInfo::TYPE_CONSUME, false); //会员消费账户
            $balanceOnlineOrder = CommonAccount::getOnlineAccount(); //线上总账户
            //商家账户余额
            $balanceEnterprise = AccountBalance::findRecord(array('account_id' => $store['member_id'], 'type' => AccountInfo::TYPE_MERCHANT, 'gai_number' => $store['gai_number']));

            if($refundMoney) $toSllerMoney = $order['pay_price'] - $refundMoney['exchange_money']; //剩余金额

            if ($balanceOnlineOrder['today_amount'] - $returnPrice < 0) {
                throw new Exception('RE208');
            }

            //更新订单状态，关闭订单, 退款成功
            $updateArr = array('status' => Order::STATUS_CLOSE, 'refund_status' => Order::REFUND_STATUS_SUCCESS, 'refund_time' => time());
            if (!Yii::app()->db->createCommand()->update('{{order}}', $updateArr, 'id = :id', array(':id' => $order['id']))) {
                throw new Exception('UPDATE ORDER ERROR');
            }

            if($returnPrice < 0)
            {
                throw new Exception('RETURN　PRICE ERROR');
            }

            if ($returnPrice > 0) {
                //更新(会员消费账户)余额
                //收回退款--@author LC将流水调整到条件以后2015-05-13
                $flowLog['member'] = AccountFlow::mergeFlowData($order, $balanceMember, array(
                    'debit_amount' => -$returnPrice,
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_REFUND,
                    'remark' => '申请退款金额：￥' . $returnPrice,
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REFUND_RETURN,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_REFUND,
                    'type'=>AccountFlow::TYPE_CONSUME,
                ));
                if (!AccountBalance::calculate(array('today_amount' => $returnPrice), $balanceMember['id'])) {
                    throw new Exception('UPDATE MEMBERACCOUNT ERROR');
                }

                //线上(盖网分配总账户)余额表--@author LC将流水调整到条件以后2015-05-13
                //退还订单金额
                $flowLog['onlineOrder'] = AccountFlow::mergeFlowData($order, $balanceOnlineOrder, array(
                    'credit_amount' => -$order['pay_price'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_REFUND,
                    'remark' => '申请退款成功',
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REFUND,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_REFUND,
                    'type'=>AccountFlow::TYPE_TOTAL,
                ));
                if (!AccountBalance::calculate(array('today_amount' => -$order['pay_price']), $balanceOnlineOrder['id'])) {
                    throw new Exception('UPDATE OnlineAccount ERROR_1');
                }

                //写入流水
                foreach ($flowLog as $log) {
                    Yii::app()->db->createCommand()->insert($flowTableName, $log);
                }

                //判断为不全额退货 廖佳伟 2015-11-10
                if($refundMoney && $toSllerMoney > 0) {
                    $flowLogForToSllerMoney['store'] = AccountFlow::mergeFlowData($order, $balanceEnterprise, array(
                        'credit_amount' => $toSllerMoney,
                        'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RETURN,
                        'remark' => '退货成功，退还商家协商剩余货款金额：￥' . $toSllerMoney,
                        'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RETURN_CHARGE_SHOP,
                        'transaction_type' => AccountFlow::TRANSACTION_TYPE_RETURN,
                        'type'=>AccountFlow::TYPE_MERCHANT,
                    ));
                    if (!AccountBalance::calculate(array('today_amount' => $toSllerMoney), $balanceEnterprise['id'])) {
                        throw new Exception('UPDATE OnlineAccount ERROR');
                    }

                    $flowLogForToSllerMoney['payFreight'] = AccountFlow::mergeFlowData($order, $balanceMember, array(
                        'debit_amount' => $toSllerMoney,
                        'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RETURN,
                        'remark' => '退货成功，商家获取协商剩余货款金额：￥' . $toSllerMoney,
                        'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RETURN_CHARGE,
                        'transaction_type' => AccountFlow::TRANSACTION_TYPE_RETURN,
                        'type'=>AccountFlow::TYPE_CONSUME,
                    ));
                    if (!AccountBalance::calculate(array('today_amount' => -$toSllerMoney), $balanceMember['id'])) {
                        throw new Exception('update memberAccount error');
                    }
                    //写入流水
                    foreach ($flowLogForToSllerMoney as $log) {
                        Yii::app()->db->createCommand()->insert($flowTableName, $log);
                    }
                }
            }



            //红包类型的订单
            if ($order['source_type'] == Order::SOURCE_TYPE_HB) {
                $flow = array(
                    'debit_amount' => -$order['other_price'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_REFUND,
                    'remark' => '申请退款，收回使用红包金额：￥' . $order['other_price'],
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REFUND_RED,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_REFUND,
                );
                self::callOtherPrice($flowHistoryTableName, $order, $flow);
            }

            // 检测借贷平衡
            if (!DebitCredit::checkFlowByCode($flowTableName, $order['code'])) {
                throw new Exception('DebitCredit Error!', '009');
            }

            //同步修改gw_order_exchange表信息
            $exchange = Yii::app()->db->createCommand()->select("exchange_id")->from("{{order_exchange}}")->where("order_id=:order_id and exchange_status=:exchange_status",array(':order_id'=>$order['id'],'exchange_status'=>1))->order('exchange_id desc')->limit(1)->queryRow();
            if($exchange){
                Yii::app()->db->createCommand()->update("{{order_exchange}}",
                    array('exchange_done_time'=>time(),'exchange_status'=>6),
                    "exchange_id=:exchange_id",array(':exchange_id'=>$exchange['exchange_id']));
            }

            //还原库存
            self::ReductionInventory($order['id']);
            Order::closeOder($order['id']);//关闭订单
            $trans->commit();
            $msg['info'] = '退款成功';
            $msg['flag'] = $flag = true;
        } catch (Exception $e) {
            $trans->rollback();
            $msg['info'] = $e->getMessage();
            $msg['flag'] = $flag = false;
        }
        if ($flag) {
            $totalMoney = AccountBalance::getAccountAllBalance($balanceMember['gai_number'], AccountInfo::TYPE_CONSUME);

            //尊敬的{0}用户，您申请{1}订单的退款已通过审核，退还您{2}积分。当前剩余{3}积分。
            $msgKey = 'refund_succeed_buyer';
            $temp = Tool::getConfig('smsmodel', 'refundSucceedBuyer');
            $smsContent = strtr($temp, array(
                '{0}' => $member['gai_number'],
                '{1}' => $order['code'],
                '{2}' => Common::convertSingle($returnPrice, $member['type_id']),
                '{3}' =>  Common::convertSingle($totalMoney, $member['type_id']),
            ));
             $datas = array($member['gai_number'], $order['code'], Common::convertSingle($returnPrice, $member['type_id']) , Common::convertSingle($totalMoney, $member['type_id']));
             $tmpId = Tool::getConfig('smsmodel','refundSucceedBuyerId');
            if (is_numeric($member['mobile'])) {
                SmsLog::addSmsLog($member['mobile'], $smsContent,$order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true, $datas, $tmpId);
            }
        }
        return $msg;
    }

}
