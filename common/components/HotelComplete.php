<?php

/**
 * 酒店订单完成类
 * @author jianlin_lin <hayeslam@163.com>
 */
class HotelComplete {

    /**
     * 执行酒店订单完成操作
     * @param array $order 酒店订单属性
     * @param bool $sendSms 是否发送短信息，默认发送
     * @return array|bool
     */
    public static function execute(array $order, $sendSms = true) {
        // 会员信息
        $fields = 'id, gai_number, referrals_id, type_id, username, mobile';
        $member = Yii::app()->db->createCommand()->select($fields)->from('{{member}}')->where('id = :id', array(':id' => $order['member_id']))->queryRow();
        if (!$member)
            return false; // 会员不存在








// 供货商会员信息
        $provider = Yii::app()->db->createCommand()
        ->select('m.id as member_id, m.gai_number')
        ->from('{{hotel_provider}} p')
        ->leftJoin('{{member}} m', 'p.member_id = m.id')
        ->where('p.id = :id And m.status = :status', array(':id' => $order['hotel_provider_id'], ':status' => Member::STATUS_NORMAL))
        ->queryRow();
        if (!$provider)
            return false; // 供货商不存在

        $memberType = MemberType::fileCache(); // 会员类型
        $roleRatio = CJSON::decode($order['distribution_ratio']); // 各角色分配比率
        // 会员类型与角色分配比率数据异常
        if (empty($memberType) && empty($roleRatio)) {
            return false;
        }

        // 判断订单分配信息是否记录旅游公司会员ID
        if (isset($roleRatio['travelCompanyId']) && is_null($roleRatio['travelCompanyId'])) {
            $roleRatio['travelCompanyId'] = Tool::getConfig('hotelparams', 'hotelOnBusinessTravelMemberId');
        }

        // 旅游公司会员信息
        $travelCompany = Yii::app()->db->createCommand()
        ->select('id, gai_number')
        ->from('{{member}}')
        ->where('id = :id And status = :status', array(':id' => $roleRatio['travelCompanyId'], ':status' => Member::STATUS_NORMAL))
        ->queryRow();
        if (!$travelCompany)
            return false; // 商旅企业会员不存在








// 会员推荐者
        $fields = 'id, type_id, gai_number, username, mobile';
        $recommenderRec = Yii::app()->db->createCommand()->select($fields)->from('{{member}}')->where('id=:id', array(':id' => $member['referrals_id']))->queryRow();
        $recommender = $recommenderRec === false ? null : $recommenderRec;

        // 订单中奖金额
        $bonus = HotelCalculate::obtainBonus($order);
        // 当前订单的分配金额
        $orderResult = HotelCalculate::orderIncome($order);
        //商旅分配金额
        $businessTravelResult = HotelCalculate::businessTravelAssign($orderResult['surplusAssign'],$roleRatio,$orderResult);
        // 当前订单中消费者的分配金额
        $memberResult = HotelCalculate::memberAssign($orderResult['surplusAssign'], $member, $roleRatio, $memberType);
        // 当前订单消费者推荐的分配金额
        $memberReferResult = HotelCalculate::memberReferAssign($orderResult['surplusAssign'], $recommender, $roleRatio, $memberType);
        // 分配详细
        $distribute = HotelCalculate::distribution($order, $businessTravelResult, $memberResult, $memberReferResult, $roleRatio);
        // 操作员操作记录
        $operator = PHP_SAPI === 'cli' ? '系统' : Yii::app()->user->name;
        $log = array();
        $log['user_id'] = PHP_SAPI === 'cli' ? '0' : Yii::app()->user->id;
        $log['username'] = $operator;
        $log['info'] = $operator . '完成酒店订单：' . $order['id'];
        $log['ip'] = Tool::getIP();
        $log['create_time'] = time();

        $flow = array();
        $monthFlowTable = AccountFlow::monthTable(); // 当月流水表名
        $update = array('live_time' => strtotime($order['live_time']), 'complete_time' => time(), 'status' => HotelOrder::STATUS_SUCCEED); // 酒店订单更新
        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            // 酒店订单更新
            $result = Yii::app()->db->createCommand()->update('{{hotel_order}}', $update, 'id = :id AND status = :ostatus AND pay_status = :pstatus And is_check = :check And is_recon = :recon', array(
                ':id' => $order['id'],
                ':ostatus' => HotelOrder::STATUS_VERIFY, ':pstatus' => HotelOrder::PAY_STATUS_YES,
                ':check' => HotelOrder::IS_CHECK_YES, ':recon' => HotelOrder::IS_RECON_YES,
            )
            );
            if (!$result) {
                throw new Exception('订单数据异常！');
            }

            // 酒店及客房入住次数
            Hotel::model()->updateCounters(array('enter_count' => 1), 'id = :hid', array(':hid' => $order['hotel_id']));
            HotelRoom::model()->updateCounters(array('enter_count' => 1), 'id = :hid', array(':hid' => $order['room_id']));

            // 写入操作员操作记录
            if (PHP_SAPI != 'cli') {
                Yii::app()->db->createCommand()->insert('{{system_log}}', $log);
            }

            // 线上总账户
            $onlineAccount = CommonAccount::getOnlineAccount();
            //盖网通收益账户
            $gaiIncomeBalance = CommonAccount::getEarningsAccount();
            // 商旅收益账户
            $travelCompanyBalance = AccountBalance::findRecord(array('account_id' => $travelCompany['id'], 'type' => AccountInfo::TYPE_MERCHANT, 'gai_number' => $travelCompany['gai_number']));
            // 供货商会员账户
            $providerMemberBalance = AccountBalance::findRecord(array('account_id' => $provider['member_id'], 'type' => AccountInfo::TYPE_MERCHANT, 'gai_number' => $provider['gai_number']));

            // 会员待返还账户
            $returnBalance = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountInfo::TYPE_RETURN, 'gai_number' => $member['gai_number']));
            // 推荐者消费账户
            if (isset($recommender)) {
                $recommenderBalance = AccountBalance::findRecord(array('account_id' => $recommender['id'], 'type' => AccountInfo::TYPE_CONSUME, 'gai_number' => $recommender['gai_number']));
            }

            // 借方（线上总账户）
            $flow['online'] = AccountFlow::mergeFlowData($order, $onlineAccount, array(
                'debit_amount' => $distribute['expend'],
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_COMPLETE,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_FINISH,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
                'remark' => "酒店订单完成，线上总账户支出：￥{$distribute['expend']}",
            ));

            // 贷方（盖网通收益账户）
            $flow['gaiIncome'] = AccountFlow::mergeFlowData($order, $gaiIncomeBalance, array(
                'credit_amount' => $distribute['gaiEarnings'],
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_COMPLETE,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_PROFIT,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
                'distribution_ratio' => $distribute['gaiRatio'],
                'remark' => "酒店订单完成，盖网通收益账户收入：￥{$distribute['gaiEarnings']}",
            ));

            // 贷方（商旅收益账户）
            $flow['earnings'] = AccountFlow::mergeFlowData($order, $travelCompanyBalance, array(
                'credit_amount' => $distribute['businessTravelIncome'],
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_COMPLETE,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_PROFIT,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
                'distribution_ratio' => $distribute['businessTravelRatio'],
                'remark' => "酒店订单完成，商旅收益账户收入：￥{$distribute['businessTravelIncome']}",
            ));
            // 贷方（供货商会员账户）
            $flow['merchant'] = AccountFlow::mergeFlowData($order, $providerMemberBalance, array(
                'type' => AccountInfo::TYPE_MERCHANT,
                'credit_amount' => $distribute['costing'],
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_COMPLETE,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_COST,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
                'remark' => "酒店订单完成，供货商会员账户收入：￥{$distribute['costing']}",
            ));
            // 该会员存在推荐者
            if (!empty($recommender) && !empty($recommenderBalance)) {
                // 贷方（消费者推荐者）
                $flow['recommender'] = AccountFlow::mergeFlowData($order, $recommenderBalance, array(
                    'credit_amount' => $distribute['recommenderEarnings'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_COMPLETE,
                    'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_DISTRIBUTION,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
                    'ratio' => $memberType[$recommender['type_id']],
                    'distribution_ratio' => $distribute['recommenderRatio'],
                    'by_gai_number' => $member['gai_number'], // 被推荐人的GW
                    'remark' => "酒店订单完成，返还金额：￥{$distribute['recommenderEarnings']}",
                ));
            }
            // 如果酒店订单参与抽奖
            if ($order['is_lottery'] == HotelOrder::IS_LOTTERY_YES) {
                // 会员消费账户
                $consumerBalance = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountInfo::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
                // 贷方（会员待返还账户）
                $flow['consumer'] = AccountFlow::mergeFlowData($order, $consumerBalance, array(
                    'credit_amount' => $bonus,
                    'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_COMPLETE,
                    'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_LOTTERY,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
                    'ratio' => $memberType[$member['type_id']],
                    'remark' => "酒店订单完成，获得：￥{$bonus}奖金",
                ));
                // 更新会员消费者帐户余额（消费者帐户入账奖金）
                if (!AccountBalance::calculate(array('today_amount' => $bonus), $consumerBalance['id'])) {
                    throw new Exception('会员收款失败！');
                }
            }
            // 贷方（会员待返还账户）
            $flow['return_credit'] = AccountFlow::mergeFlowData($order, $returnBalance, array(
                'credit_amount' => $distribute['memberEarnings'],
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_COMPLETE,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_REWARD,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
                'ratio' => $memberType[$member['type_id']],
                'distribution_ratio' => $distribute['memberRatio'],
                'remark' => "酒店订单完成，获得：￥{$distribute['memberEarnings']}待返还金额",
            ));

            // 如果线上总账户余额不足以扣除
            if ($onlineAccount['today_amount'] < $distribute['expend']) {
                throw new Exception('线上总账户余额不足！');
            }
            // 线上总账户余额更新
            if (!AccountBalance::calculate(array('today_amount' => "-{$distribute['expend']}"), $onlineAccount['id'])) {
                throw new Exception('线上总账户扣款失败！');
            }
            // 线上收益账户余额更新
            if (!AccountBalance::calculate(array('today_amount' => "{$distribute['gaiEarnings']}"), $gaiIncomeBalance['id'])) {
                throw new Exception('线上收益账户收款失败！');
            }
            // 商旅收益账户余额更新
            if (!AccountBalance::calculate(array('today_amount' => $distribute['businessTravelIncome']), $travelCompanyBalance['id'])) {
                throw new Exception('商旅收益账户收款失败！');
            }
            // 供货商会员账户余额更新
            if (!AccountBalance::calculate(array('today_amount' => $distribute['costing']), $providerMemberBalance['id'])) {
                throw new Exception('供货商收款失败！');
            }
            // 该会员存在推荐者余额更新
            if (!empty($recommender) && !empty($recommenderBalance)) {
                // 会员推荐者消费账户余额更新
                if (!AccountBalance::calculate(array('today_amount' => $distribute['recommenderEarnings']), $recommenderBalance['id'])) {
                    throw new Exception('会员推荐者收款失败！');
                }
            }
            // 更新会员待返还账户余额更新（会员分配金额入账待返还账户）
            if (!AccountBalance::calculate(array('today_amount' => $distribute['memberEarnings']), $returnBalance['id'])) {
                throw new Exception('会员待返还账户收款失败！');
            }

            // 记录流水
            foreach ($flow as $row) {
                if (!Yii::app()->db->createCommand()->insert($monthFlowTable, $row)) {
                    throw new Exception('流水记录失败！');
                }
            }

            // 验证流水表发生额
            if (!DebitCredit::checkFlowByCode($monthFlowTable, $order['code'])) {
                throw new Exception('流水表发生额不平衡！');
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
        // 发送酒店订单完成短信
        self::sendSms($order, $member, $memberResult, $bonus, $recommender, $memberReferResult, $sendSms);
        return true;
    }

    /**
     * 酒店订单完成短信发送
     * @param array $order 订单属性
     * @param array $member 会员属性
     * @param array $memberResult 会员分配计算结果
     * @param float $bonus 奖金
     * @param array $recommender 会员推荐者属性
     * @param array $memberReferResult 会员推荐者分配计算结果
     * @param boolean $sendSms 会员推荐者分配计算结果
     */
    public static function sendSms($order, $member, $memberResult, $bonus, $recommender, $memberReferResult, $sendSms) {
        if ($sendSms != true)
            return;
        // 如有抽奖，发送中奖短信给消费者会员
        if ($order['is_lottery'] == HotelOrder::IS_LOTTERY_YES) {
            $totalMoney = Member::getTotalPrice(AccountInfo::TYPE_CONSUME, $member['id'], $member['gai_number']); // 消费者帐号总金额
            $totalIntegral = Common::convertSingle($totalMoney, $member['type_id']); // 消费者帐号总积分
            // 发送消费者中奖积分短信息
            $temp = Tool::getConfig('smsmodel', 'hotelOrderCompletePrize');
            // 尊敬的{0}用户，您预订的{1}到{2}入住{3}{4}订单已完成，恭喜您通过该订单抽奖获得{5}积分。当前剩余{6}积分。 改：2014/08/07
             $settled_time = date("Y-m-d", $order['settled_time']);
            $leave_time = date("Y-m-d", $order['leave_time']);
            $msg = strtr($temp, array(
                '{0}' => $member['gai_number'],
                '{1}' => $settled_time,
                '{2}' => $leave_time,
                '{3}' => $order['hotel_name'],
                '{4}' => $order['room_name'],
                '{5}' => Common::convertSingle($bonus, $member['type_id']),
                '{6}' => $totalIntegral,
            ));
             $datas = array($member['gai_number'], $settled_time, $leave_time, $order['hotel_name'], $order['room_name'], Common::convertSingle($bonus, $member['type_id']),$totalIntegral);
             $tmpId = Tool::getConfig('smsmodel','hotelOrderCompletePrizeId');
            SmsLog::addSmsLog($member['mobile'], $msg, $order['id'], SmsLog::TYPE_HOTEL_ORDER,null,true, $datas, $tmpId); // 记录并短息日志
        }

        // 发送返还积分短信息
        $temp = Tool::getConfig('smsmodel', 'hotelOrderCompleteReturn');
        // 尊敬的{0}用户，您预定的{1}到{2}入住{3}{4}，已完成，您获得{5}返还积分，暂时冻结，评价完成后解冻。
        $incomeIntegral = Common::convertSingle($memberResult['memberIncome'], $member['type_id']);
        $settled_time = date("Y-m-d", $order['settled_time']);
        $leave_time = date("Y-m-d", $order['leave_time']);
        $msg = strtr($temp, array(
            '{0}' => $member['gai_number'],
            '{1}' => $settled_time,
            '{2}' =>$leave_time ,
            '{3}' => $order['hotel_name'],
            '{4}' => $order['room_name'],
            '{5}' => $incomeIntegral,
        ));
        $datas = array($member['gai_number'], $settled_time, $leave_time, $order['hotel_name'], $order['room_name'], $incomeIntegral);
        $tmpId2 = Tool::getConfig('smsmodel','hotelOrderCompleteReturnId');
        SmsLog::addSmsLog($member['mobile'], $msg, $order['id'], SmsLog::TYPE_HOTEL_ORDER,null,true, $datas, $tmpId2); // 记录并短息日志
        // 如消费者有推荐会员
        if (!empty($recommender)) {
            // 推荐者获得积分短信息
            $memberReferIncomeIntegral = Common::convertSingle($memberReferResult['memberReferIncome'], $recommender['type_id']);
            $temp = Tool::getConfig('smsmodel', 'hotelOrderCompleteMemref');
            // 尊敬的{0}用户，酒店订单{1}完成交易，您作为买家{2}的推荐者，获得推荐积分{3}盖网积分，此积分可以兑现。
            $msg = strtr($temp, array(
                '{0}' => $recommender['gai_number'],
                '{1}' => $order['code'],
                '{2}' => $member['gai_number'],
                '{3}' => $memberReferIncomeIntegral,
            ));
            $datas = array($recommender['gai_number'], $order['code'], $member['gai_number'], $memberReferIncomeIntegral);
            $tmpId3 = Tool::getConfig('smsmodel','hotelOrderCompleteMemrefId');
            SmsLog::addSmsLog($recommender['mobile'], $msg, $order['id'], SmsLog::TYPE_HOTEL_ORDER,null,true, $datas, $tmpId3); // 记录并短息日志
        }
    }

}
