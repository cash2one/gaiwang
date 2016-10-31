<?php

/**
 * 订单维权
 * @author binbin.liao <277250538@qq.com>
 */
class OrderRight
{

    /** @var array 订单数据 */
    private static $_order = array();
    /** @var array 会员数据 */
    private static $_member = array();
    /** @var array 流水纪录 */
    private static $_flow = array();
    /** @var string 流水表名 */
    private static $_flowTableName = '';
    /** @var int 交易金额 */
    private static $_totalRefundPrice = 0;
    /** @var int 手续费 */
    private static $_customerAssumeFreight = 0;
    /** @var array 分配比率 */
    private static $_ratio = array();
    /** @var array 红包使用金额 */
    private static $_otherPrice = 0;
    /** @var int 责任方 */
    private static $_obligation;
    /** @var float 差额 */
    private static $_surplusMoney;
    /** @var string 流水历史表名 */
    private static $_flowHistoryTableName ='';

    /**
     * 订单维权
     * @param array $order 订单数据
     * @param number $refundPrice 退还金额
     * @param number $rawFreight 原始运费
     * @param string $obligation 责任方
     * @param string $returnMoney 订单签收后的返还金额
     *
     * @throws Exception
     * @return bool
     */
    public static function right($order, $refundPrice, $rawFreight, $obligation,$returnMoney)
    {
        $flag = '';
        // 会员记录
        $memberFields = 'id, gai_number, type_id, mobile, username';
        self::$_member = Yii::app()->db->createCommand()->select($memberFields)->from('{{member}}')->where('id = :id', array(':id' => $order['member_id']))->queryRow();
        // 订单商品记录
        $goodsFields = 'quantity, gai_price, unit_price, gai_income, order_id,original_price,ratio,activity_ratio';
        $orderGoods = Yii::app()->db->createCommand()->select($goodsFields)->from('{{order_goods}}')->where('order_id = :id', array(':id' => $order['id']))->queryAll();
        // 商家信息记录
        $store = Yii::app()->db->createCommand()
            ->select('mi.id as enterprise_id, m.id as member_id, m.gai_number, m.mobile as member_mobile, c.name as store_name')
            ->from('{{store}} as c')
            ->leftJoin('{{member}} as m', 'm.id = c.member_id')
            ->leftJoin('{{enterprise}} as mi', 'm.enterprise_id = mi.id')
            ->where('c.id = :cid', array(':cid' => $order['store_id']))
            ->queryRow();

        // 会员兑现比率
        $memberType = MemberType::fileCache();
        // 分配比率
        self::$_ratio = !empty($order['distribution_ratio']) ? CJSON::decode($order['distribution_ratio']) : Order::getOldIssueRatio();
        //订单信息
        self::$_order = $order;
        // 流水表名
        self::$_flowTableName = AccountFlow::monthTable();
        self::$_flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志历史表名
        //红包使用金额
        self::$_otherPrice = $order['other_price'];
        //责任方
        self::$_obligation = $obligation;
        // 执行事务
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //再次查询订单并加上行锁,避免重复操作
            $sql = "select code,id,refund_status,status from {{order}} where id = {$order['id']} limit 1 for update";
            $data = Yii::app()->db->createCommand($sql)->queryRow();
            if ($data['refund_status'] == Order::REFUND_STATUS_SUCCESS && $data['status'] == Order::STATUS_COMPLETE)
                throw new Exception($order['code'] . Yii::t('order', '订单已经维权过了,请不要重复操作.'));
            // 消费账户
            $memberArr = array('account_id' => self::$_member['id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => self::$_member['gai_number']);
            $memberBalance = AccountBalance::findRecord($memberArr);
            // 待返还账户
            $membeReturnArr = array('account_id' => self::$_member['id'], 'type' => AccountBalance::TYPE_RETURN, 'gai_number' => self::$_member['gai_number']);
            $memberReturnBalance = AccountBalance::findRecord($membeReturnArr);
            // 商家账户
            $storeArr = array('account_id' => $store['member_id'], 'type' => AccountBalance::TYPE_MERCHANT, 'gai_number' => $store['gai_number']);
            $storeBalance = AccountBalance::findRecord($storeArr);

            // 盖网收益账户
            if ($order['delivery_status'] == Order::DELIVERY_STATUS_RECEIVE) {//已签收
                $IncomeAccount = CommonAccount::getEarningsAccount();
            }
            // 盖网在线上总账户,暂收入
            $OnlineAccount = CommonAccount::getOnlineAccount();

            //金额计算部分

            //已经评论商品，则扣除返还金额
            if($order['is_comment']==Order::IS_COMMENT_YES){
                $refundPrice = $refundPrice - $returnMoney;
            }
            self::$_totalRefundPrice = $refundPrice + $rawFreight;//总交易(退款金额 + 原始订单运费)

            self::$_customerAssumeFreight = $rawFreight - $order['freight'];//手续费
//            echo self::$_totalRefundPrice."<br/>";
//            echo self::$_customerAssumeFreight; die;
            // 订单各环节金额
            $orderResult = OnlineCalculate::orderIncome(array_merge($order, array('freight' => $rawFreight)), $orderGoods);
            // 会员待返还金额
            $memberResult = OnlineCalculate::memberAssign($orderResult['surplusAssign'], self::$_member, self::$_ratio['ratio'], $memberType);
            // 金额转积分
            $totalRefundIntegral = Common::convertSingle(self::$_totalRefundPrice, self::$_member['type_id']);  // 消费者返还积分

            // 维权信息数据
            $rightInfo = array(
                'Fright' => $order['freight'],
                'GaiPrice' => ($obligation == Order::OBLIGATION_CUSTOMER) ? $refundPrice : 0.00,
                'SalePrice' => ($obligation == Order::OBLIGATION_MERCHANT) ? $refundPrice : 0.00
            );
            // 订单数据更改
            $orderChange = array(
                'status' => Order::STATUS_CLOSE,
                'refund_status' => Order::REFUND_STATUS_SUCCESS,
                'refund_reason' => '消费者维权',
                'rights_info' => CJSON::encode($rightInfo),
                'right_time' => time(),
                'is_right' => Order::RIGHT_YES
            );

            // 更新订单记录数据
            Yii::app()->db->createCommand()->update('{{order}}', $orderChange, 'id = :id', array(':id' => $order['id']));

            # 账户余额及流水处理

            // 会员账户更新
            self::updateMember($memberBalance, $OnlineAccount);

            //如果是红包类型的订单,要收回红包
            if ($order['source_type'] == Order::SOURCE_TYPE_HB) {
                $flowArr = array(
                    'debit_amount' => -$order['other_price'], // 借方发生额
                    'remark' => self::$_member['gai_number'] . "订单维权成功，收回红包积分" . Common::convertSingle($order['other_price'], self::$_member['type_id']) . "盖网积分,订单编号:" . self::$_order['code'] . "。",
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RIGHT,
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RIGHT_CALL_RED, //0702
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RIGHTS,
                );
                OnlineOperate::callOtherPrice(self::$_flowHistoryTableName, self::$_order, $flowArr);
            }
            // 订单的配送状态为已签收
            if ($order['delivery_status'] == Order::DELIVERY_STATUS_RECEIVE) {
                //会员待返还账户更新(扣回分配的金额),还没评论的订单才可以扣回金额
                $order['is_comment']!=Order::IS_COMMENT_YES && self::updateMemberReturn($memberReturnBalance, $memberResult['memberIncome']);
                // 商家帐号余额更新
                self::updateStore($storeBalance, $rawFreight, $refundPrice);
                // 盖网总收益 还没评论的订单才可以扣回金额
                $order['is_comment']!=Order::IS_COMMENT_YES && self::updateGatewangIncome($IncomeAccount, $memberResult['memberIncome']);
            } else {
                // 盖网线上总账户
                self::updateGatewangTotal($OnlineAccount);
            }
            // 如果为消费者责任，则产生此流水，否则不产生此流水
            if (self::$_customerAssumeFreight) {
                // 买家责任,支付手续费
                self::updateMemberFreight($memberArr);
                // 买家责任,商家收取手续费
                self::updateStoreFreight($storeBalance);
            }
            //写入流水
            foreach (self::$_flow as $flow) {
                Yii::app()->db->createCommand()->insert(self::$_flowTableName, $flow);
            }
            // 检测流水表借贷平衡
            if (!DebitCredit::checkFlowByCode(self::$_flowTableName, $order['code'])) {
                throw new Exception('流水借贷不平衡');
            }
            $transaction->commit();
            $flag = true;
        } catch (Exception $e) {
            $transaction->rollBack();
            $flag = false;
            throw new Exception($e->getMessage());
        }
        if ($flag) {
            self::sendSms($store, $refundPrice, $totalRefundIntegral);
        }
        return $flag;
    }

    /**
     * 消费会员更新余额,并插入流水
     * @param type $account 会员余额账户
     */
    private static function updateMember($memberBalance, $onlineAccount = null)
    {
        // 更新余额
        AccountBalance::calculate(array('today_amount' => self::$_totalRefundPrice), $memberBalance['id']);
        // 流水
        self::$_flow[] = AccountFlow::mergeFlowData(self::$_order, $memberBalance, array(
            'debit_amount' => -self::$_totalRefundPrice, // 借方发生额
            'remark' => self::$_member['gai_number'] . "订单维权成功，退还" . Common::convertSingle(self::$_totalRefundPrice, self::$_member['type_id']) . "盖网积分,订单编号:" . self::$_order['code'] . "。",
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RIGHT,
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RIGHT_REFUND, //0701
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RIGHTS,
        ));
    }

    /**
     * 待返还更新余额,并插入流水
     * @param type $account 余额表账户信息
     * @param type $memberIncome 获得的分配金额
     */
    private static function updateMemberReturn($account, $memberIncome)
    {
        if ($account['today_amount'] - $memberIncome < 0) {
            throw new Exception('会员待返还余额不足');
        }
        $memberIncomeIntegral = Common::convertSingle($memberIncome, self::$_member['type_id']); // 待返还积分
        // 更新余额
        AccountBalance::calculate(array('today_amount' => -$memberIncome), $account['id']);
        // 流水
        $gaiNumber = self::$_member['gai_number'];
        $code = self::$_order['code'];
        self::$_flow[] = AccountFlow::mergeFlowData(self::$_order, $account, array(
            'credit_amount' => -$memberIncome,
            'remark' => "{$gaiNumber}订单维权成功，扣除待返还{$memberIncomeIntegral}盖网积分,订单编号:{$code}。",
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RIGHT,
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RIGHT_RETURN_REWARD, //0712
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RIGHTS,
        ));
    }

    /**
     * 已签收,商家更新余额,并插入流水
     * @param type $account 商家余额账户
     * @param float $freight 运费
     * @param type $refundPrice 退款金额
     */
    private static function updateStore($account, $freight, $refundPrice)
    {
        if ($account['today_amount'] - self::$_totalRefundPrice < 0) {
            throw new Exception('商家余额不足');
        }
        // 商家帐号余额更新
        AccountBalance::calculate(array('today_amount' => -self::$_totalRefundPrice), $account['id']);
        // 借方商家流水
        $gaiNum = self::$_member['gai_number'];
        $code = self::$_order['code'];
        self::$_flow[] = AccountFlow::mergeFlowData(self::$_order, $account, array(
            'credit_amount' => -self::$_totalRefundPrice, // 贷方发生额
            'remark' => "{$gaiNum}订单维权成功，扣除商家{$freight}元运费及{$refundPrice}元商品价格给买家，订单编号：{$code}。",
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RIGHT,
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RIGHT_RETURN_CASH, //0711
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RIGHTS,
        ));
    }

    /**
     * 会员支付运费,更新余额,并插入流水
     * @param type $account 会员余额账户
     */
    private static function updateMemberFreight($memberArr)
    {
        //再次查询会员账户最新余额
        $account = AccountBalance::findRecord($memberArr);
        // 会员帐号余额更新
        if ($account['today_amount'] - self::$_customerAssumeFreight < 0) {
            throw new Exception('会员余额不足');
        }
        AccountBalance::calculate(array('today_amount' => -self::$_customerAssumeFreight), $account['id']);
        // 流水
        $gaiNum = self::$_member['gai_number'];
        $code = self::$_order['code'];
        self::$_flow[] = AccountFlow::mergeFlowData(self::$_order, $account, array(
            'debit_amount' => self::$_customerAssumeFreight, // 借方发生额
            'remark' => "{$gaiNum}订单维权成功，买家承担" . self::$_customerAssumeFreight . "元手续费退还给商家，订单编号：{$code}。",
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RIGHT,
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RIGHT_PAY_CHARGE, //0704
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RIGHTS,
        ));
    }

    /**
     * 商家收取运费,更新余额,并插入流水
     * @param type $account 商家余额账户
     */
    private static function updateStoreFreight($account)
    {
        // 商家帐号余额更新
        AccountBalance::calculate(array('today_amount' => self::$_customerAssumeFreight), $account['id']);
        // 贷方商家流水(运费)
        $gaiNum = self::$_member['gai_number'];
        $code = self::$_order['code'];
        self::$_flow[] = AccountFlow::mergeFlowData(self::$_order, $account, array(
            'credit_amount' => self::$_customerAssumeFreight, // 贷方发生额
            'remark' => "{$gaiNum}订单维权成功，买家承担" . self::$_customerAssumeFreight . "元手续费退还给商家，订单编号：{$code}。",
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RIGHT,
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RIGHT_GET_CHARGE, //0714
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RIGHTS,
        ));
    }

    /**
     * 未签收,盖网暂收更新余额(线上总账户 - 订单总金额)
     * @param type $account 线上总账户
     */
    private static function updateGatewangTotal($account)
    {
        if ($account['today_amount'] - self::$_totalRefundPrice < 0) {
            throw new Exception('盖网总账户余额不足');
        }
        AccountBalance::calculate(array('today_amount' => -self::$_totalRefundPrice), $account['id']);
        // 流水
        $gaiNum = self::$_member['gai_number'];
        $code = self::$_order['code'];
        self::$_flow[] = AccountFlow::mergeFlowData(self::$_order, $account, array(
            'credit_amount' => -self::$_totalRefundPrice, // 贷方发生额
            'remark' => "{$gaiNum}订单维权成功，扣除" .
                CommonAccount::showType(CommonAccount::TYPE_ONLINE_TOTAL) . self::$_totalRefundPrice .
                "元暂收金额，订单编号：{$code}。",
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RIGHT,
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RIGHT_RETURN_ORDER, //0713
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RIGHTS,
        ));
    }

    /**
     * 已签收,盖网收益更新余额(从会员扣回分配金额加回给盖网收益账户)
     * @param type $account 盖网收益余额账户信息
     * @param type $memberIncome 会员分配金额
     */
    private static function updateGatewangIncome($account, $memberIncome)
    {
        AccountBalance::calculate(array('today_amount' => $memberIncome), $account['id']);
        // 盖网收益账户流水
        $gaiNum = self::$_member['gai_number'];
        $code = self::$_order['code'];
        self::$_flow[] = AccountFlow::mergeFlowData(self::$_order, $account, array(
            'debit_amount' => -$memberIncome, // 借方发生额
            'remark' => "{$gaiNum}订单维权成功，扣除会员{$memberIncome}元待返还，订单编号：{$code}。",
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_RIGHT,
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_RIGHT_REWARD, //0703
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RIGHTS,
        ));
    }


    /**
     * 维权短信发送
     * @param array $store
     * @param float $refundPrice
     * @param float $totalRefundIntegral
     * @param float $customerAssumeFreight
     */
    private static function sendSms($store, $refundPrice, $totalRefundIntegral)
    {
        // 发送短信息
        if (self::$_order['delivery_status'] == Order::DELIVERY_STATUS_RECEIVE) {
            // 商家，已签收：尊敬的{0}用户，订单{1}经盖网维权审核，您将扣除{2}元运费及{3}元商品价格给消费者，请您核实。
            $temp = Tool::getConfig('smsmodel', 'storeOrderRightsSigned');
            $msg = strtr($temp, array(
                '{0}' => $store['store_name'],
                '{1}' => self::$_order['code'],
                '{2}' => self::$_order['freight'],
                '{3}' => $refundPrice,
            ));
            $tmpId = Tool::getConfig('smsmodel', 'storeOrderRightsSignedId');
            $datas = array($store['store_name'],self::$_order['code'],self::$_order['freight'], $refundPrice);
            SmsLog::addSmsLog($store['member_mobile'], $msg, self::$_order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true, $datas, $tmpId);
        } else {
            // 商家，未签收：尊敬的{0}用户，订单{1}经盖网维权审核，给予退货处理，同时您获得买家承担的{2}元运费，请您核实。
            $temp = Tool::getConfig('smsmodel', 'storeOrderRightsUnsigned');
            $msg = strtr($temp, array(
                '{0}' => $store['store_name'],
                '{1}' => self::$_order['code'],
                '{2}' => self::$_customerAssumeFreight,
            ));
            $tmpId =Tool::getConfig('smsmodel', 'storeOrderRightsUnsignedId');
            $datas = array($store['store_name'],self::$_order['code'],self::$_customerAssumeFreight);
            SmsLog::addSmsLog($store['member_mobile'], $msg, self::$_order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true, $datas, $tmpId);
        }
        // 买家：尊敬的{0}用户，订单{1}经盖网维权审核，退还您{2}盖网积分，请您核实。
        $temp = Tool::getConfig('smsmodel', 'memberOrderRights');
        $msg = strtr($temp, array(
            '{0}' => self::$_member['gai_number'],
            '{1}' => self::$_order['code'],
            '{2}' => $totalRefundIntegral,
        ));
        $tmpId = Tool::getConfig('smsmodel', 'memberOrderRightsId');
        $datas = array(self::$_member['gai_number'],self::$_order['code'],$totalRefundIntegral);
        SmsLog::addSmsLog(self::$_member['mobile'], $msg, self::$_order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true, $datas, $tmpId);
    }

}
