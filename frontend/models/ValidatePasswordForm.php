<?php
/**
 * 验证密码表单，用于登录后的短信验证
 *  @author zhenjun_xu <412530435@qq.com>
 */
class ValidatePasswordForm extends CFormModel {

    public $password;
    public $password2;
    public $password3;
    public $mobile;
    public $mobileVerifyCode;

    public function attributeLabels() {
        return array(
            'password' => Yii::t('validatePasswordForm', '一级密码'),
            'password2' => Yii::t('validatePasswordForm', '二级密码'),
            'password3' => Yii::t('validatePasswordForm', '三级密码'),
            'mobile' => Yii::t('mobile', '手机号码'),
            'mobileVerifyCode' => Yii::t('validatePasswordForm', '手机验证码'),
        );
    }

    public function rules(){
        return array(
            //验证二级密码以及手机验证码
            array('password2,mobileVerifyCode','required','on'=>'pd2_code'),
            array('password2','validatePassword','on'=>'pd2_code'),
            array('mobileVerifyCode','comext.validators.mobileVerifyCode','on'=>'pd2_code'),
        );
    }

    public function validatePassword($attribute, $params){
        /** @var $member Member */
        $member = Member::model()->findByPk(Yii::app()->user->id);
        if($attribute=='password'){
            if(!$member->validatePassword($this->$attribute)){
                $this->addError($attribute,Yii::t('validatePasswordForm','密码错误！'));
            }
        }else if($attribute=='password2'){
            if(!$member->validatePassword2($this->$attribute)){
                $this->addError($attribute,Yii::t('validatePasswordForm','密码错误！'));
            }
        }else{
            if(!$member->validatePassword3($this->$attribute)){
                $this->addError($attribute,Yii::t('validatePasswordForm','密码错误！'));
            }
        }
    }

    /**
     * 查找用户手机号码，用户发短信
     * @return bool
     */
    public function beforeValidate(){
        if (parent::beforeValidate()) {
            /** @var $member Member */
            $member = Member::model()->findByPk(Yii::app()->user->id);
            $this->mobile = $member->mobile;
            return true;
        }
        return false;
    }

} 