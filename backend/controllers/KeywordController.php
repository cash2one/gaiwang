<?php

class KeywordController extends Controller
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
		@SystemLog::record(Yii::app()->user->name."商品搜索关键字id:{$id} 删除成功");

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Keyword('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Keyword']))
			$model->attributes=$_GET['Keyword'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Keyword the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Keyword::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
