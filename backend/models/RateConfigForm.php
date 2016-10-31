<?php

/**
 * 汇率配置模型
 * @author huabin.hong <huabin.hong@gwitdepartment.com>
 */
class RateConfigForm extends CFormModel {

    public $hkRate;

    public function rules() {
        return array(
            array('hkRate', 'required'),
            array('hkRate', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'hkRate' => Yii::t('home', '100港币='),
        );
    }

}

?>
