<?php

/**
 * 会员中心充值卡充值表单
 *  @author wanyun.liu <wanyun_liu@163.com>
 */
class ExchangeCodeForm extends CFormModel {

    public $name;  
    public $verifyCode;
   

    public function rules() {
        return array(
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
            array('name, verifyCode', 'required', 'message' => '{attribute}' . Yii::t('prepaidCard', '不能为空') . '！'),
            
        
        );
    }

    public function attributeLabels() {
        return array(
           
            'name' => Yii::t('prepaidCard', '兑换码'),
          
            'verifyCode' => Yii::t('prepaidCard', '验证码'),
        );
    }
}