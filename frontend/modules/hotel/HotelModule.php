<?php

/**
 * 酒店模块
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class HotelModule extends CWebModule {

    public $defaultController = 'site';

    public function init() {
        parent::init();
        $this->setImport(array(
            'hotel.models.*',
        ));
    }

    public function beforeControllerAction($controller, $action) {
        $controller->layout = '/layouts/main';
        //Yii::app()->setTheme(null); //酒店模块，暂时还是用旧版
        if (parent::beforeControllerAction($controller, $action))
            return true;
        else
            return false;
    }

}
