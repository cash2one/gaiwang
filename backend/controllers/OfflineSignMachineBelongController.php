<?php

class OfflineSignMachineBelongController extends Controller
{

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OfflineSignMachineBelong('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OfflineSignMachineBelong']))
			$model->attributes=$_GET['OfflineSignMachineBelong'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
     * 获取归属方信息
     */
    public function actionGetMachines() {
    	$extendId = $this->getParam('extendId');
        $model = new OfflineSignMachineBelong('search');
        $model->unsetAttributes();
        if (isset($_GET['OfflineSignMachineBelong']))
            $model->attributes = $this->getParam('OfflineSignMachineBelong');
        $this->render('getmachine', array(
            'model' => $model,
            'extendId'=>isset($extendId)?$extendId:'',
        ));
    }
    /**
     * 设置归属方信息
     */
    public function actionSetMachines() {
        $extendId = $this->getParam('?extendId');
        $machine_name = $this->getParam('machine_name');
        if(empty($extendId) || empty($machine_name)){
            $this->setFlash('error','参数错误');
        }
        $extendModel = OfflineSignStoreExtend::model()->findByPk($extendId);
        if(!empty($machine_name))
            $extendModel->machine_belong_to = $machine_name;
        if($extendModel->save()){
            $error_field = $extendModel->error_field;
            if(!empty($error_field)) {
                $error_field = str_ireplace('ex.machine_belong_to', '', $error_field);
                $extendModel->error_field = $error_field;
                $extendModel->save(false);
            }
        }
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('OfflineSignMachineBelong');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new OfflineSignMachineBelong;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OfflineSignMachineBelong']))
		{
			$model->attributes=$_POST['OfflineSignMachineBelong'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OfflineSignMachineBelong']))
		{
			$model->attributes=$_POST['OfflineSignMachineBelong'];
			if($model->save())
				$this->redirect(array('admin'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	// public function actionDelete($id)
	// {
		// $this->loadModel($id)->delete();

		// // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		// if(!isset($_GET['ajax']))
		// 	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	// }
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OfflineSignMachineBelong the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OfflineSignMachineBelong::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OfflineSignMachineBelong $model the model to be validated
	 */
	public function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='offline-sign-machine-belong-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
