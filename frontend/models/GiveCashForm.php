<?php
/**
 * 派发红包输入验证模型
 * @author zhenjun_xu <412530435@qq.com>
 */

class GiveCashForm extends CFormModel{

    public $mobile;
    public $cash;
    public $gai_number;
    public $mobileVerifyCode;
    public $mobile2; //派红包人的手机号
    /**
     * prepaid_card  flag 派发红包 类型
     */
    const FLAG_GIVE_CASH = 1;

    public function rules(){
        return array(
            array('mobile,cash,gai_number,mobileVerifyCode','required'),
            array('mobile','comext.validators.isMobile','errMsg' => Yii::t('giveCashForm', '请输入正确的手机号码'),),
            array('mobile','exist','className'=>'Member','attributeName'=>'mobile','message'=>Yii::t('giveCashForm', '该手机号码未在盖网注册')),
            array('mobileVerifyCode', 'comext.validators.mobileVerifyCode2'),
            array('cash','checkCash'),
        );
    }

    public function checkCash($attribute,$params){
        if (!preg_match('/^\d+\.*\d{0,2}$/', $this->$attribute)) {
            $this->addError($attribute, Yii::t('giveCashForm', '请输入正确的金额'));
        }
        $importMember = Yii::app()->db->createCommand()->from('{{import_member}}')->where('member_id=:id', array(':id' => Yii::app()->user->id))->queryRow();
        if($this->$attribute>$importMember['cash']){
            $this->addError($attribute, Yii::t('giveCashForm', '超过您拥有的红包金额'));
        }
    }

    public function attributeLabels() {
        return array(
            'mobile' => Yii::t('giveCashForm', '手机号'),
            'cash' => Yii::t('giveCashForm', '金额'),
            'gai_number' => Yii::t('giveCashForm', '盖网编号'),
            'mobileVerifyCode' => Yii::t('giveCashForm', '手机验证码'),
        );
    }


} 