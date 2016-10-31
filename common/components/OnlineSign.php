<?php

/**
 * 线上订单签收类
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class OnlineSign
{

    // 保留小数位
    static $median = 2;

    /** @var int 当前订单的分配金额 */
    private static $_totalAssign = 0;

    /** @var array 账目流水 */
    private static $_flowArray = array();

    /** @var array 订单数据 */
    private static $_order = array();

    /** @var array 短信 */
    private static $_sms = array();

    /** @var array 分配比例 */
    private static $_ratio = array();

    /** @var  int $_ip */
    private static $_ip;

    /** @var  array $_memberType */
    private static $_memberType;

    /** @var  array 消费者推荐信息 */
    private static $_memberRefer = array();

    /**
     * 消费者待返还 操作
     * @param array $member 会员信息
     * @return array 待返还金额
     */
    private static function _memberReturnAssign($member)
    {
        //返还余额账户信息
        $balanceReturnMember = OnlineOperate::getMemberAccountInfo($member, AccountInfo::TYPE_RETURN, false);
        //会员待返还金额
        $returnMoney = OnlineCalculate::memberAssign(self::$_totalAssign['surplusAssign'], $member, self::$_ratio, self::$_memberType);
        //消费奖励(待返还账户) 流水
        self::$_flowArray['returnMember'] = AccountFlow::mergeFlowData(self::$_order, $balanceReturnMember, array(
            'credit_amount' => $returnMoney['memberIncome'],
            'remark' => '线上订单签收，获得返还金额：￥' . $returnMoney['memberIncome'],
            'ratio' => self::$_memberType[$member['type_id']],
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_REWARD,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
            'ip' => self::$_ip,
        ));
        //会员(返还账户)余额
        AccountBalance::calculate(array('today_amount' => $returnMoney['memberIncome']), $balanceReturnMember['id']);
        //会员签收获得返还金额短信提示
        if ($member['mobile']) {
            //尊敬的{0}用户，您于{1}时间，支付的{2}订单，已完成签收。本次返还您{3}积分，将在评价后解冻使用。目前您还剩余{4}积分。
            $smsText = Tool::getConfig('smsmodel', 'signReturnMoney');
            $memberTotal = AccountBalance::getAccountAllBalance($member['gai_number'], AccountInfo::TYPE_CONSUME);
            $smsContent = strtr($smsText, array(
                '{0}' => $member['gai_number'],
                '{1}' => date('Y/m/d H:i:s', self::$_order['pay_time']),
                '{2}' => self::$_order['code'],
                '{3}' => Common::convertSingle($returnMoney['memberIncome'], $member['type_id']),
                '{4}' => Common::convertSingle($memberTotal, $member['type_id']),
            ));
            $datas = array($member['gai_number'],date('Y/m/d H:i:s', self::$_order['pay_time']),self::$_order['code'],Common::convertSingle($returnMoney['memberIncome'], $member['type_id']), Common::convertSingle($memberTotal, $member['type_id']),);
            $smsConfig = Tool::getConfig('smsmodel');
            self::$_sms[] = array('mobile' => $member['mobile'], 'content' => $smsContent,'datas'=>$datas, 'tmpId'=> $smsConfig['signReturnMoneyId']);
        }

        return $returnMoney;
    }

    /**
     * 消费者推荐操作
     * @param array $member 会员信息
     * @return array 消费者推荐 分配金额
     * @throws Exception
     */
    public static function _memberAssign($member)
    {
        if ($member['referrals_id']) {
            $memberRefer = Yii::app()->db->createCommand()
                ->select(array('id', 'username', 'gai_number', 'mobile', 'type_id'))
                ->from('{{member}}')
                ->where('id=:id', array(':id' => $member['referrals_id']))->queryRow();
            self::$_memberRefer = $memberRefer;
        } else {
            $memberRefer = array();
        }
        // 当前订单消费者推荐的分配金额
        $memberReferResult = OnlineCalculate::memberReferAssign(self::$_totalAssign['surplusAssign'], self::$_ratio, self::$_memberType, $memberRefer);
        if (empty($memberRefer))
            return $memberReferResult;
        $memberReferArray = array(
            'account_id' => $memberRefer['id'],
            'gai_number' => $memberRefer['gai_number'],
            'type' => AccountInfo::TYPE_CONSUME);
        $memberReferBalance = AccountBalance::findRecord($memberReferArray);
        if (!$memberReferBalance) {
            throw new Exception('创建消费者推荐账户失败');
        }

        //流水
        self::$_flowArray['memberRefer'] = AccountFlow::mergeFlowData(self::$_order, $memberReferBalance, array(
            'credit_amount' => $memberReferResult['memberReferIncome'],
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
            'remark' => '线上订单签收，消费者推荐入账：￥' . $memberReferResult['memberReferIncome'],
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_DISTRIBUTION,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
//            'distribution_ratio' => bcdiv($memberReferResult['memberReferIncome'], self::$_totalAssign['totalAssign'], self::$median),
            'distribution_ratio' => 0 == self::$_totalAssign['totalAssign'] ? 0 : bcdiv($memberReferResult['memberReferIncome'], self::$_totalAssign['totalAssign'], self::$median),
            'ratio' => self::$_memberType[$memberRefer['type_id']],
            'ip' => self::$_ip,
            'by_gai_number' => $member['gai_number'], // 被推荐人的GW
        ));
        //余额表操作
        AccountBalance::calculate(array('today_amount' => $memberReferResult['memberReferIncome']), $memberReferBalance['id']);
        // 会员推荐
        if ($memberRefer['mobile']) {
            //尊敬的{0}用户，买家{1}于{2}时间签收了订单{3}。您获得了{4}盖网积分作为推荐奖励，目前您还剩余{5}消费积分，请您核实。
            $smsTemplate = Tool::getConfig('smsmodel', 'signOrderMemrefGet');
            $historyMoney = Member::getHistoryPrice(AccountInfo::TYPE_CONSUME, $memberRefer['id'], $memberRefer['gai_number']);
            $totalPrice = $memberReferBalance['today_amount'] + $memberReferResult['memberReferIncome'] + $historyMoney;
            $smsTemplate = strtr($smsTemplate, array(
                '{0}' => $memberRefer['gai_number'],
                '{1}' => $member['gai_number'],
                '{2}' => date('Y/m/d H:i:s', time()),
                '{3}' => self::$_order['code'],
                '{4}' => Common::convertSingle($memberReferResult['memberReferIncome'], $memberRefer['type_id']),
                '{5}' => Common::convertSingle($totalPrice, $memberRefer['type_id']),
            ));
            $datas = array($memberRefer['gai_number'],$member['gai_number'],date('Y/m/d H:i:s', time()),self::$_order['code'],Common::convertSingle($memberReferResult['memberReferIncome'], $memberRefer['type_id']),Common::convertSingle($totalPrice, $memberRefer['type_id']),);
           $smsConfig = Tool::getConfig('smsmodel');
            self::$_sms[] = array('mobile' => $memberRefer['mobile'], 'content' => $smsTemplate, 'datas'=>$datas, 'tmpId'=>  $smsConfig['signOrderMemrefGetId']);
        }
        return $memberReferResult;
    }

    /**
     * 商家账户 操作
     * @param array $store 店铺信息
     * @param array $member 会员信息
     * @param array $enterprise
     * @throws Exception
     */
    private static function _enterPriseAssign($store, $member, $enterprise)
    {
        // 商家账户
        $enterpriseArray = array('account_id' => $store['member_id'], 'gai_number' => $store['gai_number'], 'type' => AccountInfo::TYPE_MERCHANT);
        $enterpriseBalance = AccountBalance::findRecord($enterpriseArray);
        if (!$enterpriseBalance) {
            throw new Exception('创建商家账户失败');
        }
        $totalPrice = self::$_totalAssign['gaiPrice'] + self::$_totalAssign['freight'];
        // 商家流水
        self::$_flowArray['enterprise'] = AccountFlow::mergeFlowData(self::$_order, $enterpriseBalance, array(
            'credit_amount' => $totalPrice,
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
            'remark' => '线上订单签收，商家入供货价：￥' . self::$_totalAssign['gaiPrice'] . '，运费：￥' . self::$_totalAssign['freight'],
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_PAY_MERCHANT,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
            'ip' => self::$_ip,
        ));
        // 商家余额表(入供货价)
        AccountBalance::calculate(array('today_amount' => ($totalPrice)), $enterpriseBalance['id']);
        //短信
        if ($store['store_mobile']) {
            //尊敬的{0}用户，买家{1}于{2}时间签收了订单{3}。您获得了{4}元供货价，及{5}元运费，此金额可以提现，请您核实。
            $signOrderComGetTemplate = Tool::getConfig('smsmodel', 'signOrderComGet');
            $smsTemplate = strtr($signOrderComGetTemplate, array(
                '{0}' => $store['name'],
                '{1}' => $member['gai_number'],
                '{2}' => date('Y/m/d H:i:s', time()),
                '{3}' => self::$_order['code'],
                '{4}' => self::$_totalAssign['gaiPrice'],
                '{5}' => self::$_order['freight'],
            ));
            $datas = array( $store['name'],$member['gai_number'],date('Y/m/d H:i:s', time()),self::$_order['code'],self::$_totalAssign['gaiPrice'],self::$_order['freight']);
            $smsConfig = Tool::getConfig('smsmodel');
            self::$_sms[] = array('mobile' => $store['store_mobile'], 'content' => $smsTemplate, 'datas'=>$datas, 'tmpId'=>  $smsConfig['signOrderComGetId']);
        }
        return $totalPrice;
    }

    /**
     * 商家推荐 操作
     * @param array $store 店铺信息
     * @param array $member 会员信息
     * @param array $enterprise 企业信息
     * @param array $memberReferResult 当前订单消费者推荐的分配金额
     * @return array 商家推荐价格
     * @throws Exception
     */
    private static function _enterpriseReferAssign($store, $member, $enterprise, $memberReferResult)
    {
        if ($store['referrals_id']) {
            $businessRefer = Yii::app()->db->createCommand()
                ->select(array('id', 'username', 'gai_number', 'mobile', 'type_id'))
                ->from('{{member}}')
                //->where(array('and', 'id=:id', 'enterprise_id > 0'), array(':id' => $store['referrals_id']))->queryRow();
                 //20160929 wyee 商家推荐可以是普通会员
                ->where('id=:id', array(':id' => $store['referrals_id']))->queryRow();
        } else {
            $businessRefer = null;
        }
        // 当前订单商家推荐的分配金额
        $businessReferResult = OnlineCalculate::businessReferAssign(self::$_totalAssign['surplusAssign'], self::$_ratio, self::$_memberType, $businessRefer);
        if (empty($businessRefer))
            return $businessReferResult;
        $businessReferArray = array('account_id' => $businessRefer['id'], 'gai_number' => $businessRefer['gai_number'], 'type' => AccountInfo::TYPE_CONSUME);
        $businessReferBalance = AccountBalance::findRecord($businessReferArray);
        if (!$businessReferBalance) {
            throw new Exception('创建商家推荐账户失败');
        }
        //流水
        self::$_flowArray['businessRefer'] = AccountFlow::mergeFlowData(self::$_order, $businessReferBalance, array(
            'credit_amount' => $businessReferResult['businessReferIncome'],
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
            'remark' => '线上订单签收，商家推荐入账：￥' . $businessReferResult['businessReferIncome'],
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_DISTRIBUTION,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
            'distribution_ratio' => 0 == self::$_totalAssign['totalAssign'] ? 0 : bcdiv($businessReferResult['businessReferIncome'], self::$_totalAssign['totalAssign'], self::$median),
            'ratio' => self::$_memberType[$businessRefer['type_id']],
            'ip' => self::$_ip,
            'by_gai_number' => $member['gai_number'], // 被推荐人的GW
        ));
        //商家推荐余额
        AccountBalance::calculate(array('today_amount' => $businessReferResult['businessReferIncome']), $businessReferBalance['id']);
        //短信
        // 商家推荐
        if ($businessRefer['mobile']) {
            //尊敬的{0}用户，买家{1}于{2}时间签收了商家{3}的订单{4}。您获得了{5}盖网积分作为推荐奖励，目前您还剩余{6}消费积分，请您核实。
            $smsTemplate = Tool::getConfig('smsmodel', 'signOrderMemrefstoreGet');
            if (isset(self::$_memberRefer['id']) && $businessRefer['id'] == self::$_memberRefer['id']) {
                $Fmoney = $businessReferResult['businessReferIncome'] + $memberReferResult['memberReferIncome'];
            } else {
                $Fmoney = $businessReferResult['businessReferIncome'];
            }
            $historyMoney = Member::getHistoryPrice(AccountInfo::TYPE_CONSUME, $businessRefer['id'], $businessRefer['gai_number']);
            $totalPrice = $businessReferBalance['today_amount'] + $Fmoney + $historyMoney;
            $smsTemplate = strtr($smsTemplate, array(
                '{0}' => $businessRefer['gai_number'],
                '{1}' => $member['gai_number'],
                '{2}' => date('Y/m/d H:i:s', time()),
                '{3}' => $enterprise['name'],
                '{4}' => self::$_order['code'],
                '{5}' => Common::convertSingle($businessReferResult['businessReferIncome'], $businessRefer['type_id']),
                '{6}' => Common::convertSingle($totalPrice, $businessRefer['type_id']),
            ));
            $datas = array($businessRefer['gai_number'], $member['gai_number'],date('Y/m/d H:i:s', time()),$enterprise['name'],self::$_order['code'],Common::convertSingle($businessReferResult['businessReferIncome'], $businessRefer['type_id']),Common::convertSingle($totalPrice, $businessRefer['type_id']));
            $smsConfig = Tool::getConfig('smsmodel');
            self::$_sms[] = array('mobile' => $businessRefer['mobile'], 'content' => $smsTemplate, 'datas'=>$datas, 'tmpId'=>$smsConfig['signOrderMemrefstoreGetId']);
        }
        return $businessReferResult;
    }

    /**
     * 线上盖网总账户 操作
     * @throws Exception
     */
    private static function _gaiOnlineAssign()
    {
        $balanceOnlineOrder = CommonAccount::getOnlineAccount();
        if ($balanceOnlineOrder['today_amount'] - self::$_order['pay_price'] < 0) {
            throw new Exception('s205');
        }
        //线上盖网总账户流水
        self::$_flowArray['onlineOrder'] = AccountFlow::mergeFlowData(self::$_order, $balanceOnlineOrder, array(
            'debit_amount' => self::$_order['pay_price'],
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
            'remark' => '线上订单签收，线上盖网总账户出账：￥' . self::$_order['pay_price'],
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_CONFIRM,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
            'ip' => self::$_ip,
        ));
        //线上总账户要减去会员实际支付的金额
        AccountBalance::calculate(array('today_amount' => -self::$_order['pay_price']), $balanceOnlineOrder['id']);
    }

    /**
     * 盖网收益账户操作
     * @param $gaiTotal
     * @throws Exception
     */
    private static function _gaiIncomeAssign($gaiTotal)
    {

        //盖网收益账户
        $balanceGAI = CommonAccount::getAccount(CommonAccount::TYPE_GAI_INCOME, AccountInfo::TYPE_COMMON);
        if (!$balanceGAI) {
            throw new Exception('创建盖网收益账户失败');
        }

        self::$_flowArray['GAI'] = AccountFlow::mergeFlowData(self::$_order, $balanceGAI, array(
            'credit_amount' => $gaiTotal,
            'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_SIGN,
            'remark' => '线上订单签收，盖网收益总账户入账' . $gaiTotal,
            'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_PROFIT,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_DISTRIBUTION,
            'distribution_ratio' => 0 == self::$_totalAssign['totalAssign'] ? 0 : bcdiv($gaiTotal, self::$_totalAssign['totalAssign'], self::$median),
            'ip' => self::$_ip,
        ));
        //账户操作
        AccountBalance::calculate(array('today_amount' => $gaiTotal), $balanceGAI['id']);
    }

    /**
     * 订单签收
     * @param array|Order $order 订单信息
     * @param array|OrderGoods $orderGoods 订单商品信息
     * @param array|member $member 会员信息
     * @param array $store 店铺信息
     * @param bool $online 区分在线还是批处理
     * @return array
     */
    public static function order(Array $order, Array $orderGoods, Array $member, Array $store, $online = true, $isAuto = false)
    {
    	//清空静态变量
    	self::$_flowArray = array();
    	self::$_sms = array();
    	self::$_memberRefer = array();
    	
        $enterprise = Yii::app()->db->createCommand()
            ->select('e.id,e.name')
            ->from('{{enterprise}} AS e')
            ->leftJoin('{{member}} AS m', 'm.enterprise_id=e.id')
            ->where('m.id=:mid', array(':mid' => $store['member_id']))->queryRow();
        self::$_order = $order;
        // 记录签收者的IP，若是自动签收脚本执行，则为0
        self::$_ip = $online ? Tool::ip2int(Yii::app()->request->userHostAddress) : 0;
        //流水日志表名
        $flowTableName = AccountFlow::monthTable(); //流水日志表名
        // 会员类型
        self::$_memberType = MemberType::fileCache();
        // 提取当前订单的分配比率
        $jsonResult = CJSON::decode($order['distribution_ratio']);
        self::$_ratio = $jsonResult['ratio'];

        $msg = array();
        $transaction = Yii::app()->db->beginTransaction();
        try {
            //再次订单状态,并加行锁
            $sql = "select code,id,is_distribution,delivery_status,status from {{order}} where id = {$order['id']} limit 1 for update";
            $data = Yii::app()->db->createCommand($sql)->queryRow();
           if($isAuto){
               if ($data['is_distribution'] == Order::IS_DISTRIBUTION_YES)
            		throw new Exception($order['code'] . Yii::t('order', '订单已经分配过了,请不要重复操作.'));
            }else{
               if ($data['delivery_status'] == Order::DELIVERY_STATUS_RECEIVE && $data['status'] == Order::STATUS_COMPLETE)
                    throw new Exception($order['code'] . Yii::t('order', '订单已经签收过了,请不要重复操作.'));
            }   
             // 当前订单的分配金额
            self::$_totalAssign = OnlineCalculate::orderIncome($order, $orderGoods);
            /**
             * 消费者待返还
             */
            $memberReturnResult = self::_memberReturnAssign($member);
            /**
             * 消费者推荐
             */
            $memberReferResult = self::_memberAssign($member);
            /**
             * 商家
             */
            $enterPriseAssign = self::_enterPriseAssign($store, $member, $enterprise);
            /**
             * 商家推荐
             */
            $businessReferResult = self::_enterpriseReferAssign($store, $member, $enterprise, $memberReferResult);

            /**
             * 线上盖网总账户
             * 1.商城公共
             * 2.盖网(利润比+自身的分配比+分配剩余)
             * 3.机动
             */
            //线上总账户
            self::_gaiOnlineAssign();

            // 当前订单盖网的分配金额
//            $gaiResult = OnlineCalculate::gaiAssign(self::$_totalAssign['surplusAssign'], self::$_ratio);
//            // 当前订单机动的分配金额
//            $moveResult = OnlineCalculate::moveAssign(self::$_totalAssign['surplusAssign'], self::$_ratio);
//            //当前订单商城公共分配金额
//            $agentResult = OnlineCalculate::mall(self::$_totalAssign['surplusAssign'], self::$_ratio);
//            // 计算分配后的最后剩余金额
//            $surplusPrice = OnlineCalculate::surplusPrice(self::$_totalAssign['surplusAssign'], $memberReturnResult, $moveResult, $gaiResult, $businessReferResult, $memberReferResult, $agentResult);
//            // 最终市盖网公共账号入账
//            $gaiTotalIncome = OnlineCalculate::gaiFinalIncome($gaiResult, $memberReturnResult, $memberReferResult, $businessReferResult, self::$_totalAssign, $surplusPrice);
//             var_dump($gaiResult);
//            echo "<hr/>";
//            var_dump($moveResult);
//            echo "<hr/>";
//            var_dump($agentResult);
//            echo "<hr/>";
//            var_dump($surplusPrice);
//            echo "<hr/>";
//            echo $gaiTotalIncome;
//            echo "<hr/>";
//            die;
            //盖网收益帐户入账金额 = 会员实际支付金额 - (消费者待返还 + 消费者推荐 + 商家 + 商家推荐)
            $assignMoney1 = bcadd($memberReturnResult['memberIncome'], $memberReferResult['memberReferIncome'], self::$median);
            $assignMoney2 = bcadd($enterPriseAssign, $businessReferResult['businessReferIncome'], self::$median);
//            echo $assignMoney1 + $assignMoney2;die;
            $gaiTotal = bcsub(self::$_order['pay_price'], bcadd($assignMoney1, $assignMoney2, self::$median), self::$median);
//            $gaiTotal = bcadd($moveResult['moveIncome'], bcadd($agentResult['mallIncome'], $gaiTotalIncome, self::$median), self::$median);
            self::_gaiIncomeAssign($gaiTotal);

            // 流水记录
            foreach (self::$_flowArray as $flow) {
                Yii::app()->db->createCommand()->insert($flowTableName, $flow);
            }
            self::$_flowArray = array();
            
           if($isAuto){
            	// 更新订单状态，变为已分配
               Yii::app()->db->createCommand()->update('{{order}}', array(
            	'is_distribution' => Order::IS_DISTRIBUTION_YES), 'id=:orderId', array(':orderId' => $order['id']));   	 
             }else{
            	// 更新订单状态，变更为已签收，订单完成状态
               Yii::app()->db->createCommand()->update('{{order}}', array(
                'delivery_status' => Order::DELIVERY_STATUS_RECEIVE,
                'status' => Order::STATUS_COMPLETE,
                'is_distribution' => Order::IS_DISTRIBUTION_YES,
                'sign_time' => time()), 'id=:orderId', array(':orderId' => $order['id']));
            }
            // 更新订单下商品的销售数据
            foreach ($orderGoods as $og) {
                Goods::model()->updateCounters(array('sales_volume' => $og['quantity']), 'id=:id', array(':id' => $og['goods_id']));
                //更新店铺销量
                Store::model()->updateCounters(array('sales' => $og['quantity']), 'id = :id', array(':id' => $order['store_id']));
            }

            //检测借贷平衡
            if (!DebitCredit::checkFlowByCode($flowTableName, $order['code'])) {
                throw new Exception('DebitCredit Error!', '009');
            }

            $transaction->commit();
            $msg['flag'] = $flag = true;
            $msg['info'] = '签收订单成功';
        } catch (Exception $e) {
            $transaction->rollBack();

            $msg['flag'] = $flag = false;
            $msg['info'] = '签收订单失败：' . $e->getMessage();
        }
        if ($flag) {
            // 短信发送
            foreach (self::$_sms as $v) {
                SmsLog::addSmsLog($v['mobile'], $v['content'],  $order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true,$v['datas'], $v['tmpId']);
            }
        }
        

        return $msg;
    }

}
