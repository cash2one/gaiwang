<?php
/**手机、地方特产频道主页
 * @author liao jiawei <569114018@qq.com>
 * Date: 2015/7/22
 * Time: 13:22
 */

class ChannelController extends Controller{
    public $layout = 'channeltop';

    const PHONE_CATEGORY = 4;   //手机数码分类
    const PHONE_CHILD_CATEGORY = 21;//定义手机通讯分类
    const PHOTOGRAPHY_CATEGORY = 97;   //摄影分类
    const PARTS_CATEGORY = 96;   //手机配件分类
    const DIGITAL_ASS_CATEGORY = 98;   //数码配件分类
    const FOOD_CATEGORY = 8;    //饮料食品分类
    const CHANNEL_NATIVE_CATEGORY = 66; //特产分类ID
    const CHANNEL_GRAIN_CATEGORY = 70;//特产分类ID
    const CHANNEL_DRINK_CATEGORY = 69;//饮料调冲
    const CHANNEL_SNACKS_CATEGORY = 71;//休闲食品
    
    const ZY_SHOP_ID = '2251'; //自营店铺id

    public function beforeAction($action)
    {
        if($this->action->id != 'autotrophy') {
            if($this->action->id == 'digital'){ 
                $id = self::PHONE_CATEGORY; 
            }else if($this->action->id == 'food'){
                $id = self::FOOD_CATEGORY;
            } 
            if (!$categorys = $this->cache(Category::CACHEDIR)->get(Category::CK_ALLCATEGORY))
                $categorys = Category::allCategoryData();
            if (!isset($categorys[$id]))
                throw new CHttpException(404, Yii::t('category', "访问出错！"));
    //        var_dump($categorys);exit;
            $seo = $categorys[$id];
            $this->title = $seo['title'];
            $this->keywords = $seo['keywords'];
            $this->description = $seo['description'];
        } else {//盖象自营频道
            $seo = $this->getConfig('seo');
            $this->title = '自营频道-盖象商城';
            $this->keywords = $seo['keyword'];
            $this->description = $seo['description'];
        }   
        return parent::beforeAction($action);
    }
    
    public function actionIndex(){
        $this->actionDigital();
    }

    /**
     * 手机数码频道
     */
    public function actionDigital(){

//        $this->title = '盖象商城-手机数码';

        $recommendGoodsCategory =  self::getChiledrenCategory(self::PHONE_CATEGORY);//获取三级分类
        $channelNav = self::getChiledren(self::PHONE_CATEGORY);//   手机数码导航栏
        $recommendData = Goods::getRecommendGoods($recommendGoodsCategory);//获取手机数码顶级分类的热门推荐
        $phoneAdver = Advert::getChannelIndexAdver(Advert::PHONE_CHANNEL_CODE);   //手机数码主页5张轮播图
        $focusAdver = Advert::getChannelIndexAdver(Advert::FOCUS_PHONE_CODE,0,3);  //副焦点广告 15条
        $topText = Advert::getChannelIndexAdver(Advert::CHANNEL_PHONE_TOP_TEXT,0,2);//获取上头文字广告
        
        /**
         * 获取手机楼层信息
         */
        $phoneLeftTop = Advert::getChannelIndexAdver(Advert::CHANNEL_PHONE_LEFT_TOP,0,1);  //手机左上方广告
        $phoneLeftDown = Advert::getChannelIndexAdver(Advert::CHANNEL_PHONE_LEFT_DOWN,0,1);  //手机左下方广告
        $phoneLeftBig = Advert::getChannelIndexAdver(Advert::CHANNEL_PHONE_LEFT_BIG,0,3);  //手机主广告
        $channelPhoneText = Advert::getChannelIndexAdver(Advert::CHANNEL_PHONE_TEXT,0,6);  //手机左下方文字广告
        //获取5条手机推荐商品
        $phoneCateArr = Category::getChildCategory(self::PHONE_CHILD_CATEGORY);
        $phoneCateStr = Tool::array_set($phoneCateArr,'id');
        $phoneCate = Goods::getRecommendGoods($phoneCateStr,5,1);

        /**
         * 获取摄影楼层信息
         */
        $photographyLeftTop = Advert::getChannelIndexAdver(Advert::CHANNEL_PHOTOGRAPHY_LEFT_TOP,0,1);  //摄影左上方广告
        $photographyLeftRight = Advert::getChannelIndexAdver(Advert::CHANNEL_PHOTOGRAPHY_LEFT_DOWN,0,1);  //摄影右上方广告
        $photographyLeftBig = Advert::getChannelIndexAdver(Advert::CHANNEL_PHOTOGRAPHY_LEFT_BIG,0,6);  //摄影主方广告
        $channelPhotographyText = Advert::getChannelIndexAdver(Advert::CHANNEL_PHOTOGRAPHY_TEXT,0,9);  //摄影左下方文字广告
        //获取5条摄影推荐商品
        $photographyCateArr = Category::getChildCategory(self::PHOTOGRAPHY_CATEGORY);
        $photographyCateStr = Tool::array_set($photographyCateArr,'id');
        $photographyCate = Goods::getRecommendGoods($photographyCateStr,5);

        /**
         * 获取手机配件楼层信息
         */
        $partsLeftTop = Advert::getChannelIndexAdver(Advert::CHANNEL_PARTS_LEFT_TOP,0,1);  //手机配件左上方广告
        $partsLeftDown = Advert::getChannelIndexAdver(Advert::CHANNEL_PARTS_LEFT_DOWN,0,1);  //手机配件左下方广告
        $partsLeftBig = Advert::getChannelIndexAdver(Advert::CHANNEL_PARTS_LEFT_BIG,0,6);  //手机配件主广告
        $channelPartsText = Advert::getChannelIndexAdver(Advert::CHANNEL_PARTS_TEXT,0,9);  //手机配件左下方文字广告
        //获取5条手机配件推荐商品
        $partsCateArr = Category::getChildCategory(self::PARTS_CATEGORY);
        $partsCateStr = Tool::array_set($partsCateArr,'id');
        $partsCate = Goods::getRecommendGoods($partsCateStr,5);

        /**
         * 获取数码配件楼层信息
         */
        $digitalLeftTop = Advert::getChannelIndexAdver(Advert::CHANNEL_DIGITAL_ASS_LEFT_TOP,0,1);  //数码配件左上方广告
        $digitalLeftRight = Advert::getChannelIndexAdver(Advert::CHANNEL_DIGITAL_ASS_LEFT_DOWN,0,1);  //数码配件右上方广告
        $digitalLeftBig = Advert::getChannelIndexAdver(Advert::CHANNEL_DIGITAL_ASS_LEFT_BIG,0,6);  //数码配件主方广告
        $channelDigitalText = Advert::getChannelIndexAdver(Advert::CHANNEL_DIGITAL_ASS_TEXT,0,9);  //数码配件左下方文字广告
        //获取5条数码配件推荐商品
        $digitalCateArr = Category::getChildCategory(self::DIGITAL_ASS_CATEGORY);
        $digitalCateStr = Tool::array_set($digitalCateArr,'id');
        $digitalCate = Goods::getRecommendGoods($digitalCateStr,5);

        $valueArray = array('topText'=>$topText,
                            'channelNav'=>$channelNav,
                            'phoneAdver'=>$phoneAdver,
                            'focusAdver'=>$focusAdver,
                            'recommendData'=>$recommendData,
                            'phoneLeftTop'=>$phoneLeftTop,
                            'phoneLeftDown'=>$phoneLeftDown,
                            'phoneLeftBig'=>$phoneLeftBig,
                            'channelPhoneText'=>$channelPhoneText,
                            'phoneCate'=>$phoneCate,
                            'photographyLeftTop'=>$photographyLeftTop,
                            'photographyLeftRight'=>$photographyLeftRight,
                            'photographyLeftBig'=>$photographyLeftBig,
                            'channelPhotographyText'=>$channelPhotographyText,
                            'photographyCate'=>$photographyCate,
                            'partsLeftTop'=>$partsLeftTop,
                            'partsLeftDown'=>$partsLeftDown,
                            'partsLeftBig'=>$partsLeftBig,
                            'channelPartsText'=>$channelPartsText,
                            'partsCate'=>$partsCate,
                            'digitalLeftTop'=>$digitalLeftTop,
                            'digitalLeftRight'=>$digitalLeftRight,
                            'digitalLeftBig'=>$digitalLeftBig,
                            'channelDigitalText'=>$channelDigitalText,
                            'digitalCate'=>$digitalCate
        );
        $this->render('phonechannel',$valueArray);
    }


    public function actionFood(){
//        $this->title = '盖象商城-饮料食物';
        $foodNavAdver = $valueArray = array();
        $channelNav = self::getChiledren(self::FOOD_CATEGORY);//   饮料食物导航栏
        $foodAdver = Advert::getChannelIndexAdver(Advert::FOOD_CHANNEL_CODE);   //饮料食物主页5张轮播图
        $focusAdver = Advert::getChannelIndexAdver(Advert::FOCUS_FOOD_CODE,0,3);  //副焦点广告 15条
        $topText = Advert::getChannelIndexAdver(Advert::CHANNEL_FOOD_TOP_TEXT,0,2);//获取上头文字广告
        $recommendGoodsCategory =  self::getChiledrenCategory(self::FOOD_CATEGORY);//获取三级分类
        $recommendData = Goods::getRecommendGoods($recommendGoodsCategory);//饮料食物顶级分类的热门推荐

        $TowCategory = Category::getCategory(self::FOOD_CATEGORY,false);
        foreach($TowCategory as $key => $value){
            $foodNavAdver[$value['id']] = Advert::getChannelIndexAdver(Advert::CHANNEL_FOOD_NAV_ADVER.'_'.$value['id'],0,1);
        }

        //地方特产
        $channelNativeText = Advert::getChannelIndexAdver(Advert::CHANNEL_NATIVE_TEXT,0,6);  //地方特产左下方文字广告
        $nativeLeftTop = Advert::getChannelIndexAdver(Advert::CHANNEL_NATIVE_LEFT_TOP,0,1);  //地方特产左上方广告
        $nativelCategory = self::getChiledren(self::CHANNEL_NATIVE_CATEGORY);//   产品特产子类
        $nativeMain = Goods::getRecommendGoods(Tool::array_set($nativelCategory,'id'),2);
        $nativeRight = Goods::getRecommendGoods(Tool::array_set($nativelCategory,'id'),4,1,2);

        //粮油调味Grain
        $channelGrainText = Advert::getChannelIndexAdver(Advert::CHANNEL_GRAIN_TEXT,0,6);  //粮油调味左下方文字广告
        $grainLeftTop = Advert::getChannelIndexAdver(Advert::CHANNEL_GRAIN_LEFT_TOP,0,1);  //粮油调味左上方广告
        $grainCategory = self::getChiledren(self::CHANNEL_GRAIN_CATEGORY);//   粮油调味子类
        $grainMain = Goods::getRecommendGoods(Tool::array_set($grainCategory,'id'),2);
        $grainRight = Goods::getRecommendGoods(Tool::array_set($grainCategory,'id'),4,1,2);

        //酒饮冲调Drink
        $channelDrinkText = Advert::getChannelIndexAdver(Advert::CHANNEL_DRINK_TEXT,0,6);  //酒饮冲调左下方文字广告
        $drinkLeftTop = Advert::getChannelIndexAdver(Advert::CHANNEL_DRINK_LEFT_TOP,0,1);  //酒饮冲调左上方广告
        $drinkCategory = self::getChiledren(self::CHANNEL_DRINK_CATEGORY);//   酒饮冲调子类
        $drinkMain = Goods::getRecommendGoods(Tool::array_set($drinkCategory,'id'),8);

        //休闲食品Snacks
        $channelSnacksText = Advert::getChannelIndexAdver(Advert::CHANNEL_SNACKS_TEXT,0,6);  //休闲食品左下方文字广告
        $snacksLeftTop = Advert::getChannelIndexAdver(Advert::CHANNEL_SNACKS_LEFT_TOP,0,1);  //休闲食品左上方广告
        $snacksCategory = self::getChiledren(self::CHANNEL_SNACKS_CATEGORY);//   休闲食品子类
        $snacksMain = Goods::getRecommendGoods(Tool::array_set($snacksCategory,'id'),8);

        $valueArray = array('channelNav'=>$channelNav,
                            'foodAdver'=>$foodAdver,
                            'focusAdver'=>$focusAdver,
                            'topText'=>$topText,
                            'recommendData'=>$recommendData,
                            'channelNativeText'=>$channelNativeText,
                            'nativeLeftTop'=>$nativeLeftTop,
                            'nativeMain'=>$nativeMain,
                            'nativeRight'=>$nativeRight,
                            'channelGrainText'=>$channelGrainText,
                            'grainLeftTop'=>$grainLeftTop,
                            'grainMain'=>$grainMain,
                            'grainRight'=>$grainRight,
                            'drinkMain'=>$drinkMain,
                            'channelDrinkText'=>$channelDrinkText,
                            'drinkLeftTop'=>$drinkLeftTop,
                            'channelSnacksText'=>$channelSnacksText,
                            'snacksLeftTop'=>$snacksLeftTop,
                            'snacksMain'=>$snacksMain,
                            'foodNavAdver'=>$foodNavAdver);
        $this->render('foodchannel',$valueArray);
    }

    /**
     * 获取当前顶级分类的二级分类和三级分类信息
     * @param $cate_id 当前顶级分类的ID
     * @return string
     */
    protected function getChiledren($cate_id){
        $result = $navList = array();
        $navList = Tool::cache(Advert::PHONE_NAV_CACHE)->get(Advert::PHONE_NAV_CACHE.$cate_id);
        if(!$navList){
            $result = Category::getCategory($cate_id, false);
            foreach($result as $key => $value){
                $result[$key]['childClass'] = Category::getCategory($value['id'], false);
            };
            Tool::cache(Advert::PHONE_NAV_CACHE)->set(Advert::PHONE_NAV_CACHE.$cate_id,$result);
            return $result;
        }else{
            $result = $navList;
        }
        return $result;
    }

    /**
     * 筛选顶级分类下的所有三级分类
     * @param $category
     * @return array|mixed
     */
    public static function getChiledrenCategory($category){
        $recommendGoodsCategoryList = Tool::cache(Advert::CHANNELCACHE)->get(Advert::CHANNELCACHE.$category);
        if(!$recommendGoodsCategoryList){
            $recommendCategory = Category::getChildCategory($category);
            foreach($recommendCategory as $key => $value){
                $tmpGoodsCategoryList = Category::getChildCategory($value['id']);
                foreach($tmpGoodsCategoryList as $key => $value){
                    $recommendGoodsCategoryList[] = $value['id'];
                }
            }
            Tool::cache(Advert::CHANNELCACHE)->set(Advert::CHANNELCACHE.$category,implode(',',$recommendGoodsCategoryList));
            return $recommendGoodsCategoryList;
        }
        return $recommendGoodsCategoryList;
    }

    /**
     * 刷新所有频道广告缓存
     */
    public static function clearvpCache(){
        Tool::cache(Advert::CHANNEL_CACHEDIE)->flush();
        return true;
    }
    
    /**
     * 自营产品
     */
    public function actionAutotrophy() {
        
        //获取所需商品
        $Goods = Yii::app()->db->createCommand()
            ->select('id,name,price,thumbnail,sort')
            ->from('{{goods}}')
            ->limit(20)
            ->order('id DESC')
            ->where('store_id=:store_id and is_publish=:push and life=:life  and status=' . Goods::STATUS_PASS)
            ->bindValues(array(':store_id' => self::ZY_SHOP_ID, ':push' => Goods::PUBLISH_YES, ':life' => Goods::LIFE_NO))
            ->queryAll();
        
        $GoodsAdv=array();
        $GoodsAdv=$autotrophyAdver = Advert::getChannelIndexAdver(Advert::AUTOTROPHY_CHANNEL_GOODS,0,18,1);//自营频道的商品广告图
        $recommendGoods = $czGoods = $tmGoods = $msGoods = array();
        $recommendGoodsAdv = $czGoodsAdv = $tmGoodsAdv = $msGoodsAdv = array();
        $autotrophyAdver = Advert::getChannelIndexAdver(Advert::AUTOTROPHY_CHANNEL_CODE);   //自营主页5张轮播图
        $ownAdver = Advert::getChannelIndexAdver(Advert::OWN_AUTOTROPHY_ADVER,0,4);   //自营主页自有品牌图
        
        
        $recommendLeftTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_RECOMMEND_LEFT_TOP,0,1); //精选推荐左上方图
        $recommendLeftUnderAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_RECOMMEND_LEFT_UNDER,0,1); //精选推荐左下方图
        $recommendMiddleTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_RECOMMEND_MIDDLE_TOP,0,1); //精选推荐中上方图
        $recommendRightTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_RECOMMEND_RIGHT_TOP,0,1); //精选推荐右上方图
        if (!empty($Goods)) $recommendGoods=array_slice($Goods,0,4);//精选推荐商品
        if (!empty($GoodsAdv)) $recommendGoodsAdv=array_slice($GoodsAdv,0,4);//精选推荐商品
        
        $tmLeftTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_TM_LEFT_TOP,0,1); //品牌特卖左上方图
        $tmMiddleTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_TM_MIDDLE_TOP,0,1); //品牌特卖中上方图
        $tmRightTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_TM_RIGHT_TOP,0,1); //品牌特卖右上方图
        if (!empty($Goods)) $tmGoods=array_slice($Goods,4,5);//品牌特卖商品  
        if (!empty($GoodsAdv)) $tmGoodsAdv=array_slice($GoodsAdv,4,5);//品牌特卖商品
        
        $czLeftTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_CZ_LEFT_TOP,0,1); //盖象超值左上方图
        $czLeftUnderAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_CZ_LEFT_UNDER,0,1); //盖象超值左下方图
        $czMiddleTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_CZ_MIDDLE_TOP,0,1); //盖象超值中上方图
        $czRightTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_CZ_RIGHT_TOP,0,1); //盖象超值右上方图
        if (!empty($Goods)) $czGoods=array_slice($Goods,9,4);//盖象超值商品   
        if (!empty($GoodsAdv)) $czGoodsAdv=array_slice($GoodsAdv,9,4);//盖象超值商品
        
        $msLeftTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_MS_LEFT_TOP,0,1); //发现美食左上方图
        $msMiddleTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_MS_MIDDLE_TOP,0,1); //发现美食中上方图
        $msRightTopAdver = Advert::getChannelIndexAdver(Advert::CHANNEL_MS_RIGHT_TOP,0,1); //发现美食右上方图
        if (!empty($Goods)) $msGoods=array_slice($Goods,13,5);//发现美食商品
        if (!empty($GoodsAdv)) $msGoodsAdv=array_slice($GoodsAdv,13,5);//发现美食商品
        
        $this->render('autotrophychannel',array(
            'autotrophyAdver' => $autotrophyAdver,
            'ownAdver' => $ownAdver,
            'recommendLeftTopAdver' => $recommendLeftTopAdver,
            'recommendLeftUnderAdver' => $recommendLeftUnderAdver,
            'recommendMiddleTopAdver' => $recommendMiddleTopAdver,
            'recommendRightTopAdver' => $recommendRightTopAdver,
            'tmLeftTopAdver' => $tmLeftTopAdver,
            'tmMiddleTopAdver' => $tmMiddleTopAdver,
            'tmRightTopAdver' => $tmRightTopAdver,
            'czLeftTopAdver' => $czLeftTopAdver,
            'czLeftUnderAdver' => $czLeftUnderAdver,
            'czMiddleTopAdver' => $czMiddleTopAdver,
            'czRightTopAdver' => $czRightTopAdver,
            'msLeftTopAdver' => $msLeftTopAdver,
            'msMiddleTopAdver' => $msMiddleTopAdver,
            'msRightTopAdver' => $msRightTopAdver,
            'recommendGoods' => $recommendGoods,
            'czGoods' => $czGoods,
            'tmGoods' => $tmGoods,
            'msGoods' => $msGoods,
            'recommendGoodsAdv' => $recommendGoodsAdv,
            'czGoodsAdv' => $czGoodsAdv,
            'tmGoodsAdv' => $tmGoodsAdv,
            'msGoodsAdv' => $msGoodsAdv,
        ));
    }

}