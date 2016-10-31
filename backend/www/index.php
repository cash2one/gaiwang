<?php
// 网站后台入口文件
define('DAILY_EXPORT_KEY','123123');
include(dirname(__FILE__) . '/../../common/config/constant.php'); //引入常量配置
include(dirname(__FILE__) . '/../../../framework/yii.php');
$app = Yii::createWebApplication(include(dirname(__FILE__) . '/../config/main.php'));

//根据域名设置语言
Yii::app()->onBeginRequest = function () {
    if (SUFFIX == 'hk') {
        Yii::app()->language = 'zh_tw';
    } elseif (SUFFIX == 'us') {
        Yii::app()->language = 'en';
    } else {
        Yii::app()->language = 'zh_cn';
    }
};
$app->run();
