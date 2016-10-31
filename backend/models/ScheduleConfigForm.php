<?php
/**
 * 会员升级配置
 * @author huabin_hong <huabin.hong@gwitdepartment.com>
 */
class ScheduleConfigForm extends CFormModel{
    public $upgradeLimitAccount;
    
    public function rules(){
        return array(
            array('upgradeLimitAccount','required'),
            array('upgradeLimitAccount','match','pattern'=>'/^[1-9][0-9]*$/'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'upgradeLimitAccount' => Yii::t('home','会员升级消费额度'),
        );
    }
}
?>
