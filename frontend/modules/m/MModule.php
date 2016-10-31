<?php

/**
 * 微商城模块
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class MModule extends CWebModule {

    public $defaultController = 'site';

     public function init() {
            $this->setImport(array(
                    'm.models.*',
                    'm.components.*',
                    'result.components.*',
            ));
            Yii::app()->setComponents(array(
            'errorHandler' => array(
            'class' => 'CErrorHandler',
            'errorAction' => '/m/site/error',
            )));
        }
        


    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        } else
            return false;
    }

}
