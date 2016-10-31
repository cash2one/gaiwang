<?php

/**
 * 加盟商模块
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class JmsModule extends CWebModule {

    public $defaultController = 'site';

    public function init() {
        parent::init();
    }

    public function beforeControllerAction($controller, $action) {
        $controller->layout = 'main';
        if (parent::beforeControllerAction($controller, $action))
            return true;
        else
            return false;
    }

}
