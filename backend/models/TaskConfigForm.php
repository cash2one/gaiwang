<?php
/**
 * 系统任务管理
 * @author huabin.hong <huabin.hong@gwitdepartment.com>
 */
class TaskConfigForm extends CFormModel{
    public $cbkMem;
    public $cbkSMS;
    
    public function rules(){
        return array(
            array('cbkMem,cbkSMS','safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'cbkMem' => Yii::t('home','会员升级权限'),
            'cbkSMS' => Yii::t('home','短信余额通知功能'),
        );
    }
}
?>
