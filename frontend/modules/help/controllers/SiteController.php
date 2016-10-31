<?php

/**
 * 帮助中心
 * Class SiteController
 */
class SiteController extends Controller {

    //public $layout = '//layouts/main';

    public function actionIndex() {
        $criteria = array('condition' => 'category_id=:cid', 'params' => array(':cid' => 7), 'limit' => 18);
        $article = Article::model()->findAll($criteria);
        
        $arr = array();
        foreach ($article as $a){
            $arr[] = $a->attributes;
        }
        
       $info = array_chunk($arr,6);

        $this->render('index', array(
            'info' => $info));
    }

    /**
     * frontend/config/urlManager.php
     * 'http://<_m:(help)>.' . SHORT_DOMAIN . '/<_c:\w+>/<alias:.*>' => '<_m>/<_c>/view',
     *  因为这条规则，不能通过 actions() 运行通用frontend/components/CommonAction.php 的ajax选择语言
     */
    public function actionView(){
        if($this->isAjax()){
            Yii::app()->user->setState('selectLanguage', Yii::app()->request->getParam('language'));
        }
    }

    public function actionError() {
        $this->layout = 'main';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}