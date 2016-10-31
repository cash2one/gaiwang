<?php

/**
 * 全局搜索热门词设置
 * @author huabin.hong <huabin.hong@gwitdepartment.com>
 */
class GlobalKeyWordConfigForm extends CFormModel{
    public $hotSearchKeyword;
    
    public function rules(){
        return array(
            array('hotSearchKeyword','required'),
            array('hotSearchKeyword','length','max'=>'90','min' => '10'),
            array('hotSearchKeyword','safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'hotSearchKeyword' => Yii::t('home','全局搜索热门词配置'),
        );
    }
}
?>
