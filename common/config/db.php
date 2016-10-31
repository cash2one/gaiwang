<?php

/**
 * 主数据库配置文件
 * @author wanyun.liu <wanyun_liu@163.com>
 */
return array(
    'db' => array(// 商城主数据库配置
        'class' => 'CDbConnection',
        'connectionString' => 'mysql:host=172.18.7.206;dbname=gaiwang',
        'emulatePrepare' => true,
        'enableProfiling' => YII_DEBUG, // 分析sql语句 配合yii调试工具
        'enableParamLogging' => YII_DEBUG, // 日志中显示每次传参的参数,配合yii调试工具
        'username' => 'gateall',
        'password' => '123456',
        'charset' => 'utf8',
        'tablePrefix' => 'gw_',
        'schemaCachingDuration' => 3600, // 数据库结构缓存时间，单位秒
//        'enableSlave' => false, //从数据库启用
//        'masterRead' => true, //紧急情况 从数据库无法连接 启用主数据库 读功能
        'attributes' => array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true   //开启文件导入功能
        ),
       
//        'slaves' => array(//从数据库
//            array(//slave1
//                'connectionString' => 'mysql:host=172.16.8.208;dbname=gatewang',
//                'emulatePrepare' => true,
//                'enableProfiling' => YII_DEBUG, // 分析sql语句 配合yii调试工具
//                'enableParamLogging' => YII_DEBUG, // 日志中显示每次传参的参数,配合yii调试工具
//                'username' => 'gateall',
//                'password' => '123456',
//                'charset' => 'utf8',
//                'tablePrefix' => 'gw_', //表前缀
//            ),
//        ),
    ),
    'db1' => array(// 商城从数据库配置
        'class' => 'CDbConnection',
        'connectionString' => 'mysql:host=172.18.7.206;dbname=gaiwang',
        'emulatePrepare' => true,
        'enableProfiling' => YII_DEBUG, // 分析sql语句 配合yii调试工具
        'enableParamLogging' => YII_DEBUG, // 日志中显示每次传参的参数,配合yii调试工具
        'username' => 'gateall',
        'password' => '123456',
        'charset' => 'utf8',
        'tablePrefix' => 'gw_',
        'schemaCachingDuration' => 3600, // 数据库结构缓存时间，单位秒
        'attributes' => array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true   //开启文件导入功能
        ),
    ),

    'st' => array(// 统计主从库配置
        'class' => 'DbConnection',
        'connectionString' => 'mysql:host=172.18.7.206;dbname=gaiwang_statistics',
        'emulatePrepare' => true,
        'enableProfiling' => YII_DEBUG, // 分析sql语句 配合yii调试工具
        'enableParamLogging' => YII_DEBUG, // 日志中显示每次传参的参数,配合yii调试工具
        'username' => 'gateall',
        'password' => '123456',
        'charset' => 'utf8',
        'tablePrefix' => 'gw_',
        'schemaCachingDuration' => 3600, // 数据库结构缓存时间，单位秒
        'enableSlave' => false, //从数据库启用
        'masterRead' => true, //紧急情况 从数据库无法连接 启用主数据库 读功能
//        'slaves' => array(//从数据库
//            array(//slave1
//                'connectionString' => 'mysql:host=172.16.8.208;dbname=gatewang_statistics',
//                'emulatePrepare' => true,
//                'username' => 'gateall',
//                'password' => '123456',
//                'charset' => 'utf8',
//                'tablePrefix' => 'gw_', //表前缀
//            ),
//        ),
    ),
    'gt' => array(// 盖网通主从库配置
        'class' => 'DbConnection',
        'connectionString' => 'mysql:host=172.18.7.206;dbname=gaitong',
        'emulatePrepare' => true,
        'enableProfiling' => YII_DEBUG, // 分析sql语句 配合yii调试工具
        'enableParamLogging' => YII_DEBUG, // 日志中显示每次传参的参数,配合yii调试工具
        'username' => 'gateall',
        'password' => '123456',
        'charset' => 'utf8',
        'tablePrefix' => 'gt_',
        'schemaCachingDuration' => 3600, // 数据库结构缓存时间，单位秒
        'enableSlave' => false, //从数据库启用
        'masterRead' => true, //紧急情况 从数据库无法连接 启用主数据库 读功能
//        'slaves' => array(//从数据库
//            array(//slave1
//                'connectionString' => 'mysql:host=172.16.8.208;dbname=gatetong',
//                'emulatePrepare' => true,
//                'username' => 'gateall',
//                'password' => '123456',
//                'charset' => 'utf8',
//                'tablePrefix' => 'gt_', //表前缀
//            ),
//        ),
    ),
    'ac' => array(// 盖网通主从库配置
        'class' => 'DbConnection',
        'connectionString' => 'mysql:host=172.18.7.206;dbname=account',
        'emulatePrepare' => true,
        'enableProfiling' => YII_DEBUG, // 分析sql语句 配合yii调试工具
        'enableParamLogging' => YII_DEBUG, // 日志中显示每次传参的参数,配合yii调试工具
        'username' => 'gateall',
        'password' => '123456',
        'charset' => 'utf8',
        'tablePrefix' => 'gw_',
        'schemaCachingDuration' => 3600, // 数据库结构缓存时间，单位秒
        'enableSlave' => false, //从数据库启用
        'masterRead' => true, //紧急情况 从数据库无法连接 启用主数据库 读功能
//        'slaves' => array(//从数据库
//            array(//slave1
//                'connectionString' => 'mysql:host=172.16.8.208;dbname=account',
//                'emulatePrepare' => true,
//                'username' => 'gateall',
//                'password' => '123456',
//                'charset' => 'utf8',
//                'tablePrefix' => 'gt_', //表前缀
//            ),
//        ),
    ),
    'ea' => array(// 盖网通主从库配置
            'class' => 'DbConnection',
            'connectionString' => 'oci:dbname=//172.16.4.61:1521/EASDB;charset=UTF8',
            'emulatePrepare' => false,
            'schemaCachingDuration' => '3600',
            'enableParamLogging' => true,
            //'enableProfiling' => YII_DEBUG, // 分析sql语句 配合yii调试工具
            //'enableParamLogging' => YII_DEBUG, // 日志中显示每次传参的参数,配合yii调试工具
            'username' => 'mdi',
            'password' => 'masterdatainterface',
            'charset' => 'utf8',
            'enableSlave' => false, //从数据库启用,,
            'masterRead' => true
    
             
    ),
    'tr' => array(// 酒店系统主数据库配置
        'class' => 'DbConnection',
        'connectionString' => 'mysql:host=172.18.7.211;dbname=hotel',
        'emulatePrepare' => true,
        'enableProfiling' => YII_DEBUG, // 分析sql语句 配合yii调试工具
        'enableParamLogging' => YII_DEBUG, // 日志中显示每次传参的参数,配合yii调试工具
        'username' => 'root',
        'password' => 'Gemall123',
        'charset' => 'utf8',
        'tablePrefix' => 'h_',
        'schemaCachingDuration' => 3600, // 数据库结构缓存时间，单位秒
        'enableSlave' => false, //从数据库启用
        'masterRead' => true, //紧急情况 从数据库无法连接 启用主数据库 读功能
        'attributes' => array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true   //开启文件导入功能
        ),
    ),
    'rl' => array(// 商城主数据库配置
        'class' => 'CDbConnection',
        'connectionString' => 'mysql:host=172.18.7.206;dbname=runtime_log',
        'emulatePrepare' => true,
        'enableProfiling' => YII_DEBUG, // 分析sql语句 配合yii调试工具
        'enableParamLogging' => YII_DEBUG, // 日志中显示每次传参的参数,配合yii调试工具
        'username' => 'gateall',
        'password' => '123456',
        'charset' => 'utf8',
        'tablePrefix' => 'gw_',
        'schemaCachingDuration' => 3600, // 数据库结构缓存时间，单位秒
        'attributes' => array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true   //开启文件导入功能
        )
    )

);
