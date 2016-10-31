<?php
class GwSmsLog extends ApiModel{

    public $tableName = '{{sms_log}}';
    public $primaryKey = 'id';
    public $smsModels = array();


    public function __construct() {
          if (empty($this->smsModels) && $smsModel !== false) {
            $this->smsModels = Tool::getConfig($name = 'smsmodel', $key);
        }
//        $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'smsmodel.config.inc';
//        $smsModel = file_get_contents($file);
//        if (empty($this->smsModels) && $smsModel !== false) {
//            $this->smsModels = unserialize(base64_decode($smsModel));
//        }
    }

    /**
     * 
     * 【订单号：{0}】尊敬的盖网会员{1}，您于{2}，在盖网通【{3}】处购买加盟商【{4}】的产品：【{5}】，数量：{6}，支已付￥{7}，请您核实。消费时请出示您的消费验证码：{8}。消费地址：【{9}】。请于{10}之前进行消费。
     * @param type $franchisee
     */
    public function sendSmsMachineOrderConsume($member,$franchisee,$orderCode, $orderDetialId,$machineName,$goods,$quantity,$money,$userPhone, $consumeCode){
        if (isset($this->smsModels['machineOrderConsume']) && !empty($this->smsModels['machineOrderConsume'])) {
            $smsContent = $this->smsModels['machineOrderConsume'];
            // 加盟商地址
            $region = new GwRegion();
            $cityName = $region->findByPk($franchisee['city_id'], array('name'));
            $districtName = $region->findByPk($franchisee['district_id'], array('name'));
            $address = $cityName['name'].'  '.$districtName['name'].$franchisee['street'];
            // 短信内容
            $smsContent = str_replace(array('{0}','{1}','{2}','{3}','{4}','{5}','{6}','{7}','{8}','{9}','{10}'), 
                    array($orderCode,$member['gai_number'],date('Y年m月d日 H:i:s'),$machineName,$franchisee['franchisee_name'],
                        $goods['name'], $quantity, $money, $consumeCode, $address, $goods['activity_end_time']), $smsContent);
            $send_status = SmsLog::STATUS_FAILD;
//            $smsRes = Sms::send($userPhone, $smsContent);
            $datas = array($orderCode,$member['gai_number'],date('Y年m月d日 H:i:s'),$machineName,$franchisee['franchisee_name'], $goods['name'], $quantity, $money, $consumeCode, $address, $goods['activity_end_time']);
            $tmpId = $this->smsModels['machineOrderConsumeId'];
            $smsRes = SmsLog::addSmsLog($userPhone, $smsContent, $target=0, SmsLog::TYPE_OFFLINE_ORDER,null,true, $datas, $tmpId);
            if($smsRes){
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
            if($status){
                 Yii::app()->db->createCommand()->update('{{machine_product_order_detail}}', array('sms_id'=>Yii::app()->db->getLastInsertID()),'id=:id',array(':id'=>$orderDetialId));
            }
        }
    }
}

?>