<?php

/**
 * app热卖搜索关键字设置
 * @author zhaoxiang.liu
 */
class AppHotKeyForm extends CFormModel{
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
            'title' => Yii::t('home','搜索关键字设置'),
        );
    }
}
