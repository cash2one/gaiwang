<?php

/**
 * 重写 CWebUser
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2015/11/4 0004
 * Time: 10:20
 */
class WebUser extends CWebUser
{

    public $loginRequiredAjaxResponse = '请先登录';
    /**
     * 重写未登录跳转，jsonp 请求不跳转
     * @throws CHttpException
     */
    public function loginRequired()
    {
        $this->loginRequiredAjaxResponse = Yii::t('site','请先登录');
        $app=Yii::app();
        $request=$app->getRequest();

        if(!$request->getIsAjaxRequest() && !isset($_GET['jsoncallBack']) && !isset($_GET['jsonpCallback']))
        {
            $this->setReturnUrl($request->getUrl());
            if(($url=$this->loginUrl)!==null)
            {
                if(is_array($url))
                {
                    $route=isset($url[0]) ? $url[0] : $app->defaultController;
                    $url=$app->createUrl($route,array_splice($url,1));
                }
                $request->redirect($url);
            }
        }
        elseif(isset($this->loginRequiredAjaxResponse))
        {
            $msg =  json_encode(array('error'=>$this->loginRequiredAjaxResponse));
            if(isset($_GET['jsoncallBack'])){
                echo $_GET['jsoncallBack'].'('.$msg.')';
            }else if(isset($_GET['jsonpCallback'])){
                echo $_GET['jsonpCallback'].'('.$msg.')';
            }else{
                echo $msg;
            }
            Yii::app()->end();
        }

        throw new CHttpException(403,Yii::t('yii','Login Required'));
    }
}