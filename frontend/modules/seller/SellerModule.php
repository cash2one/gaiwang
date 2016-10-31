<?php

/**
 * 商家管理后台模块
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class SellerModule extends CWebModule
{

    public $defaultController = 'home';

    public function init()
    {

        $this->setImport(array(
            'member.models.*',
            'member.components.*',
            'seller.components.*',
        ));
        Yii::app()->setComponents(array(
            'errorHandler' => array(
               'class' => 'CErrorHandler',
               'errorAction' => '/seller/home/error',
            ),
            'user' => array(
                'loginUrl' => Yii::app()->createUrl('/seller/home/login'),
            )));
    }

    public function beforeControllerAction($controller, $action)
    {
        //处理上传图片的session问题，写在controler里面无效
        if (isset($_POST["PHPSESSID"])) {
            session_id($_POST["PHPSESSID"]);
        } else if (isset($_GET["PHPSESSID"])) {
            session_id($_GET["PHPSESSID"]);
        }
        $controller->layout = 'seller';
        if (parent::beforeControllerAction($controller, $action)) {
            $route = $controller->id . '/' . $action->id;
            if (!$this->allowIp(Yii::app()->request->userHostAddress) && $route !== 'home/error')
                throw new CHttpException(403, "你没有权限访问此页面.");
            if(!AssistantPermission::checkAssistant($route))
                throw new CHttpException(403, "你没有权限访问此页面.".$route);
            //没有登录也可以访问的页面地址
            $publicPages = array(
                'home/login',
                'home/captcha',
                'home/error',
                'home/notSupported',
            );
            //如果是上传控制器，则返回true
            if($route=='upload/upload' && isset($_POST["PHPSESSID"])){
                return true;
            }
            if (!Yii::app()->user->getState('enterpriseId') && !Yii::app()->user->isGuest)
                Yii::app()->user->logout();
            if (Yii::app()->user->isGuest && !in_array($route, $publicPages))
                Yii::app()->user->loginRequired();
            
            if(!empty(Yii::app()->session['login_redirect_confirm'])){
                $publicPages[] = 'home/logout';
                if(!in_array($route, $publicPages)){
                    header("Location: ".DOMAIN.'/confirm/'); 
                    exit;
                }
            }else{
                return true;
            }

            return true;
        }
        return false;
    }

    protected function allowIp($ip)
    {
        if (empty($this->ipFilters))
            return true;
        foreach ($this->ipFilters as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos)))
                return true;
        }
        return false;
    }

    /**
     *  店铺装修的资源文件
     */
    private $_assetsUrl;

    public function getAssetsUrl()
    {
        if($this->_assetsUrl===null)
            //$this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.seller.assets'), false, -1, YII_DEBUG);
            $this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.seller.assets'));
        return $this->_assetsUrl;
    }
    public function setAssetsUrl($value)
    {
        $this->_assetsUrl=$value;
    }


}
