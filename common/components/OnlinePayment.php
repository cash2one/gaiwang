<?php

/**
 * 在线支付类 (积分支付,网银支付)
 * @author binbin.liao <277250538@qq.com>
 */
class OnlinePayment {

    public static $cash;

    /**
     * 库存操作
     * @param array $orders
     * @throws CDbException
     * @return int | bool
     */
    private static function _stockLog(Array $orders) {
        $sql = '';
        //下单暂减库存保留时间
        $order_config = Tool::getConfig('order', 'stock_time');
        //更新库存
        foreach ($orders as $k => $v) {
            //如果下单时间 小于  暂减库存保留时间 则跳过
            if (time() - $v['create_time'] < $order_config)
                continue;
            //查找是否已自动补回库存
            $stock_log = Yii::app()->db->createCommand()->from('{{stock_log}}')->where("order_id={$v['id']}")->queryScalar(array('order_id'));
            if (!$stock_log)
                continue; //如果为空则表示控制台程序未将库存补回，下面不用扣库存
            foreach ($v['orderGoods'] as $v2) {
                if (!isset($v2['goods_id']))
                    throw new Exception('订单数据有问题,扣减库存失败');
                $spec = Yii::app()->db->createCommand()->select('id')->from('{{goods_spec}}')->where('goods_id=' . $v2['goods_id'])->queryRow();
                if (!$spec)
                    continue; //如果库存对应的相关规格不存在，则跳过
                $sql .= "UPDATE gw_goods SET stock=stock-{$v2['quantity']} WHERE (stock-{$v2['quantity']}) >=0 AND id={$v2['goods_id']};";
                $sql .= "UPDATE gw_goods_spec SET stock=stock-{$v2['quantity']} WHERE (stock-{$v2['quantity']}) >=0 AND id={$v2['spec_id']};";
                //删除相关商品的缓存
                ActivityData::delGoodsCache($v2['goods_id']);
            }
        }
        if (!empty($sql)) {
            return Yii::app()->db->createCommand($sql)->execute();
        } else {
            return false;
        }
    }

    /**
     * 计算本次消费需要使用的历史余额
     * @param array $balance
     * @param array $balanceHistory
     * @param float $pay 使用积分支付
     * @param bool $useHistoryFirst 是否优先使用历史账户余额，网银支付优先使用历史账户余额(还需要讨论)
     * @return float
     */
    public static function getHistoryUseMoney(Array $balance, Array $balanceHistory, $pay, $useHistoryFirst=false) {
        //要代扣的金额
        $useMoney = 0;
        //1.没有历史余额
        if (!$balanceHistory)
            return $useMoney;
        //优先使用历史余额
        if($useHistoryFirst){
            if($balanceHistory['today_amount'] >= $pay){
                $useMoney = $pay;
            }else{
                if ($balance['today_amount'] >= $pay) {
                    $useMoney = $balanceHistory['today_amount'];
                }else{
                    $useMoney = bcsub($pay,$balance['today_amount'],2);
                }
            }
        }else{ //优先使用新余额
            if ($balance['today_amount'] >= $pay) {
                $useMoney = 0;
            } else {
                $useMoney = bcsub($pay,$balance['today_amount'],2);
            }
        }

        return $useMoney;
    }

    /**
     * 积分支付
     * @param array $orders 订单信息
     * @param float $payPrice 支付金额
     * @param array $balance 消费余额
     * @param array $balanceHistory 历史余额
     * @param array $member 会员信息
     * @param string $mainCode 流水号、代扣使用
     * @return bool
     * @throws CDbException
     * @throws CHttpException
     * @throws Exception
     */
    public static function payWithJF(Array $orders, $payPrice, Array $balance, Array $balanceHistory, Array $member, $mainCode) {
        $flowTableName = AccountFlow::monthTable(); //流水日志表名
        $flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志表名
        //用户所有消费余额
        $allMoney = $balance['today_amount'] + $balanceHistory['today_amount'];
        //代扣历史余额账户
        $useMoney = self::getHistoryUseMoney($balance, $balanceHistory, $payPrice);

        $trans = Yii::app()->db->beginTransaction();
        $flag = false;
        try {
            if ($useMoney > 0) {
                //当前余额账户金额(历史余额充值到新余额表之后的金额)
                $newBalance = self::deductHistoryMoney($flowTableName, $flowHistoryTableName, $member, $balance, $balanceHistory, $useMoney, $orders);
                if ($newBalance) {
                    $balance = $newBalance; //重新赋值用户余额
                }
            }
            if($payPrice < 0){
            	 throw new Exception('支付金额有误！');
             }
            //判断金额
            if ($allMoney < 0 || bcsub($allMoney,$payPrice,2) < 0) {
                throw new Exception('余额不够支付');
            }
            //线上总账户
            $balanceOnlineOrder = CommonAccount::getAccount(CommonAccount::TYPE_ONLINE_TOTAL, AccountInfo::TYPE_TOTAL);
            $jfArr=array();
            //更新信息-----------------------------------------------------------------------------------------------------
            foreach ($orders as $key=>$order) {
                //再次查询订单状态,并加行锁,避免重复操作
                $sql = "select jf_price,code,id,pay_status from {{order}} where id = {$order['id']} limit 1 for update";
                $data = Yii::app()->db->createCommand($sql)->queryRow();
                $jfArr[]=$data['jf_price'];
                if ($data['pay_status'] == Order::PAY_STATUS_YES)
                    throw new Exception($order['code'] . '订单已经支付过,请不要重复操作');
                //更改订单状态
                Yii::app()->db->createCommand()->update('{{order}}', array(
                    'pay_type' => Order::PAY_TYPE_JF,
                    'pay_status' => Order::PAY_STATUS_YES,
                    'pay_time' => time(),
                    'status' => Order::STATUS_NEW, //订单可能因为并发的原因被关闭了，还能进入支付页面，这里统一强制修改为新订单
                        ), 'id=:orderId', array(':orderId' => $order['id']));
                $orders[$key]['pay_type'] = Order::PAY_TYPE_JF;	//@author LC   
               //会员流水
                $balanceAccount = array(
                    'balanceMember' => $balance,
                    'balanceOnlineOrder' => $balanceOnlineOrder,
                );
                $flowLog = self::flowLog($order, $balanceAccount, $member['type_id']);
                //写入流水
                foreach ($flowLog as $log) {
                    Yii::app()->db->createCommand()->insert($flowTableName, $log);
                }
                //会员(消费账户)余额表
                AccountBalance::calculate(array('today_amount' => -$order['pay_price']), $balance['id']);
                //线上总账户余额表
                AccountBalance::calculate(array('today_amount' => $order['pay_price']), $balanceOnlineOrder['id']);
                //红包订单支付
                if ($order['source_type'] == Order::SOURCE_TYPE_HB) {
                    //@todo 红包订单的流水改成写入历史流水表 binbin.liao 2015-4-14
                    self::payWithOtherPrice($flowHistoryTableName, $order, $member['id']);
                }
                // 检测借贷平衡
                if (!DebitCredit::checkFlowByCode($flowTableName, $order['code'])) {
                    throw new Exception('DebitCredit Error!', '009');
                }
                //合约机订单的消息推送及相关操作
                if ($order['source_type'] == Order::SOURCE_TYPE_HYJ) {
                    self::_heyuePush($order);
                }
            } //end foreach
            
          /***********会员积分余额start-20160811 @author wyee************************************/
             
            $memberId=Yii::app()->user->id;
            //积分支付，会员额度限制  
            $jfprice=$jfArr[0];//多个订单或者单个订单，jf_price保存的数据都是会员所用的积分总数，若是多个订单，则只需取一条数据的jf_price,不可取所有订单之和        
  
            $memberPointArr=MemberPoint::getMemberPoint($memberId,$allMoney);
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
            }else if($memberPointArr['flag']){
            	$dayMoney=bcsub($memberPointArr['info']['day_limit_point'],$jfprice,2);
            	$mouthMoney=bcsub($memberPointArr['info']['month_limit_point'],$jfprice,2);
                Yii::app()->db->createCommand()->update('{{member_point}}', array(
                'day_limit_point' => $dayMoney,
                'month_limit_point' => $mouthMoney,
                'update_time' => time(),  
                ), 'member_id=:mid', array(':mid' => $memberId));
            }
        }else{
            	
            }
          /*****************************会员积分余额end*********************************/
            //库存操作
            self::_stockLog($orders);

            //如果代扣失败,则回滚
            if (!HistoryBalanceUse::pay($orders[0]['code'], $useMoney, $member, $mainCode)) {
                throw new Exception('historyBalance Pay error');
            }

            $trans->commit();
            $flag = true;
        } catch (Exception $e) {
            $trans->rollback();
            //记录错误代扣
            HistoryBalanceUse::errorLog();
            throw new CHttpException(503, Yii::t('order', '支付失败，请联系网站管理员,') . $e->getMessage());
        }
        //发送短信----------------------------------------------------------------------------------------------------------------
        if ($flag) {
            self::sendSms($orders, $member, $allMoney);
            self::_delCache($orders);
        }
        return $flag;
    }

    /**
     * 第三方支付对账成功后的统一操作
     * @param array $orders 订单信息
     * @param array $result 在线支付返回的信息
     * @param int $payType 支付类型(0:环迅 1:银联 2:翼支付)
     * @return bool|string
     * @throws Exception
     */
    public static function payWithUnionPay($orders, $result, $payType) {
        $member = Yii::app()->db->createCommand()
                ->select('id,gai_number,type_id,mobile,username')
                ->from('{{member}}')
                ->where('gai_number=:gaiNumber', array(':gaiNumber' => $result['gw']))
                ->queryRow();

        $memberArray = array(
            'account_id' => $member['id'],
            'gai_number' => $member['gai_number'],
            'type' => AccountInfo::TYPE_CONSUME,
        );
        //当前会员余额,填支付密码之前，已经查过了这两个账户，已经生产相关账户，不用再放到事务
        $balance = AccountBalance::findRecord($memberArray); //会员消费账户
        $balanceHistory = AccountBalanceHistory::findRecord($memberArray); //会员历史消费账户
        //用户所有消费余额
        $allMoney = $balance['today_amount'] + $balanceHistory['today_amount'];

        $flowTableName = AccountFlow::monthTable(); //流水日志表名
        $flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志表名
        $sourceType = $orders[0]['source_type']; //用第一个订单的source_type 判断订单类型
        $payPrice = 0; //总共要支付的金额
        $codes = ''; //代扣流水备注订单
        $jfPrice = 0; //积分支付金额
        $jfArr=array();
        $bankPayNo = isset($result['payTranNo']) ? '支付平台流水：' . $result['payTranNo'] : '';
        foreach ($orders as $order) {
            $payPrice += $order['pay_price'];
            $jfPrice += $order['jf_price'];
            $jfArr[]=$order['jf_price'];
            $codes .= $order['code'] . '：';
        }
        //特殊商品，部分积分支付，求需要 执行代扣的金额
        $useMoney = 0;
        if ($jfPrice>0 || $sourceType == Order::SOURCE_TYPE_SINGLE || $sourceType == Order::SOURCE_TYPE_JFXJ) {
            //代扣历史余额账户
            if (bcadd($allMoney,$result['money'],2) < $payPrice) {
                exit('账户余额不足以支付,allMoney+result[money]:'.($allMoney+$result['money']).',payPrice:'.$payPrice);
            } else {
                $useMoney = self::getHistoryUseMoney($balance, $balanceHistory, bcsub($payPrice,$result['money'],2),false);
            }
        }
        //事务执行
        $flag = '';
        $trans = Yii::app()->db->beginTransaction();
        try {
            $balanceOnlineOrder = CommonAccount::getAccount(CommonAccount::TYPE_ONLINE_TOTAL, AccountInfo::TYPE_TOTAL); //暂收账
            /**
             * 如果使用到历史账户余额，冲到历史余额表，再统一执行代扣操作
             */
            if ($useMoney > 0) {
                AccountBalanceHistory::calculate(array('today_amount' => $result['money']), $balanceHistory['id']);
                $balanceHistory = AccountBalanceHistory::findRecord($memberArray); //重新赋值会员历史消费账户
                //支付前,模拟充值的流水
                $credit = AccountFlow::mergeFlowData($orders[0], $balanceHistory, array(
                    'credit_amount' => $result['money'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_EBANK_RECHARGE,
                    'remark' => Recharge::showPayType($payType) . ',支付订单:' . $codes . $bankPayNo,
                    'node' => RechargeProcess::nodeSelect($payType),
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RECHARGE,
                    'recharge_type' => AccountFlow::RECHARGE_TYPE_BANK,
                    'by_gai_number' => empty($balanceHistory['by_gai_number']) ? '' : $balanceHistory['by_gai_number'],
                ));
                Yii::app()->db->createCommand()->insert($flowHistoryTableName, $credit);
                ### 模拟的支付流水end
                //当前余额账户金额(历史余额充值到新余额表之后的金额)
                $newBalance = self::deductHistoryMoney($flowTableName, $flowHistoryTableName, $memberArray, $balance, $balanceHistory, ($useMoney+$result['money']), $orders);
                if ($newBalance) {
                    $balance = $newBalance; //重新赋值用户余额
                }else{
                    throw new Exception('HistoryBalanceUse::process false');
                }
            } else {
                //先把支付的金额充到会员的不可兑现账户
                //会员(消费账户)余额表
                AccountBalance::calculate(array('today_amount' => $result['money']), $balance['id']);
                $balance = AccountBalance::findRecord($memberArray); //重新赋值用户余额
            }

            if (bcsub($balance['today_amount'],$payPrice,2) < 0) {
                throw new Exception('200 -账户余额不够支付');
            }

            //如果使用现金支付，正常流水
            if($useMoney==0){
                //支付前,模拟充值的流水
                $credit = AccountFlow::mergeFlowData($orders[0], $balance, array(
                    'credit_amount' => $result['money'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_EBANK_RECHARGE,
                    'remark' => Recharge::showPayType($payType) . ',支付订单:' . $codes . $bankPayNo,
                    'node' => RechargeProcess::nodeSelect($payType),
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RECHARGE,
                    'recharge_type' => AccountFlow::RECHARGE_TYPE_BANK,
                    'by_gai_number' => empty($balance['by_gai_number']) ? '' : $balance['by_gai_number'],
                ));
                Yii::app()->db->createCommand()->insert($flowTableName, $credit);
                ### 模拟的支付流水end
            }

            //更改订单状态
            foreach ($orders as $order) {
                //再次查询订单状态,并加行锁,避免重复操作
                $sql = "select code,id,pay_status from {{order}} where id = {$order['id']} limit 1 for update";
                $data = Yii::app()->db->createCommand($sql)->queryRow();
                if ($data['pay_status'] == Order::PAY_STATUS_YES)
                    throw new Exception($order['code'] . '订单已经支付过,请不要重复操作');
                //支付后的 流水和余额
                Yii::app()->db->createCommand()->update('{{order}}', array(
                    'pay_type' => self::getPayType($payType),
                    'pay_status' => Order::PAY_STATUS_YES,
                    'pay_time' => time(),
                    'status'=> Order::STATUS_NEW, //订单可能在支付对账前被关闭了，这里统一强制修改为新订单
                        ), 'id=:orderId', array(':orderId' => $order['id']));

                //会员流水
                $balanceAccount = array(
                    'balanceMember' => $balance,
                    'balanceOnlineOrder' => $balanceOnlineOrder,
                );
                $flowLog = self::flowLog($order, $balanceAccount, $member['type_id']);
                //写入流水
                foreach ($flowLog as $log) {
                    Yii::app()->db->createCommand()->insert($flowTableName, $log);
                }

                //会员(消费账户)余额表
                AccountBalance::calculate(array('today_amount' => -$order['pay_price']), $balance['id']);
                //线上总账户余额表
                AccountBalance::calculate(array('today_amount' => $order['pay_price']), $balanceOnlineOrder['id']);
                //红包订单支付
                if ($order['source_type'] == Order::SOURCE_TYPE_HB) {
                    self::payWithOtherPrice($flowHistoryTableName, $order, $member['id']);
                }
                //拍卖商品支付
                if($order['source_type'] == Order::SOURCE_TYPE_AUCTION) {
                    self::payWithAuction($flowHistoryTableName, $flowTableName, $member, $orders[0]);
                }
                // 检测借贷平衡
                if (!DebitCredit::checkFlowByCode($flowTableName, $order['code'])) {
                    throw new Exception('DebitCredit Error!', '009');
                }
                //合约机订单的消息推送及相关操作
                if ($order['source_type'] == Order::SOURCE_TYPE_HYJ) {
                    self::_heyuePush($order);
                }
            }
            //库存操作
            self::_stockLog($orders);

            //代扣失败
            if (!HistoryBalanceUse::pay($orders[0]['code'], $useMoney, $member, $result['parentCode'])) {
                throw new Exception('historyBalance Pay error');
            }
            
            /***********会员积分余额start-20160811 @author wyee************************************/
             
            $memberId=$member['id'];
            //积分支付，会员额度限制
            $jfpay=$jfArr[0];//多个订单或者单个订单，jf_price保存的数据都是会员所用的积分总数，若是多个订单，则只需取一条数据的jf_price,不可取所有订单之和
            
            $memberPointArr=MemberPoint::getMemberPoint($memberId,$allMoney);
            $dataArr=array();
            $dayMoney='';
            $mouthMoney='';
            if(isset($memberPointArr['flag'])){
             if( !$memberPointArr['flag'] ){
             	$dayMoney=bcsub($memberPointArr['info']['day_usable_point'],$jfpay,2);
            	$mouthMoney=bcsub($memberPointArr['info']['month_usable_point'],$jfpay,2);
            	$dataArr['member_id']=$memberId;
            	$dataArr['grade_id']=$memberPointArr['info']['id'];
            	$dataArr['day_point']=$memberPointArr['info']['day_usable_point'];
            	$dataArr['month_point']=$memberPointArr['info']['month_usable_point'];
            	$dataArr['day_limit_point']=$dayMoney;
            	$dataArr['month_limit_point']=$mouthMoney;
            	$dataArr['create_time']=time();
            	$dataArr['update_time']=time();
            	Yii::app()->db->createCommand()->insert('{{member_point}}', $dataArr);
            }else if($memberPointArr['flag']){
            	$dayMoney=bcsub($memberPointArr['info']['day_limit_point'],$jfpay,2);
            	$mouthMoney=bcsub($memberPointArr['info']['month_limit_point'],$jfpay,2);
            	Yii::app()->db->createCommand()->update('{{member_point}}', array(
            	'day_limit_point' => $dayMoney,
            	'month_limit_point' => $mouthMoney,
            	'update_time' => time(),
            	), 'member_id=:mid', array(':mid' => $memberId));
            }
          }else{
            	 
            }
            /*****************************会员积分余额end*********************************/
            
            $trans->commit();
            $flag = true;
        } catch (Exception $e) {
            $trans->rollback();
            //记录代扣错误日志
            HistoryBalanceUse::errorLog();
            throw new Exception('在线支付失败-208' . $e->getMessage());
        }
        if ($flag) {
            self::sendSms($orders, $member, $allMoney,$useMoney);
            self::_delCache($orders);
        }
        return $flag;
    }

    /**
     * 发送短信
     * @param array $orders 订单信息
     * @param array $member 会员信息
     * @param float $money 提示金额
     * @param float $useMoney 代扣金额
     */
    public static function sendSms($orders, $member, $money = 0.00,$useMoney=0.00) {
        self::$cash = $money;
        //尊敬的{0}用户，您于{1}时间，成功支付{2}订单，使用{3}积分。当前剩余{4}积分。
        $payOrdersmsTemplate = Tool::getConfig('smsmodel', 'payOrder');
        //尊敬的用户{0}，您有新的订单（{1}），请您及时上线核实。
        $sellerNewOrdersmsTemplate = Tool::getConfig('smsmodel', 'sellerNewOrder');
        
        $smsConfig = Tool::getConfig('smsmodel');
        //获取发送广告类型短信的商家的id
        $shop1314 = Tool::getConfig('order', 'shopId_13_14');
        $shop1314 = explode(',', $shop1314);

        foreach ($orders as $order) {
            $payJf = Common::convertSingle($order['pay_price'], $member['type_id']); //每个订单支付的积分
            //计算剩余金额
            if ($order['pay_type']!=Order::PAY_TYPE_JF) {
                $surplusMoney = Common::convertSingle(self::$cash-$useMoney, $member['type_id']);
            } else {
                $surplusMoney = Common::convertSingle(self::$cash -= $order['pay_price'], $member['type_id']);
            }
            //尊敬的{0}用户，您于{1}时间，成功支付{2}订单，使用{3}积分。当前剩余{4}积分。
            $smsTemplate = strtr($payOrdersmsTemplate, array(
                '{0}' => $member['gai_number'],
                '{1}' => date('Y/m/d H:i:s', time()),
                '{2}' => $order['code'],
                '{3}' => $payJf,
                '{4}' => $surplusMoney,
            ));
            $datas = array($member['gai_number'],date('Y/m/d H:i:s', time()),$order['code'],$payJf,$surplusMoney);
            //发送短信判断
            if (in_array($order['store_id'], $shop1314)) {
                self::_otherSendSms($order, $member);
            } else {
                //会员支付订单短信提示
                $tmpId = $smsConfig['payOrderId'];
                SmsLog::addSmsLog($member['mobile'], $smsTemplate, $order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true, $datas , $tmpId);
            }
            Yii::app()->db->createCommand()->update('{{order}}', array(
                'is_send_sms' => Order::SEND_SMS_OK,
                    ), 'id=:orderId', array(':orderId' => $order['id']));

            //给商家提示新订单短信提示
            $storeInfo = Yii::app()->db->createCommand()
                    ->select('c.member_id,c.name,c.mobile,c.email')
                    ->from('{{store}} c')
                    ->where('c.id=:id', array(':id' => $order['store_id']))
                    ->queryRow();
            if ($storeInfo) {
                $smsTemplate = strtr($sellerNewOrdersmsTemplate, array(
                    '{0}' => $storeInfo['name'],
                    '{1}' => $order['code'],
                ));              
                if ($storeInfo['email']) {
                    $sellerNewOrderEmailTemplate = Tool::getConfig('emailmodel', 'xdcontent');
                    $sellerNewOrderTheme =  Tool::getConfig('emailmodel', 'xdtheme');
                    $emialTemplate = strtr($sellerNewOrderEmailTemplate, array(
                        '{0}' => $storeInfo['name'],
                        '{1}' => $order['code'],
                    ));
                    //邮件模板参数,使用闪达邮件代发商
                    $value = array(
                        '%name%' => array($storeInfo['name']),
                        '%order%' => array($order['code'])
                    );
//                    EmailLog::addEmailLog($storeInfo['email'], $sellerNewOrderTheme, $emialTemplate, EmailLog::EMAIL_ORDER);
                    EmailLog::addEmailLog($storeInfo['email'], $sellerNewOrderTheme, $emialTemplate, $value, 'sp_order', EmailLog::TEMPLATE_MAIL, EmailLog::EMAIL_ORDER);

                }
                $tmpId = $smsConfig['sellerNewOrderId'];
                SmsLog::addSmsLog($storeInfo['mobile'], $smsTemplate, $order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true,array($storeInfo['name'],$order['code']), $tmpId);
            }
        }
    }

    /**
     * 订单支付类型的转换
     * @param int $payType 支付方式
     * @param int $type 应用的类型（1：订单，2：流水)
     * @return type
     */
    public static function getPayType($payType) {
        switch ($payType) {
            case OnlinePay::PAY_IPS:
                return Order::PAY_ONLINE_IPS;
                break;
            case OnlinePay::PAY_UNION:
                return Order::PAY_ONLINE_UN;
                break;
            case OnlinePay::PAY_BEST:
                return Order::PAY_ONLINE_BEST;
                break;
            case OnlinePay::PAY_HI:
                return Order::PAY_ONLINE_HI;
                break;
            case OnlinePay::PAY_UM:
                return Order::PAY_ONLINE_UM;
                break;
            case OnlinePay::PAY_UM_QUICK:
                return Order::PAY_ONLINE_UM;
            case OnlinePay::PAY_TLZF:
                return Order::PAY_ONLINE_TLZF;
                break;
            case OnlinePay::PAY_TLZFKJ:
                return Order::PAY_ONLINE_TLZFKJ;
                break;
            case OnlinePay::PAY_GHT:
                return Order::PAY_ONLINE_GHT;
                break;
            case OnlinePay::PAY_GHT_QUICK:
                return Order::PAY_ONLINE_GHT;
                break;
            case OnlinePay::PAY_GHTKJ:
                return Order::PAY_ONLINE_GHTKJ;
                 break;
            case OnlinePay::PAY_EBC:
                return Order::PAY_ONLINE_EBC;
                 break;
        }
    }

    /**
     * 支付流水
     * @param array $order 订单信息
     * @param array $balance 账户余额信息
     * $balance=array(
     * 'balanceMember'=>array(),
     * 'balanceOnlineOrder'=>array(),
     * ...
     * )
     * @param int $memberTypeId 会员类型id
     * @return array  流水日志
     */
    public static function flowLog($order, $balance, $memberTypeId) {
        $memberType = MemberType::fileCache();
        $flowLog = array();
        //会员流水
        $flowLog['member'] = AccountFlow::mergeFlowData($order, $balance['balanceMember'], array(
                    'debit_amount' => $order['pay_price'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_PAY,
                    'remark' => '订单支付成功，支付金额：￥' . $order['pay_price'],
                    'ratio' => $memberType[$memberTypeId],
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_PAY,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
        ));
        //线上总账户
        $flowLog['onlineOrder'] = AccountFlow::mergeFlowData($order, $balance['balanceOnlineOrder'], array(
                    'credit_amount' => $order['pay_price'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_PAY,
                    'remark' => '订单支付成功,暂收账入账：￥' . $order['pay_price'],
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_FREEZE,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
        ));
        return $flowLog;
    }

    /**
     * 历史余额代扣操作,将历史余额充值到消费余额
     * @param string $flowTableName 新的流水表名
     * @param string $flowHistoryTableName 旧的流水表名
     * @param array $member 会员信息
     * @param array $balance 余额
     * @param array $balanceHistory 历史余额
     * @param float $useMoney 消费需要使用的历史余额
     * @param array $orders 订单
     * @return array | bool
     */
    private static function deductHistoryMoney($flowTableName, $flowHistoryTableName, Array $member, Array $balance, Array $balanceHistory, $useMoney, Array $orders) {
        $codes = '';
        foreach ($orders as $order) {
            $codes .= $order['code'] . ':';
        }
        if (HistoryBalanceUse::process($flowTableName, $flowHistoryTableName, $balance, $balanceHistory, $useMoney, $orders[0]['code'], $orders[0]['id'], $codes)) {
            //代扣历史余额后,再次查询新的余额表信息
            $balanceMember = AccountBalance::findRecord($member);
            return $balanceMember;
        } else {
            return false;
        }
    }

    /**
     * 合约机订单支付后的操作
     * @param array $order 订单信息
     */
    public static function _heyuePush($order) {
        /** @var array $orderGoods */
        $orderGoods = isset($order->orderGoods) && !empty($order->orderGoods) ? $order->orderGoods : $order['orderGoods'];
        //订单信息
        $orderDate = array(
            'id' => $order['id'],
            'code' => $order['code'],
            'mobile' => $order['mobile'],
            'address' => $order['address'],
            'consignee' => $order['consignee'],
            'goods_name' => $orderGoods[0]['goods_name'],
        );
        /* 推送订单信息到电信分销平台 */
        $res = Heyue::heyueDataTraffic($orderDate);
        Yii::app()->db->createCommand()->update('{{heyue}}', array(
            'pay_status' => Heyue::PAY_OK,
            'up_status' => $res['status'],
            'return_order' => isset($res['resultCode']) ? $res['resultCode'] : ''
                ), 'order_id=:order_id', array(':order_id' => $order['id']));
    }

    /**
     * 拍卖商品订单流水
     */
    public static function payWithAuction($flowHistoryTableName, $flowTableName, $member, $orders) {
        
        //获取拍卖商品领先的价格记录
        $result = Yii::app()->db->createCommand()
                    ->select('id,balance_history,balance,flow_id,flow_code')
                    ->from('{{seckill_auction_record}}')
                    ->where('status=:status AND is_return=:return AND member_id=:memberId AND rules_setting_id=:rsid AND goods_id=:gid',
                            array(
                                ':status'=>SeckillAuctionRecord::STATUS_ONE,
                                ':return'=>SeckillAuctionRecord::IS_RETURN_NO,
                                ':memberId'=>$member['id'],
                                ':rsid'=>$orders['orderGoods'][0]['rules_setting_id'],
                                ':gid'=>$orders['orderGoods'][0]['goods_id']
                            ))
                    ->queryRow();
        
        if($result['balance_history'] > 0) {
            //转账人消费账户信息(旧)
            $consumeInfo = AccountBalanceHistory::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
            //转账人冻结账户信息(旧)
            $freezeInfo = AccountBalanceHistory::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $member['gai_number']));
            
            // 贷方
            $debit = array(
                    'account_id' => $freezeInfo['account_id'],
                    'gai_number' => $freezeInfo['gai_number'],
                    'card_no' => $freezeInfo['card_no'],
                    'order_id' => $result['flow_id'],
                    'order_code' => $result['flow_code'],
                    'type' => AccountFlow::TYPE_FREEZE,
                    'debit_amount' => '-'.$result['balance_history'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE,
                    'remark' => '拍卖商品积分解冻转入，金额为：￥' . $result['balance_history'],
                    'node' => AccountFlow::BUSINESS_NODE_AUCTION_UNFREEZE_INTO,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
            );

            // 借方
            $credit = array(
                    'account_id' => $consumeInfo['account_id'],
                    'gai_number' => $consumeInfo['gai_number'],
                    'card_no' => $consumeInfo['card_no'],
                    'order_id' => $result['flow_id'],
                    'order_code' => $result['flow_code'],
                    'type' => AccountFlow::TYPE_CONSUME,
                    'credit_amount' => '-'.$result['balance_history'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE,
                    'remark' => '拍卖商品积分解冻，金额为：￥'.$result['balance_history'],
                    'node' => AccountFlow::BUSINESS_NODE_AUCTION_UNFREEZE,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
            );
            //加转账人消费账户金额(旧)
            if (!AccountBalanceHistory::calculate(array('today_amount'=>$result['balance_history']),$consumeInfo['id']))
                    return Yii::t('PrepaidCardTransfer', '加消费账户金额失败！');
            //减转账人冻结账户金额(旧)
            if (!AccountBalanceHistory::calculate(array('today_amount'=>'-'.$result['balance_history']),$freezeInfo['id']))
                    return Yii::t('PrepaidCardTransfer', '减冻结账户金额失败！');

            // 记录月流水表（旧）
            Yii::app()->db->createCommand()->insert($flowHistoryTableName, AccountFlow::mergeField($debit));
            Yii::app()->db->createCommand()->insert($flowHistoryTableName, AccountFlow::mergeField($credit));            
            
        }
        
        if($result['balance'] > 0) {
            //转账人消费账户信息(旧)
            $consumeInfo = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
            //转账人冻结账户信息(旧)
            $freezeInfo = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $member['gai_number']));
            
            // 贷方
            $debit = array(
                    'account_id' => $freezeInfo['account_id'],
                    'gai_number' => $freezeInfo['gai_number'],
                    'card_no' => $freezeInfo['card_no'],
                    'order_id' => $result['flow_id'],
                    'order_code' => $result['flow_code'],
                    'type' => AccountFlow::TYPE_FREEZE,
                    'debit_amount' => '-'.$result['balance'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE,
                    'remark' => '拍卖商品积分解冻转入，金额为：￥' . $result['balance'],
                    'node' => AccountFlow::BUSINESS_NODE_AUCTION_UNFREEZE_INTO,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
            );

            // 借方
            $credit = array(
                    'account_id' => $consumeInfo['account_id'],
                    'gai_number' => $consumeInfo['gai_number'],
                    'card_no' => $consumeInfo['card_no'],
                    'order_id' => $result['flow_id'],
                    'order_code' => $result['flow_code'],
                    'type' => AccountFlow::TYPE_CONSUME,
                    'credit_amount' => '-'.$result['balance'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE,
                    'remark' => '拍卖商品积分解冻，金额为：￥'.$result['balance'],
                    'node' => AccountFlow::BUSINESS_NODE_AUCTION_UNFREEZE,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
            );
            //加转账人消费账户金额(旧)
            if (!AccountBalance::calculate(array('today_amount'=>$result['balance']),$consumeInfo['id']))
                    return Yii::t('PrepaidCardTransfer', '加消费账户金额失败！');
            //减转账人冻结账户金额(旧)
            if (!AccountBalance::calculate(array('today_amount'=>'-'.$result['balance']),$freezeInfo['id']))
                    return Yii::t('PrepaidCardTransfer', '减冻结账户金额失败！');

            // 记录月流水表（旧）
            Yii::app()->db->createCommand()->insert($flowTableName, AccountFlow::mergeField($debit));
            Yii::app()->db->createCommand()->insert($flowTableName, AccountFlow::mergeField($credit));     
        }
        
        //锁住当前记录
        Yii::app()->db->createCommand()->select('is_return')->from('{{seckill_auction_record}}')->where('id = ' . $result['id'] . ' FOR UPDATE')->queryRow();
        //更新拍卖纪录表
        $return = array('is_return' => SeckillAuctionRecord::IS_RETURN_YES);
        Yii::app()->db->createCommand()->update(
            '{{seckill_auction_record}}',
            $return,
            'id=:id',
            array(':id'=>$result['id'])
        );
        
        //更新流水记录表
        $type = array('operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE);
        Yii::app()->db->createCommand()->update(
            '{{seckill_auction_flow}}',
            $type,
            'id=:id AND code=:code',
            array(':id'=>$result['flow_id'],':code'=>$result['flow_code'])
        );
    }


    /**
     * 使用优惠金额(红包)记录流水和余额账户操作
     * @param string $flowTableName
     * @param array $order 订单信息
     * @param int $memberId
     * @author binbin.liao
     * @throws Exception
     */
    public static function payWithOtherPrice($flowTableName, $order, $memberId) {
        $otherPrice = $order['other_price'];

        //红包池公共账户
        $balanceRed = CommonAccount::getHongbaoAccount();
        //写入日志
        $flowLog = AccountFlow::mergeFlowData($order, $balanceRed, array(
                    'debit_amount' => $order['other_price'],
                    'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_PAY,
                    'remark' => '订单支付成功，订单金额：￥' . $order['real_price'] . '会员支付金额：￥' . $order['pay_price'] . '红包优惠金额：￥' . $otherPrice,
                    'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_PAY_RED,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
        ));
        Yii::app()->db->createCommand()->insert($flowTableName, $flowLog);
        if (bcsub($balanceRed['today_amount'],$otherPrice,2) < 0) {
            throw new Exception('PAY WITH YOUHUI ERROR');
        }
        //扣除红包池金额
        if (!AccountBalance::calculate(array('today_amount' => -$otherPrice), $balanceRed['id'])) {
            throw new Exception('UPDATE REDACCOUNT ERROR');
        }
//        //扣除红包池变动金额(account_manage)
//       if(!AccountManage::model()->updateCounters(array('money'=>'-'.$otherPrice),'gai_number=:gai_number AND type=:type',array(':gai_number'=>$balanceRed['gai_number'],':type'=>AccountManage::ACCOUNT_MANAGE_RED))){
//           throw new Exception('UPDATE ACCOUNTMANAGE ERROR');
//       }
        //添加会员使用红包纪录
        $log = array(
            'money' => $otherPrice,
            'create_time' => time(),
            'member_id' => $memberId,
        );
        Yii::app()->db->createCommand()->insert('{{member_account_log}}', $log);
    }

    /**
     * 订单发送其它类型的订单
     * @param array $order 订单数据
     * @param array $member 会员信息
     * @author binbin.liao
     */
    public static function _otherSendSms($order, $member) {
        //如果订单所属商家id在配置文件里,就启用广告短信通道
        $smsTemp = Tool::getConfig('smsmodel', 'smsTo_13_14');
        $advertApi = SmsLog::INTERFACE_JXT_ADVERT;   // @author lc  红包活动采用广告渠道进行发送
        if (is_numeric($member['mobile']))
            SmsLog::addSmsLog($member['mobile'], $smsTemp,0, SmsLog::TYPE_OTHER, $advertApi);
    }

    /**
     * 支付成功后,清空秒杀活动会员相关的队列和缓存信息
     * @param $orders
     */
    public static function _delCache($orders)
    {
        $key = '';
        foreach ($orders as $order) {
            foreach ($order['orderGoods'] as $good) {
                if ($good['rules_setting_id'] > 0) {
                    SeckillRedis::delCacheDefault($order['member_id'],$good['goods_id']);
                    //还要清空已经秒杀到的信息表的订单号,避免脚本造成错误删除
                    Yii::app()->db->createCommand()->update('{{seckill_order_cache}}',
                        array('is_process' => SeckillRedis::IS_PROCESS_PAYED),
                        'user_id=:uid AND goods_id=:gid AND setting_id =:sid',array(':uid'=>$order['member_id'],':gid'=>$good['goods_id'],':sid'=>$good['rules_setting_id']));
                    $name = $order['member_id'] . '-' . $good['goods_id'];
                    Tool::cache(ActivityData::CACHE_ACTIVITY_ORDER)->delete($name);

                    // 删除其他缓存
                    SeckillRedis::delCacheByGoods($good['goods_id']);
                    ActivityData::delGoodsCache($good['goods_id']);//删除商品缓存
                    ActivityData::deleteActivityGoodsStock($good['goods_id']);//删除库存缓存
                }
            }
        }
    }

}
