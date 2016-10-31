<?php

/**
 * app模块
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class GwkeyModule extends CWebModule {

    public $defaultController = 'site';

    public function init() {
        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'class' => 'CErrorHandler',
                'errorAction' => '/app/site/error',
            ),
        ));
//        parent::init();
    }

    public function beforeControllerAction($controller, $action) {
        $controller->layout = '/layouts/main';
        if (parent::beforeControllerAction($controller, $action))
            return true;
        else
            return false;
    }

}
