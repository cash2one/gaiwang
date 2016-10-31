<?php
/**
 * 图片服务器ftp配置
 */
return array(
    'ftp'=>array(
        'class'=>'comext.ftp.EFtpComponent',
        'host'=>'172.16.2.207',
        'port'=>21,
        'username'=>'gatewang',
        'password'=>'GateFTPWANG2o14',
        'ssl'=>false,
        'timeout'=>90,
        'autoConnect'=>true,
    ),
    'gtftp'=>array(
        'class'=>'comext.ftp.EFtpComponent',
        'host'=>'172.16.2.207',
        'port'=>21,
        'username'=>'gatetong',
        'password'=>'GateFTPtong2o14',
        'ssl'=>false,
        'timeout'=>90,
        'autoConnect'=>true,
    ),
);