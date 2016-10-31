<?php
/**
 * 合同
 *  @author zhenjun_xu <412530435@qq.com>
 */
class ContractConfigForm extends CFormModel{
    public $file;

    public function rules(){
        return array(
            array('file','required'),
            array('file','safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'file' => Yii::t('home','内容'),
        );
    }
}
?>
