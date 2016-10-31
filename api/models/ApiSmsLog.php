<?php

class ApiSmsLog extends ApiModel {

    public $tableName = '{{sms_log}}';
    public $primaryKey = 'id';
    public $smsModels = array();

    public function __construct() {
        if (empty($this->smsModels)) {
            $this->smsModels = Tool::getConfig($name = 'smsmodel');
        }
//        $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'smsmodel.config.inc';
//        $smsModel = file_get_contents($file);
//        if (empty($this->smsModels) && $smsModel !== false) {
//           $this->smsModels  = unserialize(base64_decode($smsModel));
//        }
    }

    /**
     * 
     * 【订单号：{0}】尊敬的盖网会员{1}，您于{2}，在盖网通【{3}】处购买加盟商【{4}】的产品：【{5}】，数量：{6}，支已付￥{7}，请您核实。消费时请出示您的消费验证码：{8}。消费地址：【{9}】。请于{10}之前进行消费。
     * @param type $franchisee
     */
    public function sendSmsMachineOrderConsume($member, $franchisee, $orderCode, $orderDetialId, $machineName, $goods, $quantity, $money, $userPhone, $consumeCode, $symbol, $smsType = 0) {
        if (isset($this->smsModels['machineOrderConsume']) && !empty($this->smsModels['machineOrderConsume'])) {
            $smsContent = $this->smsModels['machineOrderConsume'];
            if ($symbol == 'HKD')
                $smsContent = str_replace("￥", "HK$", $smsContent);
            // 加盟商地址
            $region = new ApiRegion();
            $cityName = $region->findByPk($franchisee['city_id'], array('name'));
            $districtName = $region->findByPk($franchisee['district_id'], array('name'));
            $address = $cityName['name'] . '  ' . $districtName['name'] . $franchisee['street'];
            // 短信内容
            $smsContent = str_replace(array('{0}', '{1}', '{2}', '{3}', '{4}', '{5}', '{6}', '{7}', '{8}', '{9}', '{10}'), array($orderCode, $member['gai_number'], date('Y年m月d日 H:i:s'), $machineName, $franchisee['franchisee_name'],
                $goods['name'], $quantity, $money, $consumeCode, $address, $goods['activity_end_time']), $smsContent);
            $send_status = SmsLog::STATUS_FAILD;
            //需要发送的数据
            $datas =  array($orderCode, $member['gai_number'], date('Y年m月d日 H:i:s'), $machineName, $franchisee['franchisee_name'],
                $goods['name'], $quantity, $money, $consumeCode, $address, $goods['activity_end_time']);
//            if($smsType == 1){   
            $tmpId = $this->smsModels['machineOrderConsumeId'];
            $smsRes = SmsLog::addSmsLog($userPhone, $smsContent, $orderDetialId, SmsLog::TYPE_OFFLINE_ORDER,null,true,$datas, $tmpId);
//            }else{
//                $smsRes = Sms::send($userPhone, $smsContent);
//            }
            if ($smsRes) {
                $send_status = SmsLog::STATUS_SUCCESS;
            }
            $sms = array(
                'mobile' => $userPhone,
                'content' => $smsContent,
                'create_time' => time(),
                'send_time' => time(),
                'count' => 1,
                'status' => $send_status,
                'interface' => $smsRes['send_api'],
                'type' => SmsLog::TYPE_OFFLINE_ORDER,
                'target_id' => $orderDetialId,
            );
            $status = $this->insert($sms);
            if ($status) {
                Yii::app()->db->createCommand()->update('{{machine_product_order_detail}}', array('sms_id' => Yii::app()->db->getLastInsertID()), 'id=:id', array(':id' => $orderDetialId));
            }
        }
    }

    /**
     * 盖网通消费积分后发送短信
     * @param array $member
     * @param string $franchiseeName
     * @param float $money
     * @param float $score
     * @param float $moneyRMB
     * @param int $userPhone
     */
    public function sendSms_gtDeduct($member, $franchiseeName, $money, $score, $userPhone, $symbol, $totalMoney, $recordId, $smsType = 0) {
        if (isset($this->smsModels['offScoreConsume']) && $this->smsModels['offScoreConsume'] != false) {
            $smsContent = $this->smsModels['offScoreConsume'];
            $money = $symbol == 'HKD' ? "HK$" . $money : "￥" . $money;
            $now = time();
            $smsContent = str_replace(array('{0}', '{1}', '{2}', '{3}', '{4}', '{5}'), array($member['gai_number'], date('Y-m-d H:i', $now), $franchiseeName, $money, $score,
                Common::convertSingle($totalMoney, $member['type_id'])), $smsContent);
            $datas =  array($member['gai_number'], date('Y-m-d H:i', $now), $franchiseeName, $money, $score,
                Common::convertSingle($totalMoney, $member['type_id']));
            $tmpId = $this->smsModels['offScoreConsumeId'] ;
            SmsLog::addSmsLog($userPhone, $smsContent, $recordId, SmsLog::TYPE_OFFLINE_ORDER,null,true, $datas,  $tmpId);
        }
    }

    public function sendSms_gtIncome($userPhone, $gai_number, $cardNum, $card, $points, $smsType = 0) {
        if (isset($this->smsModels['usePrepaidcarSucceed']) && $this->smsModels['usePrepaidcarSucceed'] != false) {
            $smsContent = $this->smsModels['usePrepaidcarSucceed'];
            $now = time();
            //尊敬的{0}用户，您于{1}使用了充值卡{2}充值成功，获得了{3}盖网积分。目前您消费积分余额为{4}，请您核实。
            $smsContent = str_replace(array('{0}', '{1}', '{2}', '{3}', '{4}'), array($gai_number, date('Y-m-d H:i:s', $now), $cardNum, $card['value'], $points), $smsContent);
            $datas = array($gai_number, date('Y-m-d H:i:s', $now), $cardNum, $card['value'], $points);
            $tmpId = $this->smsModels['usePrepaidcarSucceedId'];
            SmsLog::addSmsLog($userPhone, $smsContent,$card['id'], SmsLog::TYPE_CARD_RECHARGE,null,true, $datas, $tmpId);
        }
    }
    /**
     * 盖网通pos补录消费积分后发送短信
     * @param array $member
     * @param string $franchiseeName
     * @param float $money
     * @param float $score
     * @param float $moneyRM
     * @param int $userPhone
     * @param int $pay_time
     */
    public function sendSms_gtRecord($member, $franchiseeName, $money, $score, $userPhone, $symbol, $totalMoney, $recordId, $smsType = 0,$pay_time) {
        if (isset($this->smsModels['offScoreConsume']) && $this->smsModels['offScoreConsume'] != false) {
            $smsContent = $this->smsModels['offScoreConsume'];
            $money = $symbol == 'HKD' ? "HK$" . $money : "￥" . $money;
            $now = $pay_time;
            $smsContent = str_replace(array('{0}', '{1}', '{2}', '{3}', '{4}', '{5}'), array($member['gai_number'], date('Y-m-d H:i', $now), $franchiseeName, $money, $score,
                Common::convertSingle($totalMoney, $member['type_id'])), $smsContent);
            $datas =  array($member['gai_number'], date('Y-m-d H:i', $now), $franchiseeName, $money, $score,
                Common::convertSingle($totalMoney, $member['type_id']));
            $tmpId = $this->smsModels['offScoreConsumeId'] ;
            SmsLog::addSmsLog($userPhone, $smsContent, $recordId, SmsLog::TYPE_OFFLINE_ORDER,null,true, $datas,  $tmpId);
        }
    }
}

?>