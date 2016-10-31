<?php

/**
 * 线上订单退货操作类
 * @author binbin.liao <277250538@qq.com>
 */
class OnlineReturn extends OnlineOperate {

    /**
     *
     * @param array $order //订单信息
     * @param array $member //会员数据
     * @param array $store //商家信息
     * @return boolean
     * @throws Exception
     */
    public static function operate($order, $member = null, $store) {
        $flowTableName = AccountFlow::monthTable(); //流水按月分表日志表名
        $flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志历史表名
        $flowLog = array(); //流水日志
        $flag = ''; //状态
        $msg = array(); //返回信息

        if (!$member) {
            $member = Yii::app()->db->createCommand()
                ->select()
                ->from('{{member}}')
                ->where('id=:id', array(':id' => $order['id']))
                ->queryRow();
        }

        $trans = Yii::app()->db->beginTransaction();
        try {
            //再次查询订单状态,并加行锁,避免重复操作
            $sql = "select code,id,return_status from {{order}} where id = {$order['id']} limit 1 for update";
            $data = Yii::app()->db->createCommand($sql)->queryRow();
            if ($data['return_status'] == Order::RETURN_STATUS_SUCCESS)
                throw new Exception($order['code'] . '订单已经退货成功,请不要重复操作');
            $returnPrice = $order['pay_price'];
            $onlineAccountMoney = $order['real_price'];
            $balanceOnlineOrder = CommonAccount::getOnlineAccount(); //分配总账户
            //会员(消费角色)账户余额表
            $balanceMember = self::getMemberAccountInfo($member, AccountInfo::TYPE_CONSUME, false);
            //商家账户余额
            $balanceEnterprise = AccountBalance::findRecord(array('account_id' => $store['member_id'], 'type' => AccountInfo::TYPE_MERCHANT, 'gai_number' => $store['gai_number']));

            // 协商扣除运费
            if ($returnPrice - $order['deduct_freight'] < 0) {
                throw new Exception('R201');
            }
            if ($balanceOnlineOrder['today_amount'] - $returnPrice < 0) {
                throw new Exception('R202');
            }
            // 把订单状态更改为关闭,把退货状态和退款状态更改为成功
            $updateArr = array('status' => Order::STATUS_CLOSE, 'return_status' => Order::RETURN_STATUS_SUCCESS, 'refund_status' => Order::REFUND_STATUS_SUCCESS, 'return_time' => time());
            if (!Yii::app()->db->createCommand()->update('{{order}}', $updateArr, 'id = :id', array(':id' => $order['id']))) {
                throw new Exception('update order error');
            }

            //更新会员(消费账户)余额
            $realReturn = $returnPrice - $order['deduct_freight']; //(付款金额 - 退货手续费)
            if ($realReturn > 0) {
                //消费账户流水  退货返还款--@author LC将流水调整到条件以后2015-05-13
                $flowLog['member'] = AccountFlow::mergeFlowData($order, $balanceMember, array(
                    'debit_amount' => -$returnPrice,
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RETURN,
                    'remark' => '退货成功，退款金额：￥' . $returnPrice . '，协商扣除运费：￥' . $order['deduct_freight'],
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RETURN_CASH,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RETURN,
                ));
                //会员支付退货运费--@author LC将流水调整到条件以后2015-05-13
                $flowLog['payFreight'] = AccountFlow::mergeFlowData($order, $balanceMember, array(
                    'debit_amount' => $order['deduct_freight'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RETURN,
                    'remark' => '退货成功，支付协商扣除运费：￥' . $order['deduct_freight'],
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RETURN_CHARGE,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RETURN,
                ));
                if (!AccountBalance::calculate(array('today_amount' => $realReturn), $balanceMember['id'])) {
                    throw new Exception('update memberAccount error');
                }
            }

            //更新商家余额表
            if ($order['deduct_freight'] > 0) {
                //商家获得退货手续费流水--@author LC将流水调整到条件以后2015-05-13
                $flowLog['store'] = AccountFlow::mergeFlowData($order, $balanceEnterprise, array(
                    'credit_amount' => $order['deduct_freight'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RETURN,
                    'remark' => '退货成功，商家获得协商扣除运费：￥' . $order['deduct_freight'],
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RETURN_CHARGE_SHOP,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RETURN,
                ));
                if (!AccountBalance::calculate(array('today_amount' => $order['deduct_freight']), $balanceEnterprise['id'])) {
                    throw new Exception('update Enterprise error');
                }
            }

            //更新线上总账户余额表
            if ($returnPrice > 0) {
                //线上分配总账户流水--@author LC将流水调整到条件以后2015-05-13
                $flowLog['onlineOrder'] = AccountFlow::mergeFlowData($order, $balanceOnlineOrder, array(
                    'credit_amount' => -$returnPrice,
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RETURN,
                    'remark' => '申请退货成功',
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RETURN_CANCEL,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RETURN,
                ));
                if (!AccountBalance::calculate(array('today_amount' => -$returnPrice), $balanceOnlineOrder['id'])) {
                    throw new Exception('update OnlineAccount error');
                }
            }

            //写入流水
            foreach ($flowLog as $log) {
                Yii::app()->db->createCommand()->insert($flowTableName, $log);
            }

            //红包类型的订单
            if ($order['source_type'] == Order::SOURCE_TYPE_HB) {
                $flow = array(
                    'debit_amount' => -$order['other_price'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RETURN,
                    'remark' => '退货成功，收回使用红包金额：￥' . $order['other_price'],
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RETURN_RED,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RETURN,
                );
                self::callOtherPrice($flowHistoryTableName, $order, $flow);
            }

            // 检测借贷平衡
            if (!DebitCredit::checkFlowByCode($flowTableName, $order['code'])) {
                throw new Exception('DebitCredit Error!', '009');
            }

            //还原库存
            self::ReductionInventory($order['id']);

            $trans->commit();
            $msg['info'] = '退货成功';
            $msg['flag'] = $flag = true;
        } catch (Exception $e) {
            $trans->rollback();
            $msg['info'] = $e->getMessage();
            $msg['flag'] = $flag = false;
        }
        if ($flag) {
            $totalMoney = AccountBalance::getAccountAllBalance($member['gai_number'], AccountInfo::TYPE_CONSUME);
            $tmpId = Tool::getConfig('smsmodel','repurSucceedBuyerId');
            //尊敬的{0}用户，您申请{1}订单退货，商家已收到退货商品，扣除运费{2}元，退还您{3}积分。当前剩余{4}积分。
            $msgKey = 'repur_succeed_buyer';
            $temp = Tool::getConfig('smsmodel', 'repurSucceedBuyer');
            $smsTemplate = strtr($temp, array(
                '{0}' => $member['gai_number'],
                '{1}' => $order['code'],
                '{2}' => $order['deduct_freight'],
                '{3}' => Common::convertSingle($returnPrice - $order['deduct_freight'], $member['type_id']),
                '{4}' => Common::convertSingle($totalMoney, $member['type_id']),
            ));
            $datas = array($member['gai_number'],$order['code'],$order['deduct_freight'],Common::convertSingle($returnPrice - $order['deduct_freight'], $member['type_id']),Common::convertSingle($totalMoney, $member['type_id']));
            if (is_numeric($member['mobile'])) {
                SmsLog::addSmsLog($member['mobile'], $smsTemplate, $order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true, $datas, $tmpId);
            }
        }
        return $msg;
    }

}