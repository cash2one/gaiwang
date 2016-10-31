<?php

class AppSubPayManageController extends Controller
{
	public function actionIndex()
	{
		$ManageType = $this->getParam("type"); //大的支付类型  现金+积分  现金
		$model = new AppSubPayManage();
		$model->payType = $ManageType;
		//var_dump($model,$ManageType);die();
		$this->render('index',array(
				'model'=>$model,
				'ManageType'=>$ManageType,
		));
	}
	
	
	public function actionUpdate(){
		$id = $this->getParam("id");
		$payType = $this->getParam("paytype"); //大的支付类型  现金+积分  现金
		$model = $this->loadModel($id);
		$model->payType = $payType;
		$this->performAjaxValidation($model); 
		if(isset($_POST['AppSubPayManage']))
		{
			
			$AppSubPayManage = $this->getPost('AppSubPayManage');
			$payType = isset($AppSubPayManage['status_jfandcash']) ? AppPayManage::APP_PAY_TYPE_JFANDCASH : AppPayManage::APP_PAY_TYPE_CASH;
			$model->attributes = $AppSubPayManage;
			//var_dump($model,$payType);die();
			if($model->save()){
				$this->setFlash('success',"修改成功");
				$this->redirect(array('index',
						'type'=>$payType,
				));
			}
		}
		//var_dump($model,$payType);die();
		$this->render('_form',array(
				'model'=>$model,
				'ManageType'=>$payType,
		));
	}
	
	
	public function actionChange(){
		$id = $this->getParam("id");
		$payType = $this->getParam("paytype"); //大的支付类型  现金+积分  现金
		$model = $this->loadModel($id);
		if($payType == AppPayManage::APP_PAY_TYPE_JFANDCASH){
			$model->status_jfandcash = $model->status_jfandcash == AppSubPayManage::PAY_TYPE_STATUS_YES ? AppSubPayManage::PAY_TYPE_STATUS_NO : AppSubPayManage::PAY_TYPE_STATUS_YES ;
		}
		if($payType == AppPayManage::APP_PAY_TYPE_CASH){
			$model->status_cash = $model->status_cash == AppSubPayManage::PAY_TYPE_STATUS_YES ? AppSubPayManage::PAY_TYPE_STATUS_NO : AppSubPayManage::PAY_TYPE_STATUS_YES ;
		}
		if($model->save(false)){
			//$this->setFlash('success',"修改成功");
			$this->redirect(array('index',
					'type'=>$payType,
			));
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