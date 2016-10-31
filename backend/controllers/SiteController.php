<?php

/**
 * 后台默认控制器
 * 操作(首页,登录,退出)
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class SiteController extends Controller {

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'common.widgets.CaptchaAction',
                'backColor' => 0xFFFFFF,
                'foreColor' => 0x2040A0,
                'height' => '35',
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('SystemLog', array(
            'criteria' => array(
                'order' => 'create_time DESC',
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    public function actionLogin() {
        $this->layout = false;
        $model = new LoginForm;

        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->homeUrl);

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate() && $model->login()) {
//            	@SystemLog::record(Yii::app()->user->name."用户登录");
                $this->redirect(array('/main/user-info'));
            }
        }
        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
		if (!Yii::app()->user->isGuest)
        	@SystemLog::record(Yii::app()->user->name . "用户注销");
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

}
