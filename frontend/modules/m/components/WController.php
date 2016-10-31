<?php

/**
 * 微商城控制器父类
 * @author wyee <yanjie@gatewang.com>
 */
class WController extends Controller {

    public $top = false;
    public $order = false;//是否是订单控制器
    public $footer=false;
    public $layout = 'main';
    public $showTitle='';
    public $pageTitle='盖象微商城';
    public $model;
    public $uid;
    
    /**
     * 方法前操作
     * @see Controller::beforeAction()
     */
    public function beforeAction($action) {
        $route = $this->id;
        //不登陆不可以访问的页面
        $privateController = array(
                'member',
                'order',
                'orderConfirm',
                'couponActivity',
                'address',
        );
        if(!in_array($route,$privateController)){ 
            return parent::beforeAction($action);
          }
        if(empty($this->getUser()->id)){
            $this->redirect(array('home/logout'));
        }
        $this->model = Member::model()->findByPk($this->getUser()->id);
        $this->uid= $this->model->id;
        return parent::beforeAction($action);
    }
   
}
