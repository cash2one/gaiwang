<?php

/**
 * 导入充值脚本
 * @author zc
 */
class ImportRechangeCommand extends CConsoleCommand {

    public function actionRechange(){
        //查询出记录表里未充值的和充值卡里未使用的数据
        $result = Yii::app()->db->createCommand()
                    ->select('im.id as recordId,im.gai_number,im.mobile,im.card_number,im.member_id,im.send_sms,im.free_sms,pr.id,pr.number,pr.value,pr.type')
                    ->from('{{import_recharge_record}} as im')
                    ->leftJoin('{{prepaid_card}} as pr', 'im.card_number = pr.number')
                    ->where('im.record_status=:status',array(':status'=> ImportRechargeRecord::RECORD_STATUS_NO))
                    ->andWhere('pr.status=:pstatus',array(':pstatus'=> PrepaidCard::STATUS_UNUSED))
                    ->queryAll();

        //会员类型
        $memberType = MemberType::fileCache();
        if ($memberType === null) {
            throw new Exception('memberType error');
        }
        $sendsArr = array();//存储短信数据
        foreach ($result as $v) {

            $transaction = Yii::app()->db->beginTransaction();
            try{

                Yii::app()->db->createCommand()->select('record_status')->from('{{import_recharge_record}}')->where('id = ' . $v['recordId'] . ' FOR UPDATE')->queryRow();

                $member = Yii::app()->db->createCommand()->select('id,gai_number,mobile,type_id')->from('{{member}}')->where('id=:memberId',array(':memberId'=>$v['member_id']))->queryRow();

                $flag = PrepaidCardUse::recharge($v, $member, $memberType, true, false, null, true, true);

                if($flag == false){
                    throw new Exception('Recharge error');
                } else {
                    //更新充值导入记录
                    Yii::app()->db->createCommand()->update('{{import_recharge_record}}', array('status' => 1, 'detail' => '充值成功', 'record_status' => ImportRechargeRecord::RECORD_STATUS_YES), 'id=:id', array(':id' => $v['recordId']));
                    $sendsArr[] = array(
                    		'card_info' => $v,
                    		'member' => $member,
                    		'memberType' => $memberType,
                    		'flag' => $flag,
                            'totalMoney' => $this->getTotalPrice(AccountInfo::TYPE_CONSUME, $member['id'], $member['gai_number']),
                    );
                }
                $transaction->commit();

            }catch (Exception $e) {
                $transaction->rollback();
                echo 'fail:'.$e->getMessage(),"\n\r";
            }

        }

        //发送短信
        foreach ($sendsArr as $arr) {
            if ($arr['member']['mobile'] && $arr['card_info']['send_sms'] == ImportRechargeRecord::SEND_SMS_YES && $arr['flag'] == true) {
                $temp = Tool::getConfig('smsmodel', 'usePrepaidcarSucceed');
                //尊敬的{0}用户，您于{1}使用了充值卡{2}充值成功，获得了{3}盖网积分。目前您消费积分余额为{4}，请您核实 {5}。
                $msg = strtr($temp, array(
                    '{0}' => $arr['member']['gai_number'],
                    '{1}' => date('Y/m/d H:i:s', time()),
                    '{2}' => $arr['card_info']['number'],
                    '{3}' => $arr['card_info']['value'],
                    '{4}' => Common::convertSingle($arr['totalMoney'], 2),
                    '{5}' => $arr['card_info']['free_sms']
                ));
                $datas = array($arr['member']['gai_number'], date('Y/m/d H:i:s', time()), $arr['card_info']['number'], $arr['card_info']['value'], Common::convertSingle($arr['totalMoney'], 2), $arr['card_info']['free_sms']);
                $tmpId = Tool::getConfig('smsmodel', 'usePrepaidcarSucceedId');
                SmsLog::addSmsLog($arr['member']['mobile'], $msg, $arr['card_info']['id'], SmsLog::TYPE_CARD_RECHARGE,null, $datas, $tmpId); // 记录并短息日志
            }
        }

    }

    /**
     * 余额表总金额计算（当前余额及历史余额相加）
     * @param int $type 账户类型
     * @param int $memberId 会员ID
     * @param string $gaiNumber GW号
     * @return string
     */
    private function getTotalPrice($type, $memberId, $gaiNumber) {
        $currentPrice = $this->getCurrentPrice($type, $memberId, $gaiNumber);
        $historyPrice = $this->getHistoryPrice($type, $memberId, $gaiNumber);
        return sprintf('%0.2f', $currentPrice * 1 + $historyPrice * 1, 2);
    }

    /**
     * 获取历史余额
     * @param int $type 账户类型
     * @param int $memberId 会员ID
     * @param string $gaiNumber GW号
     * @return float
     */
    private function getHistoryPrice($type, $memberId, $gaiNumber) {
        $condition = '`account_id`=' . $memberId . ' AND `gai_number`="' . $gaiNumber . '" AND `type`=' . $type;
        $historyPrice = Yii::app()->db->createCommand()->select('today_amount')->from(ACCOUNT . '.' . '{{account_balance_history}}')->where($condition)->queryScalar();
        if (empty($historyPrice)) {
            return 0;
        }
        return $historyPrice * 1;
    }

    /**
     * 获取当前余额
     * @param int $type 账户类型
     * @param int $memberId 会员ID
     * @param string $gaiNumber GW号
     * @return float
     */
    private function getCurrentPrice($type, $memberId, $gaiNumber) {
        $condition = '`account_id`=' . $memberId . ' AND `gai_number`="' . $gaiNumber . '" AND `type`=' . $type;
        $currentPrice = Yii::app()->db->createCommand()->select('today_amount')->from(ACCOUNT . '.' . '{{account_balance}}')->where($condition)->queryScalar();
        return $currentPrice * 1;
    }

    /**
     * 将指定批号的充值卡进行回滚处理
     * php yiic.php importRechange returnRechange
     */
    public function actionReturnRechange()
    {
		$batchNo = 496;
		$batchNo = 8888;
		$data = Yii::app()->db->createCommand()->select('id,card_number')->from('{{import_recharge_record}}')->where('batch_number = '.$batchNo)
		->andWhere('record_status='.ImportRechargeRecord::RECORD_STATUS_YES)
		->andWhere('status='.ImportRechargeRecord::STATUS_PASS)
		->queryAll();
		$i = 1;
		foreach ($data as $row)
		{
			$rs = PrepaidCardUse::returnRecharge($row['card_number']);
			if($rs['rs'] === true)
			{
				Yii::app()->db->createCommand()->update('{{import_recharge_record}}', array(
						'status' => ImportRechargeRecord::STATUS_OTHER,
						'detail' => '充值回滚('.date('Y/m/d H:i:s', time()).')'.'回滚金额:'.$rs['money']
				), 'id='.$row['id']);
				echo $i.'success'."\n\r";
			}
			else
			{
				echo $i.$rs['msg']."\n\r";
			}
			$i++;
		}
    }

	/**
	 * 如需要补发短信，可执行该命令
	 * php yiic.php importRechange returnRechangeSms
	 */
    public function actionReturnRechangeSms()
    {
    	$batchNo = 496;
    	$data = Yii::app()->db->createCommand()->select('card_number')->from('{{import_recharge_record}}')->where('batch_number = '.$batchNo)
    	->andWhere('record_status='.ImportRechargeRecord::RECORD_STATUS_YES)
    	->queryAll();
    	$smsData = array();
    	foreach ($data as $row)
    	{
    		$smsData[] = PrepaidCardUse::returnRechargeSms($row['card_number']);
    	}

    	//正式发短信
    	$i = 1;
		foreach ($smsData as $sms)
		{
			SmsLog::addSmsLog($sms['mobile'], $sms['content'], $sms['target'], $sms['type'],$sms['apiType'],$sms['is_push'], $sms['datas'], $sms['tmpId']);
			echo $i.'success'."\n\r";
			$i++;

		}
    }

}

