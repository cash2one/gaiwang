<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SiteController
 *
 * @author wencong.lin
 */
class SiteController extends Controller {

    public function actions() {
        return array(
            'selectLanguage' => array('class' => 'CommonAction', 'method' => 'selectLanguage'),
        );
    }

    public function init() {
        Yii::app()->clientScript->registerCssFile(DOMAIN . '/css/game.css');
    }

    /**
     * 调用单页文件
     * @param string $actionId
     */
    public function missingAction($actionId) {
        $this->layout = 'application.views.layouts.main';
        $this->pageTitle = '盖象商城-网上购物商城 正品保证_放心购物_诚信服务';
        $this->keywords = '盖象 ,盖象商城,网上购物,网上商城,购物消费';
        $this->description = '盖象商城（G-emall.com）-积分兑换及网上购物商城！在线销售家电、数码、百货、服饰等数千万种优质商品；盖象承诺只售正品。便捷、诚信的服务，为您提供愉悦的网上商城购物体验！';
        $actionId = substr($actionId, -5) == '.html' ? substr($actionId, 0, -5) : $actionId;
        $renderFile = 'application.modules.yaopin.views.site.pages.' . $actionId;
        if (file_exists(Yii::getPathOfAlias($renderFile) . '.php')) {
            $this->render($renderFile);
        } else {
            parent::missingAction($actionId);
        }
    }

    public function actionView($id) {
        $this->layout = 'application.modules.yaopin.views.layouts.store';
        $this->pageTitle = '盖象商城-网上购物商城 正品保证_放心购物_诚信服务';
        $this->keywords = '盖象 ,盖象商城,网上购物,网上商城,购物消费';
        $this->description = '盖象商城（G-emall.com）-积分兑换及网上购物商城！在线销售家电、数码、百货、服饰等数千万种优质商品；盖象承诺只售正品。便捷、诚信的服务，为您提供愉悦的网上商城购物体验！';
        $this->render('view' . $id);
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
