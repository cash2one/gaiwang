<?php

/**
 * api配置文件
 * @author wanyun.liu <wanyun_liu@163.com>
 */
// 定义当前系统的路径分隔符常量
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// 当前配置文件物理路径
$backendConfigDir = dirname(__FILE__);

// 当前应用根目录物理路径的路径别名设置
$root = $backendConfigDir . DS . '..' . DS . '..';
Yii::setPathOfAlias('root', $root);

// 公共目录物理路径别名设置
$common = $root . DS . 'common';
Yii::setPathOfAlias('common', $common);
//公共类库
Yii::setPathOfAlias('comvendor', $root . DS . 'common' . DS . 'vendor');

// 秘钥路径
Yii::setPathOfAlias('keyPath', $backendConfigDir . DS . 'key');

// 引入公共配置文件
$commonConfig = require ($backendConfigDir . DS . 'mainCommon.php');

// api配置
$apiConfig = array(
    'language' => 'zh_cn', // 应用语言
    'charset' => 'utf-8', // 页面字符集
    'timezone' => 'Asia/Shanghai', // 时区
    'basePath' => dirname(__FILE__) . DS . '..',
    'name' => 'api接口管理',
    'import' => array(
        'application.components.*',
        'application.models.*',
        'comvendor.ZhConverter.ZhTranslate',
        'common.extensions.YiiRedis.*'
    ),
    'preload'=>array('log'),
    'components' => array(
        // messages组件类默认的是CPhpMessageSource
        'messages' => array(
            //没有找不到繁体翻译的时候，将使用自动转换
            'onMissingTranslation' => array('ZhTranslateEventHandler', 'ZhMissingTranslation'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
        ),
        'session' => array(
            'cookieParams' => array(
                'domain' => API_DOMAIN,
                'lifetime' => 0
            ),
            'timeout' => 3600,
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'warning,error',
//                    'categories'=>'system.*',
                ),
            ),
        ),
        'errorHandler' => array(
            'errorAction' => 'tool/error',
        ),
    ),
    'params' => require(dirname(__FILE__) . DS . 'params.php'),
);

return CMap::mergeArray($commonConfig, $apiConfig);