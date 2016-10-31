<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 缓存模型
 * @author wencong.lin
 */
class Cache extends CFormModel
{

    const CACHEDIR = 'cache';  // 首页缓存目录

    // 首页推荐广告属性

    public $recommendLeftCode;  //左
    public $recommendCenterCode; //中
    public $recommendRightCode; //右
    public $recommendBottomCode; //底
    // 首页楼层广告属性
    public $floorTextCode;  //文字
    public $floorImgCode;   //图片
    public $floorBottomCode; //底部
    public $floor;           //楼层
    public $category_id;      //分类ID   
    // 首页顶部广告属性
    public $topCode;
    // 首页LOGO旁边广告属性
    public $logoCode;

    const FLOOR_1F = 1;
    const FLOOR_2F = 2;
    const FLOOR_3F = 3;
    const FLOOR_4F = 4;
    const FLOOR_5F = 5;

    // 首页幻灯片广告属性
    public $slidesCode;

    /**
     * 获取楼层
     * @param null|integer $floor
     * @return array|string
     */
    public static function getFloor($floor = null)
    {
        $arr = array(
            self::FLOOR_1F => Yii::t('cache', '1F'),
            self::FLOOR_2F => Yii::t('cache', '2F'),
            self::FLOOR_3F => Yii::t('cache', '3F'),
            self::FLOOR_4F => Yii::t('cache', '4F'),
            self::FLOOR_5F => Yii::t('cache', '5F'),
            self::FLOOR_6F => Yii::t('cache', '6F'),
        );
        return is_null($floor) ? $arr : (isset($arr[$floor]) ? $arr[$floor] : Yii::t('cache', '未知'));
    }

    public function rules()
    {
        return array(
            array('recommendLeftCode,recommendCenterCode,recommendRightCode,recommendBottomCode', 'required', 'on' => 'recommend'),
            array('floorTextCode,floorImgCode,floorBottomCode,floor,category_id', 'required', 'on' => 'floor'),
            array('topCode', 'required', 'on' => 'top'),
            array('logoCode', 'required', 'on' => 'logo'),
            array('slidesCode', 'required', 'on' => 'slides'),
            array('floor', 'in', 'range' => array_keys(self::getFloor())),
        );
    }

    public function attributeLabels()
    {
        return array(
            'recommendLeftCode' => Yii::t('cache', '首页推荐广告-左-编码'),
            'recommendCenterCode' => Yii::t('cache', '首页推荐广告-中-编码'),
            'recommendRightCode' => Yii::t('cache', '首页推荐广告-右-编码'),
            'recommendBottomCode' => Yii::t('cache', '首页推荐广告-底-编码'),
            'floorTextCode' => Yii::t('cache', '首页楼层广告-文字-编码'),
            'floorImgCode' => Yii::t('cache', '首页楼层广告-图片-编码'),
            'floorBottomCode' => Yii::t('cache', '首页楼层广告-底-编码'),
            'floor' => Yii::t('cache', '首页楼层'),
            'category_id' => Yii::t('cache', '商品分类'),
            'topCode' => Yii::t('cache', '首页顶部广告-编码'),
            'logoCode' => Yii::t('cache', '首页LOGO旁边广告-编码'),
            'slidesCode' => Yii::t('cache', '首页幻灯片广告-编码'),
        );
    }

    /**
     * 后台设置顶部广告缓存
     * @return bool $res
     */
    public static function setTopCache($code)
    {
        // 删除缓存
        Tool::cache(Advert::CACHEDIR)->delete($code);
        // 重新生成缓存
        $data = Advert::generateConventionalAd($code);
        $res = Tool::cache(Advert::CACHEDIR)->set($code, $data);
        return $res;
    }

    /**
     * 后台设置Logo旁边广告缓存
     * @return bool $res
     */
    public static function setLogoCache($code)
    {
        // 删除缓存
        Tool::cache(Advert::CACHEDIR)->delete($code);
        // 重新生成缓存
        $data = Advert::generateConventionalAd($code);
        $res = Tool::cache(Advert::CACHEDIR)->set($code, $data);
        return $res;
    }

    /**
     * 后台设置幻灯片缓存
     * @return bool $res
     */
    public static function setSlidesCache($code)
    {
        // 删除缓存
        Tool::cache(Advert::CACHEDIR)->delete($code);
        // 重新生成缓存
        Advert::generateIndexSlideAd($code);
    }

    /**
     * 后台设置商品分类缓存
     * @return bool $res
     */
    public static function setCategoryCache()
    {
        // 删除缓存
        Tool::cache(Category::CACHEDIR)->delete(Category::CK_MAINCATEGORY);
        // 重新生成缓存
        Category::generateMainCategoryData();
    }

    /**
     * 后台设置推荐广告缓存
     * @return bool $res
     */
    public static function setRecommendCache($code)
    {
        $res = true;
        // 删除缓存
        Tool::cache(Advert::CACHEDIR)->delete($code['left']);
        $left = Advert::generateConventionalAd($code['left']);
        if (empty($left)) {
            $res = false;
        }
        // 重新生成缓存
        Tool::cache(Advert::CACHEDIR)->set($code['left'], $left);

        // 删除缓存
        Tool::cache(Advert::CACHEDIR)->delete($code['center']);
        $center = Advert::generateConventionalAd($code['center']);
        if (empty($center)) {
            $res = false;
        }
        // 重新生成缓存
        Tool::cache(Advert::CACHEDIR)->set($code['center'], $center);

        // 删除缓存
        Tool::cache(Advert::CACHEDIR)->delete($code['right']);
        $right = Advert::generateConventionalAd($code['right']);
        if (empty($right)) {
            $res = false;
        }
        // 重新生成缓存
        Tool::cache(Advert::CACHEDIR)->set($code['right'], $right);

        // 删除缓存
        Tool::cache(Advert::CACHEDIR)->delete($code['bottom']);
        $bottom = Advert::generateConventionalAd($code['bottom']);
        if (empty($bottom)) {
            $res = false;
        }
        // 重新生成缓存
        Tool::cache(Advert::CACHEDIR)->set($code['bottom'], $bottom);

        return $res;
    }

    /**
     * 后台设置线下活动缓存
     * @return bool $res
     */
    public static function setOnlineCache()
    {
        // 删除缓存
        Tool::cache(Advert::CACHEDIR)->delete('index-offline-active');
        // 重新生成缓存
        Advert::generateOfflineActiveAdNew();
    }

    /**
     * 前台首页获取楼层缓存
     * @param int $floor 楼层
     * @return array $data
     */
    public static function getFloorCache($floor)
    {
        $data = Tool::cache(self::CACHEDIR)->get('floorCache' . $floor);
        return $data;
    }

    /**
     * 前台获取盖商品商品缓存
     * @param $floor
     * @return mixed
     * @author binbin.liao
     */
    public static function getGaiCache($floor){
        $data = Tool::cache(self::CACHEDIR)->get('floorCache' . $floor);
        return $data;
    }

    /**
     * 后台设置楼层缓存
     * @param array $code 调取数据的id,$code['category_id']:分类ID；$code['floorTextCode']:首页楼层文字广告编码；$code['indexCode']:首页楼层图片广告编码；$code['floorBottomCode']:首页楼层底部图片广告编码;$code['floor']:楼层
     * @return bool $res
     */
    public static function setFloorCache($code)
    {
        $data = array();
        // 楼层信息
        $data['parent'] = Category::getFloorCategoryParent($code['category_id']);
        $data['child'] = Category::getFloorCategoryChild($code['category_id']);

        // 商品信息
        $data['goods'] = Goods::getFloorGoods(Category::getFloorCategoryGrandsonId(Category::getFloorCategoryChildId($code['category_id'])));

        // 首页楼层文字广告ID
        $textId = Advert::getFloorTextAdvertId($code['floorTextCode']);

        // 文字广告位
        if (!empty($textId))
            $data['textAd'] = Advert::getFloorTextAdvert($textId['id']);

        // 首页楼层图片广告ID
        $imgId = Advert::getFloorImgAdvertId($code['floorImgCode']);

        // 图片广告位
        if (!empty($imgId))
            $data['imgAd'] = Advert::getFloorImgAdvert($imgId['id']);

        $floor = 'floorCache' . $code['floor'];

        $res = Tool::cache(self::CACHEDIR)->set($floor, $data);
        return $res;
    }

    /**
     * 后台设置帮助指引缓存
     * @return bool $res
     */
    public static function setHelpCache()
    {
        // 删除缓存
        Tool::cache('article')->delete('helpInfo');
        // 重新生成缓存
        Article::helpInfo();
    }

    /**
     * 后台设置友情链接缓存
     * @return bool $res
     */
    public static function setLinkCache()
    {
        // 删除缓存
        Tool::cache('common')->delete('link');
        // 重新生成缓存
        Link::fileCache();
    }

    /**
     * 设置首页盖商品缓存
     * @param array $code
     * @author binbin.liao
     */
    public static function setIndexGaiCache($code = array('ad-flash' => 'index-floor-gai-flash', 'ad-single' => 'index-floor-gai-ad', 'ad-text' => 'index-floor-gai-text', 'floor' => 'gai', 'floorBottomCode' => 'index-floor-gai-ad3'))
    {
        //要设置缓存的数组
        $data = array('ad-flash' => '', 'ad-single' => '', 'ad-text' => '', 'goods' => '','floorBottomCode'=>'');
        $res = true;

        //幻灯广告位数据
        $data['ad-flash'] = Advert::generateConventionalAd($code['ad-flash']);
        if (empty($data['ad-flash'])) {
            $res = false;
        }


        //幻灯广告位上面单张广告位数据
        $data['ad-single'] = Advert::generateConventionalAd($code['ad-single']);
        if (empty($data['ad-single'])) {
            $res = false;
        }

        //底部广告
        $data['floorBottomCode'] = Advert::generateConventionalAd($code['floorBottomCode']);
        if (empty($data['floorBottomCode'])) {
            $res = false;
        }

        //文字广告数据
        $textId = Advert::getFloorTextAdvertId($code['ad-text']);
        if (!empty($textId))
            $data['ad-text'] = Advert::getFloorTextAdvert($textId['id']);

        //调用参加积分+现金专题商品数据
        $data['goods'] = Advert::generateAdGoods('index-floor-gai-goods');
//        Tool::pr($data['goods']);
        if (empty($data['goods']))
            $res = false;
        $floor = 'floorCache' . $code['floor'];
        Tool::cache(self::CACHEDIR)->set($floor, $data);
        return $res;
    }

}
