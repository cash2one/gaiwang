<?php

class OnlineComment {

    /**
     * 评论 (账户操作,流水.余额)
     * @param array $order 订单信息
     * @param array $member 会员信息
     * @param array $return 待返还
     * @param array $storeRate 商家评论
     * @param array $goodsRate 商品评论
     * @return boolean
     * @throws Exception
     */
    public static function operate($order, $member = null, $return, $storeRate = array(), $goodsRate = array()) {

//        Tool::pr($storeRate);
        // 当前客户端IP
        $clientIp = Tool::ip2int(Yii::app()->request->userHostAddress);
        // 当月的流水表
        $monthTable = AccountFlow::monthTable();
        // 待返还金额
        $money = $return['memberIncome'];
        $msg = array();

        if (empty($member)) {
            $member = Yii::app()->db->createCommand()
            ->select()
            ->from('{{member}}')
            ->where('id=:id', array(':id' => $order['member_id']))
            ->queryRow();
        }

        //事务执行
        $trans = Yii::app()->db->beginTransaction();
        try {
            //再次订单状态,并加行锁
            $sql = "select code,id,is_comment from {{order}} where id = {$order['id']} limit 1 for update";
            $data = Yii::app()->db->createCommand($sql)->queryRow();
            if ($data['is_comment'] == Order::IS_COMMENT_YES)
                throw new Exception($order['code'] . '订单已经评论过,请不要重复评论');
            //更新订单状态
            Yii::app()->db->createCommand()->update('{{order}}', array('is_comment' => Order::IS_COMMENT_YES, 'comment_time' => time()), 'id=:orderId', array(':orderId' => $order['id']));
            // 余额表消费账户
            $memberBalance = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
            // 余额表待返还账户
            $returnBalance = AccountBalance::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_RETURN, 'gai_number' => $member['gai_number']));
            //返还金额大于0，账户够扣的时候才写流水
            if ($money > 0 && ($returnBalance['today_amount'] >= $money)) {
            	// 消费余额更新
            	// 贷方,解冻转入--@author LC将流水调整到条件以后2015-05-13
            	$credit = AccountFlow::mergeFlowData($order, $memberBalance, array(
            			'credit_amount' => $money,
            			'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_COMMENT,
            			'remark' => '线上订单评论，转入金额：￥' . $money,
            			'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_COMMENT_UNFREEZE,
            			'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
            	));
                if (!AccountBalance::calculate(array('today_amount' => $money), $memberBalance['id'])) {
                    throw new Exception('c202');
                }
                
                // 借方,积分解冻--@author LC将流水调整到条件以后2015-05-13
                $debit = AccountFlow::mergeFlowData($order, $returnBalance, array(
                		'debit_amount' => $money,
                		'operate_type' => AccountFlow::OPERATE_TYPE_ONLINE_ORDER_COMMENT,
                		'remark' => '线上订单评论，转出金额：￥' . $money,
                		'node' => AccountFlow::BUSINESS_NODE_ONLINE_ORDER_COMMENT_RETURN,
                		'transaction_type' => AccountFlow::TRANSACTION_TYPE_CONSUME,
                ));
                if (!AccountBalance::calculate(array('today_amount' => -$money), $returnBalance['id'] . ' AND today_amount >=' . $money)) {
                	throw new Exception('c203');
                }
                
                // 记录月流水表
                Yii::app()->db->createCommand()->insert($monthTable, $credit);
                Yii::app()->db->createCommand()->insert($monthTable, $debit);
            }
            
            //商品评论
            if (isset($goodsRate)) {
                foreach ($goodsRate as $v) {
                    $v->save();
                    Goods::model()->updateCounters(array('comments' => 1, 'total_score' => $v['score']), 'id = :id', array(':id' => $v['goods_id']));
                }
            }

            //商家评论
            if (isset($storeRate)) {
                $storeRate->save();
                //Store::model()->updateCounters(array('comments' => 1, 'description_match' => $storeRate['description_match'], 'serivice_attitude' => $storeRate['serivice_attitude'], 'speed_of_delivery' => $storeRate['speed_of_delivery']), 'id = :id', array(':id' => $storeRate['store_id']));
            }

            // 检测流水表借贷平衡
            if (!DebitCredit::checkFlowByCode($monthTable, $order['code'])) {
                throw new Exception('流水借贷不平衡');
            }
            $trans->commit();
            $msg['info'] = '评论完成';
            $msg['flag'] = $flag = true;
        } catch (Exception $e) {
            $trans->rollback();
            $msg['info'] = $order['code'] . '评论失败' . $e->getMessage();
            $msg['flag'] = $flag = false;
        }
        if ($flag) {
            self::sendSms($memberBalance, $money, $member, $order);
        }
        return $msg;
    }

    /**
     *
     * @param array $memberBalance 会员余额
     * @param float $money 返还金额
     * @param array $member 会员信息
     * @param array $order 订单信息
     */
    public static function sendSms($memberBalance, $money, $member, $order) {
        //尊敬的{0}用户，感谢您成功评价了订单{1}，解冻{2}返还积分为消费积分。当前您消费积分余额为{3}消费积分，请您核实。
        $historyMoney = Member::getHistoryPrice(AccountInfo::TYPE_CONSUME); //历史余额
        $allAccountMoney = $memberBalance['today_amount'] + $money + $historyMoney; //总余额
        $totalMoney = Common::convertSingle($allAccountMoney, $member['type_id']);
        $score = Common::convertSingle($money, $member['type_id']);
        $smsTemplate = Tool::getConfig('smsmodel', 'commentOrder');
        $smsContent = strtr($smsTemplate, array(
            '{0}' => $member['gai_number'],
            '{1}' => $order['code'],
            '{2}' => $score,
            '{3}' => $totalMoney,
        ));
        $datas = array($member['gai_number'],$order['code'],$score,$totalMoney);
        if (is_numeric($member['mobile'])) {
            $tmpId = Tool::getConfig('smsmodel','commentOrderId');
            SmsLog::addSmsLog($member['mobile'], $smsContent,$order['id'], SmsLog::TYPE_ONLINE_ORDER,null,true, $datas , $tmpId);
        }
    }

}
