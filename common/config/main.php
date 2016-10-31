<?php

/**
 * 公共配置文件
 * @author wanyun.liu <wanyun_liu@163.com>
 */
// 公共扩展
Yii::setPathOfAlias('comext', $root . DS . 'common' . DS . 'extensions');

//公共类库
Yii::setPathOfAlias('comvendor', $root . DS . 'common' . DS . 'vendor');

// 缓存根目录别名
Yii::setPathOfAlias('cache', $root . DS . '..' . DS . 'source' . DS . 'cache');

// 上传商品图片目录
Yii::setPathOfAlias('uploads', UPLOAD_REMOTE ? UPLOAD_REMOTE . 'uploads' : $root . DS . '..' . DS . 'source' . DS . 'uploads');

// 上传附件目录
Yii::setPathOfAlias('att', UPLOAD_REMOTE ? UPLOAD_REMOTE . 'attachments' : $root . DS . '..' . DS . 'source' . DS . 'attachments');

//代理系统所在目录
Yii::setPathOfAlias('agent', $root . DS . 'agent');

//盖网通图片下载目录
Yii::setPathOfAlias('upload', UPLOAD_REMOTE_GT ? UPLOAD_REMOTE_GT . 'uploads' : $root . DS . '..' . DS . 'gtsource' . DS . 'uploads');

$config = array(
    'preload' => array('log'), // 预载入 log 组件
    'language' => 'zh_cn', // 应用语言
    'charset' => 'utf-8', // 页面字符集
    'timezone' => 'Asia/Shanghai', // 时区
    // 自动载入的类
    'import' => array(
        'comext.YiiRedis.*',
        'common.models.*',
        'common.data.*',
        'common.components.*',
        'common.widgets.*',
        'comvendor.ZhConverter.ZhTranslate',
    ),
    // 应用组件的配置
    'components' => array(
        'session' => array(
            'class' => 'CCacheHttpSession',
            'autoStart' => true,
            'cacheID' => 'sessionCache', //  sessionCache  or  cache
            'cookieMode' => 'allow',
            'cookieParams' => array(
                'domain' => SC_DOMAIN,
                'lifetime' => 0
            ),
            'timeout' => 3600
        ),
        // messages组件类默认的是CPhpMessageSource
        'messages' => array(
            //没有找不到繁体翻译的时候，将使用自动转换
            'onMissingTranslation' => array('ZhTranslateEventHandler', 'ZhMissingTranslation'),
        ),
        //数据格式化
        'format' => array(
            'class' => 'Formatter',
            'dateFormat' => 'Y-m-d',
            'timeFormat' => 'H:i:s',
            'datetimeFormat' => 'Y-m-d H:i:s',
            'booleanFormat' => array('否', '是'),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(// Yii调试扩展工具 
                    'class' => 'comext.yii-debug-toolbar.YiiDebugToolbarRoute', // 调试工具路径
                    'ipFilters' => array('127.0.0.1', '*'),
                    'skipController' => array('thumb', 'cart', 'ueditor', 'design', 'upload'), //跳过，不显示调试工具的控制器
                    'enabled' => YII_DEBUG,
                ),
                array(// 开启将错误信息记录数据库
                    'class' => 'LogRoute',
                    'levels' => 'error, warning, info',
                    'logTableName' => 'gw_log_'.date('Ym'),
                    'connectionID' => 'rl'
                ),
            ),
        ),
    ),
    'params' => require(dirname(__FILE__) . DS . 'params.php'),
);

$db = require(dirname(__FILE__) . DS . 'db.php');
$ftp = require(dirname(__FILE__) . DS . 'ftp.php');
$cache = require(dirname(__FILE__) . DS . 'cache.php');
$config['components'] = CMap::mergeArray($config['components'], $db);
$config['components'] = CMap::mergeArray($config['components'], $ftp);
$config['components'] = CMap::mergeArray($config['components'], $cache);
return $config;
