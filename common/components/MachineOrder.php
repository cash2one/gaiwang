<?php

/**
 * 盖网通商城订单 
 * @author lc
 */
class MachineOrder {

    const MACHINE_PRODUCT_ORDER_CASH_CONTENT = '尊敬的盖网会员{0}，盖网通商城订单{1}完成交易，您获得供货价{2}，可用于提现。';
    const MACHINE_PRODUCT_ORDER_MACHINE_OWNER_CONTENT = '尊敬的盖网会员{0}，在您的盖机{1}上生成的盖网通商城订单{2}完成交易，您获得{3}盖网积分作为奖励，此积分可兑现。';
    const MACHINE_PRODUCT_ORDER_CONSUMER_MEMBER_CONTENT = '尊敬的盖网会员{0}，盖网通商城订单{1}完成交易，您获得{2}返还积分，此积分可兑现。';
    const MACHINE_PRODUCT_ORDER_TUIJIANCUNZAI_MEMBER_CONTENT = '尊敬的盖网会员{0}，您推荐的会员{1}的盖网通商城订单{2}完成交易，您获得{3}盖网积分，此积分可兑现。';
    const MACHINE_PRODUCT_ORDER_TUIJIAN_MEMBER_CONTENT = '盖网通商城订单{0}完成交易，订单总价{1}，由于不存在推荐者，推荐金额{2}进入盖网。';
    const MACHINE_PRODUCT_ORDER_AGENT_DISTRIBUTE_CONTENT = '盖网会员{0}的盖网通商城订单{1}完成交易，订单总价{2}，代理获得{3}。';
    const MACHINE_PRODUCT_ORDER_JIDONG_CONTENT = '盖网会员{0}的盖网通商城订单{1}完成交易，订单总价{2}元，机动获得{3}。';
    const MACHINE_PRODUCT_ORDER_MACHINE_INTRO_CONTENT = '盖网通商城订单{0}完成交易，订单总价{1}，您作为该盖网机的推荐者，获得{2}盖网积分，此积分可兑现。';
    const MACHINE_PRODUCT_ORDER_MACHINE_INTRO_NO_CONTENT = '盖网通商城订单{0}完成交易，订单总价{1}，由于盖网机不存在推荐者，分配金额{2}进入盖网。';
    const MACHINE_PRODUCT_ORDER_OFFREFMACHINE_CONTENT = '盖网通商城订单{0}完成交易，订单总价{1}，由于该会员最近一次在您这里消费，因此奖励您{2}盖网积分，此积分可兑现。';
    const MACHINE_PRODUCT_ORDER_OFFREFMACHINE_NO_CONTENT = '盖网通商城订单{0}完成交易，订单总价{1}，由于不存在最近一次消费的加盟商，分配金额{2}进入盖网。';
    const MACHINE_PRODUCT_ORDER_GAIWANG_CONTENT = '盖网会员{0}的盖网通商城订单{1}完成交易，订单总价{2}，盖网获得{3}。';

    /**
     * 格子铺消费
     * Enter description here ...
     * @param unknown_type $franchisee
     * @param unknown_type $member
     * @param unknown_type $userPhone
     * @param unknown_type $moneyRMB
     * @param unknown_type $goods
     * @param unknown_type $payType
     * @param unknown_type $franchiseeId
     * @param unknown_type $quantity
     * @param unknown_type $ip
     * @param unknown_type $symbol
     * @param unknown_type $basePrice
     * @param unknown_type $machineId
     * @param unknown_type $machineName
     * @param unknown_type $consumeCode
     * @param unknown_type $orderCode
     */
    public static function consume($franchisee, $member, $userPhone, $moneyRMB, $goods, $payType, $franchiseeId, $quantity, $ip, $symbol, $basePrice, $machineId, $machineName, $consumeCode, $orderCode) {
        //创建南北盖网通消费公共账户
        $regionTable = Region::model()->tableName();
        $area_id = Yii::app()->db->createCommand()->select('area')->from($regionTable)->where('id=' . $franchisee['province_id'])->queryScalar();
        if ($area_id == Region::AREA_NORTH) {
            $virtualCommonAccount = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_NORTH_MACHINE);
            $distributeCommonAccount = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_NORTH_MACHINE_DISTRIBUTE);
        } else {
            $virtualCommonAccount = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_SOUTH_MACHINE);
            $distributeCommonAccount = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_SOUTH_MACHINE_DISTRIBUTE);
        }

        $order = MachineOrder::addOrder($orderCode, $machineId, $member['id'], $userPhone, $payType, $moneyRMB, $goods['market_price'] * $quantity, $goods['market_price'] * $quantity, $ip, $franchiseeId, $symbol, $basePrice);
        $orderDetial = MachineOrder::addOrderDetial($order['id'], $goods, $quantity, $consumeCode);

        //商家得到成本价
        $store_money = $orderDetial['total_price'] * (1 - $orderDetial['back_rate'] / 100);
        $store_money = IntegralOfflineNew::getNumberFormat($store_money);
        //分配金额
        $dist_money = $orderDetial['total_price'] - $store_money;
        // 记录
        MachineOrder::machineOrderConsume($moneyRMB, $member, $franchisee, $machineName, $orderCode, $orderDetial['id'], $ip, $area_id, $virtualCommonAccount, $distributeCommonAccount, $store_money, $dist_money);
        return $orderDetial['id'];
    }

    public static function addOrder($orderCode, $machineId, $memberId, $userPhone, $payType, $moneyRMB, $marketPrice, $original_price, $ip, $franchiseeId, $symbol, $basePrice) {
        $now = time();
        $orderData = array(
            'code' => $orderCode,
            'machine_id' => $machineId,
            'member_id' => $memberId,
            'phone' => $userPhone,
            'pay_type' => $payType,
            'status' => '1',
            'pay_status' => '2',
            'consume_status' => '1',
            'pay_price' => $moneyRMB,
            'real_price' => $moneyRMB,
            'original_price' => $marketPrice,
            'return_money' => '0',
            'create_time' => $now,
            'pay_time' => $now,
            'consume_time' => '0',
            'is_read' => '0',
            'ip_address' => $ip,
            'remark' => '',
            'franchisee_id' => $franchiseeId,
            'symbol' => $symbol,
            'base_price' => $basePrice
        );
        Yii::app()->db->createCommand()->insert('{{machine_product_order}}', $orderData);
        $orderData['id'] = Yii::app()->db->getLastInsertID();
        return $orderData;
    }

    public static function addOrderDetial($orderId, $goods, $quantity, $verifyCode) {
        $orderData = array(
            'machine_product_order_id' => $orderId,
            'product_id' => $goods['id'],
            'product_name' => $goods['name'],
            'quantity' => $quantity,
            'product_thumbnail_id' => $goods['thumbnail_id'],
            'total_price' => $goods['price'] * $quantity,
            'price' => $goods['price'],
            'original_price' => $goods['price'] * $quantity,
            'return_money' => 0,
            'verify_code' => $verifyCode,
            'is_consumed' => 0,
            'remark' => '',
            'gw_rate' => Common::getConfig('allocation', 'gaiIncome'),
            'gt_rate' => $goods['gt_rate'],
            'back_rate' => $goods['back_rate'],
        );
        Yii::app()->db->createCommand()->insert('{{machine_product_order_detail}}', $orderData);
        $orderData['id'] = Yii::app()->db->getLastInsertID();
        return $orderData;
    }

    public static function machineOrderConsume($moneyRMB, $member, $franchisee, $machineName, $orderCode, $recordId, $ip, $area_id, $virtualCommonAccount, $distributeCommonAccount, $store_money, $dist_money) {
        $score = Common::convertSingle($moneyRMB, $member['type_id']);
        $content = '尊敬的盖网会员：{0}，您在线下加盟商【{1}】所属盖网通【{2}】支付订单【{3}】，共消费￥{4}，使用{5}盖网积分支付';
        $content = str_replace(array('{0}', '{1}', '{2}', '{3}', '{4}', '{5}'), array($member['gai_number'], $franchisee['franchisee_name'], $machineName, $orderCode, $moneyRMB, $score), $content);
        $wealthTable = Wealth::model()->tableName();
        $wealth = array(
            'owner' => Wealth::OWNER_MEMBER,
            'member_id' => $member['id'],
            'gai_number' => $member['gai_number'],
            'type_id' => Wealth::TYPE_GAI,
            'score' => -$score,
            'money' => -$moneyRMB,
            'source_id' => Wealth::SOURCE_GT_ORDER,
            'target_id' => $recordId,
            'content' => $content,
            'create_time' => time(),
            'ip' => $ip,
            'status' => '2',
        );
        Yii::app()->db->createCommand()->insert($wealthTable, $wealth);

        //插入流水表，并更新余额lc
        $time = time();
        $accountFlowTable = AccountFlow::currentTableName($time);
        //消费者扣款
        $memberBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $member['id'],
                    'gai_number' => $member['gai_number'],
                    'name' => $member['username'],
                    'owner_type' => AccountFlow::OWNER_MEMBER
        ));
        $newMemberBalance = AccountBalance::updateAccountBalance($memberBalance, $moneyRMB, AccountBalance::OFFLINE_TYPE_DEDUCT);
        //消费者插入记录
        $accountFlow = array(
            'account_id' => $member['member_id'],
            'gai_number' => $member['gai_number'],
            'account_name' => $member['username'],
            'debit_amount' => $moneyRMB,
            'create_time' => $time,
            'debit_previous_amount_cash' => $memberBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $memberBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newMemberBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newMemberBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $memberBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $memberBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newMemberBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newMemberBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $memberBalance['debit_today_amount'],
            'credit_previous_amount' => $memberBalance['today_amount'],
            'debit_current_amount' => $newMemberBalance['debit_today_amount'],
            'credit_current_amount' => $newMemberBalance['today_amount'],
            'debit_previous_amount_frezee' => $memberBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $memberBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newMemberBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newMemberBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER,
            'trade_space' => $franchisee['street'],
            'trade_space_id' => $franchisee['district_id'],
            'trade_terminal' => $franchisee['machine_id'],
            'target_id' => $recordId,
            'code' => $orderCode,
            'owner_type' => AccountFlow::OWNER_MEMBER,
            'income_type' => AccountFlow::TYPE_GAI,
            'score_source' => AccountFlow::SOURCE_GT_ORDER,
            'remark' => $content,
            'serial_number' => $orderCode,
            'area_id' => $area_id,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $accountFlow);

        $remark = '盖网通商城订单';
        //虚拟账户(线下订单暂收账)扣钱
        $virtualBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $virtualCommonAccount['id'],
                    'name' => $virtualCommonAccount['name'],
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT
        ));
        $newVirtualBalance = AccountBalance::updateAccountBalance($virtualBalance, $store_money, AccountBalance::OFFLINE_TYPE_DEDUCT);
        $accountFlowVirtual = array(
            'account_id' => $newVirtualBalance['account_id'],
            'account_name' => $newVirtualBalance['name'],
            'credit_amount' => $store_money,
            'create_time' => $time,
            'debit_previous_amount_cash' => $virtualBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $virtualBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newVirtualBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newVirtualBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $virtualBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $virtualBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newVirtualBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newVirtualBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $virtualBalance['debit_today_amount'],
            'credit_previous_amount' => $virtualBalance['today_amount'],
            'debit_current_amount' => $newVirtualBalance['debit_today_amount'],
            'credit_current_amount' => $newVirtualBalance['today_amount'],
            'debit_previous_amount_frezee' => $virtualBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $virtualBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newVirtualBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newVirtualBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER,
            'trade_space' => $franchisee['street'],
            'trade_space_id' => $franchisee['district_id'],
            'trade_terminal' => $franchisee['machine_id'],
            'target_id' => $recordId,
            'code' => $orderCode,
            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            'income_type' => AccountFlow::TYPE_CASH,
            'score_source' => AccountFlow::SOURCE_GT_ORDER,
            'remark' => $remark,
            'serial_number' => $orderCode,
            'area_id' => $area_id,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $accountFlowVirtual);

        //分配账户扣钱
        $distributeBalance = AccountBalance::findAccountBalance(array(
                    'account_id' => $distributeCommonAccount['id'],
                    'name' => $distributeCommonAccount['name'],
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT
        ));
        $newDistributeBalance = AccountBalance::updateAccountBalance($distributeBalance, $dist_money, AccountBalance::OFFLINE_TYPE_DEDUCT);
        $accountFlowVirtual = array(
            'account_id' => $newDistributeBalance['account_id'],
            'account_name' => $newDistributeBalance['name'],
            'credit_amount' => $dist_money,
            'create_time' => $time,
            'debit_previous_amount_cash' => $distributeBalance['debit_today_amount_cash'],
            'credit_previous_amount_cash' => $distributeBalance['credit_today_amount_cash'],
            'debit_current_amount_cash' => $newDistributeBalance['debit_today_amount_cash'],
            'credit_current_amount_cash' => $newDistributeBalance['credit_today_amount_cash'],
            'debit_previous_amount_nocash' => $distributeBalance['debit_today_amount_nocash'],
            'credit_previous_amount_nocash' => $distributeBalance['credit_today_amount_nocash'],
            'debit_current_amount_nocash' => $newDistributeBalance['debit_today_amount_nocash'],
            'credit_current_amount_nocash' => $newDistributeBalance['credit_today_amount_nocash'],
            'debit_previous_amount' => $distributeBalance['debit_today_amount'],
            'credit_previous_amount' => $distributeBalance['today_amount'],
            'debit_current_amount' => $newDistributeBalance['debit_today_amount'],
            'credit_current_amount' => $newDistributeBalance['today_amount'],
            'debit_previous_amount_frezee' => $distributeBalance['debit_today_amount_frezee'],
            'credit_previous_amount_frezee' => $distributeBalance['credit_today_amount_frezee'],
            'debit_current_amount_frezee' => $newDistributeBalance['debit_today_amount_frezee'],
            'credit_current_amount_frezee' => $newDistributeBalance['credit_today_amount_frezee'],
            'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER,
            'trade_space' => $franchisee['street'],
            'trade_space_id' => $franchisee['district_id'],
            'trade_terminal' => $franchisee['machine_id'],
            'target_id' => $recordId,
            'code' => $orderCode,
            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            'income_type' => AccountFlow::TYPE_CASH,
            'score_source' => AccountFlow::SOURCE_GT_ORDER,
            'remark' => $remark,
            'serial_number' => $orderCode,
            'area_id' => $area_id,
        );
        Yii::app()->db->createCommand()->insert($accountFlowTable, $accountFlowVirtual);
    }

    /**
     * 获取分配的配置文件
     * @param $type 1 积分分配   2 代理分配
     */
    public static function getDisConfig($type, $key) {
        $config = self::getConfig($type, $key);
        return $config[$type][$key] / 100;
    }

    /**
     * 获取分配的配置文件（未作转化，用于存数据库）
     */
    public static function getConfig($type, $key = null) {
        static $disConfig = array();
        if (empty($disConfig)) {
//			$file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'allocation.config.inc';
            $disConfig[1] = Tool::getConfig($name = 'allocation');

//			$file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'agentdist.config.inc';
            $disConfig[2] = Tool::getConfig($name = 'agentdist');
        }
        if ($type === 0) {
            return $disConfig;
        }
        return $key === null ? $disConfig : $disConfig[$type][$key];
    }

    /**
     * 获取会员类型
     */
    static $member_type_rate;

    public static function getMemberTypeRate() {
        self::$member_type_rate = MemberType::fileCache();
    }

    /**
     * 盖网通商城订单确认消费
     * Enter description here ...
     * @param unknown_type $detail_id   订单详情的id
     * @param unknown_type $verify_code 验证码
     */
    public static function distribution($detail_id, $verify_code) {
        $detailTable = MachineProductOrderDetail::model()->tableName();
        $orderTable = MachineProductOrder::model()->tableName();
        $wealthTable = Wealth::model()->tableName();
        $time = time();
        $accountFlowTable = AccountFlow::currentTableName($time);

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $model = MachineProductOrderDetail::model()->findByPk($detail_id);
            if (empty($model)) {
                throw new ErrorException(Yii::t('machineProductOrder', '订单不存在'), 100);
            } elseif ($model->is_consumed == MachineProductOrderDetail::IS_CONSUMED_YES) {
                throw new ErrorException(Yii::t('machineProductOrder', '不能重复验证'), 101);
            } elseif ($model->verify_code != $verify_code) {
                throw new ErrorException(Yii::t('machineProductOrder', '验证码错误'), 102);
            }
            //执行分配
            //商家得到成本价
            $store_money = $model->total_price * (1 - $model->back_rate / 100);
            $store_money = IntegralOfflineNew::getNumberFormat($store_money);

            //分配金额
            $dist_money = $model->total_price - $store_money;

            /*             * 返还商家的供货价begin* */
            if (!isset($model->machineProductOrder->franchisee)) {
                throw new ErrorException(Yii::t('machineProductOrder', '商家不存在'), 103);
            }
            if (!isset($model->machineProductOrder->franchisee->member) || !isset($model->machineProductOrder->franchisee->member->childoffline)) {
                throw new ErrorException(Yii::t('machineProductOrder', '商家会员不存在'), 104);
            }

            //创建南北盖网通消费公共账户
            $regionTable = Region::model()->tableName();
            $area_id = Yii::app()->db->createCommand()->select('area')->from($regionTable)->where('id=' . $model->machineProductOrder->franchisee->province_id)->queryScalar();
            if ($area_id == Region::AREA_NORTH) {
                $virtualCommonAccount = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_NORTH_MACHINE);
                $distributeCommonAccount = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_NORTH_MACHINE_DISTRIBUTE);
            } else {
                $virtualCommonAccount = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_SOUTH_MACHINE);
                $distributeCommonAccount = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_SOUTH_MACHINE_DISTRIBUTE);
            }
            //虚拟账号加钱
            $virtualBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $virtualCommonAccount['id'],
                        'name' => $virtualCommonAccount['name'],
                        'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT
            ));
            $newVirtualBalance = AccountBalance::updateAccountBalance($virtualBalance, $store_money, AccountBalance::OFFLINE_TYPE_ADD);
            $store_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_CASH_CONTENT, array(
                        $model->machineProductOrder->franchisee->member->gai_number, $model->machineProductOrder->code, HtmlHelper::formatPrice($store_money)
            ));
            $accountFlowVirtual = array(
                'account_id' => $newVirtualBalance['account_id'],
                'account_name' => $newVirtualBalance['name'],
                'debit_amount' => $store_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $virtualBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $virtualBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newVirtualBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newVirtualBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $virtualBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $virtualBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newVirtualBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newVirtualBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $virtualBalance['debit_today_amount'],
                'credit_previous_amount' => $virtualBalance['today_amount'],
                'debit_current_amount' => $newVirtualBalance['debit_today_amount'],
                'credit_current_amount' => $newVirtualBalance['today_amount'],
                'debit_previous_amount_frezee' => $virtualBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $virtualBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newVirtualBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newVirtualBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                'trade_space' => $model->machineProductOrder->franchisee->street,
                'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                'trade_terminal' => $model->machine_id,
                'target_id' => $model->id,
                'code' => $model->machineProductOrder->code,
                'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'income_type' => AccountFlow::TYPE_CASH,
                'score_source' => AccountFlow::SOURCE_GT_ORDER,
                'remark' => $store_content,
                'serial_number' => $model->machineProductOrder->code,
                'area_id' => $area_id,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $accountFlowVirtual);
            //商家加钱
            if (!isset($model->machineProductOrder->franchisee->member->enterprise)) {
                throw new ErrorException(Yii::t('machineProductOrder', '商家提现账户不存在'), 104);
            }
            $storeBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $model->machineProductOrder->franchisee->member->enterprise->id,
                        'gai_number' => $model->machineProductOrder->franchisee->member->gai_number,
                        'name' => $model->machineProductOrder->franchisee->member->childoffline->username,
                        'owner_type' => AccountFlow::OWNER_COMPANY_INFO
            ));
            $newStoreBalance = AccountBalance::updateAccountBalance($storeBalance, $store_money, AccountBalance::OFFLINE_TYPE_ADD);
            $storeAccountFlow = array(
                'account_id' => $newStoreBalance['account_id'],
                'gai_number' => $newStoreBalance['gai_number'],
                'account_name' => $newStoreBalance['name'],
                'credit_amount' => $store_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $storeBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $storeBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newStoreBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newStoreBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $storeBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $storeBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newStoreBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newStoreBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $storeBalance['debit_today_amount'],
                'credit_previous_amount' => $storeBalance['today_amount'],
                'debit_current_amount' => $newStoreBalance['debit_today_amount'],
                'credit_current_amount' => $newStoreBalance['today_amount'],
                'debit_previous_amount_frezee' => $storeBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $storeBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newStoreBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newStoreBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                'trade_space' => $model->machineProductOrder->franchisee->street,
                'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                'trade_terminal' => $model->machine_id,
                'target_id' => $model->id,
                'code' => $model->machineProductOrder->code,
                'owner_type' => AccountFlow::OWNER_COMPANY_INFO,
                'income_type' => AccountFlow::TYPE_CASH,
                'score_source' => AccountFlow::SOURCE_GT_ORDER,
                'remark' => $store_content,
                'serial_number' => $model->machineProductOrder->code,
                'area_id' => $area_id,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $storeAccountFlow);
            //插入旧的日志表
            $wealthData = array(
                'owner' => AccountFlow::OWNER_COMPANY_INFO,
                'member_id' => $model->machineProductOrder->franchisee->member->id,
                'gai_number' => $model->machineProductOrder->franchisee->member->gai_number,
                'type_id' => AccountFlow::TYPE_CASH,
                'money' => $store_money,
                'source_id' => AccountFlow::SOURCE_GT_ORDER,
                'target_id' => $model->id,
                'content' => $store_content,
                'create_time' => $time,
                'ip' => $model->machineProductOrder->ip_address,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            /*             * 返还商家的供货价end* */

            /*             * *虚拟账户扣除分配金额begin** */
            $distributeBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $distributeCommonAccount['id'],
                        'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT
            ));
            $newDistributeVirtualBalance = AccountBalance::updateAccountBalance($distributeBalance, $dist_money, AccountBalance::OFFLINE_TYPE_ADD);
            $accountFlowVirtual = array(
                'account_id' => $newDistributeVirtualBalance['account_id'],
                'account_name' => $newDistributeVirtualBalance['name'],
                'debit_amount' => $dist_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $distributeBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $distributeBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newDistributeVirtualBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newDistributeVirtualBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $distributeBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $distributeBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newDistributeVirtualBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newDistributeVirtualBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $distributeBalance['debit_today_amount'],
                'credit_previous_amount' => $distributeBalance['today_amount'],
                'debit_current_amount' => $newDistributeVirtualBalance['debit_today_amount'],
                'credit_current_amount' => $newDistributeVirtualBalance['today_amount'],
                'debit_previous_amount_frezee' => $distributeBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $distributeBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newDistributeVirtualBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newDistributeVirtualBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                'trade_space' => $model->machineProductOrder->franchisee->street,
                'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                'trade_terminal' => $model->machine_id,
                'target_id' => $model->id,
                'code' => $model->machineProductOrder->code,
                'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'income_type' => AccountFlow::TYPE_CASH,
                'score_source' => AccountFlow::SOURCE_GT_ORDER,
                'remark' => '开始积分分配，扣除分配金额',
                'serial_number' => $model->machineProductOrder->code,
                'area_id' => $area_id,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $accountFlowVirtual);
            /*             * *虚拟账户扣除分配金额end** */

            /*             * *盖机收益--分配给盖机的拥有者begin** */
            self::getMemberTypeRate();
            $machine_money = $model->gt_rate / 100 * $dist_money;
            $machine_money = IntegralOfflineNew::getNumberFormat($machine_money);
            $ratio = self::$member_type_rate[$model->machineProductOrder->franchisee->member->type_id];
            $machine_integral = $machine_money / $ratio;
            $machine_owner_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_MACHINE_OWNER_CONTENT, array(
                        $model->machineProductOrder->franchisee->member->gai_number, $model->machineProductOrder->machine->name, $model->machineProductOrder->code, $machine_integral
            ));
            $machine_owner_balance = AccountBalance::findAccountBalance(array(
                        'account_id' => $model->machineProductOrder->franchisee->member_id,
                        'gai_number' => $model->machineProductOrder->franchisee->member->gai_number,
                        'name' => $model->machineProductOrder->franchisee->member->username,
                        'owner_type' => AccountFlow::OWNER_MEMBER,
            ));
            $machine_owner_balance_new = AccountBalance::updateAccountBalance($machine_owner_balance, $machine_money, AccountBalance::OFFLINE_TYPE_ADD);
            $accountFlow = array(
                'account_id' => $machine_owner_balance_new['account_id'],
                'gai_number' => $machine_owner_balance_new['gai_number'],
                'account_name' => $machine_owner_balance_new['name'],
                'credit_amount' => $machine_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $machine_owner_balance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $machine_owner_balance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $machine_owner_balance_new['debit_today_amount_cash'],
                'credit_current_amount_cash' => $machine_owner_balance_new['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $machine_owner_balance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $machine_owner_balance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $machine_owner_balance_new['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $machine_owner_balance_new['credit_today_amount_nocash'],
                'debit_previous_amount' => $machine_owner_balance['debit_today_amount'],
                'credit_previous_amount' => $machine_owner_balance['today_amount'],
                'debit_current_amount' => $machine_owner_balance_new['debit_today_amount'],
                'credit_current_amount' => $machine_owner_balance_new['today_amount'],
                'debit_previous_amount_frezee' => $machine_owner_balance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $machine_owner_balance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $machine_owner_balance_new['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $machine_owner_balance_new['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                'trade_space' => $model->machineProductOrder->franchisee->street,
                'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                'trade_terminal' => $model->machine_id,
                'target_id' => $model->id,
                'code' => $model->machineProductOrder->code,
                'owner_type' => AccountFlow::OWNER_MEMBER,
                'income_type' => AccountFlow::TYPE_GAI,
                'score_source' => AccountFlow::SOURCE_GT_ORDER,
                'remark' => $machine_owner_content,
                'serial_number' => $model->machineProductOrder->code,
                'ratio' => $ratio,
                'area_id' => $area_id,
            );
            $wealthData = array(
                'owner' => AccountFlow::OWNER_MEMBER,
                'member_id' => $machine_owner_balance_new['account_id'],
                'gai_number' => $machine_owner_balance_new['gai_number'],
                'type_id' => AccountFlow::TYPE_GAI,
                'score' => $machine_integral,
                'money' => $machine_money,
                'source_id' => AccountFlow::SOURCE_GT_ORDER,
                'target_id' => $model->id,
                'content' => $machine_owner_content,
                'create_time' => $time,
                'ip' => $model->machineProductOrder->ip_address,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            /*             * *盖机收益--分配给盖机的拥有者end** */

            //盖网拿来分的金额
            $gai_dist_money = $dist_money - $machine_money;
            //除去盖网收益的金额(用于分给其它角色)
            $distribute_money = (1 - $model->gw_rate / 100) * $gai_dist_money;
            $distribute_money = IntegralOfflineNew::getNumberFormat($distribute_money);

            /*             * *消费者begin** */
            $offConsume = IntegralOfflineNew::getDisConfig(1, 'offConsume') / 100;  //消费者
            $consumer_money = $distribute_money * $offConsume; //正式会员分的钱
            $consumer_integral = $consumer_money / self::$member_type_rate['official'];
            if ($model->machineProductOrder->member->type_id == self::$member_type_rate['defaultType']) {
                //如果是消费会员,该消费者分的钱要做相应的处理
                $consumer_money = $consumer_integral * self::$member_type_rate['default'];
            }
            $ratio = self::$member_type_rate[$model->machineProductOrder->member->type_id];
            $consumer_integral = IntegralOfflineNew::getNumberFormat($consumer_integral);
            $consumer_money = IntegralOfflineNew::getNumberFormat($consumer_money);
            $consumer_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_CONSUMER_MEMBER_CONTENT, array(
                        $model->machineProductOrder->member->gai_number, $model->machineProductOrder->code, $consumer_integral
            ));
            $consumerAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $model->machineProductOrder->member->id,
                        'gai_number' => $model->machineProductOrder->member->gai_number,
                        'name' => $model->machineProductOrder->member->username,
                        'owner_type' => AccountFlow::OWNER_MEMBER,
            ));
            $newConsumerAccountBalance = AccountBalance::updateAccountBalance($consumerAccountBalance, $consumer_money, AccountBalance::OFFLINE_TYPE_ADD);
            $consumerAccountFlow = array(
                'account_id' => $newConsumerAccountBalance['account_id'],
                'gai_number' => $newConsumerAccountBalance['gai_number'],
                'account_name' => $newConsumerAccountBalance['name'],
                'credit_amount' => $consumer_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $consumerAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $consumerAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newConsumerAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newConsumerAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $consumerAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $consumerAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newConsumerAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newConsumerAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $consumerAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $consumerAccountBalance['today_amount'],
                'debit_current_amount' => $newConsumerAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newConsumerAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $consumerAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $consumerAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newConsumerAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newConsumerAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                'trade_space' => $model->machineProductOrder->franchisee->street,
                'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                'trade_terminal' => $model->machine_id,
                'target_id' => $model->id,
                'code' => $model->machineProductOrder->code,
                'owner_type' => AccountFlow::OWNER_MEMBER,
                'income_type' => AccountFlow::TYPE_GAI,
                'score_source' => AccountFlow::SOURCE_GT_ORDER,
                'remark' => $consumer_content,
                'serial_number' => $model->machineProductOrder->code,
                'ratio' => $ratio,
                'area_id' => $area_id,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $consumerAccountFlow);
            //插入旧的日志表
            $wealthData = array(
                'owner' => AccountFlow::OWNER_MEMBER,
                'member_id' => $newConsumerAccountBalance['account_id'],
                'gai_number' => $newConsumerAccountBalance['gai_number'],
                'type_id' => AccountFlow::TYPE_GAI,
                'score' => $consumer_integral,
                'money' => $consumer_money,
                'source_id' => AccountFlow::SOURCE_GT_ORDER,
                'target_id' => $model->id,
                'content' => $consumer_content,
                'create_time' => $time,
                'ip' => $model->machineProductOrder->ip_address,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            /*             * *消费者end** */

            /*             * *消费者的推荐者begin** */
            $offRef = self::getDisConfig(1, 'offRef') / 100;
            $referrals_money = $distribute_money * $offRef; //正式推荐者分的钱
            $cityCommonAccount = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_GAI, $model->machineProductOrder->franchisee->city_id);
            if (isset($model->machineProductOrder->member->referrals)) {
                $referrals_integral = $referrals_money / self::$member_type_rate['official'];
                if ($model->machineProductOrder->member->referrals->type_id == self::$member_type_rate['defaultType']) {
                    //如果是消费推荐者
                    $referrals_money = $referrals_integral * self::$member_type_rate['default'];
                }
                $ratio = self::$member_type_rate[$model->machineProductOrder->member->referrals->type_id];
                $referrals_money = IntegralOfflineNew::getNumberFormat($referrals_money);
                $referrals_integral = IntegralOfflineNew::getNumberFormat($referrals_integral);
                $referrals_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_TUIJIANCUNZAI_MEMBER_CONTENT, array(
                            $model->machineProductOrder->member->referrals->gai_number, $model->machineProductOrder->member->gai_number, $model->machineProductOrder->code, $referrals_integral
                ));
                $referralsAccountBalance = AccountBalance::findAccountBalance(array(
                            'account_id' => $model->machineProductOrder->member->referrals->id,
                            'gai_number' => $model->machineProductOrder->member->referrals->gai_number,
                            'name' => $model->machineProductOrder->member->referrals->username,
                            'owner_type' => AccountFlow::OWNER_MEMBER,
                ));
                $newReferralsAccountBalance = AccountBalance::updateAccountBalance($referralsAccountBalance, $referrals_money, AccountBalance::OFFLINE_TYPE_ADD);
                $referralsAccountFlow = array(
                    'account_id' => $newReferralsAccountBalance['account_id'],
                    'gai_number' => $newReferralsAccountBalance['gai_number'],
                    'account_name' => $newReferralsAccountBalance['name'],
                    'credit_amount' => $referrals_money,
                    'create_time' => $time,
                    'debit_previous_amount_cash' => $referralsAccountBalance['debit_today_amount_cash'],
                    'credit_previous_amount_cash' => $referralsAccountBalance['credit_today_amount_cash'],
                    'debit_current_amount_cash' => $newReferralsAccountBalance['debit_today_amount_cash'],
                    'credit_current_amount_cash' => $newReferralsAccountBalance['credit_today_amount_cash'],
                    'debit_previous_amount_nocash' => $referralsAccountBalance['debit_today_amount_nocash'],
                    'credit_previous_amount_nocash' => $referralsAccountBalance['credit_today_amount_nocash'],
                    'debit_current_amount_nocash' => $newReferralsAccountBalance['debit_today_amount_nocash'],
                    'credit_current_amount_nocash' => $newReferralsAccountBalance['credit_today_amount_nocash'],
                    'debit_previous_amount' => $referralsAccountBalance['debit_today_amount'],
                    'credit_previous_amount' => $referralsAccountBalance['today_amount'],
                    'debit_current_amount' => $newReferralsAccountBalance['debit_today_amount'],
                    'credit_current_amount' => $newReferralsAccountBalance['today_amount'],
                    'debit_previous_amount_frezee' => $referralsAccountBalance['debit_today_amount_frezee'],
                    'credit_previous_amount_frezee' => $referralsAccountBalance['credit_today_amount_frezee'],
                    'debit_current_amount_frezee' => $newReferralsAccountBalance['debit_today_amount_frezee'],
                    'credit_current_amount_frezee' => $newReferralsAccountBalance['credit_today_amount_frezee'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                    'trade_space' => $model->machineProductOrder->franchisee->street,
                    'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                    'trade_terminal' => $model->machine_id,
                    'target_id' => $model->id,
                    'code' => $model->machineProductOrder->code,
                    'owner_type' => AccountFlow::OWNER_MEMBER,
                    'income_type' => AccountFlow::TYPE_GAI,
                    'score_source' => AccountFlow::SOURCE_GT_ORDER,
                    'remark' => $referrals_content,
                    'serial_number' => $model->machineProductOrder->code,
                    'ratio' => $ratio,
                    'area_id' => $area_id,
                );
                Yii::app()->db->createCommand()->insert($accountFlowTable, $referralsAccountFlow);
                $wealthData = array(
                    'owner' => AccountFlow::OWNER_MEMBER,
                    'member_id' => $newReferralsAccountBalance['account_id'],
                    'gai_number' => $newReferralsAccountBalance['gai_number'],
                    'type_id' => AccountFlow::TYPE_GAI,
                    'score' => $referrals_integral,
                    'money' => $referrals_money,
                    'source_id' => AccountFlow::SOURCE_GT_ORDER,
                    'target_id' => $model->id,
                    'content' => $referrals_content,
                    'create_time' => $time,
                    'ip' => $model->machineProductOrder->ip_address,
                );
                Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            } else {
                //会员推荐者不存在--进入盖网市公共账户
                $tuijian_member_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_TUIJIAN_MEMBER_CONTENT, array(
                            $model->machineProductOrder->code, HtmlHelper::formatPrice($model->total_price), HtmlHelper::formatPrice($referrals_money)
                ));
                $cityCommonAccountBalance = AccountBalance::findAccountBalance(array(
                            'account_id' => $cityCommonAccount['id'],
                            'name' => $cityCommonAccount['name'],
                            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                ));
                $newCityCommonAccountBalance = AccountBalance::updateAccountBalance($cityCommonAccountBalance, $referrals_money, AccountBalance::OFFLINE_COMMON_ACOUNT);
                $cityCommonAccountFlow = array(
                    'account_id' => $newCityCommonAccountBalance['account_id'],
                    'account_name' => $newCityCommonAccountBalance['name'],
                    'credit_amount' => $referrals_money,
                    'create_time' => $time,
                    'debit_previous_amount_cash' => $cityCommonAccountBalance['debit_today_amount_cash'],
                    'credit_previous_amount_cash' => $cityCommonAccountBalance['credit_today_amount_cash'],
                    'debit_current_amount_cash' => $newCityCommonAccountBalance['debit_today_amount_cash'],
                    'credit_current_amount_cash' => $newCityCommonAccountBalance['credit_today_amount_cash'],
                    'debit_previous_amount_nocash' => $cityCommonAccountBalance['debit_today_amount_nocash'],
                    'credit_previous_amount_nocash' => $cityCommonAccountBalance['credit_today_amount_nocash'],
                    'debit_current_amount_nocash' => $newCityCommonAccountBalance['debit_today_amount_nocash'],
                    'credit_current_amount_nocash' => $newCityCommonAccountBalance['credit_today_amount_nocash'],
                    'debit_previous_amount' => $cityCommonAccountBalance['debit_today_amount'],
                    'credit_previous_amount' => $cityCommonAccountBalance['today_amount'],
                    'debit_current_amount' => $newCityCommonAccountBalance['debit_today_amount'],
                    'credit_current_amount' => $newCityCommonAccountBalance['today_amount'],
                    'debit_previous_amount_frezee' => $cityCommonAccountBalance['debit_today_amount_frezee'],
                    'credit_previous_amount_frezee' => $cityCommonAccountBalance['credit_today_amount_frezee'],
                    'debit_current_amount_frezee' => $newCityCommonAccountBalance['debit_today_amount_frezee'],
                    'credit_current_amount_frezee' => $newCityCommonAccountBalance['credit_today_amount_frezee'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                    'trade_space' => $model->machineProductOrder->franchisee->street,
                    'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                    'trade_terminal' => $model->machine_id,
                    'target_id' => $model->id,
                    'code' => $model->machineProductOrder->code,
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                    'income_type' => AccountFlow::TYPE_CASH,
                    'score_source' => AccountFlow::SOURCE_GT_ORDER,
                    'remark' => $tuijian_member_content,
                    'serial_number' => $model->machineProductOrder->code,
                    'area_id' => $area_id,
                );
                Yii::app()->db->createCommand()->insert($accountFlowTable, $cityCommonAccountFlow);
                //插入旧的日志
                $wealthData = array(
                    'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
                    'member_id' => $newCityCommonAccountBalance['account_id'],
                    'gai_number' => $newCityCommonAccountBalance['name'],
                    'type_id' => AccountFlow::TYPE_CASH,
                    'score' => 0,
                    'money' => $referrals_money,
                    'source_id' => AccountFlow::SOURCE_GT_ORDER,
                    'target_id' => $model->id,
                    'content' => $tuijian_member_content,
                    'create_time' => $time,
                    'ip' => $model->machineProductOrder->ip_address,
                );
                Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            }
            /*             * *消费者的推荐者end** */

            /*             * *盖机推荐者begin** */
            $offWeightAverage = self::getDisConfig(1, 'offWeightAverage');
            $machine_intro_money = $distribute_money * $offWeightAverage;
            $machine_intro_money = IntegralOfflineNew::getNumberFormat($machine_intro_money);
            if (isset($model->machineProductOrder->machine->intro_member)) {
                $machine_intro_integral = $machine_intro_money / self::$member_type_rate[$model->machineProductOrder->machine->intro_member->type_id];
                $machine_intro_integral = IntegralOfflineNew::getNumberFormat($machine_intro_integral);
                $machine_intro_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_MACHINE_INTRO_CONTENT, array(
                            $model->machineProductOrder->code, HtmlHelper::formatPrice($model->total_price), $machine_intro_integral
                ));
                $machineIntroAccountBalance = AccountBalance::findAccountBalance(array(
                            'account_id' => $model->machineProductOrder->machine->intro_member_id,
                            'gai_number' => $model->machineProductOrder->machine->intro_member->gai_number,
                            'name' => $model->machineProductOrder->machine->intro_member->username,
                            'owner_type' => AccountFlow::OWNER_MEMBER,
                ));
                $newMachineIntroAccountBalance = AccountBalance::updateAccountBalance($machineIntroAccountBalance, $machine_intro_money, AccountBalance::OFFLINE_TYPE_ADD);
                $machineIntroAccountFlow = array(
                    'account_id' => $newMachineIntroAccountBalance['account_id'],
                    'gai_number' => $newMachineIntroAccountBalance['gai_number'],
                    'account_name' => $newMachineIntroAccountBalance['name'],
                    'credit_amount' => $machine_intro_money,
                    'create_time' => $time,
                    'debit_previous_amount_cash' => $machineIntroAccountBalance['debit_today_amount_cash'],
                    'credit_previous_amount_cash' => $machineIntroAccountBalance['credit_today_amount_cash'],
                    'debit_current_amount_cash' => $newMachineIntroAccountBalance['debit_today_amount_cash'],
                    'credit_current_amount_cash' => $newMachineIntroAccountBalance['credit_today_amount_cash'],
                    'debit_previous_amount_nocash' => $machineIntroAccountBalance['debit_today_amount_nocash'],
                    'credit_previous_amount_nocash' => $machineIntroAccountBalance['credit_today_amount_nocash'],
                    'debit_current_amount_nocash' => $newMachineIntroAccountBalance['debit_today_amount_nocash'],
                    'credit_current_amount_nocash' => $newMachineIntroAccountBalance['credit_today_amount_nocash'],
                    'debit_previous_amount' => $machineIntroAccountBalance['debit_today_amount'],
                    'credit_previous_amount' => $machineIntroAccountBalance['today_amount'],
                    'debit_current_amount' => $newMachineIntroAccountBalance['debit_today_amount'],
                    'credit_current_amount' => $newMachineIntroAccountBalance['today_amount'],
                    'debit_previous_amount_frezee' => $machineIntroAccountBalance['debit_today_amount_frezee'],
                    'credit_previous_amount_frezee' => $machineIntroAccountBalance['credit_today_amount_frezee'],
                    'debit_current_amount_frezee' => $newMachineIntroAccountBalance['debit_today_amount_frezee'],
                    'credit_current_amount_frezee' => $newMachineIntroAccountBalance['credit_today_amount_frezee'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                    'trade_space' => $model->machineProductOrder->franchisee->street,
                    'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                    'trade_terminal' => $model->machine_id,
                    'target_id' => $model->id,
                    'code' => $model->machineProductOrder->code,
                    'owner_type' => AccountFlow::OWNER_MEMBER,
                    'income_type' => AccountFlow::TYPE_GAI,
                    'score_source' => AccountFlow::SOURCE_GT_ORDER,
                    'remark' => $machine_intro_content,
                    'serial_number' => $model->machineProductOrder->code,
                    'ratio' => self::$member_type_rate[$model->machineProductOrder->machine->intro_member->type_id],
                    'area_id' => $area_id,
                );
                Yii::app()->db->createCommand()->insert($accountFlowTable, $machineIntroAccountFlow);
                //插入旧的日志
                $wealthData = array(
                    'owner' => AccountFlow::OWNER_MEMBER,
                    'member_id' => $newMachineIntroAccountBalance['account_id'],
                    'gai_number' => $newMachineIntroAccountBalance['gai_number'],
                    'type_id' => AccountFlow::TYPE_GAI,
                    'score' => $machine_intro_integral,
                    'money' => $machine_intro_money,
                    'source_id' => AccountFlow::SOURCE_GT_ORDER,
                    'target_id' => $model->id,
                    'content' => $machine_intro_content,
                    'create_time' => $time,
                    'ip' => $model->machineProductOrder->ip_address,
                );
                Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            } else {
                $machine_intro_no_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_MACHINE_INTRO_NO_CONTENT, array(
                            $model->machineProductOrder->code, HtmlHelper::formatPrice($model->total_price), HtmlHelper::formatPrice($machine_intro_money)
                ));
                $cityCommonAccountBalance = AccountBalance::findAccountBalance(array(
                            'account_id' => $cityCommonAccount['id'],
                            'name' => $cityCommonAccount['name'],
                            'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                ));
                $newCityCommonAccountBalance = AccountBalance::updateAccountBalance($cityCommonAccountBalance, $machine_intro_money, AccountBalance::OFFLINE_COMMON_ACOUNT);
                $cityCommonAccountFlow = array(
                    'account_id' => $newCityCommonAccountBalance['account_id'],
                    'account_name' => $newCityCommonAccountBalance['name'],
                    'credit_amount' => $machine_intro_money,
                    'create_time' => $time,
                    'debit_previous_amount_cash' => $cityCommonAccountBalance['debit_today_amount_cash'],
                    'credit_previous_amount_cash' => $cityCommonAccountBalance['credit_today_amount_cash'],
                    'debit_current_amount_cash' => $newCityCommonAccountBalance['debit_today_amount_cash'],
                    'credit_current_amount_cash' => $newCityCommonAccountBalance['credit_today_amount_cash'],
                    'debit_previous_amount_nocash' => $cityCommonAccountBalance['debit_today_amount_nocash'],
                    'credit_previous_amount_nocash' => $cityCommonAccountBalance['credit_today_amount_nocash'],
                    'debit_current_amount_nocash' => $newCityCommonAccountBalance['debit_today_amount_nocash'],
                    'credit_current_amount_nocash' => $newCityCommonAccountBalance['credit_today_amount_nocash'],
                    'debit_previous_amount' => $cityCommonAccountBalance['debit_today_amount'],
                    'credit_previous_amount' => $cityCommonAccountBalance['today_amount'],
                    'debit_current_amount' => $newCityCommonAccountBalance['debit_today_amount'],
                    'credit_current_amount' => $newCityCommonAccountBalance['today_amount'],
                    'debit_previous_amount_frezee' => $cityCommonAccountBalance['debit_today_amount_frezee'],
                    'credit_previous_amount_frezee' => $cityCommonAccountBalance['credit_today_amount_frezee'],
                    'debit_current_amount_frezee' => $newCityCommonAccountBalance['debit_today_amount_frezee'],
                    'credit_current_amount_frezee' => $newCityCommonAccountBalance['credit_today_amount_frezee'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                    'trade_space' => $model->machineProductOrder->franchisee->street,
                    'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                    'trade_terminal' => $model->machine_id,
                    'target_id' => $model->id,
                    'code' => $model->machineProductOrder->code,
                    'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                    'income_type' => AccountFlow::TYPE_CASH,
                    'score_source' => AccountFlow::SOURCE_GT_ORDER,
                    'remark' => $machine_intro_no_content,
                    'serial_number' => $model->machineProductOrder->code,
                    'area_id' => $area_id,
                );
                Yii::app()->db->createCommand()->insert($accountFlowTable, $cityCommonAccountFlow);
                //插入旧的日志
                $wealthData = array(
                    'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
                    'member_id' => $newCityCommonAccountBalance['account_id'],
                    'gai_number' => $newCityCommonAccountBalance['name'],
                    'type_id' => AccountFlow::TYPE_CASH,
                    'score' => 0,
                    'money' => $machine_intro_money,
                    'source_id' => AccountFlow::SOURCE_GT_ORDER,
                    'target_id' => $model->id,
                    'content' => $machine_intro_no_content,
                    'create_time' => $time,
                    'ip' => $model->machineProductOrder->ip_address,
                );
                Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            }
            /*             * *盖机推荐者end** */

            /*             * *最近一次消费的加盟商begin** */
            $offRefMachine = self::getDisConfig(1, 'offRefMachine');
            $offRefMachine_money = $distribute_money * $offRefMachine;
            $offRefMachine_money = IntegralOfflineNew::getNumberFormat($offRefMachine_money);
            if ($offRefMachine_money > 0) {
                //查询该消费者最近一次消费的记录
                $tn = MachineProductOrder::model()->tableName();
                $sql_execute = "select t.id,t.franchisee_id,t.pay_time from $tn t where t.member_id=" . $model->machineProductOrder->member_id . " and t.pay_time<" . $model->machineProductOrder->pay_time;
                $sql_execute .= " order by t.pay_time desc limit 1";
                $offRefMachineOrder = Yii::app()->db->createCommand($sql_execute)->queryRow();
                if (!empty($offRefMachineOrder)) {
                    $offRefFranchiseeModel = Franchisee::model()->findByPk($offRefMachineOrder['franchisee_id']);
                    $offRefMachine_integral = $offRefMachine_money / self::$member_type_rate[$offRefFranchiseeModel->member->type_id];
                    $offRefMachine_integral = IntegralOfflineNew::getNumberFormat($offRefMachine_integral);
                    $offRefMachine_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_OFFREFMACHINE_CONTENT, array(
                                $model->machineProductOrder->code, HtmlHelper::formatPrice($model->total_price), $offRefMachine_integral
                    ));
                    $offRefMachineBalance = AccountBalance::findAccountBalance(array(
                                'account_id' => $offRefFranchiseeModel->member->id,
                                'gai_number' => $offRefFranchiseeModel->member->gai_number,
                                'name' => $offRefFranchiseeModel->member->username,
                                'owner_type' => AccountFlow::OWNER_MEMBER,
                    ));
                    $newOffRefMachineBalance = AccountBalance::updateAccountBalance($offRefMachineBalance, $offRefMachine_money, AccountBalance::OFFLINE_TYPE_ADD);
                    $offRefMachineAccountFlow = array(
                        'account_id' => $newOffRefMachineBalance['account_id'],
                        'gai_number' => $newOffRefMachineBalance['gai_number'],
                        'account_name' => $newOffRefMachineBalance['name'],
                        'credit_amount' => $offRefMachine_money,
                        'create_time' => $time,
                        'debit_previous_amount_cash' => $offRefMachineBalance['debit_today_amount_cash'],
                        'credit_previous_amount_cash' => $offRefMachineBalance['credit_today_amount_cash'],
                        'debit_current_amount_cash' => $newOffRefMachineBalance['debit_today_amount_cash'],
                        'credit_current_amount_cash' => $newOffRefMachineBalance['credit_today_amount_cash'],
                        'debit_previous_amount_nocash' => $offRefMachineBalance['debit_today_amount_nocash'],
                        'credit_previous_amount_nocash' => $offRefMachineBalance['credit_today_amount_nocash'],
                        'debit_current_amount_nocash' => $newOffRefMachineBalance['debit_today_amount_nocash'],
                        'credit_current_amount_nocash' => $newOffRefMachineBalance['credit_today_amount_nocash'],
                        'debit_previous_amount' => $offRefMachineBalance['debit_today_amount'],
                        'credit_previous_amount' => $offRefMachineBalance['today_amount'],
                        'debit_current_amount' => $newOffRefMachineBalance['debit_today_amount'],
                        'credit_current_amount' => $newOffRefMachineBalance['today_amount'],
                        'debit_previous_amount_frezee' => $offRefMachineBalance['debit_today_amount_frezee'],
                        'credit_previous_amount_frezee' => $offRefMachineBalance['credit_today_amount_frezee'],
                        'debit_current_amount_frezee' => $newOffRefMachineBalance['debit_today_amount_frezee'],
                        'credit_current_amount_frezee' => $newOffRefMachineBalance['credit_today_amount_frezee'],
                        'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                        'trade_space' => $model->machineProductOrder->franchisee->street,
                        'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                        'trade_terminal' => $model->machine_id,
                        'target_id' => $model->id,
                        'code' => $model->machineProductOrder->code,
                        'owner_type' => AccountFlow::OWNER_MEMBER,
                        'income_type' => AccountFlow::TYPE_GAI,
                        'score_source' => AccountFlow::SOURCE_GT_ORDER,
                        'remark' => $offRefMachine_content,
                        'serial_number' => $model->machineProductOrder->code,
                        'ratio' => self::$member_type_rate[$offRefFranchiseeModel->member->type_id],
                        'area_id' => $area_id,
                    );
                    Yii::app()->db->createCommand()->insert($accountFlowTable, $offRefMachineAccountFlow);
                    //插入旧的日志
                    $wealthData = array(
                        'owner' => AccountFlow::OWNER_MEMBER,
                        'member_id' => $newOffRefMachineBalance['account_id'],
                        'gai_number' => $newOffRefMachineBalance['gai_number'],
                        'type_id' => AccountFlow::TYPE_GAI,
                        'score' => $offRefMachine_integral,
                        'money' => $offRefMachine_money,
                        'source_id' => AccountFlow::SOURCE_GT_ORDER,
                        'target_id' => $model->id,
                        'content' => $offRefMachine_content,
                        'create_time' => $time,
                        'ip' => $model->machineProductOrder->ip_address,
                    );
                    Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
                } else {
                    $offRefMachine_no_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_OFFREFMACHINE_NO_CONTENT, array(
                                $model->machineProductOrder->code, HtmlHelper::formatPrice($model->total_price), HtmlHelper::formatPrice($offRefMachine_money)
                    ));
                    $cityCommonAccountBalance = AccountBalance::findAccountBalance(array(
                                'account_id' => $cityCommonAccount['id'],
                                'name' => $cityCommonAccount['name'],
                                'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                    ));
                    $newCityCommonAccountBalance = AccountBalance::updateAccountBalance($cityCommonAccountBalance, $offRefMachine_money, AccountBalance::OFFLINE_COMMON_ACOUNT);
                    $cityCommonAccountFlow = array(
                        'account_id' => $newCityCommonAccountBalance['account_id'],
                        'account_name' => $newCityCommonAccountBalance['name'],
                        'credit_amount' => $offRefMachine_money,
                        'create_time' => $time,
                        'debit_previous_amount_cash' => $cityCommonAccountBalance['debit_today_amount_cash'],
                        'credit_previous_amount_cash' => $cityCommonAccountBalance['credit_today_amount_cash'],
                        'debit_current_amount_cash' => $newCityCommonAccountBalance['debit_today_amount_cash'],
                        'credit_current_amount_cash' => $newCityCommonAccountBalance['credit_today_amount_cash'],
                        'debit_previous_amount_nocash' => $cityCommonAccountBalance['debit_today_amount_nocash'],
                        'credit_previous_amount_nocash' => $cityCommonAccountBalance['credit_today_amount_nocash'],
                        'debit_current_amount_nocash' => $newCityCommonAccountBalance['debit_today_amount_nocash'],
                        'credit_current_amount_nocash' => $newCityCommonAccountBalance['credit_today_amount_nocash'],
                        'debit_previous_amount' => $cityCommonAccountBalance['debit_today_amount'],
                        'credit_previous_amount' => $cityCommonAccountBalance['today_amount'],
                        'debit_current_amount' => $newCityCommonAccountBalance['debit_today_amount'],
                        'credit_current_amount' => $newCityCommonAccountBalance['today_amount'],
                        'debit_previous_amount_frezee' => $cityCommonAccountBalance['debit_today_amount_frezee'],
                        'credit_previous_amount_frezee' => $cityCommonAccountBalance['credit_today_amount_frezee'],
                        'debit_current_amount_frezee' => $newCityCommonAccountBalance['debit_today_amount_frezee'],
                        'credit_current_amount_frezee' => $newCityCommonAccountBalance['credit_today_amount_frezee'],
                        'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                        'trade_space' => $model->machineProductOrder->franchisee->street,
                        'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                        'trade_terminal' => $model->machine_id,
                        'target_id' => $model->id,
                        'code' => $model->machineProductOrder->code,
                        'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                        'income_type' => AccountFlow::TYPE_CASH,
                        'score_source' => AccountFlow::SOURCE_GT_ORDER,
                        'remark' => $offRefMachine_no_content,
                        'serial_number' => $model->machineProductOrder->code,
                        'area_id' => $area_id,
                    );
                    Yii::app()->db->createCommand()->insert($accountFlowTable, $cityCommonAccountFlow);
                    //插入旧的日志
                    $wealthData = array(
                        'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
                        'member_id' => $newCityCommonAccountBalance['account_id'],
                        'gai_number' => $newCityCommonAccountBalance['name'],
                        'type_id' => AccountFlow::TYPE_CASH,
                        'score' => 0,
                        'money' => $offRefMachine_money,
                        'source_id' => AccountFlow::SOURCE_GT_ORDER,
                        'target_id' => $model->id,
                        'content' => $offRefMachine_no_content,
                        'create_time' => $time,
                        'ip' => $model->machineProductOrder->ip_address,
                    );
                    Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
                }
            }
            /*             * *最近一次消费的加盟商end** */

            /*             * *代理分配begin** */
            $commont_account_dist_table = CommonAccountAgentDist::model()->tableName();
            $offAgent = self::getDisConfig(1, 'offAgent');
            $agent_money = $distribute_money * $offAgent;  //代理分的钱
            $agent_money = IntegralOfflineNew::getNumberFormat($agent_money);
            if ($agent_money > 0) {
                $agents = IntegralOfflineNew::getAgentsMemberId($model->machineProductOrder->franchisee->district_id);
                $agentConfig_district = self::getDisConfig(2, 'district');  //区代理的比例
                $agentConfig_city = self::getDisConfig(2, 'city');    //市代理的比例
                $agentConfig_province = self::getDisConfig(2, 'province');  //省代理的比例
                $agentConfig_district__real = ($agents['district'] == 0) ? 0 : $agentConfig_district;
                $agentConfig_city__real = ($agents['city'] == 0) ? 0 : $agentConfig_city - $agentConfig_district__real;
                $agentConfig_province__real = ($agents['province'] == 0) ? 0 : $agentConfig_province - ($agentConfig_city__real + $agentConfig_district__real);
                $agent_district_money = $agent_money * $agentConfig_district__real;  //区代理分配的金额
                $agent_city_money = $agent_money * $agentConfig_city__real;    //市代理分配的金额
                $agent_province_money = $agent_money * $agentConfig_province__real;  //省代理分配的金额
                $agent_district_money = IntegralOfflineNew::getNumberFormat($agent_district_money);
                $agent_city_money = IntegralOfflineNew::getNumberFormat($agent_city_money);
                $agent_province_money = IntegralOfflineNew::getNumberFormat($agent_province_money);
                $agentCommonAccount = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_AGENT, $model->machineProductOrder->franchisee->district_id);
                $agent_remainder_money = $agent_money - ($agent_district_money + $agent_city_money + $agent_province_money);  //剩余金额进入区代理商公共账户
                //插入代理分配记录表
                $commont_account_dist_arr = array(
                    'common_account_id' => $agentCommonAccount['id'],
                    'dist_money' => $agent_money,
                    'remainder_money' => $agent_remainder_money,
                    'province_id' => $model->machineProductOrder->franchisee->province_id,
                    'province_member_id' => $agents['province'],
                    'province_money' => $agent_province_money,
                    'province_ratio' => $agentConfig_province__real,
                    'city_id' => $model->machineProductOrder->franchisee - city_id,
                    'city_member_id' => $agents['city'],
                    'city_money' => $agent_city_money,
                    'city_ratio' => $agentConfig_city__real,
                    'district_id' => $model->machineProductOrder->franchisee->district_id,
                    'district_member_id' => $agents['district'],
                    'district_money' => $agent_district_money,
                    'district_ratio' => $agentConfig_district__real,
                    'create_time' => $time
                );
                Yii::app()->db->createCommand()->insert($commont_account_dist_table, $commont_account_dist_arr);
                $commont_account_dist_table_insert_id = Yii::app()->db->getLastInsertID();

                if ($agent_remainder_money) {
                    $agent_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_AGENT_DISTRIBUTE_CONTENT, array(
                                $model->machineProductOrder->member->gai_number,
                                $model->machineProductOrder->code,
                                HtmlHelper::formatPrice($model->total_price),
                                HtmlHelper::formatPrice($agent_remainder_money)
                    ));
                    $agentCommonAccountBalance = AccountBalance::findAccountBalance(array(
                                'account_id' => $agentCommonAccount['id'],
                                'name' => $agentCommonAccount['name'],
                                'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                    ));
                    $newAgentCommonAccountBalance = AccountBalance::updateAccountBalance($agentCommonAccountBalance, $agent_remainder_money, AccountBalance::OFFLINE_COMMON_ACOUNT);
                    $agentCommonAccountFlow = array(
                        'account_id' => $newAgentCommonAccountBalance['account_id'],
                        'account_name' => $newAgentCommonAccountBalance['name'],
                        'credit_amount' => $agent_remainder_money,
                        'create_time' => $time,
                        'debit_previous_amount_cash' => $agentCommonAccountBalance['debit_today_amount_cash'],
                        'credit_previous_amount_cash' => $agentCommonAccountBalance['credit_today_amount_cash'],
                        'debit_current_amount_cash' => $newAgentCommonAccountBalance['debit_today_amount_cash'],
                        'credit_current_amount_cash' => $newAgentCommonAccountBalance['credit_today_amount_cash'],
                        'debit_previous_amount_nocash' => $agentCommonAccountBalance['debit_today_amount_nocash'],
                        'credit_previous_amount_nocash' => $agentCommonAccountBalance['credit_today_amount_nocash'],
                        'debit_current_amount_nocash' => $newAgentCommonAccountBalance['debit_today_amount_nocash'],
                        'credit_current_amount_nocash' => $newAgentCommonAccountBalance['credit_today_amount_nocash'],
                        'debit_previous_amount' => $agentCommonAccountBalance['debit_today_amount'],
                        'credit_previous_amount' => $agentCommonAccountBalance['today_amount'],
                        'debit_current_amount' => $newAgentCommonAccountBalance['debit_today_amount'],
                        'credit_current_amount' => $newAgentCommonAccountBalance['today_amount'],
                        'debit_previous_amount_frezee' => $agentCommonAccountBalance['debit_today_amount_frezee'],
                        'credit_previous_amount_frezee' => $agentCommonAccountBalance['credit_today_amount_frezee'],
                        'debit_current_amount_frezee' => $newAgentCommonAccountBalance['debit_today_amount_frezee'],
                        'credit_current_amount_frezee' => $newAgentCommonAccountBalance['credit_today_amount_frezee'],
                        'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                        'trade_space' => $model->machineProductOrder->franchisee->street,
                        'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                        'trade_terminal' => $model->machine_id,
                        'target_id' => $model->id,
                        'code' => $model->machineProductOrder->code,
                        'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                        'income_type' => AccountFlow::TYPE_CASH,
                        'score_source' => AccountFlow::SOURCE_AGENT_ASSIGN,
                        'remark' => $agent_content,
                        'serial_number' => $model->machineProductOrder->code,
                        'area_id' => $area_id,
                    );
                    Yii::app()->db->createCommand()->insert($accountFlowTable, $agentCommonAccountFlow);

                    //插入旧的日志
                    $wealthData = array(
                        'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
                        'member_id' => $newAgentCommonAccountBalance['account_id'],
                        'gai_number' => $newAgentCommonAccountBalance['name'],
                        'type_id' => AccountFlow::TYPE_CASH,
                        'score' => 0,
                        'money' => $agent_remainder_money,
                        'source_id' => AccountFlow::SOURCE_AGENT_ASSIGN,
                        'target_id' => $model->id,
                        'content' => $agent_content,
                        'create_time' => $time,
                        'ip' => $model->machineProductOrder->ip_address,
                    );
                    Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
                }
                if ($agent_district_money) {
                    $district_member_integral = $agent_district_money / self::$member_type_rate[$agents['district_type_id']];
                    $district_member_integral = IntegralOfflineNew::getNumberFormat($district_member_integral);
                    $district_member_dist_content = IntegralOfflineNew::getContent(IntegralOfflineNew::AGENT_DIST_MEMBER_CONTENT, array(
                                $agentCommonAccount['name'], $agent_money, $agents['district_name'], $district_member_integral
                    ));
                    $districtMemberAccountBalance = AccountBalance::findAccountBalance(array(
                                'account_id' => $agents['district'],
                                'gai_number' => $agents['district_gai_number'],
                                'name' => $agents['district_username'],
                                'owner_type' => AccountFlow::OWNER_MEMBER,
                    ));
                    $newDistrictMemberAccountBalance = AccountBalance::updateAccountBalance($districtMemberAccountBalance, $agent_district_money, AccountBalance::OFFLINE_TYPE_ADD);
                    $districtMemberAccountFlow = array(
                        'account_id' => $agents['district'],
                        'gai_number' => $agents['district_gai_number'],
                        'account_name' => $agents['district_username'],
                        'credit_amount' => $agent_district_money,
                        'create_time' => $time,
                        'debit_previous_amount_cash' => $districtMemberAccountBalance['debit_today_amount_cash'],
                        'credit_previous_amount_cash' => $districtMemberAccountBalance['credit_today_amount_cash'],
                        'debit_current_amount_cash' => $newDistrictMemberAccountBalance['debit_today_amount_cash'],
                        'credit_current_amount_cash' => $newDistrictMemberAccountBalance['credit_today_amount_cash'],
                        'debit_previous_amount_nocash' => $districtMemberAccountBalance['debit_today_amount_nocash'],
                        'credit_previous_amount_nocash' => $districtMemberAccountBalance['credit_today_amount_nocash'],
                        'debit_current_amount_nocash' => $newDistrictMemberAccountBalance['debit_today_amount_nocash'],
                        'credit_current_amount_nocash' => $newDistrictMemberAccountBalance['credit_today_amount_nocash'],
                        'debit_previous_amount' => $districtMemberAccountBalance['debit_today_amount'],
                        'credit_previous_amount' => $districtMemberAccountBalance['today_amount'],
                        'debit_current_amount' => $newDistrictMemberAccountBalance['debit_today_amount'],
                        'credit_current_amount' => $newDistrictMemberAccountBalance['today_amount'],
                        'debit_previous_amount_frezee' => $districtMemberAccountBalance['debit_today_amount_frezee'],
                        'credit_previous_amount_frezee' => $districtMemberAccountBalance['credit_today_amount_frezee'],
                        'debit_current_amount_frezee' => $newDistrictMemberAccountBalance['debit_today_amount_frezee'],
                        'credit_current_amount_frezee' => $newDistrictMemberAccountBalance['credit_today_amount_frezee'],
                        'operate_type' => AccountFlow::OPERATE_TYPE_OFFLINE_CHECK,
                        'trade_space' => $model->machineProductOrder->franchisee->street,
                        'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                        'trade_terminal' => $model->machine_id,
                        'target_id' => $model->id,
                        'code' => $model->machineProductOrder->code,
                        'owner_type' => AccountFlow::OWNER_MEMBER,
                        'income_type' => AccountFlow::TYPE_GAI,
                        'score_source' => AccountFlow::SOURCE_AGENT_ASSIGN,
                        'remark' => $district_member_dist_content,
                        'serial_number' => $model->machineProductOrder->code,
                        'ratio' => self::$member_type_rate[$agents['district_type_id']],
                        'area_id' => $area_id,
                    );
                    Yii::app()->db->createCommand()->insert($accountFlowTable, $districtMemberAccountFlow);

                    //插入旧的日志
                    $wealthData = array(
                        'owner' => AccountFlow::OWNER_MEMBER,
                        'member_id' => $agents['district'],
                        'gai_number' => $agents['district_gai_number'],
                        'type_id' => AccountFlow::TYPE_GAI,
                        'score' => $district_member_integral,
                        'money' => $agent_district_money,
                        'source_id' => AccountFlow::SOURCE_AGENT_ASSIGN,
                        'target_id' => $commont_account_dist_table_insert_id,
                        'content' => $district_member_dist_content,
                        'create_time' => $time,
                        'ip' => $model->machineProductOrder->ip_address,
                    );
                    Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
                }
                if ($agent_city_money) {
                    $city_member_integral = $agent_city_money / self::$member_type_rate[$agents['city_type_id']];
                    $city_member_integral = IntegralOfflineNew::getNumberFormat($city_member_integral);
                    $city_member_dist_content = IntegralOfflineNew::getContent(IntegralOfflineNew::AGENT_DIST_MEMBER_CONTENT, array(
                                $agentCommonAccount['name'], $agent_money, $agents['city_name'], $city_member_integral
                    ));
                    $cityMemberAccountBalance = AccountBalance::findAccountBalance(array(
                                'account_id' => $agents['city'],
                                'gai_number' => $agents['city_gai_number'],
                                'name' => $agents['city_username'],
                                'owner_type' => AccountFlow::OWNER_MEMBER,
                    ));
                    $newCityMemberAccountBalance = AccountBalance::updateAccountBalance($cityMemberAccountBalance, $agent_city_money, AccountBalance::OFFLINE_TYPE_ADD);
                    $cityMemberAccountFlow = array(
                        'account_id' => $agents['city'],
                        'gai_number' => $agents['city_gai_number'],
                        'account_name' => $agents['city_username'],
                        'credit_amount' => $agent_city_money,
                        'create_time' => $time,
                        'debit_previous_amount_cash' => $cityMemberAccountBalance['debit_today_amount_cash'],
                        'credit_previous_amount_cash' => $cityMemberAccountBalance['credit_today_amount_cash'],
                        'debit_current_amount_cash' => $newCityMemberAccountBalance['debit_today_amount_cash'],
                        'credit_current_amount_cash' => $newCityMemberAccountBalance['credit_today_amount_cash'],
                        'debit_previous_amount_nocash' => $cityMemberAccountBalance['debit_today_amount_nocash'],
                        'credit_previous_amount_nocash' => $cityMemberAccountBalance['credit_today_amount_nocash'],
                        'debit_current_amount_nocash' => $newCityMemberAccountBalance['debit_today_amount_nocash'],
                        'credit_current_amount_nocash' => $newCityMemberAccountBalance['credit_today_amount_nocash'],
                        'debit_previous_amount' => $cityMemberAccountBalance['debit_today_amount'],
                        'credit_previous_amount' => $cityMemberAccountBalance['today_amount'],
                        'debit_current_amount' => $newCityMemberAccountBalance['debit_today_amount'],
                        'credit_current_amount' => $newCityMemberAccountBalance['today_amount'],
                        'debit_previous_amount_frezee' => $cityMemberAccountBalance['debit_today_amount_frezee'],
                        'credit_previous_amount_frezee' => $cityMemberAccountBalance['credit_today_amount_frezee'],
                        'debit_current_amount_frezee' => $newCityMemberAccountBalance['debit_today_amount_frezee'],
                        'credit_current_amount_frezee' => $newCityMemberAccountBalance['credit_today_amount_frezee'],
                        'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                        'trade_space' => $model->machineProductOrder->franchisee->street,
                        'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                        'trade_terminal' => $model->machine_id,
                        'target_id' => $model->id,
                        'code' => $model->machineProductOrder->code,
                        'owner_type' => AccountFlow::OWNER_MEMBER,
                        'income_type' => AccountFlow::TYPE_GAI,
                        'score_source' => AccountFlow::SOURCE_AGENT_ASSIGN,
                        'remark' => $city_member_dist_content,
                        'serial_number' => $model->machineProductOrder->code,
                        'ratio' => self::$member_type_rate[$agents['city_type_id']],
                        'area_id' => $area_id,
                    );
                    Yii::app()->db->createCommand()->insert($accountFlowTable, $cityMemberAccountFlow);

                    //插入旧的日志
                    $wealthData = array(
                        'owner' => AccountFlow::OWNER_MEMBER,
                        'member_id' => $agents['city'],
                        'gai_number' => $agents['city_gai_number'],
                        'type_id' => AccountFlow::TYPE_GAI,
                        'score' => $city_member_integral,
                        'money' => $agent_city_money,
                        'source_id' => AccountFlow::SOURCE_AGENT_ASSIGN,
                        'target_id' => $commont_account_dist_table_insert_id,
                        'content' => $city_member_dist_content,
                        'create_time' => $time,
                        'ip' => $model->machineProductOrder->ip_address,
                    );
                    Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
                }
                if ($agent_province_money) {
                    $province_member_integral = $agent_province_money / self::$member_type_rate[$agents['province_type_id']];
                    $province_member_integral = IntegralOfflineNew::getNumberFormat($province_member_integral);
                    $province_member_dist_content = self::getContent(IntegralOfflineNew::AGENT_DIST_MEMBER_CONTENT, array(
                                $agentCommonAccount['name'], $agent_money, $agents['province_name'], $province_member_integral
                    ));
                    $provinceMemberAccountBalance = AccountBalance::findAccountBalance(array(
                                'account_id' => $agents['province'],
                                'gai_number' => $agents['province_gai_number'],
                                'name' => $agents['province_username'],
                                'owner_type' => AccountFlow::OWNER_MEMBER,
                    ));
                    $newProvinceMemberAccountBalance = AccountBalance::updateAccountBalance($provinceMemberAccountBalance, $agent_province_money, AccountBalance::OFFLINE_TYPE_ADD);
                    $provinceMemberAccountFlow = array(
                        'account_id' => $agents['province'],
                        'gai_number' => $agents['province_gai_number'],
                        'account_name' => $agents['province_username'],
                        'credit_amount' => $agent_province_money,
                        'create_time' => $time,
                        'debit_previous_amount_cash' => $provinceMemberAccountBalance['debit_today_amount_cash'],
                        'credit_previous_amount_cash' => $provinceMemberAccountBalance['credit_today_amount_cash'],
                        'debit_current_amount_cash' => $newProvinceMemberAccountBalance['debit_today_amount_cash'],
                        'credit_current_amount_cash' => $newProvinceMemberAccountBalance['credit_today_amount_cash'],
                        'debit_previous_amount_nocash' => $provinceMemberAccountBalance['debit_today_amount_nocash'],
                        'credit_previous_amount_nocash' => $provinceMemberAccountBalance['credit_today_amount_nocash'],
                        'debit_current_amount_nocash' => $newProvinceMemberAccountBalance['debit_today_amount_nocash'],
                        'credit_current_amount_nocash' => $newProvinceMemberAccountBalance['credit_today_amount_nocash'],
                        'debit_previous_amount' => $provinceMemberAccountBalance['debit_today_amount'],
                        'credit_previous_amount' => $provinceMemberAccountBalance['today_amount'],
                        'debit_current_amount' => $newProvinceMemberAccountBalance['debit_today_amount'],
                        'credit_current_amount' => $newProvinceMemberAccountBalance['today_amount'],
                        'debit_previous_amount_frezee' => $provinceMemberAccountBalance['debit_today_amount_frezee'],
                        'credit_previous_amount_frezee' => $provinceMemberAccountBalance['credit_today_amount_frezee'],
                        'debit_current_amount_frezee' => $newProvinceMemberAccountBalance['debit_today_amount_frezee'],
                        'credit_current_amount_frezee' => $newProvinceMemberAccountBalance['credit_today_amount_frezee'],
                        'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                        'trade_space' => $model->machineProductOrder->franchisee->street,
                        'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                        'trade_terminal' => $model->machine_id,
                        'target_id' => $model->id,
                        'code' => $model->machineProductOrder->code,
                        'owner_type' => AccountFlow::OWNER_MEMBER,
                        'income_type' => AccountFlow::TYPE_GAI,
                        'score_source' => AccountFlow::SOURCE_AGENT_ASSIGN,
                        'remark' => $province_member_dist_content,
                        'serial_number' => $model->machineProductOrder->code,
                        'ratio' => self::$member_type_rate[$agents['province_type_id']],
                        'area_id' => $area_id,
                    );
                    Yii::app()->db->createCommand()->insert($accountFlowTable, $provinceMemberAccountFlow);

                    //插入旧的日志
                    $wealthData = array(
                        'owner' => AccountFlow::OWNER_MEMBER,
                        'member_id' => $agents['province'],
                        'gai_number' => $agents['province_gai_number'],
                        'type_id' => AccountFlow::TYPE_GAI,
                        'score' => $province_member_integral,
                        'money' => $agent_province_money,
                        'source_id' => AccountFlow::SOURCE_AGENT_ASSIGN,
                        'target_id' => $commont_account_dist_table_insert_id,
                        'content' => $province_member_dist_content,
                        'create_time' => $time,
                        'ip' => $model->machineProductOrder->ip_address,
                    );
                    Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
                }
            }
            /*             * *代理分配end** */

            /*             * *机动begin** */
            $offFlexible = self::getDisConfig(1, 'offFlexible');
            $flexible_money = $distribute_money * $offFlexible;
            $flexible_money = IntegralOfflineNew::getNumberFormat($flexible_money);
            $commont_account_jidong = IntegralOfflineNew::getGWPublicAcc(CommonAccount::TYPE_MOVE, $model->machineProductOrder->franchisee->city_id);
            $jidong_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_JIDONG_CONTENT, array(
                        $model->machineProductOrder->member->gai_number,
                        $model->machineProductOrder->code,
                        HtmlHelper::formatPrice($model->total_price),
                        HtmlHelper::formatPrice($flexible_money)
            ));
            $jidongCommonAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $commont_account_jidong['id'],
                        'name' => $commont_account_jidong['name'],
                        'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            ));
            $newJidongCommonAccountBalance = AccountBalance::updateAccountBalance($jidongCommonAccountBalance, $flexible_money, AccountBalance::OFFLINE_COMMON_ACOUNT);
            $cityCommonAccountFlow = array(
                'account_id' => $newJidongCommonAccountBalance['account_id'],
                'account_name' => $newJidongCommonAccountBalance['name'],
                'credit_amount' => $flexible_money,
                'create_time' => $time,
                'debit_previous_amount_cash' => $cityCommonAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $cityCommonAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newCityCommonAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newCityCommonAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $cityCommonAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $cityCommonAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newCityCommonAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newCityCommonAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $cityCommonAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $cityCommonAccountBalance['today_amount'],
                'debit_current_amount' => $newCityCommonAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newCityCommonAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $cityCommonAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $cityCommonAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newCityCommonAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newCityCommonAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                'trade_space' => $model->machineProductOrder->franchisee->street,
                'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                'trade_terminal' => $model->machine_id,
                'target_id' => $model->id,
                'code' => $model->machineProductOrder->code,
                'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'income_type' => AccountFlow::TYPE_CASH,
                'score_source' => AccountFlow::SOURCE_GT_ORDER,
                'remark' => $jidong_content,
                'serial_number' => $model->machineProductOrder->code,
                'area_id' => $area_id,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $cityCommonAccountFlow);
            //插入旧的日志
            $wealthData = array(
                'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'member_id' => $newJidongCommonAccountBalance['account_id'],
                'gai_number' => $newJidongCommonAccountBalance['name'],
                'type_id' => AccountFlow::TYPE_CASH,
                'score' => 0,
                'money' => $flexible_money,
                'source_id' => AccountFlow::SOURCE_GT_ORDER,
                'target_id' => $model->id,
                'content' => $jidong_content,
                'create_time' => $time,
                'ip' => $model->machineProductOrder->ip_address,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            /*             * *机动end** */

            /*             * *市公共账户begin** */
            $gw_fenpei = $dist_money - ($machine_money + $consumer_money + $referrals_money + $machine_intro_money + $offRefMachine_money + $agent_money + $flexible_money);
            $gw_fenpei_content = IntegralOfflineNew::getContent(self::MACHINE_PRODUCT_ORDER_GAIWANG_CONTENT, array(
                        $model->machineProductOrder->member->gai_number, $model->machineProductOrder->code, $model->total_price, $gw_fenpei
            ));
            $cityCommonAccountBalance = AccountBalance::findAccountBalance(array(
                        'account_id' => $cityCommonAccount['id'],
                        'name' => $cityCommonAccount['name'],
                        'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
            ));
            $newCityCommonAccountBalance = AccountBalance::updateAccountBalance($cityCommonAccountBalance, $gw_fenpei, AccountBalance::OFFLINE_COMMON_ACOUNT);
            $cityCommonAccountFlow = array(
                'account_id' => $newCityCommonAccountBalance['account_id'],
                'account_name' => $newCityCommonAccountBalance['name'],
                'credit_amount' => $gw_fenpei,
                'create_time' => $time,
                'debit_previous_amount_cash' => $cityCommonAccountBalance['debit_today_amount_cash'],
                'credit_previous_amount_cash' => $cityCommonAccountBalance['credit_today_amount_cash'],
                'debit_current_amount_cash' => $newCityCommonAccountBalance['debit_today_amount_cash'],
                'credit_current_amount_cash' => $newCityCommonAccountBalance['credit_today_amount_cash'],
                'debit_previous_amount_nocash' => $cityCommonAccountBalance['debit_today_amount_nocash'],
                'credit_previous_amount_nocash' => $cityCommonAccountBalance['credit_today_amount_nocash'],
                'debit_current_amount_nocash' => $newCityCommonAccountBalance['debit_today_amount_nocash'],
                'credit_current_amount_nocash' => $newCityCommonAccountBalance['credit_today_amount_nocash'],
                'debit_previous_amount' => $cityCommonAccountBalance['debit_today_amount'],
                'credit_previous_amount' => $cityCommonAccountBalance['today_amount'],
                'debit_current_amount' => $newCityCommonAccountBalance['debit_today_amount'],
                'credit_current_amount' => $newCityCommonAccountBalance['today_amount'],
                'debit_previous_amount_frezee' => $cityCommonAccountBalance['debit_today_amount_frezee'],
                'credit_previous_amount_frezee' => $cityCommonAccountBalance['credit_today_amount_frezee'],
                'debit_current_amount_frezee' => $newCityCommonAccountBalance['debit_today_amount_frezee'],
                'credit_current_amount_frezee' => $newCityCommonAccountBalance['credit_today_amount_frezee'],
                'operate_type' => AccountFlow::OPERATE_TYPE_MACHINE_ORDER_CONFIRM,
                'trade_space' => $model->machineProductOrder->franchisee->street,
                'trade_space_id' => $model->machineProductOrder->franchisee->district_id,
                'trade_terminal' => $model->machine_id,
                'target_id' => $model->id,
                'code' => $model->machineProductOrder->code,
                'owner_type' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'income_type' => AccountFlow::TYPE_CASH,
                'score_source' => AccountFlow::SOURCE_GT_ORDER,
                'remark' => $gw_fenpei_content,
                'serial_number' => $model->machineProductOrder->code,
                'area_id' => $area_id,
            );
            Yii::app()->db->createCommand()->insert($accountFlowTable, $cityCommonAccountFlow);
            //插入旧的日志
            $wealthData = array(
                'owner' => AccountFlow::OWNER_COMMON_ACCOUNT,
                'member_id' => $newCityCommonAccountBalance['account_id'],
                'gai_number' => $newCityCommonAccountBalance['name'],
                'type_id' => AccountFlow::TYPE_CASH,
                'score' => 0,
                'money' => $gw_fenpei_content,
                'source_id' => AccountFlow::SOURCE_GT_ORDER,
                'target_id' => $model->id,
                'content' => $gw_fenpei_content,
                'create_time' => $time,
                'ip' => $model->machineProductOrder->ip_address,
            );
            Yii::app()->db->createCommand()->insert($wealthTable, $wealthData);
            /*             * *市公共账户end** */

            /*             * *更新订单状态begin** */
            $model->is_consumed = MachineProductOrderDetail::IS_CONSUMED_YES;
            $model->consume_time = $time;
            $model->machineProductOrder->status = MachineProductOrder::STATUS_COMPLETE;
            $model->machineProductOrder->is_read = MachineProductOrder::READ_YES;
            $model->machineProductOrder->consume_status = MachineProductOrder::CONSUME_STATUS_YES;
            $model->machineProductOrder->consume_time = $time;
            $model->return_money = $consumer_money;
            $model->machineProductOrder->return_money = $consumer_money;
            $model->distribute_config = CJSON::encode($this->getConfig(0));
            $model->save();
            $model->machineProductOrder->save();
            /*             * *更新订单状态end** */
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return $e->getCode();
        }
    }

}
