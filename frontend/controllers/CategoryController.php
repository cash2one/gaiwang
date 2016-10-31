<?php

/**
 * 商品分类控制器
 * @author jianlin.lin <hayeslam@163.com>
 */
class CategoryController extends Controller {

    public $layout ='main';
    public $defaultAction = 'view';
    public $id;     // 分类ID
    public $seo;
    public $category_id;//顶级栏目ID
    //public $searchAttribut=array(); //搜索属性

    public function beforeAction($action) {
        $this->category_id = $this->id = $this->getParam('id');
        if (!$categorys = $this->cache(Category::CACHEDIR)->get(Category::CK_ALLCATEGORY))
            $categorys = Category::allCategoryData();
        if (!isset($categorys[$this->id]))
            throw new CHttpException(404, Yii::t('category', "访问出错！"));
        // 设置面包屑
        $this->breadcrumbs = Tool::categoryBreadcrumb($this->id, array('/category/view'));
        //设置seo 根据不同类型设置不同的TDK
        $seo = $categorys[$this->id];
        //如果2,3栏目和订单栏目相同，则用下面的代码
//        if(Category::PARENT_ID != $seo['parent_id']){
//            $id = explode('|', $seo['tree']);
//            $seo = $categorys[$id[0]];
//        }
        $this->Pagetitle = $seo['title'];
        $this->keywords = $seo['keywords'];
        $this->description = $seo['description'];

        return parent::beforeAction($action);
    }

    /**
     * 分类搜索列表
     * @param type $id
     */
    public function actionView() {
        $id = $this->id;
        $category = Category::findChildCategoryElement($id);
        $get = $_GET; //获取商家所有的get请求
        
        //判断该分类是否为顶级分类
        $parentID = Yii::app()->db->createCommand()->select('parent_id')->from('{{category}}')->where('id=:id',array(':id'=>$id))->queryScalar();
        if($parentID == Category::PARENT_ID) {
            $cids = $this->_childClassId($this->id);
        }else{
            $cids = $this->_formatCategory($category);
        }
        // 获取URI参数标准
        $args = $this->_uriParamsCriterion();
        $params = Tool::requestParamsDispose($args);
        $searchAttribute = array_diff($get, $params);
        $searchAttribute = $this->magicQuotes($searchAttribute);
        $cache_id=implode($get, '-');
        $criteria = new CDbCriteria(array(
            //'select' => 't.id, t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id, t.category_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id,at.status AS at_status',
//            'select' => 't.id,t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id,t.category_id,c.status as at_status, c.category_id as active_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id,t.seckill_seting_id,s.id as sid,s.name as sname',
            'select' => 't.id,t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id,t.category_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.seckill_seting_id,t.store_id',
//            'join' => '
//                LEFT JOIN {{store}} AS s ON t.store_id = s.id ',
//                LEFT JOIN  {{seckill_product_relation}} AS c ON t.id=c.product_id
//                LEFT JOIN {{seckill_rules_seting}} AS r ON r.id = t.seckill_seting_id
//                LEFT JOIN {{seckill_rules_main}} as m ON m.id = r.rules_id
             
//            'with'=>array(
//                'goodsPicture'=>array('select'=>'path')
//            ),
            'condition' => 't.status = :status And t.is_publish = :push and t.life=:life',
            'order' => 't.sort DESC,t.sales_volume DESC', //默认排序即综合排序 
            'params' => array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES, ':life' => Goods::LIFE_NO)
        ));

        if (Yii::app()->theme) {
            //还有其他属性处理
            if (isset($searchAttribute['brand_id'])) {
                $brand_id = explode(',', $searchAttribute['brand_id']);
                $criteria->addInCondition('t.brand_id', $brand_id);
            }
            if (isset($params['freight_payment_type']) && !empty($params['freight_payment_type'])) {
                $criteria->compare('t.freight_payment_type', Goods::FREIGHT_TYPE_SELLER_BEAR);
            }
            if(isset($params['seckill_seting_id']) && !empty($params['seckill_seting_id'])) {
                $criteria->compare('t.seckill_seting_id', '>'. Goods::JOIN_ACTIVITY_NO);
//                $criteria->compare('c.status',SeckillProductRelation::STATUS_PASS);
                $criteria->compare('m.date_end', '>'.date('Y-m-d H:i:s'));
                $criteria->compare('c.status', SeckillProductRelation::STATUS_PASS);
                $criteria->compare('r.status', SeckillRulesSeting::BEGINING);
//                $criteria->compare('r.status', SeckillRulesSeting::BEGINING);
            }
        }
        $criteria->addInCondition('t.category_id', $cids);
        $criteria = $this->_criteriaDispose($criteria, $params);  // CDbCriteria 处理

        //2016-3-18 将查询出的语句设置缓存，有效时间为4个小时
        $info = Tool::cache('category_goods')->get('category_goodsList_'.$cache_id);
        //$info=false;
        if($info){
            $categoryGoodsArr=$info;
        }else{
            //产品查询。
            $dataProvider = new CActiveDataProvider( new Goods(DbCommand::DB),array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>60,
                    'pageVar'=>'page'
                ),
            ));
           /*  $pager = $dataProvider->getPagination();
            $goods = $dataProvider->getData();
            $goodsCount = $dataProvider->getTotalItemCount(); */
            $categoryGoodsArr=array();
            $categoryGoodsArr['pager']=$dataProvider->getPagination();
            $categoryGoodsArr['goods']=$dataProvider->getData();
            $categoryGoodsArr['goodsCount']=$dataProvider->getTotalItemCount();
            Tool::cache('category_goods')->set('category_goodsList_'.$cache_id, $categoryGoodsArr, 60*60*4); 

//        //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
//        foreach($goods as &$g){
//            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
//            if($g->join_activity == Goods::JOIN_ACTIVITY_YES && !empty($g->activity_tag_id) && $g->at_status == ActivityTag::STATUS_ON){
//                $g->price = $g->gai_sell_price;
//            }
//        }
//        $this->pageTitle =  $category[$id]['name'] .'_'.$this->pageTitle;
     }
     
         $pager = $categoryGoodsArr['pager'];
         $goods = $categoryGoodsArr['goods'];
         $goodsCount = $categoryGoodsArr['goodsCount'];
     
        if($this->isAjax()){
            $p = array_merge($searchAttribute,$params);
            $search = $this->renderPartial('_search',array('searchAttribute'=>$searchAttribute,'params'=>$params,'p'=> $p),true);
            $goodslist =  $this->renderPartial('_goodslist',array('p'=>$p,'params'=>$params,'pager'=>$pager,'searchAttribute'=>$searchAttribute,'goods'=>$goods),true);
            $sort = $this->renderPartial('_sort',array('p'=>$p,'params'=>$params,'searchAttribute'=>$searchAttribute,'pager'=>$pager),true);
            $pagelist = $this->renderPartial('_pager',array('pager'=>$pager),true);
            exit(json_encode(array('goodsCount'=>$goodsCount,'search'=>$search,'goodslist'=>$goodslist,'pagelist'=>$pagelist,'sort'=>$sort)));
        } else{
            $this->render('view', compact('id', 'sales', 'hotBrands', 'params', 'goodsCount', 'pager', 'goods','searchAttribute'));   
        }
    }

    /**
     * 分类列表页 （顶级分类的情况下）
     */
    public function actionList() {
        $id = $this->id;
        $cids = $this->_childClassId($this->id);
        $get = $_GET; //获取商家所有的get请求
//        var_dump($get);
        // 顶级分类不存在的情况下跳转view action
        if (empty($cids)){
            array_unshift($get,'view');
            $this->redirect($get);
        }
        if(!Yii::app()->theme) $sales = $this->_getTop3($cids);
        //$hotBrands = $this->_getHotBrands($cids);
        // 获取URI参数标准
        $args = $this->_uriParamsCriterion();
        $params = Tool::requestParamsDispose($args);
        // 差集得到属性。。。搜索
        $searchAttribute = array_diff($get, $params);
        $searchAttribute = $this->magicQuotes($searchAttribute);
        $cache_id=implode($get, '-');
        $criteria = new CDbCriteria(array(
            //'select' => 't.id, t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id, t.category_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id,at.status AS at_status',
            //'select' => 't.id,t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id,t.category_id, m.date_end as end_time,c.status as at_status, c.category_id as active_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id,t.seckill_seting_id,s.id as sid,s.name as sname',
            'select' => 't.id,t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id,t.category_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.seckill_seting_id,t.store_id',
//            'join'=>'            
//            LEFT JOIN {{store}} AS s ON t.store_id = s.id ',
//            LEFT JOIN  {{seckill_product_relation}} AS c ON t.id=c.product_id
//            LEFT JOIN {{seckill_rules_seting}} AS r ON r.id = t.seckill_seting_id
//            LEFT JOIN {{seckill_rules_main}} as m ON m.id = r.rules_id
//            'with'=>array(
//                'goodsPicture'=>array('select'=>'path')
//            ),
            'condition' => 't.status = :status And t.is_publish = :push and t.life=:life',
            'order' => 't.sort DESC,t.sales_volume DESC', //默认排序即综合排序  sales_volume销量  
            'params' => array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES,':life'=>Goods::LIFE_NO )
        ));

        //统一考虑，产品属性
        if(Yii::app()->theme){
            //还有其他属性处理
            if(isset($searchAttribute['brand_id'])){
                $brand_id = explode(',', $searchAttribute['brand_id']);
                $criteria->addInCondition('t.brand_id', $brand_id);
            }
            if(isset($params['freight_payment_type']) && !empty($params['freight_payment_type'])){
                $criteria->compare('t.freight_payment_type',  Goods::FREIGHT_TYPE_SELLER_BEAR);
            }
            //v2.0是否参加活动单独处理
//            if(isset($params['seckill_seting_id']) && !empty($params['seckill_seting_id'])) {
//                $criteria->compare('t.seckill_seting_id', '>'. Goods::JOIN_ACTIVITY_NO);
////                $criteria->compare('c.status',SeckillProductRelation::STATUS_PASS);
//                $criteria->compare('m.date_end', '>'.date('Y-m-d'));
//                $criteria->compare('c.status', SeckillProductRelation::STATUS_PASS);
//                $criteria->compare('r.status', SeckillRulesSeting::BEGINING);
//            }
//            if(isset($params['join_activity']) && !empty($params['join_activity'])){
//                $criteria->compare('t.join_activity',  Goods::JOIN_ACTIVITY_YES);
//            }
        }
        $criteria->addInCondition('t.category_id', $cids);
        $criteria = $this->_criteriaDispose($criteria, $params);  // CDbCriteria 处理
        //2016-3-18 将查询出的语句设置缓存，有效时间为4个小时
        $info = Tool::cache('category_goods')->get('category_goodsList_'.$cache_id);
        //$info=false;
        if($info){
            $categoryGoodsArr=$info;
        }else{
            $dataProvider = new CActiveDataProvider( new Goods(DbCommand::DB),array(
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>60,
                    'pageVar'=>'page',
                ),
            ));
           /*  $pager = $dataProvider->getPagination();
            $goods = $dataProvider->getData();
            $goodsCount = $dataProvider->getTotalItemCount(); */
            $categoryGoodsArr=array();
            $categoryGoodsArr['pager']=$dataProvider->getPagination();
            $categoryGoodsArr['goods']=$dataProvider->getData();
            $categoryGoodsArr['goodsCount']=$dataProvider->getTotalItemCount();
            Tool::cache('category_goods')->set('category_goodsList_'.$cache_id, $categoryGoodsArr, 60*60*4);
            
//        exit;
//        //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
//        foreach($goods as &$g){
//            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
//            if($g->join_activity == Goods::JOIN_ACTIVITY_YES && !empty($g->activity_tag_id) && $g->at_status == ActivityTag::STATUS_ON){
//                $g->price = $g->gai_sell_price;
//            }
//        }
     }
     
     $pager = $categoryGoodsArr['pager'];
     $goods = $categoryGoodsArr['goods'];
     $goodsCount = $categoryGoodsArr['goodsCount']; 
     $this->render('list', compact('id', 'sales', 'hotBrands', 'params', 'goodsCount', 'pager', 'goods','searchAttribute'));
    
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
        if (($max > $min) || ($min > 0 && $max <=0)) {
            if(Yii::app()->theme){
                if($max)
                    $criteria->addBetweenCondition("price", $min, $max);
                else
                    $criteria->compare("price", ">=" . $min);
            } else {
    //        if ($max > 0 && ($max > $min)) {//这种写法,缺少只填写最小值无最大值的情况
                $memberType = MemberType::fileCache();
                $userType = Yii::app()->user->getState('typeId');
                // 获取会员积分比率
                $rate = $memberType['default'] > 0 ? $memberType['default'] : 1;
                if (isset($memberType[$userType]))
                    $rate = $memberType[$userType];
                if($max)
                    $criteria->addBetweenCondition("price / {$rate}", $min, $max);
                else
                    $criteria->compare("price / {$rate}", ">=" . $min);
            }
        }
        $sort = Tool::findSortValue($this->_uriParamsCriterion(), $order);
        if (!empty($sort))
            $criteria->order = $sort;
        return $criteria;
    }

    /**
     * 定义URI参数标准
     * @return array    返回规范参数
     */
    protected function _uriParamsCriterion() {
        if(Yii::app()->theme){
            return array(
                'id' => 0,
                'min' => 0,
                'max' => 0,
                'seckill_seting_id'=>'',
                'freight_payment_type'=>'',
                'order' => array(
                    'views' => array(
                        'text' => Yii::t('category', '浏览量'),
                        'defaultValue' => 1,
                        1 => 't.views DESC'
                    ),
                    'price' => array(
                        'defaultValue' => 3,
                        'text' => Yii::t('category', '价格'),
                        2 => 't.price ASC',
                        3 => 't.price DESC'
                    ),
                    'audit_time' => array(
                        'defaultValue' => 4,
                        'text' => Yii::t('category', '上架时间'),
                        4 => 't.audit_time DESC'
                    ),
                ),
            );
        } else {
            return array(
                'id' => 0,
                'min' => 0,
                'max' => 0,
                'order' => array(
                    'sales_volume' => array(
                        'text' => Yii::t('category', '销量'),
                        'defaultValue' => 1,
                        1 => 'sales_volume DESC'
                    ),
                    'price' => array(
                        'defaultValue' => 3,
                        'text' => Yii::t('category', '价格'),
                        2 => 'price ASC',
                        3 => 'price DESC'
                    ),
                    'comments' => array(
                        'defaultValue' => 4,
                        'text' => Yii::t('category', '评论'),
                        4 => 'comments DESC'
                    ),
                ),
            );
        }
    }

    /**
     * 格式化化分类
     * 提取出分类下的所有子分类
     * @param array $category
     * @return array
     */
    public function _formatCategory($category) {
        $cate = array();
        foreach ($category as $value) {
            array_push($cate, $value['id']);
            if (isset($value['childClass'])) {
                foreach ($value['childClass'] as $v) {
                    array_push($cate, $v['id']);
                    if (isset($v['childClass'])) {
                        foreach ($v['childClass'] as $child)
                            array_push($cate, $child['id']);
                    }
                }
            }
        }
        return $cate;
    }

    /**
     * 获取所有子类ID (暂时用)
     * @param type $id
     * @return type
     */
    public function _childClassId($id) {
        if (!$tree = Tool::cache(Category::CACHEDIR)->get(Category::CK_TREECATEGORY))
            $tree = Category::treeCategory();
        $data = array();
        if (isset($tree[$id])) {
            $classArr = $tree[$id];
            $data[] = $classArr['id'];
            if (isset($classArr['childClass'])) {
                $childKeys = array_keys($classArr['childClass']);
                $data = array_merge($data, $childKeys);
                foreach ($classArr['childClass'] as $v) {
                    if (isset($v['childClass'])) {
                        $childKeys = array_keys($v['childClass']);
                        $data = array_merge($data, $childKeys);
                    }
                }
            }
        }
        return $data;
    }

    /**
     * 获取销售
     * @return array
     */
    private function _getTop3($cids)
    {
//        $cids = $this->_childClassId($this->id);
        $goods = Yii::app()->db->createCommand()->select('g.id, g.name, g.thumbnail, g.return_score, g.price, g.goods_spec_id,g.gai_price,g.price,g.gai_income,g.gai_sell_price,g.join_activity,g.activity_tag_id,at.status AS at_status')
            ->from('{{goods}} g')
            ->leftJoin('{{activity_tag}} at', 'g.activity_tag_id=at.id')
            ->where('g.status = :status And g.is_publish = :push and g.life=:life', array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES, ':life' => Goods::LIFE_NO))
            ->andWhere(array('in', 'g.category_id', $cids))
            ->order('g.sales_volume DESC, g.id DESC')
            ->limit(3)
            ->queryAll();
//        //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
//        foreach ($goods as &$g) {
//            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
//            if ($g['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($g['activity_tag_id']) && $g['at_status'] == ActivityTag::STATUS_ON) {
//                $g['price'] = $g['gai_sell_price'];
//            }
//        }

        return $goods;
    }

    /**
     * 热卖品牌
     * @return array
     */
    private function _getHotBrands($cids) {
//        $cids = $this->_childClassId($this->id);
        $brands = Yii::app()->db->createCommand()->select('t.id, t.name, t.logo')->from('{{brand}} as t')
                ->join('{{goods}} as g', 't.id = g.brand_id')
                ->where('t.status = :tStatus And g.status = :gStatus And is_publish = :gPush and g.life=:life', array(':tStatus' => Brand::STATUS_THROUGH, ':gStatus' => Goods::STATUS_PASS, ':gPush' => Goods::PUBLISH_YES,':life'=>Goods::LIFE_NO))
                ->andWhere(array('in', 'g.category_id', $cids))
                ->group('t.id')
                ->limit(9)
                ->queryAll();
        return $brands;
    }
    
    /**
     * 按栏目搜索品牌
     * @param int $limit 条数
     * @param boolean $is_multi 是否是多选的
     * @return 品牌数组
     */
    public function actionBrand($limit,$is_multi=false)
    {
        $brand = Yii::app()->request->getParam('brand');
        $model = new Brand('search'); 
        if(!$this->isAjax()) throw new CHttpException(404, Yii::t('category', '没有找到相应的栏目信息！'));
        $brands = Brand::getBrandInfo($this->id,$brand,$limit);
        $args = $this->_uriParamsCriterion();
        $params = Tool::requestParamsDispose($args);
        $info='';
        $msg='';
        if(!empty($brands) && is_array($brands))
         {
            $info ='<dl style="clearfix">';
            foreach ($brands as $b) {
                if($is_multi){
                    $url = 'javascript:void(0)';
                } else {
                    $params['brand_id'] = $b['id'];
                    $params['brand_name'] = $b['name'];
                    $url = $this->createUrl('category/list',$params);
                }
                $info .= '<dd>';
                if(empty($b['logo'])){
                    $info .= CHtml::link($b['name'],$url,array('icon'=>$b['id']));
                } else {
                    $info .= CHtml::link(CHtml::image(Tool::showImg(IMG_DOMAIN . '/' .$b['logo'],'c_fill,h_40,w_100'),$b['name'],array('width'=>100,'height'=>42,'alt'=>$b['name'])),$url,array('icon'=>$b['id']));
                }
                $info .= '<div class="gs-sel clearfix"><span></span></div></dd>';
            }
            $info .='</dl>';
            $msg=1;
        } else {
            $msg=0;
            $info = '<span>'.Yii::t('category','抱歉，没有找到相关品牌').'</span>';
        }
        exit(json_encode(array('brand'=>$info,'msg'=>$msg))); 
    }
    /**
     * 品牌多选和更多
     */
    public function actionMoreBrand()
    {
        
    }
}