<?php

/**
 * 商家店铺控制器
 * @author wyee <yanjie@gatewang.com>
 */
class StoreController extends WController {

    public $top=true;
    // 商家属性
    public $store;

    public $design;
    
    public function beforeAction($action) {
        $this->store = Store::model()->findByPk($this->getParam('id'));
        if (empty($this->store) || !in_array($this->store->status,array(Store::STATUS_ON_TRIAL,Store::STATUS_PASS)))
            throw new CHttpException(400, Yii::t('shop', '没有找到相应的店铺信息'));
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
     * 商家介绍
     */
     public function actionIndex() {

        $this->showTitle=Yii::t('store',"商家详情");
        $design=$this->design;
        $data=Design::getGoodsListByCondition($this->store->id, $design->tmpData[DesignFormat::TMP_RIGHT_PROLIST],'',3);
        $hot=Design::getGoodsListByCondition($this->store->id,$design->tmpData[DesignFormat::TMP_LEFT_PROLIST],'',2);      
        $scate=Scategory::scategoryInfo($this->store->id);
        $scateSon=array();
        if(!empty($scate)){
          foreach ($scate as $k => $v){
             if(!empty($v['child']))
               foreach($v['child'] as $s){
                array_push($scateSon,$s);
             }
        }
         }
        
        $this->render('index',array(
                'store'=>$this->store,
                'goodsCount' => Goods::CountSalesGoods($this->store->id),
                'scategory'=>$scateSon,
                'reccomend'=>$data,
                'hot'=>$hot,
        ));
      }
      
      /**
       * 商家商品列表
       */
      public function actionProList() {
          $this->footer = true;
          $this->showTitle=Yii::t('store',$this->store->name); 
          $args = $this->_uriShopCriterion();
          $params = Tool::requestParamsDispose($args);
          $params['id'] = $this->store->id;
          $criteria = new CDbCriteria(array(
                  'select' => 't.id, t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id, t.category_id, t.scategory_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id,at.status AS at_status',
                  'join' => 'LEFT JOIN {{activity_tag}} AS at ON t.activity_tag_id = at.id',
                  'condition' => 't.store_id = ' . $this->store->id . ' AND t.life='.Goods::LIFE_NO.' AND t.is_publish = ' . Goods::PUBLISH_YES .' AND t.status=' . Goods::STATUS_PASS,
                  'order' => 't.sort DESC',
          ));
          if(!empty($params['cid'])){
              $criteria->addCondition("t.scategory_id=:sid");
              $criteria->params[':sid']=$params['cid'];
           }
          $criteria = $this->_criteriaShopDispose($criteria,$params);  // CDbCriteria 处理
          $count = Goods::model()->count($criteria);
          $pager = new CPagination($count);
          $pager->pageSize = 20;
          $pager->applyLimit($criteria);
          $goods = Goods::model()->findAll($criteria);      
          //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
        if(!empty($goods)){
            foreach ($goods as $key => &$g) {
              //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
              if ($g->join_activity == Goods::JOIN_ACTIVITY_YES && !empty($g->activity_tag_id) && $g->at_status == ActivityTag::STATUS_ON) {
                  $g->price = $g->gai_sell_price;
              }
            } 
          } 
          $this->render('prolist', array(
                  'pages'=>$pager,
                  'goods' => $goods,
                            
          ));
      }
      
      /**
       * 商家商品分类列表
       */
      public function actionScate() { 
          $this->showTitle=Yii::t('store',"商家商品分类");
          $scate=Scategory::scategoryInfo($this->store->id);
          $this->render('scate', array(
                  'store'=>$this->store,
                  'scate' => $scate,
          ));
          
      }  
      
      /**
       * CDbCriteria 处理
       * @param object $criteria
       * @param array $params
       * @return object CDbCriteria      CDbCriteria Object
       */
      public function _criteriaShopDispose($criteria, $params) {
          if (!is_array($params) && empty($params))
              return $criteria;
          extract($params);
          $sort = Tool::findSortValue($this->_uriShopCriterion(), $order);
          if (!empty($sort))
              $criteria->order = $sort;
          return $criteria;
      }
      
      /**
       * 定义URI参数标准   shop 控制器用
       * @return array    返回规范参数
       */
      public function _uriShopCriterion() {
          return array(
                  'cid' => 0, // 分类ID
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
                  ),
          );
      }    

}
