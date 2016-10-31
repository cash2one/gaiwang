<?php

/**
 * url重写规则
 * @author wanyun.liu <wanyun_liu@163.com>
 */
return array(
    'urlFormat' => 'path',
    'showScriptName' => false,
    'urlSuffix' => '.html',
    'rules' => array(
        'http://<_m:(hotel|jms|active)>.' . SHORT_DOMAIN => array(
            '<_m>/site/index',
            'urlSuffix' => ''
        ),
        'http://m1.' . SHORT_DOMAIN . '/<id:\d+>' => 'm/site/view',
        'http://m1.' . SHORT_DOMAIN . '/<_c:\w+>/<_a:\w+>/<id:\d+>' => 'm/<_c>/<_a>',
        'http://m1.' . SHORT_DOMAIN . '/<_c:\w+>/<_a:\w+>' => array('m/<_c>/<_a>','urlSuffix'=>''),
        'http://m1.'.SHORT_DOMAIN.'/<_q:.*>/*'=>array('m/<_q>','urlSuffix'=>''),
//        'http://<_m:(hotel)>.gatewang.' . $suffix . '/site/index/<city:\w+>-<name:\w+>-<score:\d+>-<integral:\d+>-<min:\d+>-<max:\d+>-<level:\d+>-<address:\d+>-<order:\d+>' => '<_m>/site/index',
        'http://<_m:(help)>.' . SHORT_DOMAIN . '/<_c:\w+>/<alias:((?!upload)[\w\d\s-_]+)>' => '<_m>/<_c>/view', //别名正则修改，不包含upload
        'http://<_m:(jms|hotel|member|seller|agent|m|active)>.' . SHORT_DOMAIN . '/<id:\d+>' => '<_m>/site/view',
        'http://<_m:(jms|hotel|member|seller|agent|m|active)>.' . SHORT_DOMAIN . '/<_c:\w+>/<_a:\w+>/<id:\d+>' => '<_m>/<_c>/<_a>',
        'http://<_m:(jms|hotel|member|seller|agent|m|active)>.' . SHORT_DOMAIN . '/<_c:\w+>/<_a:\w+>' => array('<_m>/<_c>/<_a>','urlSuffix'=>''),
        'http://<_m:(member|hotel|jms|zt|help|app|gwkey|gatewangtong|seller|wrap|result|agent|hongbao|m|yaopin|active)>.' . SHORT_DOMAIN . '<_q:.*>/*' => array(
            '<_m><_q>',
            'urlSuffix' => '',
        ),
        'JF' => 'jf',
        'JF/<id:\d+>' => array(
            'goods/view',
            'caseSensitive' => false
        ),
        'orderFlow'=>array('orderFlow','urlSuffix'=>''  ), //购物车去掉 .html 后缀
        '<_c:\w+>/<id:\d+>' => '<_c>/view',
        '<_c:\w+>/<_a:\w+>/<id:\d+>' => '<_c>/<_a>',
        '<_c:\w+>/<_a:\w+>' => '<_c>/<_a>',
    ),
    'baseUrl' => DOMAIN
);
