<?php

/**
 * 会员中心模块
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class AgentModule extends CWebModule {

    public $defaultController = 'site';

    public function init() {
        Yii::app()->urlManager->urlSuffix = false;
        $this->setImport(array(
            'agent.models.*',
            'agent.components.*',
        	'agent.widgets.*',
        ));
        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'class' => 'CErrorHandler',
                'errorAction' => '/agent/site/error',
            ),
            'user' => array(
                'loginUrl' => Yii::app()->createUrl('/agent/site/login'),
        )));
    }

    public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {
            $route = $controller->id . '/' . $action->id;
            //没有登录也可以访问的页面地址
            $publicPages = array(
                'site/login',
		        'site/logout',
		        'site/captcha'
            );
            if (Yii::app()->user->isGuest && !in_array($route, $publicPages))
                Yii::app()->user->loginRequired();
            else
                return true;
            return true;

        }
        return false;
    }

	private $_assetsUrl;

    public function getAssetsUrl()
    {
        if($this->_assetsUrl===null)
            $this->_assetsUrl=DOMAIN.'/agent';
        return $this->_assetsUrl;
    }
    public function setAssetsUrl($value)
    {
        $this->_assetsUrl=$value;
    }
}
