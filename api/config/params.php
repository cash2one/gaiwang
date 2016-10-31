<?php

return array(
    'noLogin' => array(
        'site/login',
        'site/logout',
        'site/captcha'
    ),
    'customCUButton' => array(
        'class' => 'CButtonColumn',
        'header' => '操作',
        'template' => '{update}{delete}',
        'updateButtonLabel' => '编辑',
        'updateButtonImageUrl' => false,
        'deleteButtonLabel' => '删除',
        'deleteButtonImageUrl' => false,
    ),
    
    'ExpressApiKey'=>'c7da985b27e879fd',				//快递查询api key
	'ExpressApiHost'=>'http://www.gatewang.com/',		//快递查询api绑定的域名
);
