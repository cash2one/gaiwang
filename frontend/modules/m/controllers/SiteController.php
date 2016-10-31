<?php

/**
 * 微商城首页控制器
 * @author wyee <yanjie@gatewang.com> 
 *
 */
class SiteController extends WController {
    
   public function actionIndex() {
        $this->footer=true;
        $this->top=true;
        $this->showTitle ='<img src="'.DOMAIN.'/images/m/bg/logo.gif" alt="盖象商城"/>';
        $advertsSlide= Advert::generateConventionalAd('Mshop-index-slide');//首页幻灯片
        $advertsBrand= Advert::generateConventionalAd('Mshop-index-brand-recommend');//品牌广告
        $advertsStore= Advert::generateConventionalAd('Mshop-index-store-adverts');//商家广告
        $brands=self::_getBrand(10);//排序前十的品牌
        $topCategory=Category::getTopCategory();//分类
        $goods=self::_getShowGoods(10);//推荐商品
        $this->render('index',array(
                'advertsSlide'=>$advertsSlide,
                'advertsBrand'=>$advertsBrand,
                'topCateroty'=>$topCategory,
                'goods'=>$goods,
                'advertsStore'=>$advertsStore, 
                'brands'=>$brands,
        ));
    }  

    public function actionError() {
        $this->top=true;
        $this->showTitle ='<img src="'.DOMAIN.'/images/m/bg/logo.gif" alt="盖象商城"/>';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
    
    public function actionAbout() {
        $this->layout = 'home';
        $this->pageTitle = Yii::t('member', '盖象微商城_公司简介');
        $this->showTitle = Yii::t('member', '公司简介');
        $this->render('about');
    }
    
    public function actionContact() {
        $this->layout = 'home';
        $this->footer=false;
        $this->pageTitle = Yii::t('member', '盖象微商城_联系我们');
        $this->showTitle = Yii::t('member', '联系我们');
        $article = Article::fileCache('contact');
        $this->render('contact',array('article' => $article));
    }
    

    /**
     * 获取推荐品牌
     */
    public static function _getBrand($limit){
        $brandArr=Brand::model()->findAll(
                array(
                        'select'=>'id,logo,name,category_id,store_id',
                        'condition'=>'status=:status',
                        'params'=>array(':status'=>Brand::STATUS_THROUGH),
                        'order'=>'sort ASC',
                        'limit'=>$limit
                ));
        return $brandArr;
    }
    
    /**
     * 获取推荐商品
     */
    public static function _getShowGoods($limit){
        $goodsArr=Goods::model()->findAll(
               array(
                       'select' => 't.id, t.name, t.thumbnail, t.price,t.sales_volume, t.brand_id, t.category_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id,at.status AS at_status',
                       'join' => 'LEFT JOIN {{activity_tag}} AS at ON t.activity_tag_id = at.id',
                       'condition' => 't.status = :status AND t.is_publish = :push AND t.life=:life AND t.`show`=:show',
                       'params' => array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES,':life'=>Goods::LIFE_NO,':show'=>'1'),
                       'order'=>'t.sort DESC',
                       'limit'=>$limit
         ));
        //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
        foreach ($goodsArr as $key => &$g) {
            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
            if ($g->join_activity == Goods::JOIN_ACTIVITY_YES && !empty($g->activity_tag_id) && $g->at_status == ActivityTag::STATUS_ON) {
                $g->price = $g->gai_sell_price;
            }
        }
        return $goodsArr;  
    }

}
