<?php
//测试用控制器
class SiteController extends Controller {

    public function actionIndex() {

    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest) {
                echo $error['message'];
            } else {
                $this->render('application.views.error', $error);
            }

        }
    }
}

