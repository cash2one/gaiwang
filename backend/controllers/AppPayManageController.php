<?php

class AppPayManageController extends Controller
{
	public function actionIndex()
	{
		$model = new AppPayManage();
		$modelData = $model->findAll();
		//$model->Attributes = $modelData;
		
		//var_dump($model);die();
		$this->render('index',array(
				'modelData'=>$modelData,
				'model'=>$model,
		));
	}

	
	public function actionUpdate(){
		$dataId = $this->getParam("DataId");
		$statusVal = $this->getParam("StatusVal");
		$model = $this->loadModel($dataId);
		$model->status = $statusVal;
		if($model->save(false)){
			exit(json_encode(array('success' => true)));
		}else{
			exit(json_encode(array('success' => false)));
		}
	}
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}