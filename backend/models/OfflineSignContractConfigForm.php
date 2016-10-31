<?php
/**
 * 电子化签约合同
 *  @author zijian.ou<276059073@qq.com>
 */
class OfflineSignContractConfigForm extends CFormModel{
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