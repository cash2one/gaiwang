<?php

/**
 * 运费修改客户配置
 * @author huabin.hong<huabin.hong@gwitdepartment.com>
 */
class FreightLinkConfigForm extends CFormModel{
    public $freightQQ;
    public $freightPhone;
    
    public function rules(){
        return array(
            array('freightQQ,freightPhone','required'),
            array('freightQQ','match','pattern'=>'/^[1-9]\d{4,12}$/'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'freightQQ' => Yii::t('home','运费客服QQ'),
            'freightPhone' => Yii::t('home','运费客服电话'),
        );
    }
}
?>
