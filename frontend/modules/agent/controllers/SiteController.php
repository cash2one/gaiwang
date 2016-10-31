<?php

class SiteController extends Controller
{
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

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->redirect(array('/agent/member'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if($this->getUser()->getId())
		{
			$this->redirect(Yii::app()->homeUrl);
		}
		$this->layout = false;
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=  $this->getPost('LoginForm');
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
			{
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	/*
	 * 获取和更新当前用户的在线状态的ajax
	 */
	public function actionGetOnlineCount()
	{
		if($this->isAjax())
		{
			$user_id = $this->getUser()->getId();
			$count = User::model()->getOnlineCount($user_id);
			echo CJSON::encode(array('Error'=>$count));
		}
		Yii::app()->end();
	}
	
	public function actionTest()
	{
//		Yii::app()->codeCache->get('aaa');
//		phpinfo();die;
//		header("Content-type: text/html; charset=utf-8"); 
//		$sql = 'SELECT top 5 * FROM [dbo].[Machine];';
//		$data = Yii::app()->dbmssql->createCommand($sql)->queryAll();
//		Tool::pr($data);die;
//		$this->render('test');
//		Yii::app()->request->enableCsrfValidation = false;
//		echo Yii::app()->request->enableCsrfValidation;
//		$image_src = Tool::resizeImage('2013\13030300BF1E102F199D46D88112DA7B87E82277.jpg', 500, 400);
//		echo '<img src="'.$image_src.'"/>';
//		$this->render('test');
	}
}
