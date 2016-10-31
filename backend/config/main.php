<?php

/**
 * 后台配置文件
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

// 引入公共配置文件
$commonConfig = require ($common . DS . 'config' . DS . 'main.php');

// 后台配置
$backendConfig = array(
    'basePath' => dirname(__FILE__) . DS . '..',
    'name' => '后台控制面板',
    'defaultController' => 'main',
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
    ),
    'modules' => array(
        'rights' => array(
            'install' => true
        ),
        'travel',
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'common.gii', //自定义的模板路径
            ),
        ),
    ),
    'components' => array(
//        'request' => array( // 暂时关闭，待解决经常提示crsf报错的问题
//            'enableCsrfValidation' => true, // 防止post跨站攻击
//            'enableCookieValidation' => true, // 防止Cookie攻击
//            'csrfCookie'=>array(
//                'domain'=>SC_DOMAIN,
//            ),
//        ),
        'user' => array(
            'class' => 'RWebUser',
            'allowAutoLogin' => true,
            'stateKeyPrefix' => 'gw_',
            'identityCookie' => array(
                'domain' => SC_DOMAIN,
                'path' => '/'
            ),
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
            'connectionID' => 'db',
            'itemTable' => 'gw_auth_item',
            'itemChildTable' => 'gw_auth_item_child',
            'assignmentTable' => 'gw_auth_assignment',
            'rightsTable' => 'gw_rights',
        ),
        'urlManager' => array(
            'class' => 'UrlManager',
            'rules' => array(
                '<_c:\w+>/<id:\d+>' => '<_c>/view',
                '<_c:\w+>/<_a:\w+>/<id:\d+>' => '<_c>/<_a>',
                '<_c:\w+>/<_a:\w+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
            ),
//            'baseUrl' => DOMAIN
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
    ),
    'params' => require(dirname(__FILE__) . DS . 'params.php'),
);

return CMap::mergeArray($commonConfig, $backendConfig);
