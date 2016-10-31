<?php

/**
 * 微商城品牌下商品控制器
 * @author wyee <yanjie@gatewang.com> 
 */
class BrandController extends WController {
    
    public $top = true;

   /**
    * 品牌下的商品
    */
  public function actionList(){
           $this->footer = true;
           $args = $this->_uriBrandCriterion();
           $params = Tool::requestParamsDispose($args);
           $id=$params['bid']=$this->getParam('bid');  // 品牌ID   
           if (empty($id))
               throw new CHttpException(404, '请求的页面存在');
           $this->showTitle =Yii::t('brand', Brand::getBrandsName($id));
           $criteria = new CDbCriteria(array(
                   'select' => 't.id, t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id, t.category_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id,at.name AS at_name,at.status AS at_status',
                   'join' => 'LEFT JOIN {{brand}} AS at ON t.brand_id = at.id',
                   'condition' => 't.status = :status AND t.is_publish = :push and t.life=:life AND t.brand_id=:id AND at.status=:at_status',
                   'order' => 't.update_time DESC',
                   'params' => array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES,':life'=>Goods::LIFE_NO,':id'=>$id,':at_status'=>Brand::STATUS_THROUGH)
           ));
           $criteria = $this->_criteriaBrandDispose($criteria, $params);  // CDbCriteria 处理
           $count = Goods::model()->count($criteria);
           $pager = new CPagination($count);
           $pager->pageSize = 20;
           $pager->applyLimit($criteria);
           $goods = Goods::model()->findAll($criteria);

           
           //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
           foreach ($goods as $key => &$g) {
               //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
               if ($g->join_activity == Goods::JOIN_ACTIVITY_YES && !empty($g->activity_tag_id) && $g->at_status == ActivityTag::STATUS_ON) {
                   $g->price = $g->gai_sell_price;
               }
           }
           
           $this->render('list',array('bgoods'=>$goods,'pages'=>$pager));
       }
       
    /**
     * CDbCriteria 处理
     * @param object $criteria
     * @param array $params      
     * @return object CDbCriteria      CDbCriteria Object
     */
    public function _criteriaBrandDispose($criteria, $params) {
        if (!is_array($params) && empty($params))
            return $criteria;
        extract($params);
        $sort = Tool::findSortValue($this->_uriBrandCriterion(), $order);
        if (!empty($sort))
            $criteria->order = $sort;
        return $criteria;
    }

    /**
     * 定义URI参数标准 category 控制器用
     * @return array    返回规范参数
     */
    public function _uriBrandCriterion() {
        return array(
            'order' => array(
                'sales_volume' => array(
                    'text' => Yii::t('brand', '销量'),
                    'defaultValue' => 1,
                    1 => 'sales_volume DESC'
                ),
                'price' => array(
                    'defaultValue' => 3,
                    'text' => Yii::t('brand', '价格'),
                    2 => 'price ASC',
                    3 => 'price DESC'
                ),
                'comments' => array(
                    'defaultValue' => 4,
                    'text' => Yii::t('brand', '评论'),
                    4 => 'comments DESC'
                ),
            ),
        );
    }

}