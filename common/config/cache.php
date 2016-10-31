<?php
/**
 * 缓存的配置文件
 * @author LC
 */
return array(
	'redis' => array(
		"class" => "comext.YiiRedis.ARedisConnection",
		'hostname'=>'172.18.7.206',
		"port" => 6379
	),
	'fileCache' => array(
		'class' => 'CMemCache',
		'servers'=>array(
			array(
					'host'=>'172.18.7.206',
					'port'=>58728,
				),
			)
	),
	'sessionCache' => array(
         'class' => 'CMemCache',
            'servers' => array(
                array(
                    'host' => '172.18.7.206',
                    'port' => 58728,
                ),
            ),
//            'keyPrefix'=>SC_DOMAIN,  //不同机器共享登录session，必须要设置相同的key前缀
        ),
);