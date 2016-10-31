<?php

/**
 * 红包模块
 * @author huabin.hong <121826725@qq.com>
 */
class HongbaoModule extends CWebModule
{
	public $defaultController = 'site';
	
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'hongbao.models.*',
            'hongbao.components.*',
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
    	$controller->layout = 'main';
        if(parent::beforeControllerAction($controller, $action))
        {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}