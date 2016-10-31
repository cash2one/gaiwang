<?php
class SmsLogController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

 
    /**
     * 短信发送记录
     */
    public function actionAdmin() {
        $model = new SmsLog('search');
        $model->unsetAttributes();
        if (isset($_GET['SmsLog']))
            $model->attributes = $_GET['SmsLog'];       
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
