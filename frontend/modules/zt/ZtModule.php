<?php

/**
 * 专题模块
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class ZtModule extends CWebModule {

    public $defaultController = 'site';

    public function init() {
        parent::init();
        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'class' => 'CErrorHandler',
                'errorAction' => '/zt/site/error',
            )
        ));
    }

    public function beforeControllerAction($controller, $action) {
        $controller->layout = '//layouts/main';
        if (parent::beforeControllerAction($controller, $action))
            return true;
        else
            return false;
    }

}
