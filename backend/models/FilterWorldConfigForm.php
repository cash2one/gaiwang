<?php

/**
 * 敏感词设置
 * @author huabin.hong <huabin.hong@gwitdepartment.com>
 */
class FilterWorldConfigForm extends CFormModel{
    public $filterWorld;
    
    public function rules(){
        return array(
          array('filterWorld','safe'),  
        );
    }
    
    public function attributeLabels() {
        return array(
            'filterWorld' => Yii::t('home','敏感词设置'),
        );
    }
}
?>
