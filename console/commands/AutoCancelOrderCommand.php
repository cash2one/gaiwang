<?php
/**
 * 盖象v.20版， 当订单超过24小时未支付时，自动取消订单的执行脚本
 * 更新的订单：自下单时起，超过24小时不支付的订单
 */

    class AutoCancelOrderCommand extends CConsoleCommand
    {
        /**
         * 自动执行方法(24小时)
         */
        public function actionCancelOrder()
        {
            //查找超过一天未支付的订单
            $sql = 'SELECT
                    t.id,
                    t.pay_status,
                    t.create_time,
                    t.pay_type,
                    t.`status`,
                    t.source_type,
                    other_price,
                    t.member_id,
                    g.quantity,
                    g.spec_id,
                    g.goods_id
                FROM
                    gw_order AS t
                LEFT JOIN gw_order_goods AS g ON g.order_id = t.id
                WHERE
                    unix_timestamp(now()) - t.create_time >= 86400
                AND t.pay_status = :pay_status
                AND t.`status` = :status
                AND t.source_type!=:stype';
            $command = Yii::app()->db->createCommand($sql)->bindValues(array(':pay_status'=>Order::PAY_STATUS_NO,':status'=>Order::STATUS_NEW, ':stype'=>Order::SOURCE_TYPE_AUCTION));
            $data    = $command->query();
            $i       = 0;
            $sql1    = '';

            //更新订单
            while (($order = $data->read()) !== false){
                $sql1 .= "UPDATE {{order}} SET status = ". Order::STATUS_CLOSE . " WHERE id={$order['id']};"; //更新订单状态
                //$sql1 .= "UPDATE {{goods}} SET stock=stock+{$order['quantity']} WHERE  id= {$order['goods_id']};"; //更新库存(有另外的脚本执行了)
                $sql1 .= "UPDATE {{goods_spec}} SET stock=stock+{$order['quantity']} WHERE  id={$order['spec_id']};"; //更新规格商品库存
                //订单如果是用户红包支付，回滚红包
                if($order['source_type'] == Order::SOURCE_TYPE_HB){
                    $sql1 .= "UPDATE {{member_account}} SET money = money + {$order['other_price']} WHERE member_id={$order['member_id']};";
                }
                $i++;
            }
            if(empty($sql1)) exit('order null');
            $trans = Yii::app()->db->beginTransaction();
            try{
                Yii::app()->db->createCommand($sql1)->execute();
                $trans->commit();
                echo $i.'datas haved been updated',"\r\n";
            } catch (CException $e) {
                $trans->rollback();
                exit('fail:'.$e->getMessage());
            }
        }

        /**
         * 拍卖活动关闭订单(72小时),每10分钟执行一次
         */
        public function actionCancelAuction()
        {
            $now = time();
            $time = $now - 259200;//测试为10分钟 正式环境为72小时 600 259200
            $sql  = "SELECT o.id,o.code,o.member_id,g.rules_setting_id,g.goods_id,g.quantity,g.spec_id FROM {{order}} o LEFT JOIN {{order_goods}} g ON o.id=g.order_id ";
            $sql .= "WHERE o.status=:status AND o.pay_status=:pstatus AND o.source_type=:stype AND o.create_time<:time";

            $params = array(
                ':status' => Order::STATUS_NEW,
                ':pstatus' => Order::PAY_STATUS_NO,
                ':stype' => Order::SOURCE_TYPE_AUCTION,
                ':time' => $time
                );
            $result = Yii::app()->db->createCommand($sql)->bindValues($params)->queryAll();

            if ( !empty($result) ){
                // 当月的流水表（旧）
                $monthTableHistory = AccountFlowHistory::monthTable();
                // 当月的流水表 (新)
                $monthTable = AccountFlow::monthTable();

                foreach ($result as $v){
                    $trans = Yii::app()->db->beginTransaction();

                    try{//关闭订单并扣除冻结积分给总帐户
                        $sqlClose  = "UPDATE {{order}} SET status = ". Order::STATUS_CLOSE . ",close_time='$now' WHERE id='$v[id]';"; //更新订单状态
                        $sqlClose .= "UPDATE {{goods}} SET stock=stock + $v[quantity] WHERE id='$v[goods_id]';"; //更新库存
                        $sqlClose .= "UPDATE {{goods_spec}} SET stock=stock +$v[quantity] WHERE id='$v[spec_id]';"; //更新规格商品库存

                        Yii::app()->db->createCommand($sqlClose)->execute();

                        //将冻结积分给公共帐户
                        $sql  = "SELECT * FROM {{seckill_auction_record}} WHERE rules_setting_id=:rsid AND goods_id=:gid AND member_id=:mid AND status=:status AND is_return=:return FOR UPDATE";
                        $bind = array(
                            ':rsid' => $v['rules_setting_id'],
                            ':gid' => $v['goods_id'],
                            ':mid' => $v['member_id'],
                            ':status' => SeckillAuctionRecord::STATUS_ONE,
                            ':return' => SeckillAuctionRecord::IS_RETURN_NO
                        );

                        $row = Yii::app()->db->createCommand($sql)->queryRow(true, $bind);
                        if ( !empty($row) ){//如果该帐还没扣除冻结积分,则在这里扣除
                            //公共帐户信息
                            //$totalAccount = CommonAccount::getOnlineAccountForHistory(); //公共账户
                            //$info         = AccountBalanceHistory::findRecord( array('account_id'=>$totalAccount['account_id'], 'type'=>AccountBalance::TYPE_COMMON, 'gai_number'=>$totalAccount['gai_number']) );

                            //扣冻结帐户中被冻结的积分给公共帐户(旧)
                            if ( $row['balance_history'] > 0 ){
                                $info = CommonAccount::getOnlineAccountForHistory(); //隐帐公共账户

                                //转账人冻结账户信息(旧)
                                $historyArray = array(
                                    'account_id' => $row['member_id'],
                                    'type' => AccountBalance::TYPE_FREEZE,
                                    'gai_number' => $row['member_gw']
                                );
                                $freezeInfo = AccountBalanceHistory::findRecord( $historyArray );

                                // 借方(会员冻结帐户)
                                $debit = array(
                                    'account_id' => $freezeInfo['account_id'],
                                    'gai_number' => $freezeInfo['gai_number'],
                                    'card_no' => $freezeInfo['card_no'],
                                    'order_id' => $row['flow_id'],
                                    'order_code' => $row['flow_code'],
                                    'type' => AccountFlow::TYPE_FREEZE,
                                    'debit_amount' => $row['balance_history'],
                                    'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_MONEY,
                                    'remark' => '拍卖商品中标未支付积分解冻，金额为：￥' . $row['balance_history'],
                                    'node' => AccountFlow::BUSINESS_NODE_AUCTION_BALANCE_TRANSFER,
                                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
                                );

                                // 贷方(公共帐户)
                                $credit = array(
                                    'account_id' => $info['account_id'],
                                    'gai_number' => $info['gai_number'],
                                    'card_no' => $info['card_no'],
                                    'order_id' => $row['flow_id'],
                                    'order_code' => $row['flow_code'],
                                    'type' => AccountFlow::TYPE_COMMON,
                                    'credit_amount' => $row['balance_history'],
                                    'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_MONEY,
                                    'remark' => '拍卖商品中标未支付积分转为利润，金额为：￥'.$row['balance_history'],
                                    'node' => AccountFlow::BUSINESS_NODE_AUCTION_BALANCE_TRANSFER_INTO,
                                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
                                );
                                //减转账人消费账户金额(旧)
                                if (!AccountBalanceHistory::calculate(array('today_amount'=>'-'.$row['balance_history']),$freezeInfo['id']))
                                    exit( Yii::t('PrepaidCardTransfer', '减冻结账户金额失败！') );
                                //加公共账户金额(旧)
                                if (!AccountBalanceHistory::calculate(array('today_amount'=>$row['balance_history']),$info['id']))
                                    exit( Yii::t('PrepaidCardTransfer', '加公共账户金额失败！') );

                                // 记录月流水表（旧）
                                Yii::app()->db->createCommand()->insert($monthTableHistory, AccountFlow::mergeField($debit));
                                Yii::app()->db->createCommand()->insert($monthTableHistory, AccountFlow::mergeField($credit));

                            }

                            //扣冻结帐户中被冻结的积分给总帐户(新)
                            if ( $row['balance'] > 0 ){
                                $info = CommonAccount::getEarningsAccount(); //明帐公共账户

                                //转账人冻结账户信息(新)
                                $balanceArray = array(
                                    'account_id' => $row['member_id'],
                                    'type' => AccountBalance::TYPE_FREEZE,
                                    'gai_number' => $row['member_gw']
                                );
                                $balanceInfo = AccountBalance::findRecord( $balanceArray );

                                // 借方(会员冻结帐户)
                                $debit = array(
                                    'account_id' => $balanceInfo['account_id'],
                                    'gai_number' => $balanceInfo['gai_number'],
                                    'card_no' => $balanceInfo['card_no'],
                                    'order_id' => $row['flow_id'],
                                    'order_code' => $row['flow_code'],
                                    'type' => AccountFlow::TYPE_FREEZE,
                                    'debit_amount' => '-'.$row['balance'],
                                    'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_MONEY,
                                    'remark' => '拍卖商品中标未支付积分解冻，金额为：￥' . $row['balance'],
                                    'node' => AccountFlow::BUSINESS_NODE_AUCTION_BALANCE_TRANSFER,
                                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
                                );

                                // 贷方(公共帐户)
                                $credit = array(
                                    'account_id' => $info['account_id'],
                                    'gai_number' => $info['gai_number'],
                                    'card_no' => $info['card_no'],
                                    'order_id' => $row['flow_id'],
                                    'order_code' => $row['flow_code'],
                                    'type' => AccountFlow::TYPE_COMMON,
                                    'credit_amount' => '+'.$row['balance'],
                                    'operate_type' => AccountFlow::OPERATE_TYPE_AUCTION_MONEY,
                                    'remark' => '拍卖商品中标未支付积分转为利润，金额为：￥'.$row['balance'],
                                    'node' => AccountFlow::BUSINESS_NODE_AUCTION_BALANCE_TRANSFER_INTO,
                                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_FREEZE,
                                );
                                //减转账人消费账户金额(新)
                                if (!AccountBalance::calculate(array('today_amount'=>'-'.$row['balance']),$balanceInfo['id']))
                                    exit( Yii::t('PrepaidCardTransfer', '减冻结账户金额失败！') );
                                //加公共账户金额(新)
                                if (!AccountBalance::calculate(array('today_amount'=>$row['balance']),$info['id']))
                                    exit( Yii::t('PrepaidCardTransfer', '加公共账户金额失败！') );

                                // 记录月流水表（旧）
                                Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($debit));
                                Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));
                            }

                            //更新seckill_auction_flow表的状态
                            $sqlRecord = "UPDATE {{seckill_auction_flow}} SET operate_type='".AccountFlow::OPERATE_TYPE_AUCTION_MONEY."' WHERE id='$row[flow_id]'";
                            Yii::app()->db->createCommand($sqlRecord)->execute();

                            //更新拍卖记录表
                            $sqlRecord = "UPDATE {{seckill_auction_record}} SET is_return='".SeckillAuctionRecord::IS_RETURN_YES."' WHERE id='$row[id]'";
                            Yii::app()->db->createCommand($sqlRecord)->execute();
                        }

                        $trans->commit();

                    } catch (CException $e) {
                        $trans->rollback();
                        exit('fail:'.$e->getMessage());
                    }
                }

            }
            exit('success');
        }

        /**
         * 拍卖活动结束,自动生成订单, 每5分钟执行一次
         */
        public function actionAuctionOrder()
        {
            //获取未生成订单的已结束的活动,非强制结束部分
            $now  = time();
            $sql  = "SELECT m.`date_end`,rs.`end_time`,rs.`is_force`,ap.`goods_id`,ap.`member_id`,ap.`price`,ap.`rules_setting_id`,ap.`reserve_price`,ap.auction_end_time FROM {{seckill_rules_main}} m ";
            $sql .= "LEFT JOIN {{seckill_rules_seting}} rs ON m.id=rs.`rules_id` ";
            $sql .= "LEFT JOIN {{seckill_auction_price}} ap ON rs.id=ap.`rules_setting_id` ";
            $sql .= "WHERE m.`category_id`='".SeckillRulesSeting::SECKILL_CATEGORY_FOUR."' AND rs.is_force=".SeckillRulesSeting::IS_FORCE_NO;
            $sql .= " AND ap.auction_end_time<=$now AND ap.`create_order`='".SeckillAuctionRecord::CREATE_ORDER_NO."' AND ap.`member_id`>0";

            $result = Yii::app()->db->createCommand($sql)->queryAll();
            if ( !empty($result) ){
                foreach ( $result as $v ){//生成拍卖订单

                    //最终拍卖价大于等于保留价,生成订单
                    if ( $v['reserve_price'] <= $v['price'] ) {
                        //获取会员收货地址
                        $address = Address::getDefault($v['member_id']);

                        //获取商品的商家信息
                        $sql = "SELECT
                            g.thumbnail,
                            g.`name`,
                            g.gai_income,
                            g.gai_price,
                            g.price,
                            g.freight_payment_type,
                            g.freight_template_id,
                            g.store_id,
                            g.fee,
                            g.ratio,
                            g.`size`,
                            g.weight,
                            g.category_id AS g_category_id,
                            g.gai_sell_price,
                            g.activity_tag_id,
                            g.join_activity,
                            g.activity_ratio,
                            g.jf_pay_ratio,
                            g.seckill_seting_id,
                            f.valuation_type,
                            s.`name` AS store_name,
                            et.signing_type,
                            m.type_id
                            FROM {{goods}} AS g
                            LEFT JOIN {{freight_template}} AS f ON g.freight_template_id = f.id
                            LEFT JOIN {{store}} AS s ON s.id = g.store_id
                            LEFT JOIN {{member}} AS m ON s.member_id = m.id
                            LEFT JOIN {{enterprise}} AS et ON m.enterprise_id = et.id
                            WHERE g.id=:id";
                        $store = Yii::app()->db->createCommand($sql)->bindValue(':id', $v['goods_id'])->queryRow();

                        //计算运费
                        $quantity = 1;
                        if ( $store['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE ){//不包邮
                            $fee = ComputeFreight::compute($store['freight_template_id'], $store['size'], $store['weight'], $address['city_id'], $store['valuation_type'], $quantity);
                            foreach ($fee as $ke => $ve) {
                                if($ke>1) unset($fee[$ke]);
                                $ve['fee'] = sprintf("%.2f", $ve['fee'] * 1);//Common::rateConvert($ve['fee']);
                            }
                        } else {//包邮
                            $fee = array(1=>array('name'=>'包邮', 'fee'=>0));
                        }
                        $feeArray = array_slice($fee, 0, 1);

                        //获取运输方式
                        $mode = 1;
                        if ( $store['freight_payment_type'] == Goods::FREIGHT_TYPE_MODE ){
                            $sqlMode = "SELECT `mode` FROM {{freight_type}} WHERE freight_template_id=:tid";
                            $mode = Yii::app()->db->createCommand($sqlMode)->bindValue(':tid', $store['freight_template_id'])->queryScalar();
                        }


                        $trans = Yii::app()->db->beginTransaction();
                        try{
                            //插入订单的数组
                            $code  = Tool::buildOrderNo();

                            //供货价要重新计算
                            $gaiPrice = self::_calGaiPrice(array('price'=>$v['price'], 'category_id'=>$store['g_category_id']));

                            //计算返还积分
                            //$score = Common::convertReturn($store['gai_price'], $store['price'], $store['gai_income'] / 100)*1;
                            $score = Common::convertReturn($gaiPrice, $v['price'], $store['gai_income'] / 100)*1;

                            $freight = $feeArray[0]['fee'];
                            $orderData = array(
                                'code' => $code,
                                'member_id' => $v['member_id'],
                                'consignee' => !empty($address) ? $address['real_name'] : '',
                                'address' => !empty($address) ? implode(' ', array($address['province_name'], $address['city_name'], $address['district_name'], $address['street'])) : '',
                                'mobile' => !empty($address) ? $address['mobile'] : '',
                                'zip_code' => !empty($address) ?  $address['zip_code'] : '',
                                'status' => Order::STATUS_NEW,
                                'delivery_status' => Order::DELIVERY_STATUS_NOT,
                                'pay_status' => Order::PAY_STATUS_NO,
                                'pay_price' => $v['price'] + $freight, //会员支付订单金额  加上运费
                                'real_price' => $v['price'] + $freight, //实际订单金额 加上运费
                                'original_price' => $v['price'] + $freight,//原始订单金额,加上运费的
                                'return' => $score,//返还积分
                                'create_time' => time(),
                                'auto_sign_date' => Tool::getConfig('site', 'automaticallySignTimeOrders'), //自动签收天数,
                                'delay_sign_count' => Tool::getConfig('site', 'extendMaximumNum'), //会员延迟签收次数,
                                'remark' => '',
                                'store_id' => $store['store_id'],
                                'freight' => $freight,//运费
                                'order_type' => Order::ORDER_TYPE_JF,
                                'distribution_ratio' => CJSON::encode(Order::getOldIssueRatio()),//分配比率
                                'service_type' => ($store['signing_type'] == Enterprise::SIGNING_TYPE_SERVICE_FEE) ? Enterprise::SIGNING_TYPE_SERVICE_FEE : Enterprise::SIGNING_TYPE_OLD,
                                'source' => Order::ORDER_SOURCE_WEB,//订单类型
                                'source_type' => Order::SOURCE_TYPE_AUCTION, //订单类型（6拍卖商品）
                                'extend' => '',
                                'other_price' => 0, //使用红包金额
                            );
                            Yii::app()->db->createCommand()->insert('{{order}}', $orderData);

                            //插入订单商品信息表
                            $orderId = Yii::app()->db->lastInsertID;
                            $ratio   = Yii::app()->db->createCommand("SELECT ratio FROM {{member_type}} WHERE id=$store[type_id]")->queryScalar();

                            //$gaiPrice = self::_calGaiPrice($store, $orderData);
                            $goodsData = array(
                                'goods_id' => $v['goods_id'],
                                'order_id' => $orderId,
                                'quantity' => $quantity,
                                'unit_score' => bcdiv($v['price'], $ratio, 2),//Common::convert($store['price']),
                                'total_score' => $score,
                                'gai_price' => $gaiPrice,//$store['gai_price'],//供货价
                                'unit_price' => $v['price'],
                                'original_price' => $v['price'],
                                'total_price' => $v['price']*1,
                                'gai_income' => $store['gai_income'],
                                'spec_value' => '',//规格值
                                'spec_id' => '',//所属规格
                                'freight' => $freight,
                                'freight_payment_type' => $store['freight_payment_type'],//运输方式
                                'mode' => $mode,
                                'goods_name' => $store['name'],
                                'goods_picture' => $store['thumbnail'],
                                'activity_ratio' => 0,
                                'ratio' => Category::getCategoryServiceFeeRate($store['g_category_id']),//商品对应分类的服务费率
                                'integral_ratio' => 0,//$store['jf_pay_ratio'],//积分支付比例
                                'special_topic_category' => '0',
                                'rules_setting_id'=> $v['rules_setting_id'] ? $v['rules_setting_id'] : 0,
                            );

                            Yii::app()->db->createCommand()->insert('{{order_goods}}', $goodsData);

                            //修改拍卖价格表状态,记录订单ID
                            $sqlUpdate = "UPDATE {{seckill_auction_price}} SET create_order='".SeckillAuctionRecord::CREATE_ORDER_YES."',order_code='$code'
                        WHERE rules_setting_id='$v[rules_setting_id]' AND goods_id='$v[goods_id]' AND member_id='$v[member_id]'";
                            Yii::app()->db->createCommand($sqlUpdate)->execute();

                            //修改商品的status,让商品下架
                            $sqlGoods = "UPDATE {{goods}} SET status=2 WHERE id='$v[goods_id]'";
                            Yii::app()->db->createCommand($sqlGoods)->execute();

                            $trans->commit();

                        } catch (CException $e) {
                            $trans->rollback();
                            exit('fail:'.$e->getMessage());
                        }

                    } else {//最终拍卖价小于保留价,不生成订单,直接退还积分

                        $rows = Yii::app()->db->createCommand()
                            ->select('id,member_id,member_gw,balance_history,balance,flow_id,flow_code')
                            ->from('{{seckill_auction_record}}')
                            ->where('rules_setting_id=:rsid AND goods_id=:gid AND is_return=:return',
                                array(':rsid'=>$v['rules_setting_id'], ':gid'=>$v['goods_id'], ':return'=>SeckillAuctionRecord::IS_RETURN_NO))
                            ->queryAll();

                        if ( !empty($rows) ){
                            $flowTableName = AccountFlow::monthTable(); //流水按月分表日志表名
                            $flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志历史表名

                            foreach ( $rows as $v2 ){

                                //事务开始
                                $trans = Yii::app()->db->beginTransaction(); // 事务执行
                                try {
                                    if ( $v2['balance_history'] > 0 ){//返还历史表积分
                                        //组合数组
                                        $array = array('account_id' => $v2['member_id'], 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $v2['member_gw'], 'money'=>$v2['balance_history'],'flow_id'=>$v2['flow_id'],'flow_code'=>$v2['flow_code']);

                                        SeckillAuctionRecord::returnBalanceHistory($array, $flowHistoryTableName);
                                    }

                                    if ( $v2['balance'] > 0 ){//返还新表积分
                                        //组合数组
                                        $array = array('account_id' => $v2['member_id'], 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $v2['member_gw'], 'money'=>$v2['balance'],'flow_id'=>$v2['flow_id'],'flow_code'=>$v2['flow_code']);

                                        SeckillAuctionRecord::returnBalance($array, $flowTableName);
                                    }

                                    //更新seckill_auction_flow表的状态
                                    $sqlRecord = "UPDATE {{seckill_auction_flow}} SET operate_type=:type WHERE id=:id";
                                    Yii::app()->db->createCommand($sqlRecord)->execute(array(':type'=>AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE, ':id'=>$v2['flow_id']));

                                    //更新返还状态
                                    $sql = "UPDATE {{seckill_auction_record}} SET is_return=:return WHERE id=:id";
                                    Yii::app()->db->createCommand($sql)->execute(array(':return'=>SeckillAuctionRecord::IS_RETURN_YES, ':id'=>$v2['id']));

                                    //由于强制结束不生成订单,所以修改seckill_auction_price表,设为已生成订单状态
                                    $sql = "UPDATE {{seckill_auction_price}} SET create_order=1 WHERE rules_setting_id=:rsid AND goods_id=:gid";
                                    Yii::app()->db->createCommand($sql)->execute(array(':rsid'=>$v['rules_setting_id'], ':gid'=>$v['goods_id']));

                                    $trans->commit();//事务结束
                                }catch (Exception $e){//抛出异常处理
                                    $trans->rollback();

                                    exit('fail:'.$e->getMessage());
                                }
                            }
                        }
                    }


                }

            }

            //获取未生成订单的已结束的活动,强制结束部分
            $rows  = array();
            $sql   = "SELECT m.`date_end`,rs.`end_time`,ap.`goods_id`,ap.`member_id`,ap.`price`,ap.`rules_setting_id`,rs.`is_force` FROM {{seckill_rules_main}} m ";
            $sql  .= "LEFT JOIN {{seckill_rules_seting}} rs ON m.id=rs.`rules_id` ";
            $sql  .= "LEFT JOIN {{seckill_auction_price}} ap ON rs.id=ap.`rules_setting_id` ";
            $sql  .= "WHERE m.`category_id`='".SeckillRulesSeting::SECKILL_CATEGORY_FOUR."' AND rs.is_force=".SeckillRulesSeting::IS_FORCE_YES;
            $sql  .= " AND ap.`create_order`='".SeckillAuctionRecord::CREATE_ORDER_NO."' AND ap.`member_id`>0";

            $result = Yii::app()->db->createCommand($sql)->queryAll();
            if ( !empty($result) ) {
                foreach ($result as $v) {//返还积分
                    $rows = Yii::app()->db->createCommand()
                        ->select('id,member_id,member_gw,balance_history,balance,flow_id,flow_code')
                        ->from('{{seckill_auction_record}}')
                        ->where('rules_setting_id=:rsid AND goods_id=:gid AND is_return=:return',
                            array(':rsid'=>$v['rules_setting_id'], ':gid'=>$v['goods_id'], ':return'=>SeckillAuctionRecord::IS_RETURN_NO))
                        ->queryAll();

                    if ( !empty($rows) ){
                        $flowTableName = AccountFlow::monthTable(); //流水按月分表日志表名
                        $flowHistoryTableName = AccountFlowHistory::monthTable(); //流水日志历史表名

                        foreach ( $rows as $v2 ){

                            //事务开始
                            $trans = Yii::app()->db->beginTransaction(); // 事务执行
                            try {
                                if ( $v2['balance_history'] > 0 ){//返还历史表积分
                                    //组合数组
                                    $array = array('account_id' => $v2['member_id'], 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $v2['member_gw'], 'money'=>$v2['balance_history'],'flow_id'=>$v2['flow_id'],'flow_code'=>$v2['flow_code']);

                                    SeckillAuctionRecord::returnBalanceHistory($array, $flowHistoryTableName);
                                }

                                if ( $v2['balance'] > 0 ){//返还新表积分
                                    //组合数组
                                    $array = array('account_id' => $v2['member_id'], 'type' => AccountBalance::TYPE_FREEZE, 'gai_number' => $v2['member_gw'], 'money'=>$v2['balance'],'flow_id'=>$v2['flow_id'],'flow_code'=>$v2['flow_code']);

                                    SeckillAuctionRecord::returnBalance($array, $flowTableName);
                                }

                                //更新seckill_auction_flow表的状态
                                $sqlRecord = "UPDATE {{seckill_auction_flow}} SET operate_type=:type WHERE id=:id";
                                Yii::app()->db->createCommand($sqlRecord)->execute(array(':type'=>AccountFlow::OPERATE_TYPE_AUCTION_UNFREEZE, ':id'=>$v2['flow_id']));

                                //更新返还状态
                                $sql = "UPDATE {{seckill_auction_record}} SET is_return=:return WHERE id=:id";
                                Yii::app()->db->createCommand($sql)->execute(array(':return'=>SeckillAuctionRecord::IS_RETURN_YES, ':id'=>$v2['id']));

                                //由于强制结束不生成订单,所以修改seckill_auction_price表,设为已生成订单状态
                                $sql = "UPDATE {{seckill_auction_price}} SET create_order=1 WHERE rules_setting_id=:rsid AND goods_id=:gid";
                                Yii::app()->db->createCommand($sql)->execute(array(':rsid'=>$v['rules_setting_id'], ':gid'=>$v['goods_id']));

                                $trans->commit();//事务结束
                            }catch (Exception $e){//抛出异常处理
                                $trans->rollback();

                                exit('fail:'.$e->getMessage());
                            }
                        }
                    }
                }

            }

            exit('success');
        }

        private function _calGaiPrice(array $good)
        {
            /**
             * 因为红包计算供货价要用商家售价,所以兼容不同订单.使用original_price
             * 在普通订单中,price, original_price是一样的
             * 在红包订单中.price保存的盖网提供的售价,original_price保存的商家提供的售价
             */
            $unitPrice = $good['price'];
            //服务费率
            $fee = Category::getCategoryServiceFeeRate($good['category_id']);
            $fee = bcdiv($fee, 100, 2);
            //计算供货价 = 商家售价 - (商家售价*服务费率)
            $gai_price = bcsub($unitPrice, bcmul($unitPrice, $fee, 2), 2);
            return $gai_price * 1;
        }
    }
?>
