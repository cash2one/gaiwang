<?php

/**
 * 酒店订单评论类
 * @author jianlin_lin <hayeslam@163.com>
 */
class HotelComment {

    /**
     * 酒店订单评论
     * @param array   $order   酒店订单属性
     * @param array   $member  会员属性
     * @param boolean $sendSms 是否发送短信息，默认发送
     *
     * @return mixed
     */
    public static function Comment(array $order, array $member = null, $sendSms = true)
    {
        if ($member === null)
        {
            $member = Yii::app()->db->createCommand()
                ->select('id, type_id, gai_number, mobile')
                ->from('{{member}}')
                ->where('id = :id', array(':id' => $order['member_id']))
                ->queryRow();
            if (!$member) return false;
        }

        $memberType = MemberType::fileCache(); // 会员类型
        $ratio = CJSON::decode($order['distribution_ratio']); // 订单各角色分配比率
        if (empty($memberType) || empty($ratio)) {
            return false;
        }

        // 算出订单待分配结果，及会员分配金额
        $orderResult = HotelCalculate::orderIncome($order);
        $memberResult = HotelCalculate::memberAssign($orderResult['surplusAssign'], $member, $ratio, $memberType);
        $returnMoney = $memberResult['memberIncome']; // 评论返还金额
        $returnIntegral = Common::convertSingle($returnMoney, $member['type_id']); // 评论返还积分

        $monthFlowTable = AccountFlow::monthTable(); // 当月流水表名
        $update = array('score' => $order['score'], 'comment' => $order['comment'], 'comment_time' => time()); // 酒店订单更新
        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            // 酒店订单更新
            if (!Yii::app()->db->createCommand()->update('{{hotel_order}}', $update, 'id = :id AND status = :wstatus AND pay_status = :pstatus AND comment_time = ""',
                array(':id' => $order['id'], ':wstatus' => HotelOrder::STATUS_SUCCEED, ':pstatus' => HotelOrder::PAY_STATUS_YES))) {
                throw new Exception('订单数据异常！');
            }
            
            // 酒店表，累加评论分，次数
            Hotel::model()->updateCounters(array('comments' =>1 ,'total_score' => $order['score']),'id = :id', array(':id' => $order['hotel_id']));

            // 会员待返还账户余额
            $returnBalance = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountInfo::TYPE_RETURN, 'gai_number' => $member['gai_number']));
            // 会员消费账户余额
            $consumerBalance = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountInfo::TYPE_CONSUME, 'gai_number' => $member['gai_number']));

            // 借方（会员待返还账户）
            $debit = AccountFlow::mergeFlowData($order, $returnBalance, array(
                'debit_amount' => $returnMoney,
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_COMMENT,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_COMMENT_RETURN,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_COMMENT,
                'ratio' => $memberType[$member['type_id']],
                'remark' => "酒店订单评论，扣除：￥{$returnMoney}待返还金额",
            ));
            // 贷方（会员消费账户）
            $credit = AccountFlow::mergeFlowData($order, $consumerBalance, array(
                'credit_amount' => $returnMoney,
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_COMMENT,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_COMMENT_UNFREEZE,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_COMMENT,
                'ratio' => $memberType[$member['type_id']],
                'remark' => "酒店订单评论，获得：￥{$returnMoney}金额",
            ));

            // 如果会员待返还账户余额不足以扣除
            if ($returnBalance['today_amount'] < $returnMoney) {
                throw new Exception('账户余额不足！');
            }

            // 会员待返还账户余额更新
            if (!AccountBalance::calculate(array('today_amount' => "-{$returnMoney}"), $returnBalance['id'])) {
                throw new Exception('会员待返还账户扣款失败！');
            }
            // 会员消费账户余额更新
            if (!AccountBalance::calculate(array('today_amount' => $returnMoney), $consumerBalance['id'])) {
                throw new Exception('会员账户收款失败！');
            }

            // 记录流水
            if (!Yii::app()->db->createCommand()->insert($monthFlowTable, $debit) ||
                !Yii::app()->db->createCommand()->insert($monthFlowTable, $credit)) {
                throw new Exception('流水记录失败！');
            }

            // 验证流水表发生额
            if (!DebitCredit::checkFlowByCode($monthFlowTable, $order['code'])) {
                throw new Exception('流水表发生额不平衡！');
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }

        // 发送并记录短信信息
        if ($sendSms == true) {
            $totalMoney = Member::getTotalPrice(AccountInfo::TYPE_CONSUME, $member['id'], $member['gai_number']);
            // 尊敬的{0}用户，您预定的{1}到{2}入住{3}{4}，感谢您成功评价了订单{5}，解冻{6}返还积分为消费积分。当前您消费积分余额为{7}消费积分，请您核实。
            $temp = Tool::getConfig('smsmodel', 'hotelOrderComment');
            $settled_time = date('Y-m-d', $order['settled_time']);
            $leave_time = date('Y-m-d', $order['leave_time']);
            $msg = strtr($temp, array(
                '{0}' => $member['gai_number'],
                '{1}' => $settled_time,
                '{2}' => $leave_time,
                '{3}' => $order['hotel_name'],
                '{4}' => $order['room_name'],
                '{5}' => $order['code'],
                '{6}' => $returnIntegral,
                '{7}' => Common::convertSingle($totalMoney, $member['type_id']),
            ));
            $datas = array($member['gai_number'], $settled_time, $leave_time, $order['hotel_name'], $order['room_name'], $order['code'], $returnIntegral, Common::convertSingle($totalMoney, $member['type_id']));
            $tmpId = Tool::getConfig('smsmodel','hotelOrderCommentId');
            SmsLog::addSmsLog($member['mobile'], $msg, $order['id'], SmsLog::TYPE_HOTEL_ORDER,null,true,$datas, $tmpId); // 记录并短息日志
        }
        return true;
    }

}
