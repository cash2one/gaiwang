<?php

/**
 * 商家店铺控制器
 */
class ShopController extends Controller {

    public $layout = 'store';
    public $defaultAction = 'view';
    // 商家属性
    public $store;
    
    // 新品上架显示的条数

    const NEWEST_NUM = 4;
    // 商家店铺首页幻灯片广告条数
    const STORE_SLIDE_NUM = 5;
    // 商家店铺首页商品广告条数
    const STORE_AD_NUM = 3;
    //店铺装修数据
    public $design;

    /**
     * 获取商家信息
     */
    public function beforeAction($action) {
        $this->store = Store::model()->findByPk($this->getParam('id'));
        if (empty($this->store) || !in_array($this->store->status,array(Store::STATUS_ON_TRIAL,Store::STATUS_PASS)))
            throw new CHttpException(400, Yii::t('shop', '没有找到相应的店铺信息'));
        //店铺装修数据
        if($this->action->id=='preview'){
            return parent::beforeAction($action);
        }
        // 设置面包屑
        $this->breadcrumbs = self::_scateBreadcrumb($this->getParam('id'),$this->getParam('cid'), array('/shop/product')); 
        $res = Design::getPass($this->store->id);
        if (empty($res)) {
            $data = '';
        }else{
            $data = $res['data'];
        }
        $this->design = new DesignFormat($data);
        return parent::beforeAction($action);
    }

    /**
     * 店铺首页,首页的展示，是在店铺装修中设置的
     *
     */
    public function actionView() {
        $this->_renderView();
    }

    /**
     * 店铺预览
     * @throws CHttpException
     */
    public function actionPreview($tmpId) {
        if($this->getSession('storeId')!=$this->store->id){
            throw new CHttpException(403,Yii::t('shop','您没有权限预览店铺，请登录卖家平台！'));
        }
        $model = Design::model()->findByPk($tmpId);
        $this->design = new DesignFormat($model->data);
        $this->_renderView();
    }
    
	/**
     * 店铺预览  不做权限限制  供后台使用    by csj
     * @throws CHttpException
     */
    public function actionPreviewBackend($tmpId) {
//        if($this->getSession('storeId')!=$this->store->id){
//            throw new CHttpException(403,Yii::t('shop','您没有权限预览店铺，请登录卖家平台！'));
//        }
        $model = Design::model()->findByPk($tmpId);
        $this->design = new DesignFormat($model->data);
        $this->_renderView();
    }

    /**
     * 店铺首页的公共方法，店铺首页+店铺装修预览
     */
    private  function _renderView(){
        $design = $this->design;
        $this->pageTitle = $this->store->name . '_' . Yii::app()->name;
        $this->keywords = $this->store->keywords . '_' . Yii::app()->name;
        $this->description = $this->store->description . '_' . Yii::app()->name;
        $this->render('index', compact('design'));
    }

    /**
     * 所有商品展示
     */
    public function actionProduct() {
        $args = $this->_uriProductParams();
        $params = Tool::requestParamsDispose($args);
        $params['id'] = $this->store->id;
        $criteria = new CDbCriteria();
        $criteria->select='t.id,t.name,t.thumbnail,t.price,t.sales_volume,at.status AS at_status';
        $criteria->join='LEFT JOIN {{activity_tag}} AS at ON t.activity_tag_id = at.id';
        $criteria->condition='t.store_id= '.$this->store->id.' AND t.life='.Goods::LIFE_NO.' AND t.is_publish='.Goods::PUBLISH_YES.' AND t.status='.Goods::STATUS_PASS;
        $criteria->order='update_time DESC';
        $criteria = $this->_criteriaDispose($criteria, $params);  // CDbCriteria 处理
        $count = Goods::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 20;
        $pager->applyLimit($criteria);
        $goods = Goods::model()->findAll($criteria);
        //处理售价显示 binbin.liao
        foreach($goods as &$g){
            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
            if($g->join_activity == Goods::JOIN_ACTIVITY_YES && !empty($g->activity_tag_id) && $g->at_status == ActivityTag::STATUS_ON){
                $g->price = $g->gai_sell_price;
            }
        }
        $this->render('product', array('goods' => $goods, 'params' => $params, 'count'=>$count,'pages' => $pager));
    }

    /**
     * CDbCriteria 处理
     * @param object $criteria
     * @param array $params      
     * @return object CDbCriteria      CDbCriteria Object
     */
    private function _criteriaDispose($criteria, $params) {
        if (!is_array($params) && empty($params))
            return $criteria;
        extract($params);
        $actionId = $this->getAction()->id;
        if ($actionId == 'view') {
            if (!empty($keyword))
                $criteria->compare('name', $keyword, true);
        }
        //if ($max > 0 && ($max > $min)) {
        if (($max > $min) || ($min > 0 && $max <=0)) {
            if(Yii::app()->theme){
                if($max)
                    $criteria->addBetweenCondition("price", $min, $max);
                else
                    $criteria->compare("price", ">=" . $min);
            } else {
            $memberType = MemberType::fileCache();
            $userType = Yii::app()->user->getState('typeId');
            // 获取会员积分比率
            $rate = $memberType['default'] > 0 ? $memberType['default'] : 1;
            if (isset($memberType[$userType]))
                $rate = $memberType[$userType];
            //$criteria->addBetweenCondition("price / {$rate}", $min, $max);//积分范围搜索
            $criteria->addBetweenCondition("price", $min, $max);//现金范围搜索
          }
        }
        if ($actionId == 'product') {
            // 带上分类ID 如果是父类，则查出所有该父类下所有子类的商品
            if ($cid) {
                $cateArr[]=$cid;
                $category = Scategory::model()->findByPk($cid, 'status = :status', array(':status' => Scategory::STATUS_USING));
                if(!empty($category) && $category->parent_id==0){
                   $allCate=Scategory::model()->findAll('parent_id=:pid AND status = :status',array(':pid'=>$cid,':status' => Scategory::STATUS_USING));
                   if(!empty($allCate)){
                       unset($cateArr);
                       foreach($allCate as $k =>$v){
                           $cateArr[$k]=$v['id'];
                           array_push($cateArr, $cid);
                       }
                   }
                }
                //$pid = !$category ? 0 : $category->parent_id;
                $criteria->addInCondition('scategory_id', $cateArr);
            }
            $sort = Tool::findSortValue($this->_uriProductParams(), $order);
            if (!empty($sort))
                $criteria->order = $sort;
        }
        return $criteria;
    }

    /**
     * 定义URI参数标准   view 控制器用
     * @return array    返回规范参数
     */
    protected function _uriParamsCriterion() {
        return array(
            'id' => 0,
            'keyword' => '',
            'min' => 0,
            'max' => 0,
        );
    }

    /**
     * 定义URI参数标准   product 控制器用
     * @return array    返回规范参数
     */
    protected function _uriProductParams() {
        return array(
            'id' => 0,
            'cid' => 0, // 分类ID
            'min' => 0,
            'max' => 0,
            'order' => array(
                'sales_volume' => array(
                    'text' => Yii::t('shop','销量'),
                    'defaultValue' => 1,
                    1 => 'sales_volume DESC'
                ),
                'price' => array(
                    'defaultValue' => 3,
                    'text' => Yii::t('shop','价格'),
                    2 => 'price ASC',
                    3 => 'price DESC'
                ),
                'comments' => array(
                    'defaultValue' => 4,
                    'text' => Yii::t('shop','评论'),
                    4 => 'comments DESC'
                ),
               'views' => array(
                    'defaultValue' => 5,
                    'text' => Yii::t('shop','浏览量'),
                    5 => 'views DESC'
                    ),
               'update_time' => array(
                    'defaultValue' => 6,
                    'text' => Yii::t('shop','上架时间'),
                    6 => 'update_time DESC'
                    ),
            ),
        );
    }

    /**
     * 商家介绍
     */
    public function actionInfo() {
        $this->pageTitle = $this->store->name . Yii::t('shop', '-商家介绍-') . $this->pageTitle;
        $this->render('info', array('design' => $this->design->tmpData[DesignFormat::TMP_LEFT_CONTACT],
            'goodsCount' => Goods::CountSalesGoods($this->store->id)));
    }

    /**
     * 实体店
     */
    public function actionStore(){
        $this->pageTitle = '实体店介绍_'.$this->pageTitle;
        $this->render('store');
    }

    /**
     * 实体店预览
     * @param $tmpId
     * @throws CHttpException
     */
    public function actionStorePreview($tmpId){
        $this->pageTitle = '实体店介绍_'.$this->pageTitle;
        if($this->getSession('storeId')!=$this->store->id){
            throw new CHttpException(403,Yii::t('shop','您没有权限预览店铺，请登录卖家平台！'));
        }
        $model = Design::model()->findByPk($tmpId);
        $this->design = new DesignFormat($model->data);
        $this->render('store');
    }
    
    
	/**
     * 实体店预览   后台使用   by csj
     * @param $tmpId
     * @throws CHttpException
     */
    public function actionStorePreviewBackend($tmpId){
        $this->pageTitle = '实体店介绍_'.$this->pageTitle;

        $model = Design::model()->findByPk($tmpId);
        $this->design = new DesignFormat($model->data);
        $this->render('store');
    }

    /**
     * 店铺文章
     * @param $aid 文章id
     * @throws CHttpException
     */
    public function actionArticle($aid){
        /** @var $model StoreArticle */
        $model = StoreArticle::model()->findByPk($aid);
        if(!$model)  throw new CHttpException(404);
        if($model->status!=StoreArticle::STATUS_THROUGH){
            throw new CHttpException(403,Yii::t('shop','文章尚未审核！'));
        }
        $this->pageTitle = $model->title.'_'.$this->pageTitle;
        $this->render('article',array('model'=>$model));
    }
    
    /**
     * 店铺分类面包屑
     * @param int $catid 店铺分类Id
     * @param mixed $url CHtml::normalizeUrl()
     * @return array
     */
    public static function _scateBreadcrumb($store_id,$catid, $url = array()) {
        $scate =Scategory::scategoryInfo($store_id);
        $bradcrumb = array();
        if(empty($scate)) return array();
         foreach($scate as $k => $v){
              if($v['id']==$catid && $v['parent_id']==0){
                        $bradcrumb = array(Yii::t('scategory', $v['name']));
              }else if($v['id']!=$catid && !empty($v['child'])){
                        foreach($v['child'] as $c){
                            if($c['id']==$catid && $c['parent_id']!=0){
                            $bradcrumb = array(
                                    Yii::t('scategory', $v['name']),
                                    Yii::t('scategory', $c['name'])
                            );
                        } 
                    }
              }           
         } 
        return $bradcrumb;
    }

}
