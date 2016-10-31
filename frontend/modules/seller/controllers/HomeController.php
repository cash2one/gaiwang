<?php

class HomeController extends Controller {

    public $showTitle = null;

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'height' => '35',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
        		'offset' => 2,
            ),
        );
    }

    public function actionIndex() {
        if($this->getSession('assistantId')){
            $this->redirect(array('/seller/assistantManage/defaultShow'));
        }else{
            $this->redirect(array('/seller/store/view'));
        }

    }

    /**
     * 登录
     */
    public function actionLogin() {
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->homeUrl);
        $this->layout = false;
        $model = new SellerLoginForm;
        $this->performAjaxValidation($model);
        $users = array();
        if (isset($_POST['SellerLoginForm'])) {
            $model->attributes = $this->getPost('SellerLoginForm');
            //手机号登录，多个账号情况
            if(isset($_POST['gai_number'])){
                $model->username = $_POST['gai_number'];
            }
            //手机号登录，多个账号情况
            if(is_numeric($model->username)){
                $users = Yii::app()->db->createCommand()->select('gai_number')->from('{{member}}')->where('mobile=:m',array(':m'=>$model->username))->queryAll();
                if(count($users)>1){
                    $tmpUsers = array();
                    foreach($users as $k => $v){
                        $tmpUsers[$v['gai_number']] = $v['gai_number'];
                    }
                    $users = $tmpUsers;
                    $model->addError('username','');
                }else{
                    $users = array();
                }
            }
            if ($model->validate(null,false) && $model->login()){
                SellerLog::create(SellerLog::CAT_LOGIN,SellerLog::logTypeUpdate,0,'登录成功');
                Yii::app()->session['login_redirect_confirm'] = false;
                Yii::app()->session['login_redirect'] = $this->createAbsoluteUrl('');
                //$this->redirect(DOMAIN.'/confirm/index');
                 $this->redirect(Yii::app()->homeUrl);
            }
        }
        $this->render('login', array(
            'model' => $model,
            'users' => $users,
        ));
    }

    public function actionError() {
        $this->layout = 'seller';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * 退出登录
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(array('/seller/home/login'));
    }

    /**
     * 屏蔽ie6-7
     */
    public function actionNotSupported(){
        $this->layout = false;
        $this->renderPartial('notsupported');
    }
}
