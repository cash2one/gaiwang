<?php
/**
 * @author: xiaoyan.luo
 * @mail: xiaoyan.luo@g-emall.com
 * Date: 15-4-1 上午9:52
 */
class WebAdData{
    /**
     * 获取商城首页推荐广告位信息
     * @param $left string 左侧广告位编码
     * @param $center string 中间广告位编码
     * @param $right string 右侧广告位编码
     * @param $bottom string 底部广告位编码
     * @return array 首页推荐广告位信息
     */
    public static function getRecommendData($left, $center, $right, $bottom)
    {
        $left = Advert::generateConventionalAd($left);//查询出左侧广告位数据
        $center = Advert::generateConventionalAd($center);
        $right = Advert::generateConventionalAd($right);
        $bottom = Advert::generateConventionalAd($bottom);
        return array('left' => $left, 'center' => $center, 'right' => $right, 'bottom' => $bottom);
    }

    /**
     * 获取商品楼层信息
     * @param $categoryId string 分类id
     * @param $floorTextCode string 首层楼层文字广告编码
     * @param $floorImgCode string 首层楼层广告编码
     * @param $floorBottomCode string 首层楼层底部广告编码
     * @return array
     */
    public static function getFloorData($categoryId, $floorTextCode, $floorImgCode, $floorBottomCode)
    {
        $data = array();
        // 楼层信息
        $data['parent'] = Category::getFloorCategoryParent($categoryId);
        $data['child'] = Category::getFloorCategoryChild($categoryId);

        // 商品信息
        $data['goods'] = Goods::getFloorGoods(Category::getFloorCategoryGrandsonId(Category::getFloorCategoryChildId($categoryId)));

        // 首页楼层文字广告ID
        $textId = Advert::getFloorTextAdvertId($floorTextCode);

        // 文字广告位
        if (!empty($textId)){
            $limit = Yii::app()->theme ? 10 : 5;
            $data['textAd'] = Advert::getFloorTextAdvert($textId['id'],$limit);
        }
        // 首页楼层图片广告ID
        $imgId = Advert::getFloorImgAdvertId($floorImgCode);

        // 图片广告位
        if (!empty($imgId))
            $data['imgAd'] = Advert::getFloorImgAdvert($imgId['id']);

        //楼层底部广告位
        $floorId = Advert::getFloorImgId($floorBottomCode);
        if(!empty($floorId))
            $data['bottom'] = Advert::getFloorImgAdvertData($floorId['id']);

        //品牌logo图片广告
        $data['brand'] = Advert::getFloorBrandAdvertData($categoryId);

        return $data;
    }

    /**
     * 获取线下活动数据
     * @return array
     */
    public static function getOfflineData()
    {
        $datas = Advert::getOfflineDefaultAdvert(FranchiseeActivityCity::getOnlineDefaultCity());
        $adData = $parentData =$childData= array();
        if(!empty($datas)){
            foreach($datas as $key => $value){
                $adData[$key] = $value['ad'];
                $parentData[$key]['id'] = $value['id'];
                $parentData[$key]['name'] = $value['name'];
                $parentData[$key]['content'] = $value['content'];
            }
        }
        $childData = Category::getOfflineCategoryChildData($parentData);
        $city = FranchiseeActivityCity::getOnlineAllCity();
        $slideData = array(); //轮播图广告
        foreach($city as $k=>$v){
            $slideData[$v['city_id']] = Advert::getOfflineDefaultAdvert($v,'index_offline_slide%');
        }

        $offlineData = array(
            'de_city' => FranchiseeActivityCity::getOnlineDefaultCity(),//默认城市
            'city' => FranchiseeActivityCity::getOnlineAllCity(),//所有城市
            'ad' => $adData,//广告数据
            'parent' => $parentData,//父分类
            'child' => $childData,//子分类
            'logo'=>self::getCommonData('index_offline_logo',12), //店铺logo广告
            'keyword'=>self::getCommonData('index_offline_keyword',10), //店铺logo广告
            'slideData'=>$slideData,
        );
        return $offlineData;
    }

    /**
     * 获取盖商品数据
     * @param $adFlash string 幻灯广告位编码
     * @param $adSingle string 单张幻灯广告位编码
     * @param $floorBottomCode string 底部广告编码
     * @param $adText string 文字广告编码
     * @param $goods string 积分+现金专题商品编码
     * @return array
     */
    public static function getGaiData($adFlash, $adSingle, $floorBottomCode, $adText, $goods)
    {
        //幻灯广告位数据
        $data['ad-flash'] = Advert::generateConventionalAd($adFlash);

        //幻灯广告位上面单张广告位数据
        $data['ad-single'] = Advert::generateConventionalAd($adSingle);

        //底部广告
        $data['floorBottomCode'] = Advert::generateConventionalAd($floorBottomCode);

        //文字广告数据
        $textId = Advert::getFloorTextAdvertId($adText);
        if (!empty($textId))
            $data['ad-text'] = Advert::getFloorTextAdvert($textId['id']);

        //调用参加积分+现金专题商品数据
        $data['goods'] = Advert::generateAdGoods($goods);

        return $data;
    }

    /**
     * 首页logo
     * @param $code string 广告位编码
     * @return array
     */
    public static function getLogoData($code){
        $data = Tool::cache(Advert::CACHEDIR)->get($code);
        if(!$data) $data = Advert::generateConventionalAdData($code);
        return $data;
    }

    /**
     * 获取首页分类数据
     * @return array
     */
    public static function getMainCategoryData(){
        $data = Tool::cache(Advert::CACHEDIR)->get(Advert::HOME_NAV_CACHE_DIR);
        if(empty($data)) $data = Category::getHomepageCategoryData();
        return $data;
    }

    /**
     * 首页大屏幻灯片
     * @param $code string 广告位编码
     * @return array
     */
    public static function getSlidesData($code){
        $data = Advert::IndexSlideAdData($code);
        return $data;
    }

    /**
     * 获取首页友情链接
     * @return mixed
     */
    public static function getLinkData(){
        $linkData = Yii::app()->db->createCommand()
            ->select(array('name', 'url'))
            ->from('{{link}}')
            ->where('position', array('position' => Link::POSITION_HOME))
            ->order('sort asc')
            ->limit(Link::POSITION_HOME_MAX)
            ->queryAll();
        return $linkData;
    }

    /**
     * 获取帮助中心数据
     * @return array
     */
    public static function getHelpData(){
        $data = Article::getHelpInfo();
        return $data;
    }

    /**
     * 通用的根据 编码 获取广告内容
     * @param string $code
     * @param int $limit 条数
     * @return array
     *
     */
    public static function getCommonData($code,$limit=null){
        $data = Tool::cache(Advert::CACHEDIR)->get($code);
        if(empty($data)){
            $data =  Advert::generateConventionalAdData($code,$limit);
        }
        if(!empty($data)){
            foreach($data as $k=>$v){
                //是否过期验证
                if(isset($v['start_time']) && !AdvertPicture::isValid($v['start_time'],$v['end_time'])){
                    unset($data[$k]);
                }
            }
            foreach($data as $k=>$v){
                //删除多余的
                if($k>=$limit && $limit!==null){
                    unset($data[$k]);
                }
            }
        }
        return $data;
    }
}