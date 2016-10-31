<?php

class SiteController extends Controller {

    public function actions() {
        return array(
            'selectLanguage' => array('class' => 'CommonAction','method'=>'selectLanguage'),
        );
    }

    public function actionIndex() {
        //客户端
        $url = '';
        $res = Yii::app()->db->createCommand()->from('{{app}}')->where('system=1 and is_visible=1 and is_published=1')->order('id desc')->queryRow();
        if (!empty($res) && $res['url'])
            $url = $res['url'];
        $this->render('index', array('url_android' => $url));
    }

    public function actionError() {
        $this->layout = 'app';
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
	public function actionVideo(){
		$this->layout = false;
		$this->render('video');
	}
}