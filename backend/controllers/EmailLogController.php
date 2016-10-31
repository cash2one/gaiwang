<?php
class EmailLogController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

 
    /**
     * 短信发送记录
     */
    public function actionAdmin() {
        $model = new EmailLog('search');
        $model->unsetAttributes();
        if (isset($_GET['EmailLog']))
            $model->attributes = $_GET['EmailLog'];       
        $this->render('admin', array(
            'model' => $model,
        ));
    }

}
