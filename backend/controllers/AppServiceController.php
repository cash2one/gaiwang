<?php

class AppServiceController extends Controller
{
	
	public function actionConsum()
	{
		$model = new AppService();
		$model->type = AppService::CONTENT_TYPE_CONSUM;
		$data = Yii::app()->db1->createCommand()->select('*')
		->from(AppService::model()->tableName())->where("type = '{$model->type}'")->queryRow();
		$model->id = $data['id'];
		if(isset($_POST['AppService'])){

			$model->content = $_POST['AppService']['content'];
			if(!empty($model->id)){
				Yii::app()->db->createCommand()->update(AppService::model()->tableName(),array(
				     'update_time'=>time(),
				     'update_user'=>Yii::app()->user->id,
				     'content' => $_POST['AppService']['content'],
				),"id='{$model->id}'");
				$this->render('index',array(
						'model'=>$model,
						'type'=>1
				));
			}else{
				$model->create_time = time();
				$model->create_user = Yii::app()->user->id;
				if($model->save()){
					$this->render('index',array(
							'model'=>$model,
							'type'=>1
					));
				}
			}
		}
		$model->content = $data['content'];
		$this->render('index',array(
				'model'=>$model,
				'type'=>0
		));
	}
	
	
	public function actionOrder()
	{
		$model = new AppService();
		$model->type = AppService::CONTENT_TYPE_ORDER;
			$data = Yii::app()->db1->createCommand()->select('*')
		->from(AppService::model()->tableName())->where("type = '{$model->type}'")->queryRow();
		$model->id = $data['id'];
		if(isset($_POST['AppService'])){

			$model->content = $_POST['AppService']['content'];
			if(!empty($model->id)){
				Yii::app()->db->createCommand()->update(AppService::model()->tableName(),array(
				     'update_time'=>time(),
				     'update_user'=>Yii::app()->user->id,
				     'content' => $_POST['AppService']['content'],
				),"id='{$model->id}'");
				$this->render('index',array(
						'model'=>$model,
						'type'=>1
				));
			}else{
				$model->create_time = time();
				$model->create_user = Yii::app()->user->id;
				if($model->save()){
					$this->render('index',array(
							'model'=>$model,
							'type'=>1
					));
				}
			}
		}
		$model->content = $data['content'];
		$this->render('index',array(
				'model'=>$model,
				'type'=>0
		));
	}
	
	public function actionPay()
	{
		$model = new AppService();
		$model->type = AppService::CONTENT_TYPE_PAY;
			$data = Yii::app()->db1->createCommand()->select('*')
		->from(AppService::model()->tableName())->where("type = '{$model->type}'")->queryRow();
		$model->id = $data['id'];
		if(isset($_POST['AppService'])){

			$model->content = $_POST['AppService']['content'];
			if(!empty($model->id)){
				Yii::app()->db->createCommand()->update(AppService::model()->tableName(),array(
				     'update_time'=>time(),
				     'update_user'=>Yii::app()->user->id,
				     'content' => $_POST['AppService']['content'],
				),"id='{$model->id}'");
				$this->render('index',array(
						'model'=>$model,
						'type'=>1
				));
			}else{
				$model->create_time = time();
				$model->create_user = Yii::app()->user->id;
				if($model->save()){
					$this->render('index',array(
							'model'=>$model,
							'type'=>1
					));
				}
			}
		}
		$model->content = $data['content'];
		$this->render('index',array(
				'model'=>$model,
				'type'=>0
		));
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