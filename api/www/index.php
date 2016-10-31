<?php
// api入口文件
$yii = dirname(__FILE__) . '/../../../framework/yii.php';
require(dirname(__FILE__) . '/../config/constant.php');
require(dirname(__FILE__) . '/../../common/config/constant.php');
$config = dirname(__FILE__) . '/../config/main.php';
require_once($yii);
Yii::createWebApplication($config)->run();

