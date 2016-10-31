<?php

/**
 * 酒店订单确认类
 * @author jianlin_lin <hayeslam@163.com>
 */
class HotelVerify {

    /**
     * 酒店订单确认业务流程
     * @param array $order 酒店订单属性
     * @param HotelOrder $rawOrder 原订单数据
     * @param boolean $sendSms 是否发送短信息，默认发送
     * @return array|bool
     */
    public static function verify(array $order, $rawOrder, $sendSms = true)
    {
        // 会员信息
        $member = Yii::app()->db->createCommand()
            ->select('id, type_id, gai_number, mobile')
            ->from('{{member}}')
            ->where('id = :id', array(':id' => $order['member_id']))
            ->queryRow();
        if (!$member) return false;

        // 酒店订单分发比率
        $ratio = CJSON::decode($order['distribution_ratio']);
        $memberType = MemberType::fileCache(); // 会员类型
        if (empty($memberType) || empty($ratio)) {
            return false;
        }

        // 换房，则替换相应数据
        if ($order['room_id'] != $rawOrder->room_id) {
            // 查询新客房数据
            $newRoom = Yii::app()->db->createCommand()
                ->select('r.id, r.gai_income, r.name, r.hotel_id, h.name as hotel_name')
                ->from('{{hotel_room}} as r')
                ->leftJoin('{{hotel}} as h', 'r.hotel_id = h.id')
                ->where('r.id = :rid', array(':rid' => $order['room_id']))
                ->queryRow();

            $order = array_merge($order, array(
                'room_id' => $newRoom['id'],
                'room_name' => $newRoom['name'],
                'hotel_id' => $newRoom['hotel_id'],
                'hotel_name' => $newRoom['hotel_name'],
                'gai_income' => $newRoom['gai_income'],
            ));
        }

        $orderPrice = HotelCalculate::price($order);    // 订单价格
        $difference = HotelCalculate::difference($order, $rawOrder->attributes);    // 订单差额

        // 判断原订单支付总价是否小于当前订单总价
        if ($rawOrder->total_price < $orderPrice['total']) {
            return false;
        }

        $monthFlowTable = AccountFlow::monthTable();    // 当月流水表名
        $orderResult = HotelCalculate::orderIncome($order); // 订单金额分配计算结果
        $memberResult = HotelCalculate::memberAssign($orderResult['surplusAssign'], $member, $ratio, $memberType);  // 会员收益计算结果

        // 酒店订单变动
        $order = array_merge($order, array(
            'payed_price' => $orderPrice['total'],
            'total_price' => $orderPrice['total'],
            'amount_returned' => $memberResult['memberIncome'],
            'status' => HotelOrder::STATUS_VERIFY,  // 订单状态
            'confirm_user' => Yii::app()->getUser()->name,
            'confirm_time' => time(),
        ));

        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            // 酒店订单更新
            if (!Yii::app()->db->createCommand()->update('{{hotel_order}}', $order, 'id = :id AND status = :wstatus AND pay_status = :pstatus',
                array(':id' => $order['id'], ':wstatus' => HotelOrder::STATUS_NEW, ':pstatus' => HotelOrder::PAY_STATUS_YES))) {
                throw new Exception('订单数据异常！');
            }

            // 有差额，退还差额流程
            if ($difference['total_chae']) {
                // 会员消费者账户
                $memberBalance = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
                // 线上总账户
                $onlineAccount = CommonAccount::getOnlineAccount();

                // 借方（会员消费者账户）
                $debit = AccountFlow::mergeFlowData($order, $memberBalance, array(
                    'debit_amount' => "-{$difference['total_chae']}",
                    'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_VERIFY,
                    'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_CONFIRM,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CONFIRM,
                    'remark' => "酒店订单确认，退还订单变更差额：￥{$difference['total_chae']}",
                ));

                // 贷方（线上总账户）
                $credit = AccountFlow::mergeFlowData($order, $onlineAccount, array(
                    'credit_amount' => "-{$difference['total_chae']}",
                    'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_VERIFY,
                    'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_RETURN,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_ORDER_CONFIRM,
                    'remark' => "酒店订单确认，线上总账户支出：￥{$difference['total_chae']}",
                ));

                // 如果线上总账户余额不足以扣除
                if ($onlineAccount['today_amount'] < $difference['total_chae']) {
                    throw new Exception('线上总账户余额不足！');
                }

                // 线上总账户余额更新
                if (!AccountBalance::calculate(array('today_amount' => "-{$difference['total_chae']}"), $onlineAccount['id'])) {
                    throw new Exception('线上总账户扣款失败！');
                }
                // 会员余额账户余额更新
                if (!AccountBalance::calculate(array('today_amount' => $difference['total_chae']), $memberBalance['id'])) {
                    throw new Exception('会员收款失败！');
                }

                // 记录流水
                if (!Yii::app()->db->createCommand()->insert($monthFlowTable, $debit) ||
                    !Yii::app()->db->createCommand()->insert($monthFlowTable, $credit)) {
                    throw new Exception('流水记录失败！');
                }

                // 验证流水表发生额
                if (!DebitCredit::checkFlowByCode($monthFlowTable, $order['code'])) {
                    throw new Exception('流水表发生额不平衡！', '090305');
                }
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }

        // 发送短信息
        if ($sendSms === true) {
            $smsConfig = Tool::getConfig('smsmodel');
            $sms = array();
            // 如果有差额，发送短信通知客户
            if ($difference['total_chae']) {
                $temp = Tool::getConfig('smsmodel', 'hotelOrderRoomChange');
                // 尊敬的{0}用户，我们已为您更换{1}到{2}入住{3}{4}，{5}间房，退还您差额￥{6}元，订单编号为{7}，请您核实。
                $settled_time = date("Y-m-d", $order['settled_time']);
                $leave_time =  date("Y-m-d", $order['leave_time']);
                $msg = strtr($temp, array(
                    '{0}' => $member['gai_number'],
                    '{1}' => $settled_time,
                    '{2}' => $leave_time,
                    '{3}' => $order['hotel_name'],
                    '{4}' => $order['room_name'],
                    '{5}' => $order['rooms'],
                    '{6}' => $difference['total_chae'],
                    '{7}' => $order['code'],
                ));
                $datas = array($member['gai_number'], $settled_time, $leave_time, $order['hotel_name'], $order['room_name'], $order['rooms'], $difference['total_chae'],$order['code']);                     
                // 记录并短息日志
                $tmpId = $smsConfig['hotelOrderRoomChangeId'];
                SmsLog::addSmsLog($member['mobile'], $msg, $order['id'], SmsLog::TYPE_HOTEL_ORDER,null,true, $datas, $tmpId);
            }

            // 发送确认订单短信消息
            $hotel = Yii::app()->db->createCommand()->select('checkout_time, street, phone')->from('{{hotel}}')->where('id = :id', array(':id' => $order['hotel_id']))->queryRow();
            $temp = Tool::getConfig('smsmodel', 'hotelOrderConfirm');
            $lodgers = HotelOrder::analysisLodgerInfo($order['people_infos'], true);
            // 尊敬的{0}用户，您好！盖网酒店订单{1}已成功，确认如下:{2}酒店，{3}房，{4}间，{5}天，入住日期{6}，登记入住人{7}，共{8}积分。入住前{9}小时，不可退订。酒店地址：{10}。请凭名字为{11}的证件入住
             //尊敬的{0}用户，您好！盖网酒店订单{1}已成功，确认如下:{2}，{3}，{4}间，{5}天，入住日期{6}，登记入住人{7}，共{8}积分。如您需要修改或取消预订，请致电客服申请，最终申请结果以客服回复为准。酒店地址：{10}。请凭名字为{11}的证件入住{12}。
            $msg = strtr($temp, array(
                '{0}' => $member['gai_number'],
                '{1}' => $order['code'],
                '{2}' => $order['hotel_name'],
                '{3}' => $order['room_name'],
                '{4}' => $order['rooms'],
                '{5}' => HotelCalculate::liveDays($order['leave_time'], $order['settled_time']),
                '{6}' => date("Y-m-d", $order['settled_time']),
                '{7}' => $lodgers,
                '{8}' => Common::convertSingle($order['total_price'], $member['type_id']),
                '{9}' => $hotel['checkout_time'],
                '{10}' => $hotel['street'],
                '{11}' => $lodgers,
                '{12}' => $hotel['phone'] ? ',酒店电话：' . $hotel['phone'] : '',
            ));
            $datas = array($member['gai_number'],$order['code'],$order['hotel_name'],$order['room_name'], $order['rooms'], HotelCalculate::liveDays($order['leave_time'], $order['settled_time']),date("Y-m-d", $order['settled_time']),$lodgers,Common::convertSingle($order['total_price'], $member['type_id']),$hotel['street'],$lodgers, $hotel['phone'] ? ',酒店电话：' . $hotel['phone'] : '');
            $tmpId2 = $smsConfig['hotelOrderConfirmId'];
            SmsLog::addSmsLog($order['mobile'], $msg,  $order['id'], SmsLog::TYPE_HOTEL_ORDER,null,true, $datas, $tmpId2); // 记录并短息日志
            SmsLog::addSmsLog($member['mobile'], $msg, $order['id'], SmsLog::TYPE_HOTEL_ORDER,null,true, $datas, $tmpId2); // 记录并短息日志
        }
        return true;
    }

}
