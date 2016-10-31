 <?php
 /**
  * 收藏商品控制器
  * @author zhizhong.liu <404597544@qq.com>
  */
class GoodsCollectController extends MController
{
    //public $layout = '//layouts/main';
    //public $member_id = $this->getUser()->gw;
    public  $gid;
       
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
        if ($max > 0 && ($max > $min)) {
            $memberType = MemberType::fileCache();
            $userType = Yii::app()->user->getState('typeId');
            // 获取会员积分比率
            $rate = $memberType['default'] > 0 ? $memberType['default'] : 1;
            if (isset($memberType[$userType]))
                $rate = $memberType[$userType];
            //$criteria->addBetweenCondition("price / {$rate}", $min, $max);//积分范围搜索
            $criteria->addBetweenCondition("price", $min, $max);//现金范围搜索
        }
        if ($actionId == 'product') {
            // 带上分类ID
            if ($cid) {
                $category = Scategory::model()->findByPk($cid, 'status = :status', array(':status' => Scategory::STATUS_USING));
                $pid = !$category ? 0 : $category->parent_id;
                $criteria->addInCondition('scategory_id', array($cid, $pid));
            }
            $sort = Tool::findSortValue($this->_uriProductParams(), $order);
            if (!empty($sort))
                $criteria->order = $sort;
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
                'create_time' => array(
                    'defaultValue' => 6,
                    'text' => Yii::t('shop','上架时间'),
                    6 => 'create_time DESC'
                ),
            ),
        );
    }
    
    /**
     * 商品收藏列表
     */
    public function actionIndex()
    {
        $args = $this->_uriProductParams();
        $params = Tool::requestParamsDispose($args);
        $params['id'] = $this->getUser()->id;
        $criteria = new CDbCriteria();
        $criteria->select='t.id,t.name,t.gai_price,t.price,t.thumbnail,g.id as store_id';
        $criteria->join='JOIN {{goods_collect}} AS g ON g.good_id=t.id';
        $criteria->condition='g.member_id= '.$this->getUser()->id.'';
        $criteria->order='g.create_time DESC';
        $criteria = $this->_criteriaDispose($criteria, $params);  // CDbCriteria 处理
        $count = Goods::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = 18;
        $pager->applyLimit($criteria);
        $goods = Goods::model()->findAll($criteria);          
        foreach($goods as &$g){
            //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
            if($g->join_activity == Goods::JOIN_ACTIVITY_YES && !empty($g->activity_tag_id) && $g->at_status == ActivityTag::STATUS_ON){
                $g->price = $g->gai_sell_price;
            }
        }       
        $this->render('index', array('goods' => $goods, 'count'=>$count,'pages' => $pager));        
    }

    /**
     * 收藏商品
     * **/
    public function actionCollect()
    {
        $model = new GoodsCollect('search');
        $model->unsetAttributes();  // clear any default values 
        $data = array('success' => false, 'type' => 2, 'msg' => '收藏失败！');
        $cb = $this->getParam('jsoncallBack');
        if (!$this->user->id) {
            $data['msg'] = Yii::t('Collect', '您还没有登录，请先登录！');
            exit($cb ? $cb . '(' . json_encode($data) . ')' : json_encode($data));
        }
        if (isset($_GET['id'])) {
            $msg = null;
            $goods = Goods::getGoodsData($this->getParam('id'),array('id,life,status,is_publish'));
            if(!$goods){
                $msg = '该商品已经删除，收藏失败';
            }else{
                if($goods['life']==Goods::LIFE_YES || $goods['status']!=Goods::STATUS_PASS || $goods['is_publish']==Goods::PUBLISH_NO){
                    $msg = '该商品已经下架，收藏失败';
                }
            }
            $rs = GoodsCollect::model()->findByAttributes(array('good_id' => $_GET['id'], 'member_id' => $this->getUser()->id));
            if (!$msg && $rs) {
                $msg = '收藏夹中已有该商品无需再次收藏！';
            } else {
                $model->good_id = $this->getParam('id');
                $model->member_id = $this->getUser()->id;
                $model->create_time = time();
                if (!$msg && $model->save()) {
                    $msg = '已添加到收藏列表！';
                    $data['success'] = true;
                    //删除 删除商品列表
                    if ($this->getParam('spec_id')) {
                        $shopCart = new ShopCart();
                        $shopCart->historyData;
                        if (!empty($shopCart->historyData)) {
                            foreach ($shopCart->historyData as $k => $v) {
                                if ($v['spec_id'] == $this->getParam('spec_id') && $v['goods_id'] == $this->getParam('id')) {
                                    unset($shopCart->historyData[$k]);
                                }
                            }
                            $cookie = new CHttpCookie(ShopCart::CART_HISTORY_PATH . $model->member_id, $shopCart->historyData, array('domain' => SHORT_DOMAIN));
                            $cookie->expire = time() + ShopCart::HISTORY_TIME;
                            Yii::app()->request->cookies[ShopCart::CART_HISTORY_PATH . $model->member_id] = $cookie;
                        }
                    }
                } else {
                    $msg = '收藏失败！';
                }
            }
        } else {
            throw new CHttpException(400, Yii::t('Collect', '没有找到相应的商品信息'));
        }
        $data['msg'] = $msg;
        exit($cb ? $cb . '(' . json_encode($data) . ')' : json_encode($data));
    }   
    /**
     * 批量收藏
     * **/
    public function actionCollectSelected(){
        $goodsData = $this->getParam('goodsData');
        $msg = '';
        if(!empty($goodsData)){
            foreach($goodsData as $v){
                $rs = GoodsCollect::model()->findByAttributes(array('good_id'=>$v['goods_id'],'member_id'=>$this->getUser()->id));
                if ($rs){
                    $msg = '收藏夹中已有该商品无需再次收藏！';
                }else {
                    $model = new GoodsCollect();
                    $model->good_id = $v['goods_id'];
                    $model->member_id = $this->getUser()->id;
                    $model->create_time = time();
                    if ($model->save(false)) {
                        $msg = '已添加到收藏列表！';
                        $data['success'] = true;
                    }
                    else{
                        $msg = '收藏失败！';
                    }
                }
            }
        }
        $data['msg'] = $msg;
        $cb   = $this->getParam('jsoncallBack');
        exit( $cb ? $cb.'('.json_encode($data).')' : json_encode($data) );
    }
     /**
     * 删除收藏
     */
    public function actionDelete($id) {
        $model = new GoodsCollect('search');
        $member = GoodsCollect::model()->findByAttributes(array('id'=>$id)); //查找该商品的收藏者
        $data = array('success'=>false, 'msg'=>'删除失败！');
        $cb   = $this->getParam('jsoncallBack');
        if(!$this->user->id){
            $data['msg'] = Yii::t('Collect','您还没有登录，请先登录！');
            exit( $cb ? $cb.'('.json_encode($data).')' : json_encode($data) );
        }
        if(!empty($member)){
            if($member['member_id']==$this->getUser()->id){
                $model->deleteall('id=:postID', array(':postID'=>$id));
                $msg = Yii::t('Collect','已从收藏列表中删除！');
                $cacheKey='GOODS_COLLECT_'.$member->good_id.'_'.$member->member_id;
                Tool::cache($cacheKey)->delete($cacheKey);
                $data['success'] = true;
            }else{
                $msg = Yii::t('Collect','你无权限删除！');
            }
        }else{
             $msg = Yii::t('Collect','该商品已从收藏列表中删除！');
        }
        $data['msg'] = $msg;
        exit( $cb ? $cb.'('.json_encode($data).')' : json_encode($data) );
    }
   
} 