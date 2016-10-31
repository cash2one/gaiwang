<?php

class OfflineSignEnterpriseController extends Controller
{
	//存储临时数据key
	private $tmpDataKey = 'offline_sign_enterprise_model_tmpdata';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$extendId = $this->getParam('storeExtendId');
		if(empty($extendId)){
			$this->setFlash('error', '非法访问');
			$this->redirect(array('offlineSignStoreExtend/admin'));
		}
		$model = new OfflineSignEnterprise();
        $this->performAjaxValidation($model);
		$extendModel = OfflineSignStoreExtend::model()->findByPk($extendId);
		if($this->isPost()){
			$postData = $this->getPost('OfflineSignEnterprise');
			$model->attributes = $postData;
			//点击上一步，暂存数据并跳转到上一步
			if($model->step == OfflineSignEnterprise::LAST_STEP){
				$this->_syncTmpData($this->tmpDataKey,$postData);
				$this->redirect(array('offlineSignContract/newFranchiseeUpdate','id'=>$extendModel->id)); //点击上一步，返回到编辑合同页面
			}
			if($model->save()){
				//流程记录
				$auditModel = new OfflineSignAuditLogging($extendId,'1102');
				$auditModel->save(false);
				$extendModel->offline_sign_enterprise_id = $model->id;
				$extendModel->save();
				$this->setFlash('success', '添加成功');
				$this->redirect(array('offlineSignStore/update','storeExtendId'=>$extendId)); //点击下一步，进入新建店铺页面
			}
			$model->registration_time = empty($model->registration_time) ? null : date('Y-m-d',$model->registration_time);
			$model->license_begin_time = empty($model->license_begin_time) ? null : date('Y-m-d',$model->license_begin_time);
			$model->license_end_time = empty($model->license_end_time) ? null : date('Y-m-d',$model->license_end_time);
		}

		$model->attributes = $this->_syncTmpData($this->tmpDataKey);
		$demoImgs = Tool::getConfig('offlinesigndemoimgs');
		$this->render('create',array(
			'model'=>$model,
			'demoImgs' => $demoImgs
		));
	}

	/**
	 * 编辑电签--企业信息
	 */
	public function actionUpdate(){
        $storeExtendId = $this->getParam('storeExtendId');
		$enterpriseId = $this->getParam('enterpriseId');
		if(empty($storeExtendId)){
			$this->setFlash('error', '非法访问');
			$this->redirect(array('offlineSignStoreExtend/admin'));
		}
        if(empty($enterpriseId)){
            $this->redirect(array('offlineSignEnterprise/create','storeExtendId'=>$storeExtendId));
        }
		$model = $this->loadModel($enterpriseId);
        $this->performAjaxValidation($model);
    //    echo "<pre>";var_dump($model->getValidatorList());exit;
		if($this->isPost()){
			$postData = $this->getPost('OfflineSignEnterprise');
			$model->attributes = $postData;

			//点击上一步，暂存数据并跳转到上一步
			if($model->step == OfflineSignEnterprise::LAST_STEP){
				$this->_syncTmpData($this->tmpDataKey,$postData);
				$this->redirect(array('offlineSignContract/newFranchiseeUpdate','id'=>$storeExtendId)); //点击上一步，返回到编辑合同页面
			}

			if($model->save()){
				$auditModel = new OfflineSignAuditLogging();
				$auditModel->extend_id = $storeExtendId;
				$auditModel->audit_role = OfflineSignAuditLogging::ROLE_AGENT;
				$auditModel->behavior = '1105';
				if($auditModel->save(false)) {
                    $this->setFlash('success', '添加成功');
                    $this->redirect(array('offlineSignStore/update', 'storeExtendId' => $storeExtendId)); //点击下一步，进入新建店铺页面
                }
			}
			$model->registration_time = empty($model->registration_time) ? null : date('Y-m-d',$model->registration_time);
			$model->license_begin_time = empty($model->license_begin_time) ? null : date('Y-m-d',$model->license_begin_time);
			$model->license_end_time = empty($model->license_end_time) ? null : date('Y-m-d',$model->license_end_time);
		}

		$model->attributes = $this->_syncTmpData($this->tmpDataKey);
		$demoImgs = Tool::getConfig('offlinesigndemoimgs');
		return $this->render('update',array('model'=>$model,'demoImgs'=>$demoImgs));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OfflineSignEnterprise the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OfflineSignEnterprise::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OfflineSignEnterprise $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']))
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
