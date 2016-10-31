<?php

/**
 * 线上订单模型
 * @author binbin.liao
 */
class OrderForm extends CFormModel {

    public $payType;
    public $code;
    public $create_time;
    public $totalPrice;
    /** @var  array 会员信息 */
    public $member;
    /** @var  float $accountPrice  会员账户余额*/
    public $accountMoney;
    /** @var  array 消费账户 */
    public $balance;
    /** @var  array 历史消费账户 */
    public $balanceHistory;
    public $mobileVerifyCode;
    public $mobile;

    public function rules() {
        return array(
            array('payType','required'),
            array('totalPrice','validateAccount'),
            array('mobileVerifyCode','required'),
            array('mobileVerifyCode','comext.validators.mobileVerifyCode'),
        );
    }

    public function attributeLabels() {
        return array(
            'payType' => Yii::t('orderForm', '支付类型'),
            'code' => Yii::t('orderForm', '支付单号'),
            'totalPrice' => Yii::t('orderForm', '支付总金额'),
            'mobileVerifyCode' => Yii::t('orderForm', '验证码'),
        );
    }  

    // 验证账户金额
    public function validateAccount($attribute, $params) {

        if ('JF' == $this->payType && $this->accountMoney < $this->totalPrice)
            $this->addError('password3', Yii::t('orderForm', '帐户积分不够支付！'));
    }

    /**
     *  计算 特殊商品在线支付金额
     * @return array
     */
    public function singlePayDetail(){
        /**
         * @var float $jfPay 积分支付金额
         * @var float $onlinePay 在线支付金额
         */
        $jfPay = Tool::getConfig('order','payJfRatio')/100*$this->totalPrice;
        if($jfPay > $this->accountMoney){
            $jfPay = $this->accountMoney;
        }
        return array('onlinePay'=>sprintf('%.2f',$this->totalPrice - $jfPay),'jfPay'=>sprintf('%.2f',$jfPay));
    }

}
