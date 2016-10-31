<?php

return array(
    'ExpressApiKey' => 'c7da985b27e879fd', //快递查询api key
    'ExpressApiHost' => 'http://www.gatewang.com/', //快递查询api绑定的域名
    'cache' => array(// 各缓存文件的缓存时间
        'indexTopCache' => 24 * 60 * 60, // 首页顶部缓存
        'indexLogoCache' => 24 * 60 * 60, // 首页Logo旁边缓存
        'indexSlidesCache' => 24 * 60 * 60, // 首页幻灯片缓存
        'indexCategoryCache' => 24 * 60 * 60, // 首页商品分类缓存
        'indexRecommendCache' => 24 * 60 * 60, // 首页推荐广告缓存
        'indexOnLineCache' => 24 * 60 * 60, // 首页线下活动缓存
        'indexFloorCache' => 24 * 60 * 60, // 首页楼层数据缓存
        'indexHelpCache' => 24 * 60 * 60, // 首页帮助指引缓存
        'indexLinkCache' => 24 * 60 * 60, // 首页友情链接缓存
        'GoodsCache' => 3600, //商品详情页缓存
    )
);
