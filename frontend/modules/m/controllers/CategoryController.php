<?php

/**
 * 微商城商品分类控制器
 * @author wyee <yanjie@gatewang.com> 
 */
class CategoryController extends WController {
    
    public $top = true;

    /**
     * 商品分类首页
     * 顶级分类，二级分类，三级分类的显示
     */   
   public function actionIndex(){
       $this->layout=false;
       $TopCategory=Category::getTopCategory();
       $firstCategory=current($TopCategory);
       $id=$this->getParam('cid') ? $this->getParam('cid') : $firstCategory['id'];
       $treeCategory=Category::findChildCategoryElement($id);
       $this->render('index',array('TopCategory'=>$TopCategory,'first'=>$firstCategory['id'],'treeCategory'=>$treeCategory[$id],"cid"=>$id));  

       } 

    /**
     * 二级分类
     * 分类列表和该分类下热门推荐的商品
     */
   public function actionList(){
       $cid=$this->getParam('cid');
       if ($cid > 0) {
           $treeCategory = Category::treeCategory();
           $categoryIndex = Category::categoryIndexing();
           if (!isset($categoryIndex[$cid]))
               throw new CHttpException(404, '请求的页面不存在');
           $categoryIds = '';
           $categorylist='';
           //顶级分类
           if($categoryIndex[$cid]['type']==1){
               $this->showTitle =Yii::t('category', $categoryIndex[$cid]['name']);
               $categoryIds =array($cid);
           } else {
           $morecate=$treeCategory[$categoryIndex[$cid]['parentId']]['childClass'][$cid];
           $categoryIds = $this->_formatCategory($morecate);
           $this->showTitle =Yii::t('category', $treeCategory[$categoryIndex[$cid]['parentId']]['name']);
           $categorylist=$morecate;
           }
          // 热门推荐
          $hotRecom = Yii::app()->db->createCommand()->select('id, name,sales_volume, thumbnail, price, gai_price,return_score')
          ->from('{{goods}}')
          ->where('status = :status AND is_publish = :push AND life=:life', array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES,':life'=>Goods::LIFE_NO))
          ->order('create_time DESC')
          ->limit(2);
            $hotRecom->andWhere(array('in', 'category_id', $categoryIds));
            $hotRecom = $hotRecom->queryAll();
            
            // 获取URI参数标准
            $args = $this->_uriCategoryCriterion();
            $params = Tool::requestParamsDispose($args);
            $criteria = new CDbCriteria(array(
                    'select' => 't.id, t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id, t.category_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id,at.status AS at_status',
                    'join' => 'LEFT JOIN {{activity_tag}} AS at ON t.activity_tag_id = at.id',
                    'condition' => 't.status = :status AND t.is_publish = :push AND t.life=:life',
                    'order' => 't.sort DESC',
                    'params' => array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES,':life'=>Goods::LIFE_NO)
            ));
            array_push($categoryIds,$cid);
            $criteria->addInCondition('t.category_id', $categoryIds);
            $criteria = $this->_criteriaCategoryDispose($criteria, $params);  // CDbCriteria 处理
            $goodsCount = Goods::model()->count($criteria);
            $pager = new CPagination($goodsCount);
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
            $this->render('list',array('pages'=>$pager,'cate'=>$categorylist,'goods'=>$hotRecom,'allcategoods'=>$goods));
       }else{
           throw new CHttpException(404, '请求的页面不存在');
       }
     }
       
   /**
    * 更多二级分类
    * （根据二级分类id查出所有同级分类及相应的三级分类）
    */
  public function actionMorecate(){
      $id=$this->getParam('cid');
      $pcate=Category::categoryIndexing();
      $this->showTitle =Yii::t('category',$pcate[$id]['parentName']);
       if (empty($id))
               throw new CHttpException(404, '请求的页面不存在');
      $ci = Category::categoryIndexing();
      if (isset($ci[$id]) && $ci[$id]['type'] != 1) {
          $category = $ci[$id];
          $id = $category['type'] == 2 ? $ci[$category['parentId']]['id'] : $category['grandpaId'];//by 2014/2/22 binbin.liao修改
      }
      $treeCategory = Category::treeCategory();
      if (isset($treeCategory[$id]))
          $moreCatetory = $treeCategory[$id];
      $this->render('morecate',array('morecate'=>$moreCatetory['childClass']));       
       }

   /**
    * 三级分类下的商品
    */
  public function actionProlist(){
           $this->footer = true;
           $args = $this->_uriCategoryCriterion();
           $params = Tool::requestParamsDispose($args);
           $id=$params['cid']=$this->getParam('cid');  // 分类ID
           $this->showTitle =Yii::t('category', Category::getCategoryName($id));
           if (empty($id))
               throw new CHttpException(404, '请求的页面不存在');
           $criteria = new CDbCriteria(array(
                   'select' => 't.id, t.name, t.thumbnail, t.price, t.sales_volume, t.brand_id, t.category_id, t.goods_spec_id, t.return_score, t.gai_price, t.gai_income,t.gai_sell_price,t.join_activity,t.activity_tag_id,at.status AS at_status',
                   'join' => 'LEFT JOIN {{activity_tag}} AS at ON t.activity_tag_id = at.id',
                   'condition' => 't.status = :status AND t.is_publish = :push and t.life=:life AND t.category_id=:id',
                   'order' => 't.update_time DESC',
                   'params' => array(':status' => Goods::STATUS_PASS, ':push' => Goods::PUBLISH_YES,':life'=>Goods::LIFE_NO,':id'=>$id)
           ));
           $criteria = $this->_criteriaCategoryDispose($criteria, $params);  // CDbCriteria 处理
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
           
           $this->render('prolist',array('cgoods'=>$goods,'pages'=>$pager));
       }
  
   /**
    * 格式化分类
    * 提取出分类下的所有子分类
    * @param array $category
    * @return array
    */
  public function _formatCategory($category) {
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
       
    /**
     * CDbCriteria 处理
     * @param object $criteria
     * @param array $params      
     * @return object CDbCriteria      CDbCriteria Object
     */
    public function _criteriaCategoryDispose($criteria, $params) {
        if (!is_array($params) && empty($params))
            return $criteria;
        extract($params);
        $sort = Tool::findSortValue($this->_uriCategoryCriterion(), $order);
        if (!empty($sort))
            $criteria->order = $sort;
        return $criteria;
    }

    /**
     * 定义URI参数标准 category 控制器用
     * @return array    返回规范参数
     */
    public function _uriCategoryCriterion() {
        return array(
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