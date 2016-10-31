<?php

/**
 * 合约机商品id配置
 * @author binbin.liao
 */
class HeyuejiConfigForm extends CFormModel {

    public $telecom_4g;
    public $telecom_3g;

    public function rules() {
        return array(
            array('telecom_4g,telecom_3g', 'required'),
            array('telecom_4g,telecom_3g', 'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'telecom_4g' => Yii::t('home', '4G合约机套餐商品id'),
            'telecom_3g' => Yii::t('home', '3G合约机套餐商品id'),
        );
    }

}
