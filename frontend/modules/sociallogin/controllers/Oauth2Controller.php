<?php

/**
 * Oauth2 server 服务接口
 * Class Oauth2Controller
 */

class Oauth2Controller extends Controller
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'height' => '30',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
                'testLimit' => 30,
            ),
        );
    }

    /**
     * 登录
     * @throws CException
     */

    public function actionLogin(){
        $this->pageTitle = '网站链接 - '.$this->getUser()->getState('thirdName');
        $model = new LoginForm;
        $model->username = $this->getCookie('uname');
        $this->performAjaxValidation($model);
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->homeUrl);
        $users = array();

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $this->getPost('LoginForm');
            if (isset($_POST['gai_number'])) {
                $model->username = $_POST['gai_number'];
            }
            //手机号登录，多个账号情况
            if (is_numeric($model->username)) {
                $users = Yii::app()->db->createCommand()->select('gai_number')
                    ->from('{{member}}')->where('mobile=:m', array(':m' => $model->username))->queryAll();
                if (count($users) > 1) {
                    $tmpUsers = array();
                    foreach ($users as $k => $v) {
                        $tmpUsers[$v['gai_number']] = $v['gai_number'];
                    }
                    $users = $tmpUsers;
                    $model->addError('username', '');
                } else {
                    $users = array();
                }
            }
            if ($model->validate(null, false) && $model->login()) {
                $this->setCookie('uname', $model->username, 3600 * 30 * 365);
                $flag = Yii::app()->db->createCommand()->select('flag')
                    ->from('{{member}}')->where('id=:id', array(':id' => $this->getUser()->id))->queryScalar();
                if($flag==Member::FLAG_NO){
                    $this->setSession('activation','登录并激活');
                }else{
                    if (stripos(Yii::app()->user->returnUrl, 'logout') === false) {
                        $this->redirect(Yii::app()->user->returnUrl);
                    } else {
                        $this->redirect(array('/member'));
                    }
                }
            }
        }
        $this->renderPartial('login',array('model' => $model, 'users' => $users),false,true);
    }

    /**
     * 初始入口，获取code
     */
    public function actionIndex()
    {
        $server = Yii::app()->oauth2Auth;
        $server->initOAuth2Request();
    }


    /**
     * 接口验证
     * @throws Exception
     */
    public function actionAuthorize()
    {
        $_POST['accept'] = true;
        $server = Yii::app()->oauth2Auth;
        $server->authorize();
//        $this->render('authorize', array('params'=>$server->getSessionParams()));
    }

    /**
     * 获取 token
     */
    public function actionToken()
    {
        $server = Yii::app()->oauth2Auth;
        $server->issueAccessToken();
    }

    /**
     * 获取用户信息
     */
    public function actionGetUserInfo(){
        $server = Yii::app()->oauth2Resource;
        $server->checkToken();
        $uid = $server->server->getOwnerId();
        $response = new OAuth2ServerResponse;
        $data = Member::getUserInfoById($uid);
        //id做md5加密
        if(isset($data['id'])){
            $data['id'] = md5($data['id'].'gw');
        }
        $response->set($data)->send();
    }

}
