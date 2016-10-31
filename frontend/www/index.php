<?php
// 网站前台入口文件
include(dirname(__FILE__) . '/../../common/config/constant.php'); //引入常量配置
include(dirname(__FILE__) . '/../../../framework/yii.php');
$app = Yii::createWebApplication(include(dirname(__FILE__) . '/../config/main.php'));

Yii::app()->onBeginRequest = function () {
    //根据域名设置语言包
    if (SUFFIX == 'hk') {
        Yii::app()->language = 'zh_tw';
    } elseif (SUFFIX == 'us') {
        Yii::app()->language = 'en';
    } else {
        Yii::app()->language = 'zh_cn';
    }
    //cookie 设置 语言包
    $lang = Yii::app()->user->getState('selectLanguage');
    if ($lang == HtmlHelper::LANG_ZH_TW) {
        Yii::app()->language = 'zh_tw';
    } elseif ($lang == HtmlHelper::LANG_EN) {
        Yii::app()->language = 'en';
        defined('CSS_DOMAIN') or define('CSS_DOMAIN', DOMAIN.'/css/encss/');
        defined('CSS_DOMAIN2') or define('CSS_DOMAIN2', DOMAIN.'/styles/encss/');
    } else {
        Yii::app()->language = 'zh_cn';
    }
};
defined('CSS_DOMAIN') or define('CSS_DOMAIN',  DOMAIN.'/css/');
defined('CSS_DOMAIN2') or define('CSS_DOMAIN2',  DOMAIN.'/styles/');
$app->run();
