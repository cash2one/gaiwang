<?php

class AppHomePictureController extends Controller
{
	public function actionAdmin()
	{
		$model = new AppHomePicture();
		//$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AppHomePicture'])){
			$model->title = $_GET['AppHomePicture']['title'];
			$model->start_time = strtotime($_GET['AppHomePicture']['start_time']);
			$model->end_time =strtotime($_GET['AppHomePicture']['end_time']);
		}
		
		$this->render('index', array(
				'model' => $model,
		));
		//$this->render('index');
	}

	public function actionCreate()
	{
		$model = new AppHomePicture('create');
		$this->performAjaxValidation($model);
		if(isset($_POST['AppHomePicture']))
		{
			$appHomePicture = $this->getPost('AppHomePicture');
			$model->attributes = $appHomePicture;

			$saveDir = 'AppHomePicture/'.time();
			$model = UploadedFile::uploadFile($model, 'image',$saveDir);
			
			$db = Yii::app()->db;
			$model->start_time = strtotime($model->start_time);
			$model->end_time = strtotime($model->end_time);
 			$model->update_time =time();
			$model->admin =Yii::app()->user->id;
			$ImageSize = getimagesize($_FILES['AppHomePicture']['tmp_name']['image']);
			if($ImageSize[0] !=1242 || $ImageSize[1] !=2208 ){
				    $model->addError("image","请上传1242*2208的图片");
					$this->render('create',array(
							'model'=>$model,
					));exit;
			}
			if($model->save()){
				UploadedFile::saveFile('image', $model->image);
				$this->setFlash('success', Yii::t('AppHomePicture', '创建欢迎页专题成功') . '"' . $model->title . '"' . Yii::t('AppHomePicture', '成功'));
				$this->redirect(array('admin'));
			}
		}
		$this->render('create',array(
				'model'=>$model,
		));
	}
	
	
	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$this->performAjaxValidation($model);
		if(isset($_POST['AppHomePicture']))
		{
			
			$oldImage = $model->image;
			$oldStartTime = $model->start_time;
			$oldEndTime = $model->end_time;
			//$oldVersion = $model->version;
			$appHomePicture = $this->getPost('AppHomePicture');
			$model->attributes = $appHomePicture;
	
			$saveDir = 'AppHomePicture/'.time();
			$model = UploadedFile::uploadFile($model, 'image',$saveDir);
			$db = Yii::app()->db;
			
			
			$model->start_time = strtotime($model->start_time);
			$model->end_time = strtotime($model->end_time);
			$model->update_time =time();
			//处理图片
			//$save = false;
			if(empty($_FILES['AppHomePicture']['name']['image'])){
				$model->image = $oldImage;
				$del = false;
			}else{
				$model = UploadedFile::uploadFile($model, 'image',$saveDir);
				$ImageSize = getimagesize($_FILES['AppHomePicture']['tmp_name']['image']);
				if($ImageSize[0] !=1242 || $ImageSize[1] !=2208 ){
				//	$save = true;
					$model->addError("image","请上传1242*2208的图片");
					$this->render('update',array(
							'model'=>$model,
					));exit;
				}
				$del = true;
			}
			if($oldImage != $model->image || $oldStartTime != $model->start_time ||  $oldEndTime != $model->end_time){
				$model->version = $model->version + 1;
			}
			$model->admin =Yii::app()->user->id;
			if($model->save()){
				if($del) UploadedFile::saveFile('image', $model->image,$oldImage,true);
				$this->setFlash('success', Yii::t('AppHomePicture', '保存欢迎页专题成功') . '"' . $model->title . '"' . Yii::t('AppHomePicture', '成功'));
				$this->redirect(array('admin'));
			}
		}
		$this->render('update',array(
				'model'=>$model,
		));
	}

	
	public function actionDelete($id){
		$model=$this->loadModel($id);
		Yii::app()->db->createCommand()
					->delete(AppHomePicture::model()->tableName(), "id=:id", array(
						':id' => $id,
					));
		UploadedFile::delete(ATTR_DOMAIN.DS.$model->image);
		$this->redirect(array('admin'));
	}
}