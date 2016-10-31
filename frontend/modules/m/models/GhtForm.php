<?php

/**
 *  高汇通支付模型
 *  @author wyee<yanjie.wang@g-emall>
 */
class GhtForm extends CFormModel {

    public $accountName;
    public $certificateNo;
    public $mobilePhone;
    public $validateCode;
    public $bankCardNo;
    public $bankCardType;
    public $certificateType;
    public $sendReqMsgId;
    
    //信用卡信息
    public $valid;
    public $cvn2;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('accountName, certificateNo, valid, cvn2, bankCardNo,mobilePhone,validateCode', 'required','message'=>'{attribute}不可为空'),
           );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'accountName' => Yii::t('ghtpay', '持卡人姓名'),
            'bankCardNo' => Yii::t('ghtpay', '银行卡号'),
            'certificateNo' => Yii::t('ghtpay', '身份证号'),
            'mobilePhone' => Yii::t('ghtpay', '银行预留手机号码'),
            'validateCode' => Yii::t('ghtpay','验证码'),
            'bankCardType' => Yii::t('ghtpay','银行卡类别'),
            'certificateType' => Yii::t('ghtpay','身份证类别'),
            'sendReqMsgId' => Yii::t('ghtpay','短信流水号'),
            'valid' => Yii::t('ghtpay','信用卡有效期'),
            'cvn2' => Yii::t('ghtpay','信用卡背面后三位数字'),     
        );
    }
    
    //验证是否选择银行
    public function validateQequired($attribute, $params){
        if($this->bankCardType=='02'){
            if(empty($this->valid) || empty($this->cvn2)){
                $this->addError($attribute, Yii::t('orderForm', '不能为空'));
            }
        }
    }
    
   
}