<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of YaoPinModule
 *
 * @author wencong.lin
 */
class YaopinModule extends CWebModule {

    public $defaultController = 'site';

    public function init() {
        parent::init();
        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'class' => 'CErrorHandler',
                'errorAction' => '/yaopin/site/error',
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
