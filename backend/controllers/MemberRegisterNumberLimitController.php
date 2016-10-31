<?php

class MemberRegisterNumberLimitController extends Controller
{
	public function actionIndex()
	{
		$model = new MemberRegisterNumberLimit();
		if(isset($_GET['MemberRegisterNumberLimit']))
			$model->attributes = $this->getParam('MemberRegisterNumberLimit');
		$this->render('index',array(
				'model'=>$model,
		));
	}
	
	/**
	 * Create
	 */
	public function actionMemberCreate(){
		$model = new MemberRegisterNumberLimit();
		if(isset($_POST['MemberRegisterNumberLimit'])){
			$model->attributes = $_POST['MemberRegisterNumberLimit'];
			$model->create_admin_id = $this->getUser()->getId();
			$model->create_time = time();
			if($model->save()){
				$this->redirect(array('index'));
			}
		}
		$this->render('create',array(
			     'model'=>$model,	
		));
	}
	
	public function actionMemberUpdate($id){
		$model = $this->loadModel($id);
	    if(isset($_POST['MemberRegisterNumberLimit'])){
			$model->attributes = $_POST['MemberRegisterNumberLimit'];
			$model->update_admin_id = $this->getUser()->getId();
			$model->update_time = time();
			if($model->save()){
				$this->redirect(array('index'));
			}
		}
		$this->render('create',array(
			     'model'=>$model,
				 'type'=>'update',	
		));
	}
	
	public function actionDelete($id){
		$deletesql = "delete from ".MemberRegisterNumberLimit::model()->tablename()." where id = '".$id."'";
		Yii::app()->db->createCommand($deletesql)->execute();
		$this->redirect(array('index'));
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