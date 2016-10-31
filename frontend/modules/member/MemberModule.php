<?php

/**
 * 会员中心模块
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class MemberModule extends CWebModule {

    public $defaultController = 'site';

    public function init() {
        $this->setImport(array(
            'member.models.*',
            'member.components.*',
        ));
        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'class' => 'CErrorHandler',
                'errorAction' => '/member/site/error',
            ),
            'user' => array(
                'loginUrl' => Yii::app()->createUrl('/member/home/login'),
        )));
    }

    public function beforeControllerAction($controller, $action) {
        //处理上传图片的session问题，写在controler里面无效
        if (isset($_POST["PHPSESSID"])) {
            session_id($_POST["PHPSESSID"]);
        } else if (isset($_GET["PHPSESSID"])) {
            session_id($_GET["PHPSESSID"]);
        }
        $controller->layout = 'member';
        if (parent::beforeControllerAction($controller, $action)) {
            $route = $controller->id . '/' . $action->id;
            if (!$this->allowIp(Yii::app()->request->userHostAddress) && $route !== 'site/error')
                throw new CHttpException(403,Yii::t('member','你没有权限访问此页面.'));
            if(Yii::app()->user->getState('assistantId')) Yii::app()->user->logout(); //店小二访问，直接退出
            //没有登录也可以访问的页面地址
            $publicPages = array(
                'home/login',
                'home/register',
                'home/quickRegister',
                'home/getMobileVerifyCode',
                'home/getMobileVerifyCall',
                'home/registerEnterprise',
                'home/getCaptcha',
                'home/resetPassword',
                'home/resetPasswordComplete',
                'home/captcha',
                'home/captcha2',
                'site/error',
                'site/selectLanguage',
                'region/updateCity',
                'region/updateArea',
                'home/checkCode',
                'home/checkLogin',
                'home/memberUpgrade',
            );
            //如果是上传控制器，则返回true
            if($route=='upload/upload' && isset($_POST["PHPSESSID"])){
                return true;
            }
            if (Yii::app()->user->isGuest && !in_array($route, $publicPages)){
                Yii::app()->user->loginRequired();
            }else if(!empty(Yii::app()->session['login_redirect_confirm'])){
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

    protected function allowIp($ip) {
        if (empty($this->ipFilters))
            return true;
        foreach ($this->ipFilters as $filter) {
            if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos)))
                return true;
        }
        return false;
    }

}
