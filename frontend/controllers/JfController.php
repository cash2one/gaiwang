<?php

/**
 * 积分兑换控制器
 * 
 */
class JfController extends Controller {

    public $layout = 'main';
    public $defaultAction = 'list';
    public $seo;

    public function beforeAction($action) {
        throw new CHttpException(404); //v2.0 废止
        //设置seo
        $seo = $this->getConfig('seo');
        $this->pageTitle = $seo['jfTitle'];
        $this->keywords = $seo['jfKeyword'];
        $this->description = $seo['jfDescription'];
        Yii::app()->setTheme(null);
        return parent::beforeAction($action);
    }

    public function actionList() {
        $args = $this->_uriParamsCriterion();
        $params = Tool::requestParamsDispose($args);

        $criteria = new CDbCriteria(array(
            'select' => 't.id, t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id, t.category_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id',
            'condition' => 't.status = :status And t.is_publish = :push and t.life=:life And t.is_score_exchange = :is_score_exchange',
            'order' => 't.update_time DESC',
            'params' => array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES,':life'=>Goods::LIFE_NO,':is_score_exchange' => Goods::IS_SCORE_EXCHANGE)
        ));
        $cid = $params['cid'];  // 分类ID
        if ($cid > 0) {
            $treeCategory = Category::treeCategory();
            $categoryIndex = Category::categoryIndexing();
            if (!isset($categoryIndex[$cid]))
                throw new CHttpException(404, '请求的页面不存在');
            $categoryIds = '';
            switch ($categoryIndex[$cid]['type']) {
                case 1:
                    $category = $treeCategory[$cid];
                    $categoryIds = $this->_formatCategory($category);
                    break;
                case 2:
                    $category = $treeCategory[$categoryIndex[$cid]['parentId']];
                    $categoryIds = $this->_formatCategory($treeCategory[$categoryIndex[$cid]['parentId']]['childClass'][$cid]);
                    break;
                default:
                    $category = $treeCategory[$categoryIndex[$cid]['grandpaId']];
                    $categoryIds = array($cid);
                    break;
            }
            $criteria->addInCondition('category_id', $categoryIds);
        } else {
            $allCategoryCache = Category::treeCategory();   // 获取分类树
            $allCategoryCache = array_splice($allCategoryCache, 0, 14);//限前14位的主分类
            $category = array();
            foreach ($allCategoryCache as $v)   // 获取顶级分类 
                array_push($category, array('id' => $v['id'], 'name' => $v['name']));
        }
        $criteria = $this->_criteriaDispose($criteria, $params);  // CDbCriteria 处理

        //整理和添加活动相关条件
        $activityRs = Yii::app()->db->createCommand()->select('id,status')
            ->from('{{activity_tag}}')
            ->queryAll();
        $treeAct = array();//活动的ID和状态
        foreach($activityRs as $v){
            $treeAct[$v['id']] = $v['status'];
        }

        //查出数据
        $count = Goods::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 25;
        $pager->applyLimit($criteria);
        $goods = Goods::model()->findAll($criteria);

        //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
        foreach($goods as &$g){
            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
            if($g->join_activity == Goods::JOIN_ACTIVITY_YES && !empty($g->activity_tag_id) && $treeAct[$g->activity_tag_id] == ActivityTag::STATUS_ON){
                $g->price = $g->gai_sell_price;
            }
            //如果参加专题活动.
            $sp = Goods::getZtPrice($g);
            if($sp['isOk']){
                $g->price = $sp['price'];
            }
        }


        // 热门推荐
        $hotRecom = Yii::app()->db->createCommand()->select('g.id, g.name, g.thumbnail, g.price, g.return_score,g.gai_sell_price,g.join_activity,g.activity_tag_id')
                ->from('{{goods}} g')
                ->where('g.status = :status And g.is_publish = :push and g.life=:life', array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES,':life'=>Goods::LIFE_NO))
                ->order('g.create_time DESC')
                ->limit(5);

        if ($cid > 0)
            $hotRecom->andWhere(array('in', 'g.category_id', $categoryIds));
        $hotRecom = $hotRecom->queryAll();

        //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
        foreach ($hotRecom as &$g) {
            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
            if ($g['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($g['activity_tag_id']) && $treeAct[$g['activity_tag_id']] == ActivityTag::STATUS_ON) {
                $g['price'] = $g['gai_sell_price'];
            }
        }
        // 最近销售
        $sells = $cid > 0 ? Order::recentlySell(array('in', 'g.category_id', $categoryIds)) : Order::recentlySell();
        //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
        foreach ($sells as &$g) {
            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
            if ($g['join_activity'] == Goods::JOIN_ACTIVITY_YES && !empty($g['activity_tag_id']) && $g['at_status'] == ActivityTag::STATUS_ON) {
                $g['price'] = $g['gai_sell_price'];
            }
        }

        $this->render('index', compact('pager', 'goods', 'category', 'cid', 'params', 'hotRecom', 'sells'));
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
        if ($max > 0 && ($max > $min)) {
            $memberType = MemberType::fileCache();
            $userType = Yii::app()->user->getState('typeId');
            // 获取会员积分比率
            $rate = $memberType['default'] > 0 ? $memberType['default'] : 1;
            if (isset($memberType[$userType]))
                $rate = $memberType[$userType];
            $criteria->addBetweenCondition("price / {$rate}", $min, $max);
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
        return array(
            'cid' => 0,
            'min' => 0,
            'max' => 0,
            'order' => array(
                'sales_volume' => array(
                    'text' => Yii::t('shop','销量'),
                    'defaultValue' => 1,
                    1 => 'sales_volume DESC'
                ),
                'price' => array(
                    'defaultValue' => 2,
                    'text' => Yii::t('shop','价格'),
                    2 => 'price ASC',
                    3 => 'price DESC'
                ),
                'comments' => array(
                    'defaultValue' => 4,
                    'text' => Yii::t('shop','评论'),
                    4 => 'comments DESC'
                ),
            ),
        );
    }

    /**
     * 格式化分类
     * 提取出分类下的所有子分类
     * @param array $category
     * @return array
     */
    private function _formatCategory($category) {
        $cate = array();
        if (isset($category['childClass'])) {
            foreach ($category['childClass'] as $value) {
                array_push($cate, $value['id']);
                if (isset($value['childClass'])) {
                    foreach ($value['childClass'] as $v)
                        array_push($cate, $v['id']);
                }
            }
        }
        return $cate;
    }

}
