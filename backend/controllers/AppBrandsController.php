<?php

class AppBrandsController extends Controller
{
	
	public function actionAdmin(){
		
		$model = new AppBrands('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['AppBrands']))
			$model->attributes=$_GET['AppBrands'];
		$this->render('index',array(
				'model'=>$model,
		));
	}
	
	public function actionCreate(){
		$model = new AppBrands('create');
		$this->performAjaxValidation($model);
		if(isset($_POST['AppBrands']))
		{
			//var_dump(1111);die();
			$appBrands = $this->getPost('AppBrands');
			$model->attributes = $appBrands;
		
			$saveDir = 'AppBrands/'.time();
			$model = UploadedFile::uploadFile($model, 'img',$saveDir);
		
			$db = Yii::app()->db;
			$model->update_time = $model->create_time = time();
			$model->admin =Yii::app()->user->id;
			$ImageSize = getimagesize($_FILES['AppBrands']['tmp_name']['img']);
			if($ImageSize[0] !=1080 || $ImageSize[1] !=628 ){
				$model->addError("img","请上传1080*628的图片");
				$this->render('create',array(
						'model'=>$model,
				));exit;
			}
			if($model->save()){
				UploadedFile::saveFile('img', $model->img);
				$this->setFlash('success', Yii::t('AppBrands', '创建品牌馆专题成功') . '"' . $model->title . '"' . Yii::t('AppBrands', '成功'));
				$this->redirect(array('admin'));
			}
		}
		$this->render('create',array(
				'model'=>$model,
		));
	}
	
	public function actionUpdate($id){
		$model = $this->loadModel($id);
		$this->performAjaxValidation($model);
		if(isset($_POST['AppBrands']))
		{
			$oldImg = $model->img;
			//var_dump(1111);die();
			$appBrands = $this->getPost('AppBrands');
			$model->attributes = $appBrands;
		
			$saveDir = 'AppBrands/'.time();
			$model = UploadedFile::uploadFile($model, 'img',$saveDir);
			//处理图片
			if(empty($_FILES['AppBrands']['name']['img'])){
				$model->img = $oldImg;
				$del = false;
			}else{
				$model = UploadedFile::uploadFile($model, 'img',$saveDir);
				$ImageSize = getimagesize($_FILES['AppBrands']['tmp_name']['img']);
				if($ImageSize[0] !=1080 || $ImageSize[1] !=628 ){
					//	$save = true;
					$model->addError("img","请上传1080*628的图片");
					$this->render('update',array(
							'model'=>$model,
					));exit;
				}
				$del = true;
			}
			$db = Yii::app()->db;
			$model->update_time = $model->create_time = time();
			$model->admin =Yii::app()->user->id;
			if($model->save()){
				if($del) UploadedFile::saveFile('img', $model->img,$oldImg,true);
				$this->setFlash('success', Yii::t('AppBrands', '创建品牌馆专题成功') . '"' . $model->title . '"' . Yii::t('AppBrands', '成功'));
				$this->redirect(array('admin'));
			}
		}
		$this->render('create',array(
				'model'=>$model,
		));
	}

    public function actionDelete($id){
    	try {
    		$model=$this->loadModel($id);
    		$brandsId = $model->id;
    		$transaction = Yii::app()->db->beginTransaction();//事务
    		Yii::app()->db->createCommand()
    		->delete(AppBrands::model()->tableName(), "id=:id", array(
    				':id' => $id,
    		));
    		Yii::app()->db->createCommand()
	    		->delete(AppBrandsGoods::model()->tableName(), "brands_id=:brandsId and type = :type", array(
	    		':brandsId' => $brandsId,
	    		':type'=>1,
    		));
	    	$transaction->commit();
    		UploadedFile::delete(ATTR_DOMAIN.DS.$model->img);
    		$this->redirect(array('admin'));
    	} catch (Exception $e) {
    		$transaction->Rollback();
    		echo $e->getMessage();
    	}
	}
}