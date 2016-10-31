<?php

/**
 * 报修控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class RepairsController extends Controller {

	/**
	 * 查看电话报修详情
	 * @param int $id
	 */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        
        $this->render('_form', array(
            'model' => $model,
        ));
    }

    /**
     * 电话报修列表
     */
    public function actionAdmin() {
        $model = new Repairs('search');
        $model->unsetAttributes();
        if (isset($_GET['Repairs']))
            $model->attributes = $_GET['Repairs'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    /**
     * 删除
     * @param int $id
     */
    public function actionDelete($id) {
    	$this->loadModel($id)->delete();
    	//@SystemLog::record(Yii::app()->user->name . "删除电话报修：{$id}");
    	if (!isset($_GET['ajax']))
    		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

}
