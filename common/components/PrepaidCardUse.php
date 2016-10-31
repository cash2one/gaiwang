<?php

/**
 * 充值卡充值类
 * @author wanyun.liu <wanyun_liu@163.com>
 *
 * 事务处理作了调整  导入充值需要去掉事务  @2014/11/21  by csj
 *
 */
class PrepaidCardUse {

    /**
     * @param $prepaidCard
     * @param $member
     * @param $memberType
     * @param bool $doTransaction 是否执行事务
     * @param $recharger   充值者
     * @param $forImportRecharge 是否用于导入充值
     * @return bool
     */
    public static function recharge($prepaidCard, $member, $memberType, $doTransaction = true, $sendSms = true, $recharger = null, $forImportRecharge = false, $console = false, $sms = '') {

        // 当前客户端IP
        $clientIp = Tool::ip2int(Yii::app()->request->userHostAddress);
        // 当月的流水表（旧）
        $monthTable = AccountFlowHistory::monthTable();
        // 充值卡金额
        $money = 0;
        // 积分返还卡使用，用会员的类型，算出此积分卡转换成金额，是多少
        if ($prepaidCard['type'] == PrepaidCard::TYPE_GENERAL) {
            $money = sprintf("%.2f", $prepaidCard['value'] * $memberType[$member['type_id']]);
        }
        // 充值卡使用，会员升级为正式会员
        if ($prepaidCard['type'] == PrepaidCard::TYPE_SPECIAL) {
            $money = sprintf("%.2f", $prepaidCard['value'] * $memberType['official']);
            $member['type_id'] = $memberType['officialType'];
        }
        // 会员账户金额更新
        $memberData = array(
            'type_id' => $memberType['officialType']
        );
        // 充值卡信息更新
        $prepaidCardData = array(
            'status' => PrepaidCard::STATUS_USED,
            'use_time' => time(),
            'member_id' => $member['id'],
        );
        if ($doTransaction) {
            // 事务（会员积分入账，充值卡信息变更）
            if ($forImportRecharge !== true)
                $transaction = Yii::app()->db->beginTransaction();
            try {
                // 锁住当前充值卡
                $card = Yii::app()->db->createCommand()->select('status')->from('{{prepaid_card}}')->where('id = ' . $prepaidCard['id'] . ' FOR UPDATE')->queryRow();
                if ($card['status'] == PrepaidCard::STATUS_USED)
                    throw new Exception('充值卡异常', '0');
                // 会员余额表记录创建（旧）
                $memberBalance = AccountBalanceHistory::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
                // 更新充值卡状态
                Yii::app()->db->createCommand()->update('{{prepaid_card}}', $prepaidCardData, 'id=:id', array(':id' => $prepaidCard['id']));

                // 贷方
                $credit = array(
                    'account_id' => $member['id'],
                    'gai_number' => $memberBalance['gai_number'],
                    'card_no' => $memberBalance['card_no'],
                    'type' => AccountFlow::TYPE_CONSUME,
                    'credit_amount' => $money,
                    'operate_type' => AccountFlow::OPERATE_TYPE_CARD_RECHARGE,
                    'prepaid_card_no' => $prepaidCard['number'],
                    'remark' => '使用积分充值卡充值，金额为：￥' . $money,
                    'node' => AccountFlow::BUSINESS_NODE_CARD_RECHARGE,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RECHARGE,
                    'recharge_type' => AccountFlow::RECHARGE_TYPE_CARD
                );
                $credit['by_gai_number'] = isset($recharger['gai_number']) ? $recharger['gai_number'] : ' ';

                // 会员余额更新（旧）
                AccountBalanceHistory::calculate(array('today_amount' => $money), $memberBalance['id']);
                // 更新会员类型
                Yii::app()->db->createCommand()->update('{{member}}', $memberData, 'id=:id', array(':id' => $member['id']));
                // 记录月流水表（旧）
                Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));

                if ($forImportRecharge !== true)
                    $transaction->commit();
                $flag = true;
            } catch (Exception $e) {
                if ($forImportRecharge !== true)
                    $transaction->rollBack();
                $flag = false;
            }

            // 如果普通会员使用充值卡，变更session中的typeId
            if (true === $flag && $prepaidCard['type'] == PrepaidCard::TYPE_SPECIAL) {
                if($console == false)
                    Yii::app()->user->setState('typeId', $memberType['officialType']);
            }

            // 发送短信
            if (true === $flag && $member['mobile'] && true === $sendSms) {
                $totalMoney = Member::getTotalPrice(AccountInfo::TYPE_CONSUME, $member['id'], $member['gai_number']);
                $temp = Tool::getConfig('smsmodel', 'usePrepaidcarSucceed');
                $msg = strtr($temp, array(
                    '{0}' => $member['gai_number'],
                    '{1}' => date('Y/m/d H:i:s', time()),
                    '{2}' => $prepaidCard['number'],
                    '{3}' => $prepaidCard['value'],
                    '{4}' => Common::convertSingle($totalMoney, $member['type_id']),
                    '{5}' => $sms
                ));
                $datas = array($member['gai_number'],date('Y/m/d H:i:s', time()),$prepaidCard['number'],$prepaidCard['value'],Common::convertSingle($totalMoney, $member['type_id']));
                $tmpId = Tool::getConfig('smsmodel', 'usePrepaidcarSucceedId');
                SmsLog::addSmsLog($member['mobile'], $msg, $prepaidCard['id'], SmsLog::TYPE_CARD_RECHARGE,null,true, $datas, $tmpId); // 记录并短息日志
            }
            return $flag;
        } else {
            die; //旧导入会员用，暂时不提供
        }
    }

    /**
     * 批发充值发送短信
     * @param $prepaidCard 充值卡信息
     * @param $mobile 手机号码
     * @param $sendSms 是否发送短信
     */
    public static function createPrepaidCard($prepaidCard,$mobile,$applyTime,$sendSms = true) {
        if($mobile && true === $sendSms) {
            $temp = Tool::getConfig('smsmodel', 'createPrepaidcar');
            $msg = strtr($temp, array(
                '{0}' => $mobile,
                '{1}' => $prepaidCard['number'],
                '{2}' => Tool::authcode($prepaidCard['password'],'DECODE'),
                '{3}' => $prepaidCard['value'],
                '{4}' => date('Y-m-d', $applyTime),
            ));
            $datas = array($mobile,$prepaidCard['number'],Tool::authcode($prepaidCard['password'],'DECODE'), $prepaidCard['value'],date('Y-m-d', $prepaidCard['create_time']),);
            $tmpId = Tool::getConfig('smsmodel', 'createPrepaidcarId');
            SmsLog::addSmsLog($mobile, $msg, $prepaidCard['id'], SmsLog::TYPE_CARD_RECHARGE,null,true, $datas, $tmpId); // 记录并短息日志
        } else {
            die;
        }
    }

    /**
     * 充值卡充值成功后进行回滚
     * @param unknown $card_number  充值卡号
     * @param bool $doTransaction 是否开启事务
     * @author LC
     */
    public static function returnRecharge($card_number)
    {
    	// 当月的流水表（旧）
    	$monthTable = AccountFlowHistory::monthTable();
    	$transaction = Yii::app()->db->beginTransaction();
    	try{
    		$card = Yii::app()->db->createCommand()->select('*')->from('{{prepaid_card}}')
    		->where("number = '" . $card_number . "' FOR UPDATE")->queryRow();
			if($card['status'] == PrepaidCard::STATUS_USED)
			{
				$member = Yii::app()->db->createCommand()->select('id,gai_number,mobile,type_id')->from('{{member}}')
				->where('id=:memberId',array(':memberId'=>$card['member_id']))->queryRow();
				$memberBalance = AccountBalanceHistory::findRecord(array('account_id' => $member['id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $member['gai_number']));
				$money = -$card['money'];
				if($memberBalance['today_amount'] <0){
					throw new Exception("账户余额不能为负数");
				}
				if(bcadd($memberBalance['today_amount'],$money,2)<0)
				{
					$money = -$memberBalance['today_amount'];
				}
				// 贷方
				$credit = array(
						'account_id' => $member['id'],
						'gai_number' => $memberBalance['gai_number'],
						'card_no' => $memberBalance['card_no'],
						'type' => AccountFlow::TYPE_CONSUME,
						'credit_amount' => $money,
						'operate_type' => AccountFlow::OPERATE_TYPE_CARD_RECHARGE,
						'prepaid_card_no' => $card['number'],
						'remark' => '使用积分充值卡充值，金额为：￥' . $money,
						'node' => AccountFlow::BUSINESS_NODE_CARD_RECHARGE,
						'transaction_type' => AccountFlow::TRANSACTION_TYPE_RECHARGE,
						'recharge_type' => AccountFlow::RECHARGE_TYPE_CARD
				);

				// 会员余额更新（旧）
				AccountBalanceHistory::calculate(array('today_amount' => $money), $memberBalance['id']);
				// 记录月流水表（旧）
				Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($credit));

				$transaction->commit();

				return array(
						'rs' => true,
						'money'=>$money,
				);
			}
			else
			{
				throw new Exception('充值卡未使用，不能回滚');
			}

    	}catch (Exception $e) {
    		$transaction->rollback();
    		return array(
    				'rs' => false,
    				'msg'=>'fail:'.$e->getMessage()
    		);
    	}

    }

    /**
     * 补发某个充值卡回滚的短信，返回要发的短信内容
     * @param unknown $card_number 充值卡号
     * @author LC
     */
    public static function returnRechargeSms($card_number)
    {
    	$card = Yii::app()->db->createCommand()->select('*')->from('{{prepaid_card}}')
    	->where("number = '" . $card_number . "' FOR UPDATE")->queryRow();
    	$member = Yii::app()->db->createCommand()->select('id,gai_number,mobile,type_id')->from('{{member}}')
    	->where('id=:memberId',array(':memberId'=>$card['member_id']))->queryRow();

    	$totalMoney = Member::getTotalPrice(AccountInfo::TYPE_CONSUME, $member['id'], $member['gai_number']);
    	$temp = Tool::getConfig('smsmodel', 'recoveryPrepaidcar');
    	$msg = strtr($temp, array(
    			'{0}' => $member['gai_number'],
    			'{1}' => date('Y/m/d H:i:s', $card['use_time']),
    			'{2}' => $card['number'],
    			'{3}' => $card['value'],
    			'{4}' => Common::convertSingle($totalMoney, $member['type_id'])
    	));
    	$datas = array($member['gai_number'],date('Y/m/d H:i:s', $card['use_time']),$card['number'],$card['value'],Common::convertSingle($totalMoney, $member['type_id']));
    	$tmpId = Tool::getConfig('smsmodel', 'recoveryPrepaidcarId');
    	return array(
    			'mobile' => $member['mobile'],
    			'content' => $msg,
    			'target'=> $card['id'],
    			'type'=>SmsLog::TYPE_CARD_RECHARGE,
    			'apiType'=> null,
    			'is_push'=> false,
    			'datas' => $datas,
    			'tmpId'=>$tmpId
    	);
    }
}
