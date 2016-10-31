<?php

/**
 * att.gatewang.com
 * 缩略图配置文件，更多配置参考 config.bak.php
 *
 */
$defaultConfig = array
(
    'debug' => 0, // 0: redirect to error png | 1: redirect to error png with error url msg | 2: throw an exception
    'source_path' => Yii::getPathOfAlias('att'),
    'thumb_cache_path' => Yii::getPathOfAlias('att') . '/thumb_cache',
    'adapter' => 'GD', // GD | Imagick | Gmagick
//    'prefix' => 'thumb', //if no prefix, will use array key
    'cache' => 1, // 缓存
    'error_url' => 'http://www.gaiwang.com/images/error.png',
    'allow_stretch' => true, // 允许拉伸
    'max_width' => 2000,
    'max_height' => 2000,
    'quality' => 80,
    'allow_sizes' => require( 'allow_sizes.php'),
    'disable_operates' => array(),
    'png_optimize' => array(
        'enable' => 0,
    ),
);

return array(
    'thumbers' => array(
        'head_portrait' => $defaultConfig,
        'assistant' => $defaultConfig,
        'franchisee' => $defaultConfig,
        'brand' => $defaultConfig,
        'files' => $defaultConfig,
        'zt' => $defaultConfig,
        'store' => $defaultConfig,
        'category' => $defaultConfig,
        'images' => $defaultConfig,
    ),
);
