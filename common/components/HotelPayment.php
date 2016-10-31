<?php

/**
 * 酒店订单支付类
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class HotelPayment {

    /**
     * 积分支付
     * @param array   $order   订单
     * @param array   $member  消费会员
     * @param float $useMoney 新余额表还须扣除多少钱
     * @param boolean $sendSms 是否发送短信息，默认发送
     * @return boolean
     */
    public static function payWithIntegration(array $order, array $member = null, $useMoney = 0.00, $sendSms = true)
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

        $monthFlowTable = AccountFlow::monthTable(); // 当月流水表名
        $flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志表名
        $lotteryPrice = $order['is_lottery'] == HotelOrder::IS_LOTTERY_YES ? $order['lottery_price'] : 0; // 抽奖支付金额
        $orderAmount = bcadd($order['total_price'], $lotteryPrice, HotelCalculate::SCALE); // 订单总额

        // 酒店订单表更新
        $update = array(
            'pay_status' => HotelOrder::PAY_STATUS_YES,
            'payed_price' => $order['total_price'],
            'unpay_price' => 0.0,
            'pay_time' => time(),
        );

        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //再次查询订单状态--begin
            $sql = "SELECT * FROM {{hotel_order}} WHERE code = :code And member_id = :mid And status = :status And pay_status = :payStatus FOR UPDATE";
            /** @var HotelOrder $model 酒店订单实例 */
            $model = HotelOrder::model()->findBySql($sql, array(
                    ':code' => $order['code'], ':mid' => Yii::app()->user->id, ':status' => HotelOrder::STATUS_NEW, ':payStatus' => HotelOrder::PAY_STATUS_NO)
            );
            // 数据异常抛出错误
            if ($model == null) {
                throw new CHttpException(404, Yii::t('hotelOrder', '找不到该订单数据！'));
            }
            //再次查询订单状态--end

            // 获取查询余额表所需的数据
            $balanceArray = AccountBalance::getAccountBalanceArrayBuild($member);
            // 需要历史余额代扣的金额
            $useMoney = AccountBalance::getHistoryUseMoney($member['id'], $member['gai_number'], $orderAmount);
            // 历史余额转扣
            if ($useMoney > 0) {
                $memberBalance = AccountBalance::findRecord($balanceArray); // 会员消费者账户余额
                $historyBalance = AccountBalanceHistory::findRecord($balanceArray); // 会员消费者账户历史余额
                if (!HistoryBalanceUse::process($monthFlowTable,$flowHistoryTableName, $memberBalance, $historyBalance, $useMoney, $order['code'], $order['id'],  $order['code'])) {
                    throw new Exception('余额转扣失败！');
                }
            }

            // 酒店订单更新
            if (!Yii::app()->db->createCommand()->update('{{hotel_order}}', $update, 'id = :id AND status = :status AND pay_status = :pstatus',
                array(':id' => $order['id'], ':status' => HotelOrder::STATUS_NEW, ':pstatus' => HotelOrder::PAY_STATUS_NO))) {
                throw new Exception('订单数据异常！');
            }

            $memberBalance = AccountBalance::findRecord($balanceArray); // 会员消费者账户
            $onlineAccount = CommonAccount::getOnlineAccount(); // 线上总账户

            // 借方（会员消费者账户）
            $debit = AccountFlow::mergeFlowData($order, $memberBalance, array(
                'debit_amount' => $orderAmount,
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_PAY,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_BOOK,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
                'remark' => "酒店订单支付，扣除金额：￥{$orderAmount}" . ($lotteryPrice > 0 ? "，含抽奖支付金额：￥{$lotteryPrice}" : ""),
            ));

            // 贷方（线上总账户）
            $credit = AccountFlow::mergeFlowData($order, $onlineAccount, array(
                'credit_amount' => $orderAmount,
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_PAY,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_CHECK,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
                'remark' => "酒店订单支付，线上总账户收入：￥{$orderAmount}",
            ));

            // 如果会员消费者账户余额不足以扣除
            if ($orderAmount <= 0 || $memberBalance['today_amount'] < $orderAmount) {
                throw new Exception('账户余额不足！');
            }

            // 会员账户余额更新
            if (!AccountBalance::calculate(array('today_amount' => "-{$orderAmount}"), $memberBalance['id'])) {
                throw new Exception('会员扣款失败！');
            }
            // 线上总账户
            if (!AccountBalance::calculate(array('today_amount' => "{$orderAmount}"), $onlineAccount['id'])) {
                throw new Exception('线上总账户收款失败！');
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

            // 网银代扣
            if(!HistoryBalanceUse::pay($order['code'], $useMoney, $member, $order['parent_code'])){
                throw new Exception('网银代扣失败');
            }

            /***********会员积分余额start-20160815 @author wyee************************************/          
            $memberId=$member['id'];
            //积分支付，会员额度限制
            $jfprice=$order['total_price'];//多个订单或者单个订
            //会员总余额
            $balanceAllMoney=AccountBalance::getAccountAllBalance($member['gai_number'], AccountBalance::TYPE_CONSUME);
            $memberPointArr=MemberPoint::getMemberPoint($memberId,$balanceAllMoney);
            $dataArr=array();
            $dayMoney='';
            $mouthMoney='';
            if(isset($memberPointArr['flag'])){
             if( !$memberPointArr['flag'] ){
            	$dayMoney=bcsub($memberPointArr['info']['day_usable_point'],$jfprice,2);
            	$mouthMoney=bcsub($memberPointArr['info']['month_usable_point'],$jfprice,2);
            	$dataArr['member_id']=$memberId;
            	$dataArr['grade_id']=$memberPointArr['info']['id'];
            	$dataArr['day_point']=$memberPointArr['info']['day_usable_point'];
            	$dataArr['month_point']=$memberPointArr['info']['month_usable_point'];
            	$dataArr['day_limit_point']=$dayMoney;
            	$dataArr['month_limit_point']=$mouthMoney;
            	$dataArr['create_time']=time();
            	$dataArr['update_time']=time();
            	Yii::app()->db->createCommand()->insert('{{member_point}}', $dataArr);
            }else{
            	$dayMoney=bcsub($memberPointArr['info']['day_limit_point'],$jfprice,2);
            	$mouthMoney=bcsub($memberPointArr['info']['month_limit_point'],$jfprice,2);
            	Yii::app()->db->createCommand()->update('{{member_point}}', array(
            	'day_limit_point' => $dayMoney,
            	'month_limit_point' => $mouthMoney,
            	'update_time' => time(),
            	), 'member_id=:mid', array(':mid' => $memberId));
              }
            }
            
            /*****************************会员积分余额end*********************************/
            
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            HistoryBalanceUse::errorLog(); // 记录代扣错误日志
            return false;
        }
        self::sendSms($order, $member);
        return true;
    }

    /**
     * 第三方网银支付
     * @param array $order   订单
     * @param array $result  支付接口返回的数据
     * @param boolean $sendSms 是否发送短信息，默认发送
     * @return boolean
     */
    public static function payWithThirdParty(array $order, $result = array(), $sendSms = true)
    {
        $member = Yii::app()->db->createCommand()
            ->select('id, type_id, gai_number, mobile')
            ->from('{{member}}')
            ->where('id = :id', array(':id' => $order['member_id']))
            ->queryRow();
        if (!$member) return false;

        $monthFlowTable = AccountFlow::monthTable(); // 当月流水表名
        $lotteryPrice = $order['is_lottery'] == HotelOrder::IS_LOTTERY_YES ? $order['lottery_price'] : 0; // 抽奖支付金额
        $orderAmount = bcadd($order['total_price'], $lotteryPrice, HotelCalculate::SCALE); // 订单总额

        // 酒店订单表更新
        $update = array(
            'pay_status' => HotelOrder::PAY_STATUS_YES,
            'status' => HotelOrder::STATUS_NEW,
            'payed_price' => $order['total_price'],
            'unpay_price' => 0,
            'pay_time' => time(),
        );

        // 事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            // 酒店订单更新
            if (!Yii::app()->db->createCommand()->update('{{hotel_order}}', $update, 'id = :id AND pay_status = :pstatus',
                array(':id' => $order['id'], ':pstatus' => HotelOrder::PAY_STATUS_NO))) {
                throw new Exception('订单数据异常！');
            }

            // 获取查询余额表所需的数据
            $balanceArray = AccountBalance::getAccountBalanceArrayBuild($member);
            // 会员消费者账户余额
            $memberBalance = AccountBalance::findRecord($balanceArray);

            $flow = array();
            // 贷方（会员消费者账户）
            $flow['credit_member'] = AccountFlow::mergeFlowData($order, $memberBalance, array(
                'credit_amount' => $orderAmount,
                'operate_type' => AccountFlow::OPERATE_TYPE_ASSIGN_TWO,
                'node' => AccountFlow::BUSINESS_NODE_ASSIGN_TWO,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_ASSIGN,
                'remark' => OnlinePay::getPayWay($order['pay_type']),
            ));

            // 会员消费者账户余额更新
            if (!AccountBalance::calculate(array('today_amount' => $orderAmount), $memberBalance['id'])) {
                throw new Exception('会员收款失败！');
            }

            // 线上总账户余额
            $onlineAccount = CommonAccount::getOnlineAccount();
            // 会员消费者账户余额
            $memberBalance = AccountBalance::findRecord($balanceArray);

            // 借方（会员消费者账户）
            $flow['debit_member'] = AccountFlow::mergeFlowData($order, $memberBalance, array(
                'debit_amount' => $orderAmount,
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_PAY,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_BOOK,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
                'remark' => "酒店订单支付，扣除金额：￥{$orderAmount}" . ($lotteryPrice > 0 ? "，含抽奖支付金额：￥{$lotteryPrice}" : ""),
            ));
            // 贷方（线上总账户）
            $flow['credit_temp'] = AccountFlow::mergeFlowData($order, $onlineAccount, array(
                'credit_amount' => $orderAmount,
                'operate_type' => AccountFlow::OPERATE_TYPE_HOTEL_ORDER_PAY,
                'node' => AccountFlow::BUSINESS_NODE_HOTEL_ORDER_CHECK,
                'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
                'remark' => "酒店订单支付，线上总账户收入：￥{$orderAmount}",
            ));
                
            // 如果会员消费者账户余额不足以扣除
            if ($orderAmount <= 0 || $memberBalance['today_amount'] < $orderAmount) {
                throw new Exception('账户余额不足！');
            }

            // 会员账户余额更新
            if (!AccountBalance::calculate(array('today_amount' => "-{$orderAmount}"), $memberBalance['id'])) {
                throw new Exception('会员扣款失败！');
            }
            // 线上总账户余额更新
            if (!AccountBalance::calculate(array('today_amount' => "{$orderAmount}"), $onlineAccount['id'])) {
                throw new Exception('线上总账户收款失败！');
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
        self::sendSms($order, $member);
        return true;
    }

    /**
     * 酒店支付成功短信发送方法
     * @param array $order 酒店订单属性
     * @param array $member 会员属性
     * @param bool $sendSms 是否发送短信息，默认发送
     */
    public static function sendSms($order, $member, $sendSms = true) {
        if ($sendSms === true) {
            $sms = array();
            $totalMoney = Member::getTotalPrice(AccountInfo::TYPE_CONSUME, $member['id'], $member['gai_number']); // 会员剩余总金额
            $usableIntegral = Common::convertSingle($totalMoney, $member['type_id']); // 消费账户剩余积分
            $smsConfig = Tool::getConfig('smsmodel');
            // 如果该订单参与抽奖，发送抽奖短信
            if ($order['is_lottery'] == HotelOrder::IS_LOTTERY_YES) {
                // 尊敬的{0}用户，您预订的{1}到{2}入住{3}{4}，已成功支付订单使用{5}盖网积分,并参与了酒店抽奖使用{6}盖网积分。此短信为支付成功的通知，您还未能入住。酒店管家会在2小时内确认订单，确认成功后才能办理入住。感谢您的预订！目前您还剩余{7}消费积分，请您核实。
                $temp = Tool::getConfig('smsmodel', 'hotelOrderLotterPay');              
                $settled_time = date('Y-m-d', $order['settled_time']);
                $leave_time =  date('Y-m-d', $order['leave_time']);
                $msg = strtr($temp, array(
                    '{0}' => $member['gai_number'],
                    '{1}' => $settled_time,
                    '{2}' => $leave_time,
                    '{3}' => $order['hotel_name'],
                    '{4}' => $order['room_name'],
                    '{5}' => Common::convertSingle($order['total_price'], $member['type_id']),
                    '{6}' => Common::convertSingle($order['lottery_price'], $member['type_id']),
                    '{7}' => $usableIntegral,
                ));
                $datas =array($member['gai_number'], $settled_time, $leave_time, $order['hotel_name'], $order['room_name'], Common::convertSingle($order['total_price'], $member['type_id']),Common::convertSingle($order['lottery_price'], $member['type_id']),$usableIntegral);               
                $tmpId = $smsConfig['hotelOrderLotterPayId'];
            } else {
                // 尊敬的{0}用户，您预订的{1}到{2}入住{3}{4}，已成功支付使用{5}盖网积分。此短信为支付成功的通知，您还未能入住。酒店管家会在2小时内确认订单，确认成功后才能办理入住。感谢您的预订！目前您还剩余{6}消费积分，请您核实。
                $temp = Tool::getConfig('smsmodel', 'hotelOrderPay');
                $settled_time = date('Y-m-d', $order['settled_time']);
                $leave_time =  date('Y-m-d', $order['leave_time']);
                $msg = strtr($temp, array(
                    '{0}' => $member['gai_number'],
                    '{1}' => $settled_time,
                    '{2}' =>$leave_time,
                    '{3}' => $order['hotel_name'],
                    '{4}' => $order['room_name'],
                    '{5}' => Common::convertSingle($order['total_price'], $member['type_id']),
                    '{6}' => $usableIntegral,
                ));
                   $datas = array($member['gai_number'], $settled_time, $leave_time, $order['hotel_name'], $order['room_name'], Common::convertSingle($order['total_price'], $member['type_id']),$usableIntegral);
                   $tmpId = $smsConfig['hotelOrderPayId'];
            }         
            SmsLog::addSmsLog($member['mobile'], $msg,$order['id'], SmsLog::TYPE_HOTEL_ORDER,null,true, $datas, $tmpId); // 记录并短息日志
        }
    }

}
