<?php

/**
 * 搜索控制器
 * @author wyee<yanjie.wang@g-emall.com>
 */
class SearchController extends WController
{
    public $top = true;
    public $cart = true; //加入购物车模块是否显示
    public $keyword;

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $this->pageTitle = Yii::t('search', "盖象微商城-").$this->getParam('p').Yii::t('search', "-商品搜索");
        $this->showTitle =Yii::t('search', "商品搜索");
        return true;
    }

    public function actionSearch()
    { 
        $xunsearch = '/www/web/xunsearch/lib/XS.php';
        $sorts = array();//排序规则
        $this->keyword = $this->getParam('p');
        $p = $this->getParam('p');
        $f = 'name';
        if (empty($this->keyword)) $this->keyword = '';
            // 获取URI参数标准
            $args = $this->_uriParamsCriterion();
            $params = Tool::requestParamsDispose($args);
            /**
             * 根据不同的条件组装不同的搜索条件
             * 销量(1 DESC),价格(3 DESC),评论(4 DESC)
             */
            switch ($params['order']) {
                case 1:
                    $sorts = array_merge($sorts, array('sales_volume' => false));
                    break;
                case 3:
                    $sorts = array_merge($sorts, array('price' => false));
                    break;
                case 4:
                    $sorts = array_merge($sorts, array('comments' => false));
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
            //设置排序规则
            $search->setMultiSort($sorts);
            $p = max(1, intval($this->getParam('page', 0)));
            $n = 10;
            $search->setLimit($n, ($p - 1) * $n);
            //执行查询
            $goods = $search->search();        
            //计算数量
            $count = $search->getLastCount();
            $pages=new CPagination($count);
            $pages->pageSize=$n;
                //处理售价显示,如果参加红包活动，并且活动状态是有效的，则显示盖网提供的售价
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
       $this->render('view', array('model' => $goods,'pages' => $pages,'params' => $params));
    }
    
    /**
     * 定义URI参数标准
     * @return array    返回规范参数
     */
    protected function _uriParamsCriterion()
    {
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
