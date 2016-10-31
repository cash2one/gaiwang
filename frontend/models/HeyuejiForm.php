<?php

/**
 * 合约机表单模型
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class HeyuejiForm extends CFormModel {

    public $taocan;
    public $phone;
    public $username;
    public $identityCard;
    public $readAndAgree;
    public $idPicture1;
    public $idPicture2;
    public $idPicture3;

    public function rules() {
        return array(
            array('taocan, phone, username, identityCard', 'required'),
//            array('idPicture1,idPicture2,idPicture3','required','message'=>Yii::t('heyueji','请选择上传图片')),
            array('phone', 'checkStatus'),
            array('taocan', 'numerical', 'min' => 0, 'max' => 8, 'integerOnly' => true, 'message' => '请选择相应的套餐'),
            array('readAndAgree', 'required', 'requiredValue' => true, 'message' => '请阅读并同意并同意入网协议'),
            array('idPicture1,idPicture2,idPicture3', 'file', 'allowEmpty' => false,  'types' => 'jpg,jpeg,gif,png', 'maxSize' => 1024 * 1024 * 1, 'tooLarge' => Yii::t('heyueji', '上传图片最大不能超过1Mb,请重新上传')),
        );
    }

    public function attributeLabels() {
        return array(
            'taocan' => Yii::t('heyueji', '套餐'),
            'phone' => Yii::t('heyueji', '号码'),
            'username' => Yii::t('heyueji', '机主姓名'),
            'identityCard' => Yii::t('heyueji', '身份证号'),
            'readAndAgree' => Yii::t('heyueji', '我已阅读并同意'),
            'idPicture1'=>Yii::t('heyueji','身份证正面照'),
            'idPicture2'=>Yii::t('heyueji','身份证反面照'),
            'idPicture3'=>Yii::t('heyueji','手持身份证照'),
        );
    }

    /**
     * 合约机表单提交，验证选择号码
     * @param type $attribute
     * @param type $params
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function checkStatus($attribute, $params) {
        $fields = 'is_lock=:isLock AND member_id=:memberId AND create_time>:createTime';
        $conditions = array(':isLock' => Heyue::NOT_LOCK, ':memberId' => Yii::app()->user->id, ':createTime' => (time() - 15 * 60));
        $model = Heyue::model()->findByPk($this->phone, $fields, $conditions);
        if (null == $model)
            $this->addError($attribute, '请选择相应的号码');
    }

}
