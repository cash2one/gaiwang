<?php

/**
 * 线上订单退款操作类
 * @author binbin.liao <277250538@qq.com>
 */
class OnlineRefund extends OnlineOperate {

    /**
     *
     * @param array $order //订单信息
     * @param array $member //会员信息
     * @return boolean
     * @throws Exception
     */
    public static function operate($order, $member = null) {

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

            if ($balanceOnlineOrder['today_amount'] - $returnPrice < 0) {
                throw new Exception('RE208');
            }

            //更新订单状态，关闭订单, 退款成功
            $updateArr = array('status' => Order::STATUS_CLOSE, 'refund_status' => Order::REFUND_STATUS_SUCCESS, 'refund_time' => time());
            if (!Yii::app()->db->createCommand()->update('{{order}}', $updateArr, 'id = :id', array(':id' => $order['id']))) {
                throw new Exception('UPDATE ORDER ERROR');
            }

            //更新(会员消费账户)余额
            if ($returnPrice > 0) {
                //收回退款--@author LC将流水调整到条件以后2015-05-13
                $flowLog['member'] = AccountFlow::mergeFlowData($order, $balanceMember, array(
                    'debit_amount' => -$returnPrice,
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_REFUND,
                    'remark' => '申请退款金额：￥' . $returnPrice,
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REFUND_RETURN,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_REFUND,
                ));
                if (!AccountBalance::calculate(array('today_amount' => $returnPrice), $balanceMember['id'])) {
                    throw new Exception('UPDATE MEMBERACCOUNT ERROR');
                }
            }

            //线上(盖网分配总账户)余额表--@author LC将流水调整到条件以后2015-05-13
            if ($returnPrice > 0) {
                //退还订单金额
                $flowLog['onlineOrder'] = AccountFlow::mergeFlowData($order, $balanceOnlineOrder, array(
                    'credit_amount' => -$returnPrice,
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_REFUND,
                    'remark' => '申请退款成功',
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REFUND,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_REFUND,
                ));
                if (!AccountBalance::calculate(array('today_amount' => -$returnPrice), $balanceOnlineOrder['id'])) {
                    throw new Exception('UPDATE OnlineAccount ERROR');
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

            //还原库存
            self::ReductionInventory($order['id']);
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
            $tmpId = Tool::getConfig('smsmodel','refundSucceedBuyerId');
            //尊敬的{0}用户，您申请{1}订单的退款已通过审核，退还您{2}积分。当前剩余{3}积分。
            $msgKey = 'refund_succeed_buyer';
            $temp = Tool::getConfig('smsmodel', 'refundSucceedBuyer');
            $smsContent = strtr($temp, array(
                '{0}' => $member['gai_number'],
                '{1}' => $order['code'],
                '{2}' => Common::convertSingle($returnPrice, $member['type_id']),
                '{3}' => Common::convertSingle($totalMoney, $member['type_id']),
            ));
            $datas = array( $member['gai_number'],$order['code'],Common::convertSingle($returnPrice, $member['type_id']),Common::convertSingle($totalMoney, $member['type_id']));
            if (is_numeric($member['mobile'])) {
                SmsLog::addSmsLog($member['mobile'], $smsContent, $order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true,$datas, $tmpId);
            }
        }
        return $msg;
    }

}
