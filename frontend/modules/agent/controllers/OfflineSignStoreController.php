<?php

class OfflineSignStoreController extends Controller
{	
	//存储临时数据key
	private $tmpDataKey = 'offline_sign_store_model_tmpdata';


	/**
	 * ajax处理二级、三级分类
	 */
	public function actionDepthCategory(){
		if ($this->isPost()) {
			$pid = isset($_POST['pid']) ? (int) $_POST['pid'] : "9999999";
			$dropDownCities = "<option value=''>" . '经营类别（级别二）' . "</option>";
			$depthOne = OfflineSignStore::getChildCategory($pid);
			foreach ($depthOne as $value => $name)
				$dropDownCities .= CHtml::tag('option', array('value' => $value), CHtml::encode(Yii::t('region', $name)), true);
			echo CJSON::encode(array(
				'dropDownCategory' => $dropDownCities,
			));
		}else{
			echo array();
		}
	}

	/**
	 * 添加新商户--》生成店铺信息
	 */
	public function actionCreate()
	{
		if(isset($_GET['storeExtendId'])){
			$extendId = $this->getParam('storeExtendId');
			$extendModel = OfflineSignStoreExtend::model()->findByPk($extendId);
			$model=new OfflineSignStore();
			$model->setScenario('create');
            $this->performAjaxValidation($model);
            $enterpriseId = $extendModel->offline_sign_enterprise_id;
			if(isset($_POST['OfflineSignStore'])){
				$dataArr = $this->getPost('OfflineSignStore');
				$model->attributes = $dataArr;
				$model->franchisee_category_id = (!empty($dataArr['depthOne']) ? $dataArr['depthOne'] : (!empty($dataArr['depthZero']) ? $dataArr['depthZero'] : ''));
				$model->extend_id = $extendId;
                if($dataArr['step'] == OfflineSignEnterprise::LAST_STEP){
                    $this->_syncTmpData($this->tmpDataKey,$dataArr);
                    $this->redirect(array('offlineSignEnterprise/update','enterpriseId'=>$enterpriseId,'storeExtendId'=>$extendId));
                }
				if($model->save(false)){
					$auditModel = new OfflineSignAuditLogging($extendId, '1103');
					$auditModel->save(false);
					$this->setFlash('success', '添加成功');
                    if($model->step == OfflineSignStore::NEXT_STEP){
                        $auditModel = new OfflineSignAuditLogging($extendId, '1001');
                        $auditModel->save(false);
                        //点击下一步，进入审核记录页面
                        $extendModel->_setStatusAndAuditStatus();
                        $extendModel->save(false);
                        $this->redirect(array('offlineSignAuditLogging/seeAudit','storeExtendId'=>$extendId));
                    }
					if($model->step == OfflineSignStore::ADDFRANCHISEE){
						$this->redirect(array('offlineSignStore/create','storeExtendId'=>$extendId)); //点击下一步，进入新建店铺页面
					}
				}
			}
            $storeM = new OfflineSignStore();
            $storeM->extend_id = $extendModel->id;
            $criteria = $storeM->searchView();
            $storeModel = $storeM->findAll($criteria);
			$model->attributes = $this->_syncTmpData($this->tmpDataKey);
			$demoImgs = Tool::getConfig('offlinesigndemoimgs');
			$this->render('create',array(
				'model'=>$model,
                'extendModel' => $extendModel,
				'demoImgs' => $demoImgs,
                'storeModel'=>isset($storeModel) ? $storeModel : '',
			));
		}else{
			$this->setFlash('error', '非法访问');
			$this->redirect(array('offlineSignStore/admin'));
		}
	}

	/**
	 * 原有会员新增加盟商
	 * @param int $enterpriseId 企业表id
	 * @param int $memberId 会员表id
	 * @param int $extendId 资质表id 为空则为第一次创建 不为空则为添加多次
	 * @throws Exception
	 */
	public function actionOldFranchiseeView($enterpriseId,$memberId,$extendId){
        $model = new OfflineSignStore();
        $this->performAjaxValidation($model);
        $model->setScenario('OldFranchisee');
		//如果是多次添加或者为继续编辑
		if($extendId){
			$extendModel = OfflineSignStoreExtend::model()->findByPk($extendId);
			if($extendModel->offline_sign_enterprise_id)
                $enterpriseModel = OfflineSignEnterprise::model()->findByPk($extendModel->offline_sign_enterprise_id);
            if($extendModel->offline_sign_contract_id)
                $contractModel = OfflineSignContract::model()->findByPk($extendModel->offline_sign_contract_id);
            if(isset($_POST['OfflineSignStore'])){
                $dataArr = $this->getPost('OfflineSignStore');
                $storeId = OfflineSignStoreExtend::getAllStoreId($extendModel->id);
                $model->attributes = $dataArr;
                $model->franchisee_category_id = (!empty($dataArr['depthOne']) ? $dataArr['depthOne'] : (!empty($dataArr['depthZero']) ? $dataArr['depthZero'] : ''));
                $model->extend_id = $extendId;
                if($model->save()){
                    //生成审核进度
                    $auditModel = new OfflineSignAuditLogging($extendModel->id,'1201');
                    $auditModel->save(false);
                    $this->setFlash('success', '添加成功');
                    if($dataArr['step'] == OfflineSignStore::NEXT_STEP){
                        //修改状态
                        $extendModel->_setStatusAndAuditStatus();
                        $extendModel->save(false);
                        $this->redirect(array('offlineSignAuditLogging/seeAudit', 'storeExtendId' => $extendId)); //点击下一步，进入审核记录页面
                    }
                    if($dataArr['step'] == OfflineSignStore::ADDFRANCHISEE) {
                        //跳转添加加盟商
                        $this->redirect(array('offlineSignStore/oldFranchiseeView', 'enterpriseId' => $enterpriseId, 'memberId' => $memberId, 'extendId' => $extendId));
                    }
                }
            }
            $storeM = new OfflineSignStore();
            $storeM->extend_id = $extendModel->id;
            $criteria = $storeM->searchView();
            $storeModel = $storeM->findAll($criteria);
		}else{
			//第一次添加
			$extendModel = new OfflineSignStoreExtend();
			//判断这个会员是否由电签产生，如果是，绑定电签合同表和电签企业表
			$data = OfflineSignStore::enterIsByOffline($enterpriseId);
			if($data){
				$extendModel->offline_sign_contract_id = $data['offline_sign_contract_id'];
                $extendModel->upload_contract_img = $data['upload_contract_img'];
                $extendModel->upload_contract = $data['upload_contract'];
				$extendModel->offline_sign_enterprise_id = $data['offline_sign_enterprise_id'];
				$contractModel = OfflineSignContract::model()->findByPk($extendModel->offline_sign_contract_id);
				$enterpriseModel = OfflineSignEnterprise::model()->findByPk($extendModel->offline_sign_enterprise_id);
                $extendModel->enTerName = $enterpriseModel['name'];
			}else{
				//如果不是，新建企业表，设置企业名，方便两个后台列表
				$enterpriseInfo = Enterprise::getEnterpriseInfo($enterpriseId); //获取企业信息
				$enterpriseModel = new OfflineSignEnterprise();
				$enterpriseModel->name = $enterpriseInfo['name'];
                $enterpriseModel->save(false);
                $offline_sign_enterprise_id = $enterpriseModel->id;
			}
            if(isset($_POST['OfflineSignStore'])){
                $dataArr = $this->getPost('OfflineSignStore');
                $model->attributes = $dataArr;
                $model->franchisee_category_id = (!empty($dataArr['depthOne']) ? $dataArr['depthOne'] : (!empty($dataArr['depthZero']) ? $dataArr['depthZero'] : ''));
                $eid = empty($data['offline_sign_enterprise_id'])?isset($offline_sign_enterprise_id)?$offline_sign_enterprise_id:'':$data['offline_sign_enterprise_id'];
                $cid = empty($data['offline_sign_contract_id'])?'':$data['offline_sign_contract_id'];
                //生成资质表信息id
                $extendModel = OfflineSignStore::createExtend($eid,$cid,OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE,$enterpriseId,$memberId);
                //生成审核进度
                $auditModel = new OfflineSignAuditLogging($extendModel->id,'1201');
                $auditModel->save(false);
                $model->extend_id = $extendModel->id;
                if($model->save()){
                    $this->setFlash('success', '添加成功');
                    if($dataArr['step'] == OfflineSignStore::NEXT_STEP){
                        $extendModel->_setStatusAndAuditStatus();
                        $extendModel->save(false);
                        $this->redirect(array('offlineSignAuditLogging/seeAudit', 'storeExtendId' => $extendModel->id)); //点击下一步，进入审核记录页面
                    }
                    if($dataArr['step'] == OfflineSignStore::ADDFRANCHISEE) {
                        //跳转添加加盟商
                        $this->redirect(array('offlineSignStore/oldFranchiseeView', 'enterpriseId' => $enterpriseId, 'memberId' => $memberId, 'extendId' => $extendModel->id));
                    }
                }
            }
		}
		$demoImgs = Tool::getConfig('offlinesigndemoimgs');
		$this->render('oldFranchiseeView',array(
			'model'=>$model,
            'storeModel'=>isset($storeModel) ? $storeModel : '',
			'contractModel' => isset($contractModel) ? $contractModel : '',
			'enterpriseModel' => isset($enterpriseModel) ? $enterpriseModel : '',
            'extendModel'=>isset($extendModel) ? $extendModel : '',
			'demoImgs'=>$demoImgs,
		));
	}

	/**
	 * 获取会员和帐号信息
	 *
	 * @param  integre  $id
	 * @param  string   $type
	 *         tips : type指拉取信息依据 memberId还是enterpriseId
	 *
	 * @return mixed
	 */
	protected function getBankInfos($id,$type='memberId'){

		$memberBankInfo = null;

		if($type=='memberId'){
			$memberBankInfo = Yii::app()->db->createCommand()
				->select('account_name,province_id,city_id,district_id,street,bank_name,account,licence_image')
				->from(BankAccount::model()->tableName())
				->where('member_id=:id',array(':id'=>$id))->queryRow();
		}

		if($type=='enterpriseId'){
			$memberBankInfo = Yii::app()->db->createCommand()
				->select('t.account_name,t.province_id,t.city_id,t.district_id,t.street,t.bank_name,t.account,t.licence_image, m.gai_number, m.register_time')
				->from(BankAccount::model()->tableName()." as t ")
				->leftJoin(Member::model()->tableName() . ' as m','m.id = t.member_id')
				->where('m.enterprise_id=:enterpriseId',array(':enterpriseId'=>$id))->queryRow();
		}
		return $memberBankInfo;
	}
    /**
     * 原有会员增加加盟商，编辑电签
     */
    public function actionOldFranchiseeUNLL(){
        $extendId = $this->getParam('id');
        if($extendId){
            $extendModel = OfflineSignStoreExtend::model()->findByPk($extendId);
            if($extendModel->offline_sign_enterprise_id)
                $enterpriseModel = OfflineSignEnterprise::model()->findByPk($extendModel->offline_sign_enterprise_id);
            if($extendModel->offline_sign_contract_id)
                $contractModel = OfflineSignContract::model()->findByPk($extendModel->offline_sign_contract_id);
            if($this->isPost()){
                $dataArr = $this->getPost('OfflineSignStore');
                if($dataArr['step'] == OfflineSignStore::ADDFRANCHISEE) {
                    //跳转添加加盟商
                    $this->redirect(array('offlineSignStore/oldFranchiseeUpdate','id' => $extendId));
                }
                if($dataArr['step'] == OfflineSignStore::NEXT_STEP){
                    //修改状态
                    $extendModel->_setStatusAndAuditStatus();
                    $extendModel->save(false);
                    $this->redirect(array('offlineSignAuditLogging/seeAudit', 'storeExtendId' => $extendId)); //点击下一步，进入审核记录页面
                }
            }
            $storeM = new OfflineSignStore();
            $storeM->extend_id = $extendModel->id;
            $criteria = $storeM->searchView();
            $storeModel = $storeM->findAll($criteria);
        }
        $demoImgs = Tool::getConfig('offlinesigndemoimgs');
        $this->render('oldFranchiseeUpdate',array(
            'storeModel'=>isset($storeModel) ? $storeModel : '',
            'contractModel' => isset($contractModel) ? $contractModel : '',
            'enterpriseModel' => isset($enterpriseModel) ? $enterpriseModel : '',
            'extendModel'=>isset($extendModel) ? $extendModel : '',
            'storeExtendId'=>$extendId,
            'demoImgs'=>$demoImgs,
        ));
    }
    /**
     * 原有会员增加加盟商，编辑电签
     */
    public function actionOldFranchiseeUpdate(){
        $extendId = $this->getParam('id');
        $model = new OfflineSignStore();
        $this->performAjaxValidation($model);
        $model->setScenario('OldFranchisee');
        //如果是多次添加或者为继续编辑
        if($extendId){
            $extendModel = OfflineSignStoreExtend::model()->findByPk($extendId);
            if($extendModel->offline_sign_enterprise_id)
                $enterpriseModel = OfflineSignEnterprise::model()->findByPk($extendModel->offline_sign_enterprise_id);
            if($extendModel->offline_sign_contract_id)
                $contractModel = OfflineSignContract::model()->findByPk($extendModel->offline_sign_contract_id);
            if(isset($_POST['OfflineSignStore'])){
                $dataArr = $this->getPost('OfflineSignStore');
                $model->attributes = $dataArr;
                $model->franchisee_category_id = (!empty($dataArr['depthOne']) ? $dataArr['depthOne'] : (!empty($dataArr['depthZero']) ? $dataArr['depthZero'] : ''));
                $model->extend_id = $extendId;
                if($model->save()){
                    //生成审核进度
                    $auditModel = new OfflineSignAuditLogging($extendModel->id,'1202');
                    $auditModel->save(false);
                    $this->setFlash('success', '添加成功');
                    if($dataArr['step'] == OfflineSignStore::ADDFRANCHISEE) {
                        //跳转添加加盟商
                       // $this->redirect(array('offlineSignStore/oldFranchiseeUpdate','id' => $extendId));
                    }
                    if($dataArr['step'] == OfflineSignStore::NEXT_STEP){
                        //修改状态
                        $extendModel->_setStatusAndAuditStatus();
                        $extendModel->save(false);
                        $this->redirect(array('offlineSignAuditLogging/seeAudit', 'storeExtendId' => $extendId)); //点击下一步，进入审核记录页面
                    }
                }
            }
            $storeM = new OfflineSignStore();
            $storeM->extend_id = $extendModel->id;
            $criteria = $storeM->searchView();
            $storeModel = $storeM->findAll($criteria);
        }
        $model = new OfflineSignStore();
        $demoImgs = Tool::getConfig('offlinesigndemoimgs');
        $this->render('oldFranchiseeView',array(
            'model'=>$model,
            'storeModel'=>isset($storeModel) ? $storeModel : '',
            'contractModel' => isset($contractModel) ? $contractModel : '',
            'enterpriseModel' => isset($enterpriseModel) ? $enterpriseModel : '',
            'extendModel'=>isset($extendModel) ? $extendModel : '',
            'demoImgs'=>$demoImgs,
        ));
    }
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
        $storeExtendId = $this->getParam('storeExtendId');
        $extendModel = OfflineSignStoreExtend::model()->findByPk($storeExtendId);
        $storeExtendId = $extendModel->id;
        $enterpriseId = $extendModel->offline_sign_enterprise_id;
		if($this->isPost()){
			$dataArr = $this->getPost('OfflineSignStore');
            if($dataArr['step'] == OfflineSignStore::NEXT_STEP){
                $auditModel = new OfflineSignAuditLogging($storeExtendId, '1011');
                $auditModel->save(false);
                //点击下一步，进入审核记录页面
                $extendModel->_setStatusAndAuditStatus();
                $extendModel->save(false);
                $this->redirect(array('offlineSignAuditLogging/seeAudit','storeExtendId'=>$storeExtendId));
            }
			if($dataArr['step'] == OfflineSignEnterprise::LAST_STEP){
				$this->_syncTmpData($this->tmpDataKey,$dataArr);
                $this->redirect(array('offlineSignEnterprise/update','enterpriseId'=>$enterpriseId,'storeExtendId'=>$storeExtendId));
			}elseif($dataArr['step'] == OfflineSignStore::ADDFRANCHISEE){
                $this->redirect(array('offlineSignStore/create','storeExtendId'=>$dataArr['extendId'])); //点击下一步，进入新建店铺页面
            }
		}
        $storeModel = $this->loadModel($storeExtendId);
        $this->performAjaxValidation($storeModel);
        if(empty($storeModel)){
            $this->redirect(array('offlineSignStore/create','storeExtendId'=>$storeExtendId)); //点击下一步，进入新建店铺页面
        }
        $model = new OfflineSignStore();
		$model->attributes = $this->_syncTmpData($this->tmpDataKey);
		$demoImgs = Tool::getConfig('offlinesigndemoimgs');
		$this->render('franchiseeupdate',array(
            'model'=>$model,
            'storeModel'=>isset($storeModel)?$storeModel:'',
            'extendModel' => $extendModel,
            'storeExtendId'=>$storeExtendId,
			'demoImgs' => $demoImgs,
		));
	}
    /*
     * 编辑加盟商
     * */
    public function actionFranchiseeUpdate()
    {
        if(isset($_GET['storeId'])) {
            $storeId = $this->getParam('storeId');
            $extendId = $this->getParam('extendId');
            $apply_type = $this->getParam('apply_type');
        }
        $storeModel = OfflineSignStore::model()->findByPk($storeId);
        $this->performAjaxValidation($storeModel);
        if($this->isPost()){
            $dataArr = $this->getPost('OfflineSignStore');
            $storeModel = OfflineSignStore::model()->findByPk($dataArr['id']);
            $storeModel->attributes = $dataArr;
            $storeModel->install_province_id = $dataArr['install_province_id'];
            $storeModel->update_time = time();
            $storeModel->franchisee_category_id = (!empty($dataArr['depthOne']) ? $dataArr['depthOne'] : (!empty($dataArr['depthZero']) ? $dataArr['depthZero'] : ''));

            if($storeModel->save()){
                $auditModel = new OfflineSignAuditLogging();
                $auditModel->extend_id = $extendId;
                $auditModel->audit_role = OfflineSignAuditLogging::ROLE_AGENT;
                if($apply_type == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE) {
                    $auditModel->behavior = '1106';
                }else{
                    $auditModel->behavior = '1202';
                }
                $auditModel->save(false);
                $this->setFlash('success', '保存成功');
                $this->setFlash('success', Yii::t('offlineSignAuditLogging', '更新成功'));
                if($apply_type == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE) {
                    $this->redirect(array('offlineSignStore/update', 'storeExtendId' => $extendId));
                }
                else{
                    $this->redirect(array('offlineSignStore/OldFranchiseeUNLL','id'=>$extendId)); //返回旧店铺页面
                }
            }

        }
        $demoImgs = Tool::getConfig('offlinesigndemoimgs');
        $this->render('update', array('model'=>$storeModel,'demoImgs' => $demoImgs));
    }
    /*
     * 删除加盟商
     * */
    public function actionFranchiseeDelete(){
        if(isset($_GET['storeId'])) {
            $storeId = $this->getParam('storeId');
            $extendId = $this->getParam('extendId');
            $del = OfflineSignStore::model()->findByPk($storeId);
            if($del->delete()){
                $this->setFlash('success', '删除成功');
            }
        }
        $this->redirect(array('offlineSignStore/create','storeExtendId'=>$extendId)); //返回店铺页面
    }
    /*
     * 原会员新添加盟商  删除加盟商
     * */
    public function actionOldFranchiseeDelete(){
        if(isset($_GET['storeId'])) {
            $storeId = $this->getParam('storeId');
            $extendId = $this->getParam('extendId');
            $del = OfflineSignStore::model()->findByPk($storeId);
            if($del->delete()){
                $this->setFlash('success', '删除成功');
            }
        }
        $this->redirect(array('offlineSignStore/oldFranchiseeUpdate','id'=>$extendId)); //返回旧店铺页面
    }
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new OfflineSignStore('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OfflineSignStore'])){
			$dataArr = $this->getParam('OfflineSignStore');
			$model->attributes = $dataArr;
			$model->enterprise_name = $dataArr['enterprise_name'];
		}
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OfflineSignStore the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
        $extendModel = OfflineSignStoreExtend::model()->findByPk($id);
        $storeModel = new OfflineSignStore();
        $storeModel->extend_id = $extendModel->id;
        $criteria = $storeModel->searchView();
        $model = $storeModel->findAll($criteria);
		return $model;
	}


	/**
	 * Performs the AJAX validation.
	 * @param OfflineSignStore $model the model to be validated
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
