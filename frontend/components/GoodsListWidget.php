<?php
/**
 * 店铺商品列表显示
 */

class GoodsListWidget extends CWidget {
    /** @var  object 店铺数据 */
    public $design;
    public $storeId;
    public $route;
    public function run(){
        if(!empty($this->design)){
            $args = $this->_uriParamsCriterion();
            $params = Tool::requestParamsDispose($args);
            $params['id'] = $this->storeId;
            $criteria = new CDbCriteria(array(
                'condition' => 'status = ' . Goods::STATUS_PASS . ' and life='.Goods::LIFE_NO.' And is_publish = ' . Goods::PUBLISH_YES . ' And store_id = ' . $this->storeId,
                'order' => 'sales_volume DESC',
            ));
            $defined = $this->design;
            if (!empty($defined)) {
                $box['childTitle'] = $defined['TypeChildTitle'];
                $box['title'] = $defined['TypeTitle'];
                if ($defined['OrderMode'])
                    $criteria->order = Design::getOrder($defined['OrderMode']);
                if ($defined['Keywords']) {
                    $criteria->condition .= " and `name` like '%" . $defined['Keywords'] . "%'";
                }
                if ($defined['CatId']) {
                    $criteria->condition .= " and scategory_id=" . $defined['CatId'];
                }
                if ($defined['MinMoney']) {
                    $criteria->condition .= " and price>=" . ($defined['MinMoney'] * 0.9);
                }
                if ($defined['MaxMoney']) {
                    $criteria->condition .= " and price<=" . ($defined['MaxMoney'] * 0.9);
                }
                $num = $defined['ProCount'];
            }
            $criteria = $this->_criteriaDispose($criteria, $params);  // CDbCriteria 处理
            $count = Goods::model()->count($criteria);
            // 翻页
            $pager = new CPagination($count);
            $pager->pageSize = $num ? $num : 30;
            $pager->applyLimit($criteria);
            $box['goods'] = Goods::model()->findAll($criteria);
            $box['params'] = $params;
            $box['pager'] = $pager;
        
            $this->render('goodslist',array('box'=>$box));
        }
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
        	'minScore' => 0,
            'maxScore' => 0,
        );
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
        $maxScore = 0;
        $minScore = 0;
        extract($params);
        if (!empty($keyword))
            $criteria->compare('name', $keyword, true);
        if ($maxScore > 0 && ($maxScore > $minScore)) {
            $memberType = MemberType::fileCache();
            $userType = Yii::app()->user->getState('typeId');
            // 获取会员积分比率
            $rate = $memberType['default'] > 0 ? $memberType['default'] : 1;
            if (isset($memberType[$userType]))
                $rate = $memberType[$userType];
            $criteria->addBetweenCondition("price / {$rate}", $minScore, $maxScore);
        }
        return $criteria;
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
                    'text' => '销量',
                    'defaultValue' => 1,
                    1 => 'sales_volume DESC'
                ),
                'price' => array(
                    'defaultValue' => 3,
                    'text' => '价格',
                    2 => 'price ASC',
                    3 => 'price DESC'
                ),
                'comments' => array(
                    'defaultValue' => 4,
                    'text' => '评论',
                    4 => 'comments DESC'
                ),
            ),
        );
    }
} 