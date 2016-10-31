<?php

class HosSellOrderController extends Controller
{
	public function actionIndex()
	{
		$model = new HosSellOrder();
		if(isset($_GET['HosSellOrder'])){
			$model->name = $_GET['HosSellOrder']['name'];
			$model->type = $_GET['HosSellOrder']['type'];
		}
		$this->render('index',array(
				'model'=>$model,
		));
	}

	public function actionCreate()
	{
		$model = new HosSellOrder('create');
		$this->performAjaxValidation($model);
		if(isset($_POST['HosSellOrder'])){
			$hosSellOrder = $this->getPost('HosSellOrder');
			$model->attributes = $hosSellOrder;
			$saveDir = 'HosSellOrder/'.time();
			
			$model = UploadedFile::uploadFile($model, 'logo',$saveDir);
			
			$db = Yii::app()->db;
			
			$model->update_time =time();
			$model->create_time =time();
			$model->create_user =Yii::app()->user->id;
			$model->update_user =Yii::app()->user->id;
			$ImageSize = getimagesize($_FILES['HosSellOrder']['tmp_name']['logo']);
			if($ImageSize[0] !=250 || $ImageSize[1] !=250 ){
				$model->addError("logo","请上传250*250的图片");
				$this->render('create',array(
						'model'=>$model,
				));exit;
			}
			if($model->save()){
				UploadedFile::saveFile('logo', $model->logo);
				//$this->setFlash('success', Yii::t('HosSellOrder', '创建盖象APP新动专题') . '"' . $model->title . '"' . Yii::t('AppTopicCar', '成功'));
				$this->redirect(array('index'));
			}
		}
		$this->render('create',array(
				'model'=>$model,
			//	'action'=>'create',
		));
	}
	
	public function actionUpdate($id){
		$model=$this->loadModel($id);
		$this->performAjaxValidation($model);
		
		if(isset($_POST['HosSellOrder'])){
			$oldLogo = $model->logo;
			
			$hosSellOrder = $this->getPost('HosSellOrder');
			$model->attributes = $hosSellOrder;
			$saveDir = 'HosSellOrder/'.time();
				
			$model = UploadedFile::uploadFile($model, 'logo',$saveDir);
			//var_dump($model);die();
			$db = Yii::app()->db;
			
			//处理图标图片
			if(empty($_FILES['HosSellOrder']['name']['logo'])){
				$model->logo = $oldLogo;
			}else{
				$model = UploadedFile::uploadFile($model, 'logo',$saveDir);
				$ImageSize = getimagesize($_FILES['HosSellOrder']['tmp_name']['logo']);
				if($ImageSize[0] !=250 || $ImageSize[1] !=250 ){
					$model->addError("logo","请上传250*250的图片");
					$this->render('update',array(
							'model'=>$model,
					));exit;
				}
			}
				
			$model->update_time =time();
			$model->update_user =Yii::app()->user->id;
			
			if($model->save()){
				UploadedFile::saveFile('logo', $model->logo,$oldLogo,true);
				//$this->setFlash('success', Yii::t('HosSellOrder', '创建盖象APP新动专题') . '"' . $model->title . '"' . Yii::t('AppTopicCar', '成功'));
				$this->redirect(array('index'));
			}
		}
		
		$this->render('update',array(
				'model'=>$model,
			//	'action'=>'update',
		));
	}
	
	public function actionDelete($id){
		Yii::app()->db->createCommand()
			->delete(HosSellOrder::model()->tableName(), "id=:id", array(
			':id' => $id,
		));
		$this->redirect(array('index'));
	}
	
	public function actionChange($id){
		$model=$this->loadModel($id);
		$status = $model->status == HosSellOrder::HOT_SELL_STATUS_YES ? HosSellOrder::HOT_SELL_STATUS_NO : HosSellOrder::HOT_SELL_STATUS_YES;
		if($model->status == 1){
			Yii::app()->db->createCommand()->update(HosSellOrder::model()->tableName(), array(
			'status' => $status,
			), "id='{$model->id}'");
		}else{
			$sql = "SELECT * FROM ".HosSellOrder::model()->tableName()." where type = '{$model->type}' and status = '".HosSellOrder::HOT_SELL_STATUS_YES."' and id != '{$model->id}'";
			$result = Yii::app()->db->createCommand($sql)->queryRow();
			if($result){
				$this->setFlash('error', "已存在正在使用的入口类型,改变<".$model->name.">入口的状态失败!");
				$this->redirect(array('index'));
			}else{
				Yii::app()->db->createCommand()->update(HosSellOrder::model()->tableName(), array(
				'status' => $status,
				), "id='{$model->id}'");
			}
		}
		$this->setFlash('success', "改变<".$model->name.">入口的状态成功!");
		$this->redirect(array('index'));
	}
}