<?php

class OfflineSignStoreController extends Controller
{


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate(){

        $storeId = $this->getParam('id');
        $role = $this->getParam('role');
        if(empty($storeId) || empty($role)){
            $this->setFlash('error','参数错误');
            $this->redirect(array('admin'));
        }

        $storeInfoModel = $this->loadModel($storeId);
        switch ($storeInfoModel->apply_type) {
            case  OfflineSignStore::APPLY_TYPE_NEW_FRANCHIESE:
                $this->updateNewFranchisee($storeId,$role);
                break;
            case  OfflineSignStore::APPLY_TYPE_OLD_FRANCHIESE:
                $this->updateOldFranchisee($storeId,$role);
                break;
            default:
                break;
        }
    }

    /**
     * 编辑新增用户
     * 
     * @author xuegang.liu@g-emall.com
     * @since  2016-01-12T10:48:56+0800
     */
	protected function updateNewFranchisee($storeId,$role){

		$storeInfoModel = $this->loadModel($storeId);
        $enterpriseInfoModel = OfflineSignEnterprise::model()->findByPk($storeInfoModel->offline_sign_enterprise_id);
        $contractInfoModel = OfflineSignContract::model()->findByPk($enterpriseInfoModel->offline_sign_contract_id);

		if($this->isPost()){
            try{
                $trans = Yii::app()->db->beginTransaction();
                $storeInfoModel->attributes = $this->getPost('OfflineSignStore');
                $enterpriseInfoModel->attributes = $this->getPost('OfflineSignEnterprise');
                // $contractInfoModel->attributes = $this->getPost('OfflineSignContract');
                $storeInfoModel->franchisee_category_id = (!empty($storeInfoModel->depthOne) ? $storeInfoModel->depthOne : (!empty($storeInfoModel->depthZero) ? $storeInfoModel->depthZero : ''));
                // OfflineSignContract::setContractAdExpires($contractInfoModel,$this->getPost('OfflineSignContract'));//设置广告起止时间

                // if($storeInfoModel->save() && $enterpriseInfoModel->save() && $contractInfoModel->save()){
                if($storeInfoModel->save() && $enterpriseInfoModel->save()){
                    $loging = new OfflineSignAuditLogging();
                    $loging->offline_sign_store_id = $storeId;
                    $loging->audit_role = $role;
                    $loging->behavior = '2003';
                    $loging->save(false);
                    $this->setFlash('success', Yii::t('offlineSignAuditLogging', '更新成功'));
                    $trans->commit();
                    $this->redirect(array('admin','role'=>$role));
                }
            }catch(Exception $e){
                $trans->rollback();
                $this->setFlash('error',$e->getMessage());
            }
        }

        OfflineSignContract::formatContractAdExpires($contractInfoModel); 
        $demoImgs = Tool::getConfig('offlinesigndemoimgs');
		$this->render('update',array(
			'storeInfoModel'=>$storeInfoModel,
            'enterpriseInfoModel'=>$enterpriseInfoModel,
            'contractInfoModel'=>$contractInfoModel,
            'demoImgs'=>$demoImgs,
            'role' => $role,
		));
	}

    /**
     * 编辑原有会员新增盟商
     * 
     * @author xuegang.liu@g-emall.com
     * @since  2016-01-12T10:48:56+0800
     */
    protected function updateOldFranchisee($storeId,$role){

        $storeInfoModel = $this->loadModel($storeId);
        $storeInfoModel->setScenario('OldFranchisee');

        if($this->isPost()){
            $storeInfoModel->attributes = $this->getPost('OfflineSignStore');
            $storeInfoModel->franchisee_category_id = (!empty($storeInfoModel->depthOne) 
                    ? $storeInfoModel->depthOne : (!empty($storeInfoModel->depthZero) ? $storeInfoModel->depthZero : ''));

            if($storeInfoModel->save()){
                $loging = new OfflineSignAuditLogging();
                $loging->offline_sign_store_id = $storeId;
                $loging->audit_role = $role;
                $loging->behavior = '2003';
                $loging->save(false);
                $this->setFlash('success', Yii::t('offlineSignAuditLogging', '更新成功'));
                $this->redirect(array('admin','role'=>$role));
            }
            $this->setFlash('error', '更新错误');
        }

//        OfflineSignContract::formatContractAdExpires($storeInfoModel);
        $demoImgs = Tool::getConfig('offlinesigndemoimgs');
        $this->render('update',array(
            'storeInfoModel'=>$storeInfoModel,
            'enterpriseInfoModel'=>null,
            'contractInfoModel'=>null,
            'demoImgs'=>$demoImgs,
            'role' => $role,
        ));
    }

    /**
     * ajax实现自动回填合同结束时间
     */
    public function actionReturnEndTime(){
        if ($this->isAjax() && $this->isPost()) {
            $benginTime = $this->getPost('benginTime');
            $contractTerm = $this->getPost('contractTerm');
            $endTiem = date('Y-m-d',strtotime($benginTime .' +'.$contractTerm.' months'));
            $endTiem = strtotime($endTiem. '-1 day');
            exit(json_encode(array('endTiem' => $endTiem)));
        }
    }

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
     * 审核
     */
    public function actionQualificationAudit(){

        $this->showBack = true;
        $id = $this->getParam('id');
        switch($this->role){
            //运作部
            case OfflineSignAuditLogging::ROLE_AUDIT_OPERATIONS_REGION :
            case OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER :
                $this->_yesOperations($id);
                break;
            //非运作部
            default:
                $this->_noOperations($id);
                break;
        }
    }

    /**
     * @param $id
     * 审核 (非运作部)
     */
    public function _noOperations($id)
    {
        $model = OfflineSignStore::model()->findByPk($id);
        switch($model->apply_type){
            case OfflineSignStore::APPLY_TYPE_NEW_FRANCHIESE:
                $enterprise_model = OfflineSignEnterprise::model()->findByPk($model->offline_sign_enterprise_id);
                $contract_model = OfflineSignContract::model()->findByPk($enterprise_model->offline_sign_contract_id);
                if(isset($_POST['status'])){
                    $this->_operationsNew($model,$enterprise_model,$contract_model,$id,$this->role);
                }
                $this->render('qualificationAudit', array(
                    'model' => $model,
                    'enterprise_model' => $enterprise_model,
                    'contract_model' => $contract_model,
                ));
                break;
            case OfflineSignStore::APPLY_TYPE_OLD_FRANCHIESE:
                $data = Yii::app()->db->createCommand()
                    ->select('e.name,e.link_man,e.enterprise_type,ed.license,ed.license_photo,ed.organization_image,
                            ed.organization,ba.account_name,ba.province_id,ba.city_id,ba.district_id,ba.street,ba.bank_name,ba.account,ba.licence_image')
                    ->from(Enterprise::model()->tableName() . ' as e')
                    ->leftJoin(EnterpriseData::model()->tableName() .' as ed','e.id = ed.enterprise_id')
                    ->leftJoin(Member::model()->tableName() . ' as m','m.enterprise_id = e.id')
                    ->leftJoin(BankAccount::model()->tableName() . ' as ba','ba.member_id = m.id')
                    ->where('e.id=:id',array(':id'=>$model->old_member_franchisee_id))
                    ->queryRow();
                if(isset($_POST['status'])){
                    $this->_operationsOld($model,$id,$this->role);
                }
                $this->render('qualificationAudit', array(
                    'model' => $model,
                    'data'=>$data,
                ));
                break;
        }
    }

    /**
     * 审核（运作部）
     */
    public function _yesOperations($id){
        $model = OfflineSignStore::model()->findByPk($id);
        switch($model->apply_type) {
            case OfflineSignStore::APPLY_TYPE_NEW_FRANCHIESE:
                $enterprise_model = OfflineSignEnterprise::model()->findByPk($model->offline_sign_enterprise_id);
                $contract_model = OfflineSignContract::model()->findByPk($enterprise_model->offline_sign_contract_id);
                if(isset($_POST['status'])){
                    $this->_operationsNew($model,$enterprise_model,$contract_model,$id,$this->role);
                }
                $this->render('operationDepartmentAudit', array(
                    'model' => $model,
                    'enterprise_model' => $enterprise_model,
                    'contract_model' => $contract_model,
                ));
                break;
            case OfflineSignStore::APPLY_TYPE_OLD_FRANCHIESE:
                $data = Yii::app()->db->createCommand()
                    ->select('e.name,e.link_man,e.enterprise_type,ed.license,ed.license_photo,ed.organization_image,
                            ed.organization,ba.account_name,ba.province_id,ba.city_id,ba.district_id,ba.street,ba.bank_name,ba.account,ba.licence_image')
                    ->from(Enterprise::model()->tableName() . ' as e')
                    ->leftJoin(EnterpriseData::model()->tableName() .' as ed','e.id = ed.enterprise_id')
                    ->leftJoin(Member::model()->tableName() . ' as m','m.enterprise_id = e.id')
                    ->leftJoin(BankAccount::model()->tableName() . ' as ba','ba.member_id = m.id')
                    ->where('e.id=:id',array(':id'=>$model->old_member_franchisee_id))
                    ->queryRow();
                if(isset($_POST['status'])){
                    $this->_operationsOld($model,$id,$this->role);
                }
                $this->render('operationDepartmentAudit', array(
                    'model' => $model,
                    'data'=>$data,
                ));
                break;
        }
    }

    /**
     * 新商户审核
     * @param object $model 店铺模型
     * @param object $enterprise_model 企业模型
     * @param object $contract_model  合同模型
     * @param int $id  店铺id
     * @param int $role 审核角色
     * @throws CDbException
     */
    public function _operationsNew($model,$enterprise_model,$contract_model,$id,$role){
        $auditing = $this->getPost('status');
        $auditing = $auditing * 1;
        $trans = Yii::app()->db->beginTransaction();
        try {
            //保存到进度表OfflineSignAuditLogging
            $loging = new OfflineSignAuditLogging();
            $loging->offline_sign_store_id = $id;
            $loging->status = $auditing;
            $loging->audit_role = $role;
            $loging->behavior = '2001';
            if ($auditing == OfflineSignAuditLogging::STATUS_NO_PASS) {
                if (empty($_POST['contentHidden']))
                    throw new CHttpException(400, '请填写审核不通过原因');
                $c_error = array();
                $e_error = array();
                $s_error = array();
                preg_match_all('/(c\.[a-zA-Z_]+)/', $_POST['errorField'], $c_error);
                preg_match_all('/(e\.[a-zA-Z_]+)/', $_POST['errorField'], $e_error);
                preg_match_all('/(s\.[a-zA-Z_]+)/', $_POST['errorField'], $s_error);
                //将错误字段保存到各自表里面
                $model->error_field = isset($s_error[1]) ? json_encode($s_error[1]) : '';
                $enterprise_model->error_field = isset($e_error[1]) ? json_encode($e_error[1]) : '';
                $contract_model->error_field = isset($c_error[1]) ? json_encode($c_error[1]) : '';
                $model->save(false,array('error_field'));
                $enterprise_model->save(false,array('error_field'));
                $contract_model->save(false,array('error_field'));

                OfflineSignStoreExtend::updateAuditStatus($id,$role,false); //审核不通过，更新审核状态
                $loging->error_field = $this->getPost('errorField');
                $loging->remark = $this->getPost('contentHidden');
            }elseif($auditing == OfflineSignAuditLogging::STATUS_PASS){

                //$loging->remark = $this->getPost('content');
                //当运作部经理审核通过后
                if($role == OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER){

                    //生成 enterprise 表数据
                    $enterprise = array(
                        'name' => $enterprise_model->name,
                        'link_man' => $enterprise_model->linkman_name,
                        'service_start_time'=>$contract_model->begin_time,
                        'service_end_time' => $contract_model->end_time,
                    );
                    Yii::app()->db->createCommand()->insert(Enterprise::model()->tableName(),$enterprise);
                    $enterpriseId = Yii::app()->db->getLastInsertID();
                        //生成gw_enterprise_data 表数据
                    $enterprise_data = array(
                        'enterprise_id' => $enterpriseId,
                        'license' =>$enterprise_model->enterprise_license_number,
                        'license_photo' => OfflineSignFile::getPathById($enterprise_model->license_image),
                        'legal_man' => $enterprise_model->legal_man,
                        'tax_id' => $enterprise_model->tax_id,
                        'license_province_id'=>$contract_model->province_id,
                        'license_city_id' =>$contract_model->city_id,
                        'license_district_id' =>$contract_model->district_id,
                    );
                    Yii::app()->db->createCommand()->insert(EnterpriseData::model()->tableName(),$enterprise_data);
                    $modelMember = new Member();
                    $modelMember->salt = Tool::generateSalt();
                    //生成 Member 表数据

                    $passWord = mt_rand(10000,100000000);

                    $member =array(
                        'enterprise_id'=>$enterpriseId,
                        'gai_number'=>$modelMember->generateGaiNumber(),
                        'password' =>$modelMember->hashPassword($passWord),
                        'salt' =>$modelMember->salt,
                        'register_time'=>time(),
                        'mobile' => $contract_model->mobile,
                        'type_id' => MemberType::MEMBER_EXPENSE,
                        'member_type' => Member::REG_TYPE_OFFLINE,
                    );
                    $temp = Yii::app()->db->createCommand()->insert(Member::model()->tableName(),$member);
                    $memberId = Yii::app()->db->getLastInsertID();

                    if($temp){
                        //发送短信
                        $smsConfig = $this->getConfig('smsmodel');
                        $msg = str_replace('{0}', '企业会员', $smsConfig['newMemberContent']);
                        $msg = str_replace('{1}', $member['gai_number'], $msg);
                        $msg = str_replace('{2}', $passWord, $msg);
                        $rong = array('企业会员',$member['gai_number'],$passWord);
                        $tmpId = $smsConfig['newMemberContentId'];
                        Sms::send($contract_model->mobile, $msg, $rong, $tmpId);
                    }

                        //生成 gw_bank_account 表数据
                    $bank_account = array(
                        'member_id' =>  $memberId,
                        'account_name' => $contract_model->account_name,
                        'bank_name' => $contract_model->bank_name,
                        'account' =>$contract_model->account,
                        'province_id' =>$enterprise_model->bank_province_id,
                        'city_id' =>$enterprise_model->bank_city_id,
                        'district_id' =>$enterprise_model->bank_district_id,
                        'licence_image' => OfflineSignFile::getPathById($enterprise_model->bank_permit_image),
                    );
                    Yii::app()->db->createCommand()->insert(BankAccount::model()->tableName(),$bank_account);

                    //生成 gw_franchisee 表信息
                    $franModel = new Franchisee();
                    $franModel->password = mt_rand(10000,100000000);
                    $franModel->member_id = $memberId;
                    $franModel->province_id=$model->install_province_id;
                    $franModel->city_id =$model->install_city_id;
                    $franModel->district_id =$model->install_district_id;
                    $franModel->street = $model->install_street;
                    $franModel->save(false);

                    //生成 gt_machine 表信息
                    $machineCode = Machine::createMachineCode();
                    $machine = array(
                        'create_time'=>time(),
                        'biz_info_id'=>$franModel->id,
                        'machine_code'=> $machineCode,
                        'activation_code'=> Machine::createActivationCode($machineCode),
                    );
                    Yii::app()->gt->createCommand()->insert(Machine::model()->tableName(),$machine);
                    $machineId = Yii::app()->gt->getLastInsertID();

                        //修改 offline_sign_store 表信息
                    $off_line_sign_store =array(
                        'enterprise_id' =>$enterpriseId,
                        'machine_id' => $machineId,
                        'franchisee_id' =>$franModel->id,
                        'status' =>OfflineSignStore::STATUS_HAS_PASS,
                        'audit_status' =>OfflineSignStore::AUDIT_STATUS_EXA_SUCCES,
                    );
                    Yii::app()->db->createCommand()->update(OfflineSignStore::model()->tableName(),$off_line_sign_store,'id=:id',array(":id"=>$id));
                }

                $model->error_field = ''; //清空错误字段
                $model->save(false,array('error_field'));
                OfflineSignStoreExtend::updateAuditStatus($id,$role); //审核通过，更新审核状态
                $loging->remark = $this->getPost('contentHidden');
            }
            $loging->save(false);
            $this->setFlash('success', Yii::t('offlineSignAuditLogging', '审核成功'));
            $trans->commit();
            $this->redirect(array('offlineSignStore/admin','role'=>$role));
        }catch (Exception $e){
            $trans->rollback();
            $this->setFlash('error', Yii::t('offlineSignAuditLogging', $e->getMessage()));
        }
    }


    /**
     * 原有会员新增加盟商审核
     * @param object $model 店铺模型
     * @param int $id 店铺id
     * @param int $role 审核人角色
     * @throws CDbException
     */
    public function _operationsOld($model,$id,$role){
        $auditing = $this->getPost('status');
        $auditing = $auditing * 1;
        $trans = Yii::app()->db->beginTransaction();
        try{
            //保存到进度表OfflineSignAuditLogging
            $loging = new OfflineSignAuditLogging();
            $loging->offline_sign_store_id = $id;
            $loging->status = $auditing;
            $loging->audit_role = $role;
            $loging->behavior = '2001';
            if ($auditing == OfflineSignAuditLogging::STATUS_NO_PASS) {
                if (empty($_POST['contentHidden']))
                    throw new CHttpException(400, '请填写审核不通过原因');
                $s_error = array();
                preg_match_all('/(s\.[a-zA-Z_]+)/', $_POST['errorField'], $s_error);
                $model->error_field = isset($s_error[1]) ? json_encode($s_error[1]) : '';
                $model->save(false,array('error_field'));

                OfflineSignStoreExtend::updateAuditStatus($id,$role,false); //审核不通过，更新审核状态
                $loging->remark = $this->getPost('contentHidden');
                $loging->error_field = $this->getPost('errorField');
            }elseif($auditing == OfflineSignAuditLogging::STATUS_PASS){
                if($role == OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER) {

                    //生成 gw_franchisee 表信息
                    $memberId = Yii::app()->db->createCommand()
                        ->select('id')
                        ->from(Member::model()->tableName())
                        ->where('enterprise_id = :id',array(':id' => $model->old_member_franchisee_id))
                        ->queryScalar();

                    if(empty($memberId)){
                        throw new Exception("会员id不存在", 1);
                    }

                    $franModel = new Franchisee();
                    $franModel->password = mt_rand(10000,100000000);
                    $franModel->member_id = $memberId;
                    $franModel->province_id=$model->install_province_id;
                    $franModel->city_id =$model->install_city_id;
                    $franModel->district_id =$model->install_district_id;
                    $franModel->street = $model->install_street;
                    $franModel->save(false);

                    //生成 gt_machine 表信息
                    $machineCode = Machine::createMachineCode();
                    $machine = array(
                        'biz_info_id'=>$franModel->id,
                        'machine_code'=> $machineCode,
                        'activation_code'=> Machine::createActivationCode($machineCode),
                    );
                    Yii::app()->gt->createCommand()->insert(Machine::model()->tableName(),$machine);
                    $machineId = Yii::app()->gt->getLastInsertID();
                        //修改 offline_sign_store 表信息
                    $off_line_sign_store =array(
                        'machine_id' => $machineId,
                        'franchisee_id' =>$franModel->id,
                        'status' =>OfflineSignStore::STATUS_HAS_PASS,
                        'audit_status' =>OfflineSignStore::AUDIT_STATUS_EXA_SUCCES,
                    );
                    Yii::app()->db->createCommand()->update(OfflineSignStore::model()->tableName(),$off_line_sign_store,'id=:id',array(":id"=>$id));
                }
                $model->error_field = ''; //清空错误字段
                $model->save(false,array('error_field'));
                OfflineSignStoreExtend::updateAuditStatus($id,$role); //审核通过，更新审核状态
                $loging->remark = $this->getPost('contentHidden');
            }
            $loging->save(false);
            $this->setFlash('success', Yii::t('offlineSignAuditLogging', '审核成功'));
            $trans->commit();
            $this->redirect(array('offlineSignStore/admin','role'=>$role));
        }catch (Exception $e){
            $trans->rollback();
            $this->setFlash('error', Yii::t('offlineSignAuditLogging', $e->getMessage()));
        }
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
		$model=OfflineSignStore::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OfflineSignStore $model the model to be validated
	 */
	public function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='offline-sign-store-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * 导入excel 批量增加
     */
    public function actionImportExcel(){

        // @ini_set ( 'memory_limit', '2048M' );
        // set_time_limit ( 0 );

        $model = new UploadForm('excel');
        $this->performAjaxValidation($model);
        $result = array(); //import_member_log excel 数据插入结果
        if (isset($_POST['UploadForm'])) {
            $model->attributes = $_POST['UploadForm'];
            $dir = dirname(Yii::getPathOfAlias('cache'));
            $fileName = $_FILES['UploadForm']['name']['file'];
            if(file_exists($dir.'/import_offline_sign_store/'.$fileName)){
                $this->setFlash('error', '该文件已经被上传过了，请重命名！');
                $this->refresh();
            }
            $model = UploadedFile::uploadFile($model, 'file', 'import_offline_sign_store',$dir, pathinfo($fileName,PATHINFO_FILENAME));
            if ($model->validate()) {
                UploadedFile::saveFile('file', $model->file);
                
                require realpath(Yii::getPathOfAlias('root'))."/console/commands/ImportOfflineSignCommand.php";
                $command = new ImportOfflineSignCommand();
                $command->setPath($dir.DS.$model->file);
                $logName = $command->actionIndex();

                date_default_timezone_set('PRC');
                $time =date('Ymd');
                // 输出Excel文件头
                Header( "Content-type:   application/octet-stream "); 
                Header( "Accept-Ranges:   bytes "); 
                header( "Content-Disposition:   attachment;   filename={$time}.txt "); 
                header( "Expires:   0 "); 
                header( "Cache-Control:   must-revalidate,   post-check=0,   pre-check=0 "); 
                header( "Pragma:   public "); 
                $input = file_get_contents($logName);
                echo $input;
                Yii::app()->end();
            }else {
                @SystemLog::record(Yii::app()->user->name . "导入上传文件失败");
                $this->setFlash('error', '上传文件失败');
            }
        }
        $this->render('importExcel',array(
            'model'=>$model,
            'result' => $result,
        ));
    }
    /**
     * 查看详情
     */
    public function actionDetailsView(){

        $this->showBack = true;
        $id = $this->getParam('id');
        $auditLogging_model = new OfflineSignAuditLogging();
        $model = OfflineSignStore::model()->findByPk($id);
        $enterpriseTable = Enterprise::model()->tableName();
        $enterpriseDataTable = EnterpriseData::model()->tableName();
        $memberTable = Member::model()->tableName();
        $bankAccountTable = BankAccount::model()->tableName();
        switch($model->apply_type){
            //查询合同、企业、店铺信息.
            case OfflineSignStore::APPLY_TYPE_NEW_FRANCHIESE:
                $enterprise_model = OfflineSignEnterprise::model()->findByPk($model->offline_sign_enterprise_id);
                $contract_model = OfflineSignContract::model()->findByPk($enterprise_model->offline_sign_contract_id);

                $this->render('detailsView',array(
                    'model' => $model,
                    'enterprise_model' => $enterprise_model,
                    'contract_model' => $contract_model,
                    'auditLogging_model'=>$auditLogging_model,
                    'id'=>$id,
                ));
                break;
            //查询企业、店铺信息（目前无合同信息，二期导入）
            case OfflineSignStore::APPLY_TYPE_OLD_FRANCHIESE:
                $data = Yii::app()->db->createCommand()
                            ->select('e.name,e.link_man,e.enterprise_type,ed.license,ed.license_photo,ed.organization_image,ed.organization,ba.account_name,ba.province_id,ba.city_id,ba.district_id,ba.street,ba.bank_name,ba.account,ba.licence_image')
                            ->from($enterpriseTable . ' as e')
                            ->leftJoin($enterpriseDataTable .' as ed','e.id = ed.enterprise_id')
                            ->leftJoin($memberTable . ' as m','m.enterprise_id = e.id')
                            ->leftJoin($bankAccountTable . ' as ba','ba.member_id = m.id')
                            ->where('e.id=:id',array(':id'=>$model->old_member_franchisee_id))
                            ->queryRow();
                $this->render('detailsView',array('model'=>$model,'data'=>$data,'auditLogging_model'=>$auditLogging_model,
                    'id'=>$id,));
                break;
        }
    }

    /**
     * 同步bit数据使用
     */
    public function actionInitAreaId()
    {
        if(!isset($_GET['pw']) || $_GET['pw'] != 'xuegang.liu'){
            return false;
        }

        $connection = Yii::app()->db;
        $sql = "select distinct agent_id FROM gw_offline_sign_store";
        $data = $connection->createCommand($sql)->queryAll();
        if(empty($data)) die('no date');

        $data = array_map(function($val){ return $val['agent_id']; },$data);
        $data = array_filter($data);
        
        foreach ((array)$data as $agentId) {

            $areaId = Region::getAreaIdByUserId($agentId);
            $areaId = intval($areaId);
            $updateSql = "update gw_offline_sign_store set install_area_id={$areaId} where agent_id={$agentId}";
            $rowNum = $connection->createCommand($updateSql)->execute();
            var_dump("agent = {$agentId} : update : ".$rowNum."条");
        }
    }
}
