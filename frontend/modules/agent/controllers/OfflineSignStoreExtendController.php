<?php

class OfflineSignStoreExtendController extends Controller
{
	protected function setCurMenu($name) {
		$this->curMenu = Yii::t('main', '电子化签约管理');
	}

	/**
	 *选择签约新建类型
	 */
	public function actionSelectCreate(){
		$this->render('selectCreate');
	}

	/**
	 * 原有会员新增加盟商
	 */
	public function actionOldFranchisee(){
		$this->render('oldFranchisee');
	}

	/**
	 * 原有会员新增加盟商
	 * ajax获取会员信息
	 */
	public function actionAjaxGetInfo(){
		if ($this->isAjax() && $this->isPost()) {
			$str = $this->getPost('str');
			$flag = $this->getPost('flag');
			$enterpriseInfo = array();
			if($flag == 0){					//为GW号
				$enterpriseInfo = Yii::app()->db->createCommand()
					->select('id as mid,enterprise_id as eid')
					->from(Member::model()->tableName())
					->where('gai_number=:str and enterprise_id != 0',array(':str'=>$str))
					->queryRow();
			}elseif($flag == 1){			//为企业名
				$enterpriseInfo = Yii::app()->db->createCommand()
					->select('e.id as eid,m.id as mid')
					->from(Enterprise::model()->tableName() . ' as e')
					->leftJoin(Member::model()->tableName() . ' as m','e.id = m.enterprise_id')
					->where('name=:str',array(':str'=>$str))
					->queryRow();
			}
			if($enterpriseInfo){
				exit(json_encode(array('success'=>1,'enterpriseInfo'=>$enterpriseInfo)));
			}else{
				exit(json_encode(array('error' =>'此盖网号或企业名不存在或不存在该企业信息，请重新搜索')));
			}
		}
	}


	/**
	 * 继续编辑【未提交状态下】
	 * 资质表中无企业信息id则进入第二步，有则进入第三步
	 * (只有新商户才能继续编辑)
	 */
	public function actionContinueUpdate(){
		$id = $this->getParam('id');
		if(empty($id)){
			$this->setFlash('error', '休要捣乱');
			$this->redirect(array('offlineSignStoreExtend/admin'));
		}
		//拉取状态是未提交的申请类型是新用户的店铺数据
		$params = array('id'=>$id,'status'=>OfflineSignStoreExtend::AUDIT_STATUS_NOT_SUBMIT);
		$extends = OfflineSignStoreExtend::model()->find('id=:id and status=:status',$params);
		if(empty($extends)){
			$this->setFlash('error','休要捣乱');
			$this->redirect(array('offlineSignStoreExtend/admin'));
		}
		if($extends->offline_sign_enterprise_id)
			$this->redirect(array('offlineSignStore/create','storeExtendId'=>$id));
		else
			$this->redirect(array('offlineSignEnterprise/create','storeExtendId'=>$id));
	}

	/**
	 * 资质详情
	 * @param int $id 资质id
	 * @throws CHttpException
	 */
	public function actionQualificationDetails($id){
		$extendModel = OfflineSignStoreExtend::model()->findByPk($id);
		if($extendModel->offline_sign_enterprise_id)
			$enterpriseModel = OfflineSignEnterprise::model()->findByPk($extendModel->offline_sign_enterprise_id);
		if($extendModel->offline_sign_contract_id)
			$contractModel = OfflineSignContract::model()->findByPk($extendModel->offline_sign_contract_id);
		$storeModel = new OfflineSignStore();
		$storeModel->extend_id = $extendModel->id;
		$criteria = $storeModel->searchView();
		$storeData = $storeModel->findAll($criteria);
		$this->render('qualificationDetails',array(
			'extendModel'=>$extendModel,
			'enterpriseModel'=>isset($enterpriseModel) ? $enterpriseModel : '',
			'contractModel'=>isset($contractModel) ? $contractModel : '',
			'storeData'=>$storeData,
		));
	}
	/**
	 * 不通过原因
	 * @param int $id 资质id
	 * @throws CHttpException
	 */
	public function actionCanNotPass($id){
		$extendModel = OfflineSignStoreExtend::model()->findByPk($id);
		if($extendModel->offline_sign_enterprise_id)
			$enterpriseModel = OfflineSignEnterprise::model()->findByPk($extendModel->offline_sign_enterprise_id);
		if($extendModel->offline_sign_contract_id)
			$contractModel = OfflineSignContract::model()->findByPk($extendModel->offline_sign_contract_id);
		$storeModel = new OfflineSignStore();
		$storeModel->extend_id = $extendModel->id;
		$criteria = $storeModel->searchView();
		$storeData = $storeModel->findAll($criteria);
		$this->render('canNotPass',array(
			'extendModel'=>$extendModel,
			'enterpriseModel'=>isset($enterpriseModel) ? $enterpriseModel : '',
			'contractModel'=>isset($contractModel) ? $contractModel : '',
			'storeData'=>$storeData,
		));
	}

	/**
	 * 上传合同（新商户为pdf文档，原有会员新增加盟商是图片格式）
	 */
	public function actionUploadContract(){
		$id = $this->getParam('storeExtendId');
		$model = OfflineSignStoreExtend::model()->findByPk($id);
        OfflineSignStoreExtend::setExtendAreaId($model);
		$model->setScenario('pdf');//此处没有限制文件类型
		if(isset($_POST['OfflineSignStoreExtend'])){
			$dataArr = $this->getPost('OfflineSignStoreExtend');
			$model->upload_contract = !empty($dataArr['upload_contract'])?$dataArr['upload_contract']:'';
            $model->upload_contract_img = !empty($dataArr['upload_contract_img'])?implode(',',$dataArr['upload_contract_img']):'';
			$model->_setStatusAndAuditStatus('upload');
            $model->create_time = time();
            $model->update_time = time();
			if($model->validate(array('upload_contract','upload_contract_img')) && $model->save(false,array('upload_contract','upload_contract_img','status','audit_status','role_1_audit_status','create_time','update_time'))){
				$auditModel = new OfflineSignAuditLogging($id,'1002');
				$auditModel->save(false);
                $sign_audit_logging = new OfflineSignAuditLogging();
                $sign_audit_logging->updateAll(array('error_field'=>''),'extend_id = :extend_id and status = :status and audit_role = :audit_role',array(':extend_id'=>$id,':status'=>OfflineSignAuditLogging::STATUS_NO_PASS,':audit_role'=>OfflineSignAuditLogging::ROLE_REGIONAL_SALES));
                if($model->offline_sign_enterprise_id) {
                    $enterpriseModel = OfflineSignEnterprise::model()->findByPk($model->offline_sign_enterprise_id);
                    $enterpriseModel->error_field =  '';
                    $enterpriseModel->save(false,array('error_field'));
                }
                if($model->offline_sign_contract_id) {
                    $contractModel = OfflineSignContract::model()->findByPk($model->offline_sign_contract_id);
                    $contractModel->error_field =  '';
                    $contractModel->save(false,array('error_field'));
                }
                $model->error_field =  '';
                $storeId = OfflineSignStoreExtend::getAllStoreId($id);
                if(!empty($storeId)){
                    foreach($storeId as $val){
                        $storeEM = OfflineSignStore::model()->findByPk($val['id']);
                        $storeEM->error_field = '';
                        $storeEM->save(false);
                    }
                }
                $model->save(false,array('error_field'));
				$this->setFlash('success', '添加成功');
				$this->redirect(array('offlineSignAuditLogging/seeAudit','storeExtendId'=>$id));
			}
		}
        $storeModel = new OfflineSignStore();
        $storeModel->extend_id = $model->id;
        $criteria = $storeModel->searchView();
        $storeData = $storeModel->findAll($criteria);
		$model->upload_contract = '';
        $model->upload_contract_img = '';
        $storeNum = count($storeData);
		$this->render('uploadContract',array('model'=>$model,'storeNum'=>$storeNum));
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OfflineSignStoreExtend('search');
		$model->unsetAttributes();
		if(isset($_GET['OfflineSignStoreExtend'])) {
            $model->attributes = $_GET['OfflineSignStoreExtend'];
            $model->apply_type = $_GET['apply_type'];
            $model->status = $_GET['status'];
        }

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OfflineSignStoreExtend the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OfflineSignStoreExtend::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OfflineSignStoreExtend $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='offline-sign-store-extend-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
