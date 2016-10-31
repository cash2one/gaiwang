<?php

/**
 * 搜索控制器
 * @author jianlin.lin <hayeslam@163.com>
 */
class SearchController extends Controller
{

    public $layout = 'main';
    public $defaultAction = 'view';
    public $keyword;
    public $options;
    public $provinceId = 0;
    public $store;
    public $design;

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $site_config = $this->getConfig('site');
        $this->pageTitle =  $this->getParam('q').Yii::t('search', "-搜索-").$site_config['name'];
        $this->keywords = $this->getParam('q').','.$site_config['name'].' '.$this->getParam('q');
        return true;
    }

    public function actionSearch()
    {
        
        $xunsearch = '/www/web/xunsearch/lib/XS.php';
        $brands = array();//组装后的品牌数据
        $cates = array();//组装后分类数据
        $sorts = array();//排序规则
        $this->keyword = $this->getParam('q');
        $this->options = $this->getParam('o');
        $sid=$this->getParam('s');
        $f = $this->getParam('f');
        $p = $this->getParam('p');
        $fpt = $this->getParam('freight_payment_type');  //包邮筛选
        $ssi = $this->getParam('seckill_seting_id');  //活动筛选
        if (empty($this->keyword))
            $this->keyword = '';
        $this->breadcrumbs = array($this->keyword); // 面包屑
        if ($this->options == '宝贝' || $this->options == "") {
            // 设置COOKIE
            $this->setCookie('optionsName', $this->options, 24 * 60 * 60);
            // 获取URI参数标准
            $args = $this->_uriParamsCriterion();
            $params = Tool::requestParamsDispose($args);
            /**
             * 根据不同的条件组装不同的搜索条件
             * 销量(1 DESC),价格(2 ASC,3 DESC),评论(4 DESC)
             */
            switch ($params['order']) {
                case 1:
                    $sorts = array_merge($sorts, array('sales_volume' => false));
                    break;
                case 2:
                    $sorts = array_merge($sorts, array('price' => true));
                    break;
                case 3:
                    $sorts = array_merge($sorts, array('price' => false));
                    break;
                case 4:
                    $sorts = array_merge($sorts, array('comments' => false));
                    break;
                case 5:
                    $sorts = array_merge($sorts, array('views' => true));
                    break;
                case 6:
                    $sorts = array_merge($sorts, array('update_time' => true));
                    break;
                default:
                    $sorts = array_merge($sorts, array('create_time' => false));
            }

            //加载迅迅搜的API
            require_once($xunsearch);
            $xs = new XS('gaiwang');
            $search = $xs->search;
            $search->setCharset('UTF-8');
            $search->setQuery($f . ':(' . $this->keyword . ')');

            //设置分面查询
            $search->setFacets(array('brand_id', 'category_id'));
            //价格查询区间
            if ($params['min'] > 0 || $params['max'] > 0){
                if($params['min']>0 && $params['max']>0){//同是存在
                    $params['min'] = $params['min'] < $params['max'] ? $params['min'] : NULL;
                    $params['max'] = $params['max'] >= $params['min'] ? $params['max'] : NULL;
                }else{//只有一个价格
                    $params['min'] = $params['min'] > 0 ? $params['min'] : NULL;
                    $params['max'] = $params['max'] > 0 ? $params['max'] : NULL;
                }
                $search->addRange('price', $params['min'], $params['max']);
            }
            //品牌,分类筛选
            if (isset($_GET['bid']) && $params['bid']>=0) {
                $search->addRange('brand_id', $params['bid'], $params['bid']);
            }
            if ($params['cid']) {
                $search->addRange('category_id', $params['cid'], $params['cid']);
            }
            if ($sid) {
                $search->addRange('store_id', $sid, $sid);
            }
            //是否包邮
            if(isset($_GET['freight_payment_type'])){
                $params['freight_payment_type']=$fpt;
                $search->addRange('freight_payment_type',$fpt, $fpt);
            }
            //是否参加活动
            if(isset($_GET['seckill_seting_id'])){
                $params['seckill_seting_id']=$ssi;
                $search->addRange('seckill_seting_id',$ssi, null);
                $sorts = array_merge($sorts, array('create_time' => false));
            }

            //设置排序规则
            $search->setMultiSort($sorts);

            // set offset, limit
            $p = max(1, intval($this->getParam('page', 0)));
            $n = 15;
            if(!empty($sid)){
                $n=20;
            }
            $search->setLimit($n, ($p - 1) * $n);

            //执行查询
            $goods = $search->search();
            // 读取分面结果
            $bid_counts = $search->getFacets('brand_id'); // 返回数组，以 brand_id 为键，匹配数量为值
            $cid_counts = $search->getFacets('category_id'); // 返回数组，以 category_id 为键，匹配数量为值
            //计算数量
            $count = $search->getLastCount();
            //$total = $search->getDbTotal();


            if(!Yii::app()->theme){
                //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价 binbin.liao
                foreach ($goods as &$g) {
                    //如果参加红包活动,并且活动的是开启的.显示盖网的销售价,否则显示原来的售价
                    if ($g->join_activity == Goods::JOIN_ACTIVITY_YES && !empty($g->activity_tag_id) && $g->at_status == ActivityTag::STATUS_ON) {
                        $g->price = $g->gai_sell_price;
                    }
                    //如果参加专题活动.
                    $sp = Goods::getZtPrice($g);
                    if ($sp['isOk']) {
                        $g->price = $sp['price'];
                    }
                }
            }
            //查询出所有的品牌数据
            $brandData = Yii::app()->db->createCommand()
                ->select('id,name')
                ->from('{{brand}}')->where(array('in','id',array_keys($bid_counts)))
                ->queryAll();
            foreach ($brandData as $v) {
                if (array_key_exists($v['id'], $bid_counts)) {
                    $brands[$v['id']] = array('id' => $v['id'], 'name' => $v['name'], 'total' => $bid_counts[$v['id']]);
                }
            }
            if(isset($bid_counts[0])){
                $brands[0] = array('id' => 0, 'name' => '无品牌', 'total' => $bid_counts[0]);
            }
            //查询出所有分类数据并组装数据
            $cateData = Yii::app()->db->createCommand()
                ->select('id,name')
                ->from('{{category}}')->where(array('in','id',array_keys($cid_counts)))
                ->queryAll();
            foreach ($cateData as $v) {
                if (array_key_exists($v['id'], $cid_counts)) {
                    $cates[$v['id']] = array('id' => $v['id'], 'name' => $v['name'], 'total' => $cid_counts[$v['id']]);
                }
            }
            //排序
            if(!empty($brands)) $brands = $this->_array_sort($brands,'total');
            if(!empty($cates)) $cates = $this->_array_sort($cates,'total');

            if(!empty($goods)){
                $rulesIds = array(); //活动id
                $storeIds = array(); //店铺id
                foreach($goods as $v){
                    $storeIds[] = $v['store_id'];
                    if($v['seckill_seting_id']>0) $rulesIds[] = $v['seckill_seting_id'];
                }
                $storeIds = array_unique($storeIds);
                $storeNames = Yii::app()->db->createCommand()->select('id,name')->from('gw_store')->where(array('in','id',$storeIds))->queryAll();
                //组装店铺数据
                foreach($goods as &$v){
                    foreach($storeNames as $v2){
                        if($v['store_id']==$v2['id']){
                            $v->setField('store_name',$v2['name']);
                        }
                    }
                }
                // 查找活动类型，组装数据
                if(!empty($rulesIds)){
                    $seckill_rules = Yii::app()->db->createCommand()->select("m.category_id,s.id as sid")
                        ->from("gw_seckill_rules_seting as s")->leftJoin('gw_seckill_rules_main as m','m.id=s.rules_id')
                        ->where(array('in','s.id',$rulesIds))->andWhere('s.status='.SeckillRulesSeting::ACTIVITY_IS_RUNNING)->queryAll();
                    foreach($goods as $k => &$v){
                        foreach($seckill_rules as $v2){
                            if($v['seckill_seting_id']==$v2['sid']){
                                $v->setField('seckill_category_id',$v2['category_id']);
                            }
                        }
                        //查询商品是否通过活动审核
                        if ($v['seckill_seting_id'] > 0) {
                            $productStatus = Yii::app()->db->createCommand()
                                ->select('id')->from('gw_seckill_product_relation')
                                ->where('rules_seting_id=' . $v['seckill_seting_id'] . ' and product_id=' . $v['id'] . ' and status=' . SeckillProductRelation::STATUS_PASS)->queryRow();
                            if ($this->getParam('seckill_seting_id') && !$productStatus) {
                                unset($goods[$k]);
                                $count--;
                            }
                        }
                    }
                }
            }
            $totalPage = ceil($count/$n); //总页数
            // Tool::pr($bid_counts);
            // 生成分页
            $pages=new CPagination($count);
            $pages->pageSize=$n;
            //旧版的分页
            $pager = '';
            if(!$this->theme){
                if ($count > $n) {
                    $pb = max($p - 5, 1);
                    $pe = min($pb + 10, ceil($count / $n) + 1);
                    do {
                        $pager .= ($pb == $p) ? '<li class="page selected"><a>' . $p . '</a></li>' : '<li><a href="' . $this->createAbsoluteUrl('search/search', array_merge($params, array('page' => $pb))) . '">' . $pb . '</a></li>';
                    } while (++$pb < $pe);
                }
            }
           if(!empty($sid)){
               $this->layout = 'store';
               $args = $this->_uriProductParams();
               $params = Tool::requestParamsDispose($args);
               $params['o']='宝贝';
               $storeModel = Store::model()->findByPk($sid);
               if(empty($storeModel)) throw new CHttpException(400, '店铺出错，请刷新重试！');
               $res = Design::getPass($sid);
               if (empty($res)) {
                   $data = '';
               }else{
                   $data = $res['data'];
               }
               $design = new DesignFormat($data);
               $this->store=$storeModel;
               $this->design=$design; 
               $this->render('storeGoods_2', array(
                       'goods' => $goods, 
                       'params' => $params,
                       'pages' => $pages,
                       'totalPage'=>$totalPage
            ));
           }else{
            $this->render('view_2', array(
                'params' => $params,
                'goodsCount' => $count,
                'pager' => $pager,
                'pages' => $pages,
                'goods' => $goods,
                'brands' => $brands,
                'cates' => $cates,
                'totalPage'=>$totalPage
            ));
           }
        }

        if ($this->options == '店铺') {
//            Yii::app()->setTheme(null);
            $store = array();
            // 设置COOKIE
            $this->setCookie('optionsName', $this->options, 24 * 60 * 60);
            // 获取URI参数标准
            $args = $this->_uriParamsCriterion1();
            $args['o'] = $this->options;
            $args['q'] = $this->keyword;
            $args['p'] = $this->provinceId;
            $args['page'] = $this->getParam('page', 0);
            $args['f'] = 'name';
            $params = Tool::requestParamsDispose($args);
            $f = 'name';
            /**
             * 根据不同的条件组装不同的搜索条件
             * 销量(1 DESC,2 ASC),综合评分(3 DESC,4 ASC)
             */
            switch ($params['order']) {
                case 1:
                    $sorts = array_merge($sorts, array('sales' => false));
                    break;
                case 2:
                    $sorts = array_merge($sorts, array('sales' => true));
                    break;
                case 3:
                    $sorts = array_merge($sorts, array('comments' => false));
                    break;
                case 4:
                    $sorts = array_merge($sorts, array('comments' => true));
                    break;
                default:
                    $sorts = array_merge($sorts, array('sales' => false));
            }

            // 获取店铺所在区域
            $region = Yii::app()->db->createCommand()
                ->select('id,short_name')
                ->from('{{region}}')->where('depth = :d', array(':d' => 1))
                ->queryAll();

            //调用xunsearchAPI
            require_once($xunsearch);
            $xs = new XS('gw_store');
            $search = $xs->search;
            $search->setCharset('UTF-8');
            $search->setQuery($f . ':(' . $this->keyword . ')');

            //设置排序规则
            $search->setMultiSort($sorts);
            //设置筛选条件
            if ($params['p']) {
                $search->addRange('province_id', $args['p'], $args['p']);
            }
            // set offset, limit
            $p = max(1, intval($args['page']));
            $n = 10;
            $search->setLimit($n, ($p - 1) * $n);

            //执行查询
            $storeData = $search->search();

            //计算数量
            $count = $search->getLastCount();
            //$total = $search->getDbTotal();

            // 生成分页
            $pages=new CPagination($count);
            $pages->pageSize=$n;
            $totalPage = ceil($count/$n); //总页数
            //旧版的分页
            $pager = '';
            if (!$this->theme) {
                if ($count > $n) {
                    $pb = max($p - 5, 1);
                    $pe = min($pb + 10, ceil($count / $n) + 1);
                    do {
                        $pager .= ($pb == $p) ? '<li class="page selected"><a>' . $p . '</a></li>' : '<li><a href="' . $this->createAbsoluteUrl('search/search', array_merge($params, array('page' => $pb))) . '">' . $pb . '</a></li>';
                    } while (++$pb < $pe);
                }
            }
            //组装数据
            foreach ($storeData as &$v) {
                //查询所属店铺的商品
                $pars = array(
                	':sid' => $v['id'],
                	':life' => Goods::LIFE_NO,
                    ':pub' => Goods::PUBLISH_YES,
                	':status' => Goods::STATUS_PASS,
                    
                );
                $goods = Yii::app()->db->createCommand()
                    ->select('id,name,thumbnail,price')
                    ->from('{{goods}}')
                    ->where('store_id =:sid AND life = :life AND is_publish=:pub AND status=:status', $pars)
                    ->order('id desc')
                    ->limit(5)
                    ->queryAll();
                $store[$v['id']] = array_merge($v->getFields(),array('goods'=>$goods));
            }
            //店铺商品统计
            $goodsCount = Yii::app()->db->createCommand()
            ->select('store_id,count(*) num')
            ->from('{{goods}}')
            ->where(array('in','store_id',array_keys($store)))
            ->andWhere('status=:status AND is_publish=:pub AND life = :life',array(':status' => Goods::STATUS_PASS,':pub' => Goods::PUBLISH_YES,':life' => Goods::LIFE_NO))
            ->group('store_id')
            ->queryAll();
            
            if($goodsCount){
                foreach($goodsCount as $v){
                    if(isset($store[$v['store_id']])) $store[$v['store_id']]['count'] = $v['num'];
                }
            }
            $this->render('store_2', array(
                'store' => $store,
                'storeCount' => $count,
                'region' => $region,
                'params' => $params,
                'pager' => $pager,
                'totalPage' => $totalPage,
                'pages' => $pages
            ));
        }
    }

    /**
     * 定义URI参数标准
     * @return array    返回规范参数
     */
    protected function _uriParamsCriterion()
    {
        return array(
            'q' => '',
            'bid' => -1,
            'cid' => 0,
            'min' => 0,
            'max' => 0,
            'f' => 'name',
            'order' => array(
                'sales_volume' => array(
                    'text' => Yii::t('search', '销量'),
                    'defaultValue' => 1,
                    1 => 'sales_volume DESC'
                ),
                'price' => array(
                    'defaultValue' => 3,
                    'text' => Yii::t('search', '价格'),
                    2 => 'price ASC',
                    3 => 'price DESC'
                ),
                'comments' => array(
                    'defaultValue' => 4,
                    'text' => Yii::t('search', '评论'),
                    4 => 'comments DESC'
                ),
            ),
        );
    }

    /**
     * 定义URI参数标准   店铺宝贝查询
     * @return array    返回规范参数
     */
    protected function _uriProductParams() {
        return array(
                'q' => '',
                's' => 0,
                'min' => 0,
                'max' => 0,
                'order' => array(
                         'views' => array(
                                'defaultValue' => 5,
                                'text' => Yii::t('shop','浏览量'),
                                5 => 'views DESC'
                        ),
                        'price' => array(
                                'defaultValue' => 3,
                                'text' => Yii::t('shop','价格'),
                                2 => 'price ASC',
                                3 => 'price DESC'
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
     * 定义URI参数标准
     * @return array    返回规范参数
     */
    protected function _uriParamsCriterion1()
    {
        return array(
            'order' => array(
                'sales' => array(
                    'text' => Yii::t('search', '销量'),
                    'defaultValue' => 2,
                    1 => 'sales DESC',
                    2 => 'sales ASC',
                ),
                'comments' => array(
                    'defaultValue' => 4,
                    'text' => Yii::t('search', '评论数'),
                    3 => 'comments DESC',
                    4 => 'comments ASC',
                ),
            ),
        );
    }




    /**
     * 二维数组排序
     * @param array $arr
     * @param string $keys
     * @param string $type desc|asc
     * @return array
     */
    private function _array_sort($arr,$keys,$type='desc'){
        $keysValue = $new_array = array();
        foreach ($arr as $k=>$v){
            $keysValue[$k] = $v[$keys];
        }
        if($type == 'asc'){
            asort($keysValue);
        }else{
            arsort($keysValue);
        }
        reset($keysValue);
        foreach ($keysValue as $k=>$v){
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
}
