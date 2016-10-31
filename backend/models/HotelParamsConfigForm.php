<?php

/**
 * 酒店参数配置
 */
class HotelParamsConfigForm extends CFormModel {

    public $orderRation; //供价比例
    public $checkOutFees; //退房手续费
    public $luckRation; //抽奖积分
    public $luckMoneyRation; //中奖比例
    public $autoComplete; //订单自动完成

    public $pricerange; // 价格区间
    public $hotelServiceTel; //酒店客服电话
    public $hotelServiceTime; // 酒店客服时间
    public $latestStayTime; // 当天入住最晚预定时间
    public $duration;
    public $hotelOnBusinessTravelMemberId; //绑定商旅收益账户的会员ID
    public $hotelOnBusinessTravelAccount;

    public function rules() {
        return array(
            array('orderRation,checkOutFees,luckRation,luckMoneyRation,autoComplete,hotelServiceTel, hotelServiceTime,
                    latestStayTime, duration, hotelOnBusinessTravelAccount, pricerange', 'required'),
            array('orderRation,checkOutFees,luckRation,luckMoneyRation,autoComplete', 'numerical'),
            array('pricerange','match','pattern'=>'/^(\d+\-\d+\|)+$/','message'=>Yii::t('hotelParams', '请按照示例格式添加')),
//            array('hotelServiceTel','match','pattern'=>'/^0\d{2}-\d{8}|0\d{2,3}-\d{7,8}$/','message'=>Yii::t('hotelParams','客服电话格式不正确')),
            array('orderRation', 'validateRatio'),
            array('hotelOnBusinessTravelMemberId', 'checkHotelBusinessTravelAccount'),
        );
    }

    /**
     * 验证比率系数
     * @param string $attribute
     * @param array $params
     */
    public function validateRatio($attribute, $params) {
        if ($this->$attribute < 1 || $this->$attribute >= 2)
            $this->addError($attribute, Yii::t('hotelParams', '必须是大于"1"小于"2"的值'));
    }

    public function attributeLabels() {
        return array(
            'orderRation' => Yii::t('hotelParams', '酒店供价比例'),
            'checkOutFees' => Yii::t('hotelParams', '酒店退房手续费'),
            'luckRation' => Yii::t('hotelParams', '酒店抽奖价格(积分)'),
            'luckMoneyRation' => Yii::t('hotelParams', '酒店中奖金额比例'),
            'autoComplete' => Yii::t('hotelParams', '酒店订单自动完成天数'),
            'pricerange' => Yii::t('hotelParams','价格区间'),
            'hotelServiceTel' => Yii::t('hotelParams', '酒店客服电话'),
            'hotelServiceTime' => Yii::t('hotelParams', '酒店客服时间'),
            'latestStayTime' => Yii::t('hotelParams', '当天入住最晚预定时间'),
            'duration' => Yii::t('hotelParams', '新订单至确认订单的时长'),
            'hotelOnBusinessTravelAccount' => Yii::t('hotelParams', '商旅收益账户'),
        );
    }

    /**
     * 检查商旅收益账户ID是否一致
     * @param string $attribute
     * @param array $params
     */
    public function checkHotelBusinessTravelAccount($attribute, $params) {
        $data = Yii::app()->db->createCommand()
        ->select('m.id as member_id')
        ->from('{{enterprise}} e')
        ->leftJoin('{{member}} m', 'e.id = m.enterprise_id')
        ->where('e.name = :name', array(':name' => $this->hotelOnBusinessTravelAccount))
        ->queryRow();

        if ($data['member_id'] !== $this->hotelOnBusinessTravelMemberId) {
            $this->addError($attribute, Yii::t('home', '绑定商旅收益账户ID不一致，绑定失败！'));
        }
    }

}

?>
