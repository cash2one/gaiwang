<?php

/**
 * 公共配置文件
 * @author qinghao.ye <qinghaoye@sina.com>
 */

// 公共扩展
Yii::setPathOfAlias('comext', $root . DS . 'common' . DS . 'extensions');

// 缓存根目录别名
Yii::setPathOfAlias('cache', $root . DS . '..' . DS . 'source' . DS . 'cache');

// 上传商品图片目录
Yii::setPathOfAlias('uploads', $root . DS . '..' . DS . 'source' . DS . 'uploads');

// 上传附件目录
Yii::setPathOfAlias('att', $root . DS . '..' . DS . 'source' . DS . 'attachments');

$config = array(
    'preload' => array('log'), // 预载入 log 组件
    // 自动载入的类
    'import' => array(
        'common.models.*',
        'common.components.*',
    ),
    // 应用组件的配置
    'components' => array(
        //数据格式化
        'format' => array(
            'class' => 'CFormatter',
            'dateFormat' => 'Y-m-d',
            'timeFormat' => 'H:i:s',
            'datetimeFormat' => 'Y-m-d H:i:s',
            'booleanFormat' => array('否', '是'),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(// 开启将错误信息记录数据库
                    'class' => 'CDbLogRoute',
                    'levels' => 'info',
                    'logTableName' => 'applog',
                    'connectionID' => 'db'
                ),
            ),
        ),
        'urlManager' => array(
            'class' => 'UrlManager',
            'rules' => array(
                '<_c:\w+>/<id:\d+>' => '<_c>/view',
                '<_c:\w+>/<_a:\w+>/<id:\d+>' => '<_c>/<_a>',
                '<_c:\w+>/<_a:\w+>' => '<_c>/<_a>',
                '<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_c>/<_a>',
                '<_c:\w+>' => '<_c>',
                'api/Main/GetUpdate' => 'tool/oldAppUpdate',
            ),
        ),
    ),
);

$db = require($common . DS . 'config' . DS . 'db.php');
$config['components'] = CMap::mergeArray($config['components'], $db);
$cache = require($common . DS . 'config' . DS . 'cache.php');
$config['components'] = CMap::mergeArray($config['components'], $cache);
return $config;