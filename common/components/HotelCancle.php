<?php

/**
 * 酒店订单取消类
 * @author jianlin_lin <hayeslam@163.com>
 */
class HotelCancle
{
    /**
     * 取消酒店订单，未确认订单，不扣手续费
     * @param array $order 酒店订单属性
     * @param boolean $deduct 是否扣除手续费，默认不扣除
     * @param boolean $sendSms 是否发送短信息，默认发送
     * @return mixed
     */
    public static function execute(array $order, $deduct = false, $sendSms = true)
    {
        // 会员信息
        $member = Yii::app()->db->createCommand()
            ->select('id, type_id, gai_number, mobile')
            ->from('{{member}}')
            ->where('id = :id', array(':id' => $order['member_id']))
            ->queryRow();
        if (!$member) return false;

        $lotteryPrice = $order['is_lottery'] == HotelOrder::IS_LOTTERY_YES ? $order['lottery_price'] : 0; // 抽奖支付金额
        $finalRefundPrice = $realityRefundPrice = bcadd($order['total_price'], $lotteryPrice, HotelCalculate::SCALE); // 订单总支付金额

        // 手续费
        $fee = 0;
        if ($deduct == true) {
            // 手续费系数不能大于 1
            if ($order['refund_radio'] > 1) return false;
            $fee = $order['total_price'] * $order['refund_radio'];
        }

        $monthFlowTable = AccountFlow::monthTable();// 当月流水表名
        $update = array('status' => HotelOrder::STATUS_CLOSE, 'refund' => $fee, 'cancle_time' => time()); // 酒店订单更新

        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            // 酒店订单更新
            if (!Yii::app()->db->createCommand()->update('{{hotel_order}}', $update, 'id = :id AND pay_status = :pstatus',
                array(':id' => $order['id'], ':pstatus' => HotelOrder::PAY_STATUS_YES))) {
                throw new Exception('订单数据异常！');
            }

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

            // 手续费流水
            if ($deduct == true && $fee > 0)
            {
                // 供货商会员信息
                $provider = Yii::app()->db->createCommand()
                    ->select('m.id as member_id, m.gai_number')
                    ->from('{{hotel_provider}} p')
                    ->leftJoin('{{member}} m', 'p.member_id = m.id')
                    ->where('p.id = :id And m.status = :status', array(':id' => $order['hotel_provider_id'], ':status' => Member::STATUS_NORMAL))
                    ->queryRow();

                // 供货商不存在
                if (!$provider) {
                    throw new Exception('供货商不存在！');
                }

                // 会员消费账户余额
                $consumerBalance = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountInfo::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
                // 供货商会员账户
                $providerBalance = AccountBalance::findRecord(array('account_id' => $provider['member_id'], 'type' => AccountInfo::TYPE_MERCHANT, 'gai_number' => $provider['gai_number']));

                // 借方（会员消费账户）
                $feeDebit = AccountFlow::mergeFlowData($order, $consumerBalance, array(
                    'debit_amount' => $fee,
                    'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_CANCEL,
                    'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_CANCEL_CHARGE,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CANCEL,
                    'remark' => "酒店订单取消，扣除手续费：￥{$fee}",
                ));

                // 贷方（供货商会员账户）
                $feeCredit = AccountFlow::mergeFlowData($order, $providerBalance, array(
                    'credit_amount' => $fee,
                    'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_CANCEL,
                    'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_CANCEL_GET_CHARGE,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CANCEL,
                    'remark' => "酒店订单取消，手续费金额：￥{$fee}",
                ));

                // 如果会员消费账户余额不足以扣除
                if ($consumerBalance['today_amount'] < $fee) {
                    throw new Exception('账户余额不足！');
                }
                // 会员消费账户余额更新
                if (!AccountBalance::calculate(array('today_amount' => "-{$fee}"), $consumerBalance['id'])) {
                    throw new Exception('会员账户扣款失败！');
                }
                // 供货商会员账户余额更新
                if (!AccountBalance::calculate(array('today_amount' => $fee), $providerBalance['id'])) {
                    throw new Exception('供货商收款失败！');
                }

                // 记录流水
                if (!Yii::app()->db->createCommand()->insert($monthFlowTable, $feeDebit) ||
                    !Yii::app()->db->createCommand()->insert($monthFlowTable, $feeCredit)) {
                    throw new Exception('流水记录失败！');
                }

                // 实际返还金额
                $realityRefundPrice = $finalRefundPrice - $fee;
            }

            // 验证流水表发生额
            if (!DebitCredit::checkFlowByCode($monthFlowTable, $order['code'])) {
                throw new Exception('流水表发生额不平衡！', '090603');
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        self::sendSms($order, $member, $realityRefundPrice, $sendSms, $fee, $deduct); // 发送短信
        return true;
    }

    /**
     * 酒店取消订单短信发送方法
     * @param array $order 酒店订单属性
     * @param array $member 会员属性
     * @param float $finalReturnPrice 订单退还金额
     * @param float $fee 手续费
     * @param boolean $deduct 是否扣除手续费
     * @param boolean $sendSms 是否发送短信
     */
    public static function sendSms($order, $member, $finalReturnPrice, $sendSms, $fee = 0.00, $deduct = false)
    {
        if ($sendSms != true) return;
        $totalMoney = Member::getTotalPrice(AccountInfo::TYPE_CONSUME, $member['id'], $member['gai_number']);
        $usableIntegral = Common::convertSingle($totalMoney, $member['type_id']); // 消费账户剩余积分
        $finalReturnIntegral = Common::convertSingle($finalReturnPrice, $member['type_id']); // 订单退还总积分
        $settled_time = date("Y-m-d", $order['settled_time']);
        $leave_time =  date("Y-m-d", $order['leave_time']);
        $hotel_name = $order['hotel_name'];
        $room_name = $order['room_name'];
        $smsConfig = Tool::getConfig('smsmodel');
        $msg = array(
            '{0}' => $member['gai_number'],
            '{1}' => $settled_time,
            '{2}' => $leave_time,
            '{3}' => $hotel_name,
            '{4}' =>$room_name,
        );
        // 发送短信息
        if ($order['is_lottery'] == HotelOrder::IS_LOTTERY_NO) {
            if ($deduct == true) {
                // 尊敬的{0}用户，您预定的{1}到{2}入住{3}{4}，已成功取消预定，扣除手续费{5}盖网积分，退还您{6}盖网积分，目前您还剩余{7}消费积分，请您核实。
                $temp = Tool::getConfig('smsmodel', 'hotelOrderRefund');
                $msg = strtr($temp, array_merge($msg, array(
                    '{5}' => Common::convertSingle($fee, $member['type_id']),
                    '{6}' => $finalReturnIntegral,
                    '{7}' => $usableIntegral,                
                )));
                  $datas = array($member['gai_number'], $settled_time, $leave_time, $hotel_name,$room_name ,Common::convertSingle($fee, $member['type_id']), $finalReturnIntegral, $usableIntegral);
                 $tmpid = $smsConfig['hotelOrderRefundId'];
            } else {
                // 尊敬的{0}用户，您预定的{1}到{2}入住{3}{4},已取消，退还您{5}盖网积分，目前您还剩余{6}消费积分，请您核实。
                $temp = Tool::getConfig('smsmodel', 'hotelOrderCancle');
                $msg = strtr($temp, array_merge($msg, array(
                    '{5}' => $finalReturnIntegral,
                    '{6}' => $usableIntegral,
                )));
                  $datas = array($member['gai_number'], $settled_time, $leave_time, $hotel_name,$room_name , $finalReturnIntegral, $usableIntegral);
                  $tmpid = $smsConfig['hotelOrderCancleId'];
            }
        } else if ($order['is_lottery'] == HotelOrder::IS_LOTTERY_YES) {
            if ($deduct == true) {
                // 尊敬的{0}用户，您预订的{1}到{2}入住{3}{4}，已成功取消预定，扣除手续费{5}积分，现退还您{6}积分，当前剩余{7}积分。 改：2014/08/07
                //尊敬的{0}用户，您预订的{1}到{2}入住{3}{4}，已成功取消预定，扣除手续费{5}盖网积分，同时取消中奖积分{6}盖网积分，退还您{7}盖网积分，目前您还剩余{8}消费积分，请您核实。
                $temp = Tool::getConfig('smsmodel', 'hotelOrderLotterRefund');
                $msg = strtr($temp, array_merge($msg, array(
                    '{5}' => Common::convertSingle($fee, $member['type_id']),
                    '{6}' => $finalReturnIntegral,
                    '{7}' => $usableIntegral,
                )));
                $datas = array($member['gai_number'], $settled_time, $leave_time, $hotel_name,$room_name ,Common::convertSingle($fee, $member['type_id']), $finalReturnIntegral, $usableIntegral);
                $tmpid = $smsConfig['hotelOrderLotterRefundId']; //中奖金额没有待解决
            } else {
                // 尊敬的{0}用户，您预定的{1}到{2}入住{3}{4}，已取消，退还支付酒店使用的{5}盖网积分，及抽奖使用的{6}盖网积分，目前您还剩余{7}消费积分，请您核实。
                $temp = Tool::getConfig('smsmodel', 'hotelOrderLotterCancle');
                $msg = strtr($temp, array_merge($msg, array(
                    '{5}' => Common::convertSingle($finalReturnPrice - $order['lottery_price'], $member['type_id']),
                    '{6}' => Common::convertSingle($order['lottery_price'], $member['type_id']),
                    '{7}' => $usableIntegral,
                )));
                  $datas = array($member['gai_number'], $settled_time, $leave_time, $hotel_name,$room_name ,Common::convertSingle($finalReturnPrice - $order['lottery_price'], $member['type_id']),Common::convertSingle($order['lottery_price'], $member['type_id']), $usableIntegral);
                  $tmpid = $smsConfig['hotelOrderLotterCancleId'];
            }
        }
        SmsLog::addSmsLog($member['mobile'], $msg,$order['id'], SmsLog::TYPE_HOTEL_ORDER,null,true, $datas, $tmpid); // 记录并短息日志
    }
}
