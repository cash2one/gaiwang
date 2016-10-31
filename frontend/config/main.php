<?php

/**
 * 前台配置文件
 * @author wanyun.liu <wanyun_liu@163.com>
 */
// 定义当前系统的路径分隔符常量
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

// 当前配置文件物理路径
$frontendConfigDir = dirname(__FILE__);

// 当前应用根目录物理路径的路径别名设置
$root = $frontendConfigDir . DS . '..' . DS . '..';
Yii::setPathOfAlias('root', $root);

// 公共目录物理路径别名设置
$common = $root . DS . 'common';
Yii::setPathOfAlias('common', $common);

// 引入公共配置文件
$commonConfig = include ($common . DS . 'config' . DS . 'main.php');

// 前台配置
$frontendConfig = array(
    'basePath' => dirname(__FILE__) . DS . '..',
    'name' => '盖象商城',
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
        'member', 'hotel', 'jms', 'zt', 'help', 'app', 'gatewangtong', 'seller', 'wrap', 'result', 'gwkey', 'agent', 'hongbao', 'm','yaopin', 'sociallogin','active'
    ),
    'components' => array(
        'request' => array(
            'enableCsrfValidation' => true, // 防止post跨站攻击
            'enableCookieValidation' => true, // 防止Cookie攻击
            'csrfCookie' => array(
                'domain' => SC_DOMAIN,
            ),
            'class' => 'CustomHttpRequest',
            'noCsrfValidationRoutes' => array(
                'result/bestpay',
                'result/bestWappay',//微商城翼支付接受消息接口
                'result/unionpay',
                'result/unionWappay',
                'result/hipay',
                'result/umpay',
                'result/umWappay',
                'result/tlzfpay',
                'result/tlzfWappay',
                'member/recharge/payResult',
                'singlePay/uresult',
                'member/recharge/uresult', //接收网银支付结果页面
                'member/quickPay/bindCard', //接收联动优势网银支付结果页面
                'order/onlinePayResult', //支付接收网银支付结果页面
                'm/orderConfirm/onlinePayResult', ////微商城翼支付接受消息接口 支付结果页面
                'hotel/order/onlinePayResult', //支付接收网银支付结果页面
                'seller/franchiseeUpload/upload', //图片管理用的上传处理
                'seller/upload/upload', //图片上传处理
                'member/upload/upload', //图片上传处理
                'help/upload/upload', //图片上传处理
                'business/create', //联盟商户结算关系确认函
                'creditor/create', //债权转移确认函
                'heyuePay/bestPayResult', //合约机支付接收
                'heyuePay/ipsPayResult',
                'heyuePay/uresult',
                'filemanage/upload',
                'filemanage/sure',
                'sociallogin/duimian/callback',
				'sociallogin/weibo/callback',
				'sociallogin/qq/callback',
                'sociallogin/oauth2/token',
                'sociallogin/oauth2/getUserInfo',
            ),
        ),
        'statePersister' => array(
            'class' => 'system.base.CStatePersister',
            'stateFile' => $frontendConfigDir . '/../runtime/state.bin',
        ),
        'user' => array(
            'class' => 'WebUser',
            'allowAutoLogin' => true,
            'authTimeout' => 3600, //用户登陆后处于非活动状态的超时时间（秒）
            'stateKeyPrefix' => 'gatewang_',
            'identityCookie' => array(
                'domain' => SC_DOMAIN,
                'path' => '/'
            ),
        ),
        'urlManager' => require(dirname(__FILE__) . DS . 'urlManager.php'),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'clientScript' => array(
            'class' => 'CClientScript',
            'packages' => array(
                'artDialog' => array(
                    'baseUrl' => DOMAIN,
                    'js' => array('js/artDialog/jquery.artDialog.js?skin=aero', 'js/swf/js/artDialog.iframeTools.js'),
                    'depends' => array('jquery'),
                ),
            ),
        ),
        'oauth2Auth'=>array(
            'class'=>'application.extensions.oauth2server.OAuth2ServerAuth',
            'identityClass'=>'UserIdentity',
            'loginEndpoint'=>'sociallogin/oauth2/login',
            'authorizeEndpoint'=>'sociallogin/oauth2/authorize',
        ),
        'oauth2Resource'=>array(
            'class'=>'application.extensions.oauth2server.OAuth2ServerResource',
        ),
    ),
    'params' => require(dirname(__FILE__) . DS . 'params.php'),
    'theme'=>'v2.0',

);

return CMap::mergeArray($commonConfig, $frontendConfig);
