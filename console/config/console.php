<?php

/**
 * 控制台配置文件
 * @author wanyun.liu <wanyun_liu@163.com>
 */
// 定义当前系统的路径分隔符常量
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('IS_COMMAND') or define('IS_COMMAND', 1);

// 当前配置文件物理路径
$consoleConfigDir = dirname(__FILE__);

// 当前应用根目录物理路径的路径别名设置
$root = $consoleConfigDir . DS . '..' . DS . '..';
Yii::setPathOfAlias('root', $root);

// 公共目录物理路径别名设置
$common = $root . DS . 'common';
Yii::setPathOfAlias('common', $common);

$frontend = $root . DS . 'frontend';
Yii::setPathOfAlias('frontend', $frontend);
//自动签收记录保存
$autoSign = $root . DS . '..' . DS . 'source' . DS . 'cache' . DS . 'autoSign';
Yii::setPathOfAlias('autoSign', $autoSign);
// 控制台日志缓存目录
$consoleLog = $root . DS . '..' . DS . 'source' . DS . 'cache' . DS . 'consolelog';
Yii::setPathOfAlias('consoleLog', $consoleLog);

// 公共扩展
Yii::setPathOfAlias('comext', $root . DS . 'common' . DS . 'extensions');

//公共类库
Yii::setPathOfAlias('comvendor', $root . DS . 'common' . DS . 'vendor');

// 控制台配置
$consoleConfig = array(
    'basePath' => dirname(__FILE__) . DS . '..',
    'preload' => array('log'), // 预载入 log 组件
    'import' => array(
        'common.extensions.YiiRedis.*',
    	'common.components.*',
        'frontend.components.*',
    	'common.models.*',
		'comvendor.ZhConverter.ZhTranslate',
    ),
    'components' => array(
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(// 开启将错误信息记录数据库
                    'class' => 'CDbLogRoute',
                    'levels' => 'error, warning, info',
                    'logTableName' => 'applog',
                    'connectionID' => 'db'
                ),
            ),
        ),
    ),
);
$db = require($common . DS . 'config' . DS . 'db.php');
$consoleConfig['components'] = CMap::mergeArray($consoleConfig['components'], $db);
$ftp = require($common . DS . 'config' . DS . 'ftp.php');
$consoleConfig['components'] = CMap::mergeArray($consoleConfig['components'], $ftp);
$cache = require($common . DS . 'config' . DS . 'cache.php');
$consoleConfig['components'] = CMap::mergeArray($consoleConfig['components'], $cache);
return $consoleConfig;
