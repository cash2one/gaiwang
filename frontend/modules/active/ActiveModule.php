<?php

/**
 * 活动模块
 * @author jaiwei.liao <569114018@qq.com>
 */
class ActiveModule extends CWebModule {

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
