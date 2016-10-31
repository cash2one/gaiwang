<?php

/**
 * 热卖活动标题设置
 * @author zhaoxiang.liu
 */
class AppActiveTitleForm extends CFormModel{
    public $title;
    
    public function rules(){
        return array(
            array('title','required'),
            array('title','length','max'=>'90'),
            array('title','safe'),
        );
    }
    
    public function attributeLabels() {
        return array(
            'title' => Yii::t('home','热卖活动标题配置'),
        );
    }
}
?>