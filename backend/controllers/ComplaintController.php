<?php

/**
 * 投诉建议控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class ComplaintController extends Controller {

    public function actionAdmin() {
        $model = new Complaint('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Complaint']))
            $model->attributes = $_GET['Complaint'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    /**
     * 查看一条投诉建议
     * @param int $id
     */
    
    public function actionUpdate($id)
    {
    	$this->render('_form',array(
    			'model'=>$this->loadModel($id),
    	));
    }

    
    /**
     * 删除
     * @param int $id
     */
    public function actionDelete($id) {
    	$this->loadModel($id)->delete();
    	//@SystemLog::record(Yii::app()->user->name . "删除投诉建议：{$id}");
    
    	if (!isset($_GET['ajax']))
    		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    
}
