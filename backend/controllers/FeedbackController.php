<?php

class FeedbackController extends Controller
{

    public function filters() {
        return array(
            'rights',
        );
    }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		@SystemLog::record(Yii::app()->user->name."用户关键字id:{$id} 删除成功");

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	
	
	public function actionAdmin()
	{
		//$model=new Feedback;
		$model = new Feedback('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Feedback']))
            $model->attributes = $_GET['Feedback'];
        $this->render('admin', array(
            'model' => $model,
        ));
	}

	/**
	 * 查看详细
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) {
	    //$this->breadcrumbs = array(Yii::t('order', '订单管理 '), Yii::t('order', '订单查看'));
	    /** @var $model Order */
	    $model = $this->loadModel($id);
	
	    $this->render('view', array(
	        'model' => $model,
	    ));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Feedback the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Feedback::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
