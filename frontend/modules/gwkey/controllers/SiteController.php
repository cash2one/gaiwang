<?php

class SiteController extends Controller {

    public function actions() {
        return array(
            'selectLanguage' => array('class' => 'CommonAction','method'=>'selectLanguage'),
        );
    }

    public function actionIndex() {
        if(Yii::app()->theme){
            $this->layout = '//layouts/miniMain';
        }
        //客户端
        $androidUrl = '';
        $isoUrl='http://itunes.apple.com/us/app/id789586631?mt=8';
        $res = Yii::app()->db->createCommand()->from('{{app}}')->where('app_type='.AppVersion::APP_TYPE_TOKEN.' and system_type='.AppVersion::SYSTEM_TYPE_ANDROID.' and is_visible=1 and is_published=1')->order('id desc')->queryRow();
        if (!empty($res) && $res['url'])
            $androidUrl = $res['url'];

        $gxIosUrl = ''; //盖象商城app apple store url
        $gxAndroidUrl = ''; //盖象商城app 安卓 url
        $res = Yii::app()->db->createCommand()->from('{{app}}')->where('app_type='.AppVersion::APP_TYPE_GAIWANGAPP.' and system_type='.AppVersion::SYSTEM_TYPE_ANDROID.' and is_visible=1 and is_published=1')->order('id desc')->queryRow();
        if (!empty($res) && $res['url']) $gxAndroidUrl = $res['url'];
        $res = Yii::app()->db->createCommand()->from('{{app}}')->where('app_type='.AppVersion::APP_TYPE_GAIWANGAPP.' and system_type='.AppVersion::SYSTEM_TYPE_IOS.' and is_visible=1 and is_published=1')->order('id desc')->queryRow();
        if (!empty($res) && $res['url']) $gxIosUrl = $res['url'];

        //盖掌柜
        $gzgIosUrl = 'http://itunes.apple.com/us/app/gai-zhang-gui-zhi-fu-ma-cha/id938049649?mt=8';
        $gzgAndroidUrl = '';
        $res = Yii::app()->db->createCommand()->from('{{app}}')->where('app_type='.AppVersion::APP_TYPE_SHOPKEEPER.' and system_type='.AppVersion::SYSTEM_TYPE_IOS.' and is_visible=1 and is_published=1')->order('id desc')->queryRow();
        if (!empty($res) && $res['url']) $gzgIosUrl = $res['url'];
        $res = Yii::app()->db->createCommand()->from('{{app}}')->where('app_type='.AppVersion::APP_TYPE_SHOPKEEPER.' and system_type='.AppVersion::SYSTEM_TYPE_ANDROID.' and is_visible=1 and is_published=1')->order('id desc')->queryRow();
        if (!empty($res) && $res['url']) $gzgAndroidUrl = $res['url'];

        $this->render('index', array(
            'url_android' => $androidUrl,
            'isoUrl'=>$isoUrl,
            'gxIosUrl'=>$gxIosUrl,
            'gxAndroidUrl'=>$gxAndroidUrl,
            'gzgIosUrl'=>$gzgIosUrl,
            'gzgAndroidUrl'=>$gzgAndroidUrl,
            ));
    }

    /**
     * 盖付通页面
     */
    public function actionPay(){
        $this->layout = '//layouts/miniMain';
        $this->render('pay');
    }

    /*
     * 盖掌柜页面
     */
    public function actionShopkeeper(){
        $this->layout = '//layouts/miniMain';
        $this->render('shopkeeper');
    }

    /*
     * UWP盖付通介绍页面
     */
    public function actionUwpPay(){
        $this->layout = '//layouts/miniMain';
        $this->render('uwpPay');
    } 
    /*
     * UWP盖掌柜页面
    */
    public function actionUwpShopkeeper(){
        $this->layout = '//layouts/miniMain';
        $this->render('uwpShopkeeper');
    }
    /*
     * 盖讯通页面
    */
    public function actionGxt(){
        $this->layout = '//layouts/miniMain';
        $this->render('gxt');
    }

    public function actionError() {
        $this->layout = 'app';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}