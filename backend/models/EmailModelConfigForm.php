<?php

/**
 * SEO设置模型类
 * @author huabin_hong <huabin.hong@gwitdepartment.com>
 */
class EmailModelConfigForm extends CFormModel {

    public $shop;
    public $order;
    public $kdtheme;
    public $kdcontent;
    public $xdtheme;
    public $xdcontent;
    public $isRedis;
    public $verdify;
    public $esubject;
    public $econtent;

    public function rules() {
        return array(
            array('kdtheme,kdcontent,
               xdtheme,xdcontent,esubject,econtent
                ', 'required'),
            array('isRedis', 'safe')
        );
    }

    public function attributeLabels() {
        return array(
            'shop' => Yii::t('home', '商户开店邮件提醒'),
            'order' => Yii::t('home', '新订单邮件提醒'),
            'kdtheme' => Yii::t('home', '开店邮件主题'),
            'kdcontent' => Yii::t('home', '开店邮件内容'),
            'xdtheme' => Yii::t('home', '新订单邮件主题'),
            'xdcontent' => Yii::t('home', '新订单邮件内容'),
            'verdifyEmail'=>Yii::t('home', '邮件认证'),
            'esubject'  =>  Yii::t('home', '邮件认证主题'),
            'econtent'  =>  Yii::t('home', '邮件认证内容'),
            'isRedis' => Yii::t('home', '是否启用Redis'),
        );
    }

}

?>
