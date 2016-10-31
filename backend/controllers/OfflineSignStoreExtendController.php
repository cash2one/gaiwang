<?php

class OfflineSignStoreExtendController extends Controller
{
    public $roleArr = array();                        //当前用户所属的角色
    public $role;                                     //当前用户的角色
    public $showBack = false; //右上角 是否显示 “返回列表”

    /**
     * 处理用户角色
     * @param CAction $action
     * @return bool
     */
    protected function beforeAction($action) {
        //获取当前登录用户所拥有的7个审核角色
        $this->roleArr = OfflineSignStoreExtend::getRoleByUser();
        if(isset($_GET['role'])){//如果有传递角色，就按传递的角色
            $this->role = $this->getParam('role');
        }else{//没有就按拥有的第一个角色
            $this->role = reset($this->roleArr);
            $this->role = $this->role['id'];
        }
        return parent::beforeAction($action);
    }



    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions() {
        return 'returnEndTime,depthCategory';
    }


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        //根据登录用户的角色或者点击的具体审核列表来展示（一个用户可能有多个角色）
        $role = $this->role;
        switch($role){
            case OfflineSignAuditLogging::ROLE_REGIONAL_SALES:
                $this->breadcrumbs = array('电子化签约审核列表' => array('admin'), '大区经理审核列表');
                break;
            case OfflineSignAuditLogging::ROLE_DIRECTOR_OF_SALES:
                $this->breadcrumbs = array('电子化签约审核列表' => array('admin'), '销售总监列表');
                break;
            case OfflineSignAuditLogging::ROLE_REGION_AUDIT:
                $this->breadcrumbs = array('电子化签约审核列表' => array('admin'), '大区审核列表');
                break;
            case OfflineSignAuditLogging::ROLE_THE_AUDIT_TEAM_LEADER:
                $this->breadcrumbs = array('电子化签约审核列表' => array('admin'), '审核组长列表');
                break;
            case OfflineSignAuditLogging::ROLE_DIRECTOR_OF_OPERATIONS:
                $this->breadcrumbs = array('电子化签约审核列表' => array('admin'), '运营总监列表');
                break;
            case OfflineSignAuditLogging::ROLE_AUDIT_OPERATIONS_REGION:
                $this->breadcrumbs = array('电子化签约审核列表' => array('admin'), '运作部大区审核列表');
                break;
            case OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER:
                $this->breadcrumbs = array('电子化签约审核列表' => array('admin'), '运作部经理列表');
                break;
            case OfflineSignAuditLogging::PASS_AUDIT:
                $this->breadcrumbs = array('电子化签约审核列表' => array('admin'), '审核完毕列表');
                break;
            case OfflineSignAuditLogging::ALL_SIGN:
                $this->breadcrumbs = array('电子化签约审核列表' => array('admin'), '全部签约列表');
                break;
        }
        $this->_AuditList();
	}

    /**
     * 审核列表
     * @param int $role 对应角色
     */
    public function _AuditList(){
        $model = new OfflineSignStoreExtend('search');
        $model->unsetAttributes();
        if (isset($_GET['OfflineSignStoreExtend'])) {
            $searchArr = $this->getParam('OfflineSignStoreExtend');
            $model->attributes = $this->getParam('OfflineSignStoreExtend');
            $model->role = $_GET['role'];
            $model->enTerName = $searchArr['enTerName'];
            $model->createTimeStart = $searchArr['createTimeStart'];
            $model->createTimeEnd = $searchArr['createTimeEnd'];
            $model->apply_type = $_GET['apply_type'];
            $model->role_status = $_GET['role_audit_status'];
        }
        $model->role = $this->role;
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 审核完毕
     */
    public function actionFinishAdmin(){
        $model = new OfflineSignStoreExtend('search');
        $model->unsetAttributes();
        if (isset($_GET['OfflineSignStoreExtend'])) {
            $searchArr = $this->getParam('OfflineSignStoreExtend');
            $model->attributes = $this->getParam('OfflineSignStoreExtend');
            $model->role = $_GET['role'];
            $model->enTerName = $searchArr['enTerName'];
            $model->createTimeStart = $searchArr['createTimeStart'];
            $model->createTimeEnd = $searchArr['createTimeEnd'];
            $model->apply_type = $_GET['apply_type'];
            $model->role_status = OfflineSignStoreExtend::ROLE_ALL_SIGN_AUDIT_STATUS_DONE;
        }
        $model->role = $this->role;
        $this->render('finishAdmin', array(
            'model' => $model,
        ));
    }

    /**
     * 全部签约
     */
    public function actionAllContractAdmin(){
        $model = new OfflineSignStoreExtend('search');
        $model->unsetAttributes();
        if (isset($_GET['OfflineSignStoreExtend'])) {
            $searchArr = $this->getParam('OfflineSignStoreExtend');
            $model->attributes = $this->getParam('OfflineSignStoreExtend');
            $model->role = $_GET['role'];
            $model->enTerName = $searchArr['enTerName'];
            $model->createTimeStart = $searchArr['createTimeStart'];
            $model->createTimeEnd = $searchArr['createTimeEnd'];
        }
        if (isset($_GET['apply_type']) || isset($_GET['role_audit_status'])) {
            $model->role = $_GET['role'];
            $model->apply_type = $_GET['apply_type'];
            $model->role_audit_status_2_all_sign = $_GET['role_audit_status'];
        }
        $model->role = $this->role;
        $this->render('allContractAdmin', array(
            'model' => $model,
        ));
    }


    /**
     * 查看（运作部）详情
     * @param int $id 资质id
     * @throws CHttpException
     */
    public function actionOperationDetailsView(){
        $id = $this->getParam('id');
        if(empty($id)){
            $this->setFlash('error','参数错误');
            $this->redirect(array('admin'));
        }
        $extendModel = OfflineSignStoreExtend::model()->findByPk($id);
        if($extendModel->offline_sign_enterprise_id)
            $enterpriseModel = OfflineSignEnterprise::model()->findByPk($extendModel->offline_sign_enterprise_id);
        if($extendModel->offline_sign_contract_id)
            $contractModel = OfflineSignContract::model()->findByPk($extendModel->offline_sign_contract_id);
        $auditLogging_model = new OfflineSignAuditLogging();
        $storeModel = new OfflineSignStore();
        $storeModel->extend_id = $extendModel->id;
        $criteria = $storeModel->searchView();
        $storeData = $storeModel->findAll($criteria);
        $data = OfflineSignStoreExtend::getCreateInfo($extendModel,$storeData);
        $this->render('operationDetailsView',array(
            'extendModel'=>$extendModel,
            'enterprise_model'=>isset($enterpriseModel) ? $enterpriseModel : '',
            'contract_model'=>isset($contractModel) ? $contractModel : '',
            'storeData'=>$storeData,
            'auditLogging_model'=>$auditLogging_model,
            'id'=>$id,
            'data'=>$data,
        ));
    }


    /**
     * 查看（非运作部）详情
     */
    public function actionDetailsView(){
        $this->showBack = true;
        $id = $this->getParam('id');
        $auditLogging_model = new OfflineSignAuditLogging();
        $extendModel = OfflineSignStoreExtend::model()->findByPk($id);
        $enterpriseTable = Enterprise::model()->tableName();
        $enterpriseDataTable = EnterpriseData::model()->tableName();
        $memberTable = Member::model()->tableName();
        $bankAccountTable = BankAccount::model()->tableName();

        switch($extendModel->apply_type){
            //查询合同、企业、店铺信息.
            case OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE:
                $enterpriseModel = OfflineSignEnterprise::model()->findByPk($extendModel->offline_sign_enterprise_id);
                $contractModel = OfflineSignContract::model()->findByPk($extendModel->offline_sign_contract_id);
                $storeModel = new OfflineSignStore();
                $storeModel->extend_id = $extendModel->id;
                $storeModel->machine_id = 0;
                $criteria = $storeModel->searchView();
                $storeData = $storeModel->findAll($criteria);
                $data = OfflineSignStoreExtend::getCreateInfo($extendModel,$storeData);
                $this->render('detailsView',array(
                    'extendModel'=>$extendModel,
                    'enterpriseModel'=>isset($enterpriseModel) ? $enterpriseModel : '',
                    'contractModel'=>isset($contractModel) ? $contractModel : '',
                    'storeData'=>$storeData,
                    'auditLogging_model'=>$auditLogging_model,
                    'id'=>$id,
                    'data'=>$data,
                ));
                break;
            //查询企业、店铺信息（目前无合同信息，二期导入）
            case OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE:
                /*$data = Yii::app()->db->createCommand()
                    ->select('e.name,e.link_man,e.enterprise_type,ed.license,ed.license_photo,ed.organization_image,ed.organization,ba.account_name,ba.province_id,ba.city_id,ba.district_id,ba.street,ba.bank_name,ba.account,ba.licence_image')
                    ->from($enterpriseTable . ' as e')
                    ->leftJoin($enterpriseDataTable .' as ed','e.id = ed.enterprise_id')
                    ->leftJoin($memberTable . ' as m','m.enterprise_id = e.id')
                    ->leftJoin($bankAccountTable . ' as ba','ba.member_id = m.id')
                    ->where('e.id=:id',array(':id'=>$model->old_member_franchisee_id))
                    ->queryRow();*/
                if($extendModel->offline_sign_enterprise_id)
                    $enterprise_model = OfflineSignEnterprise::model()->findByPk($extendModel->offline_sign_enterprise_id);
                if($extendModel->offline_sign_contract_id)
                    $contract_model = OfflineSignContract::model()->findByPk($extendModel->offline_sign_contract_id);
                $storeModel = new OfflineSignStore();
                $storeModel->extend_id = $extendModel->id;
                $criteria = $storeModel->searchView();
                $storeData = $storeModel->findAll($criteria);
                $data = OfflineSignStoreExtend::getCreateInfo($extendModel,$storeData);
                $this->render('detailsView',array(
                    'extendModel'=>$extendModel,
                    'enterpriseModel'=>isset($enterprise_model) ? $enterprise_model : '',
                    'contractModel'=>isset($contract_model) ? $contract_model : '',
                    'storeData'=>$storeData,
                    'auditLogging_model'=>$auditLogging_model,
                    'id'=>$id,
                    'data'=>$data,
                ));
                break;
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
        $model = OfflineSignStoreExtend::model()->findByPk($id);
        switch($model->apply_type){
            case OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE:
                $enterprise_model = OfflineSignEnterprise::model()->findByPk($model->offline_sign_enterprise_id);
                $contract_model = OfflineSignContract::model()->findByPk($model->offline_sign_contract_id);
                $storeModel = new OfflineSignStore();
                $storeModel->extend_id = $model->id;
                $criteria = $storeModel->searchView();
                $storeData = $storeModel->findAll($criteria);
                if(isset($_POST['status'])){
                    $this->_operationsNew($model,$storeData,$enterprise_model,$contract_model,$id,$this->role);
                }
                $this->render('qualificationAudit', array(
                    'extendModel' => $model,
                    'enterpriseModel' => $enterprise_model,
                    'contractModel' => $contract_model,
                    'storeData'=>$storeData,
                ));
                break;
            case OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE:
                /*$data = Yii::app()->db->createCommand()
                    ->select('e.name,e.link_man,e.enterprise_type,ed.license,ed.license_photo,ed.organization_image,
                            ed.organization,ba.account_name,ba.province_id,ba.city_id,ba.district_id,ba.street,ba.bank_name,ba.account,ba.licence_image')
                    ->from(Enterprise::model()->tableName() . ' as e')
                    ->leftJoin(EnterpriseData::model()->tableName() .' as ed','e.id = ed.enterprise_id')
                    ->leftJoin(Member::model()->tableName() . ' as m','m.enterprise_id = e.id')
                    ->leftJoin(BankAccount::model()->tableName() . ' as ba','ba.member_id = m.id')
                    ->where('e.id=:id',array(':id'=>$model->old_member_franchisee_id))
                    ->queryRow();*/
                if($model->offline_sign_enterprise_id)
                $enterprise_model = OfflineSignEnterprise::model()->findByPk($model->offline_sign_enterprise_id);
                if($model->offline_sign_contract_id)
                $contract_model = OfflineSignContract::model()->findByPk($model->offline_sign_contract_id);
                $storeModel = new OfflineSignStore();
                $storeModel->extend_id = $model->id;
                $criteria = $storeModel->searchView();
                $storeData = $storeModel->findAll($criteria);
                if(isset($_POST['status'])){
                    $this->_operationsOld($model,$storeData,$id,$this->role);
                }
                $this->render('qualificationAudit', array(
                    'extendModel' => $model,
                    'enterpriseModel' => isset($enterprise_model)?$enterprise_model:'',
                    'contractModel' => isset($contract_model)?$contract_model:'',
                    'storeData'=>$storeData,
                ));
                break;
        }
    }

    /**
     * 审核（运作部）
     */
    public function _yesOperations($id){
        $model = OfflineSignStoreExtend::model()->findByPk($id);
        switch($model->apply_type) {
            case OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE:
                $enterprise_model = OfflineSignEnterprise::model()->findByPk($model->offline_sign_enterprise_id);
                $contract_model = OfflineSignContract::model()->findByPk($model->offline_sign_contract_id);
                $storeModel = new OfflineSignStore();
                $storeModel->extend_id = $model->id;
                $criteria = $storeModel->searchView();
                $storeData = $storeModel->findAll($criteria);
                if(isset($_POST['status'])){
                    $this->_operationsNew($model,$storeData,$enterprise_model,$contract_model,$id,$this->role);
                }
                $this->render('operationDepartmentAudit', array(
                    'storeData' => $storeData,
                    'enterpriseModel' => $enterprise_model,
                    'contractModel' => $contract_model,
                    'extendModel' => $model,
                ));
                break;
            case OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE:
                if($model->offline_sign_enterprise_id)
                    $enterprise_model = OfflineSignEnterprise::model()->findByPk($model->offline_sign_enterprise_id);
                if($model->offline_sign_contract_id)
                    $contract_model = OfflineSignContract::model()->findByPk($model->offline_sign_contract_id);
                $storeModel = new OfflineSignStore();
                $storeModel->extend_id = $model->id;
                $criteria = $storeModel->searchView();
                $storeData = $storeModel->findAll($criteria);
                if(isset($_POST['status'])){
                    $this->_operationsOld($model,$storeData,$id,$this->role);
                }
                $this->render('operationDepartmentAudit', array(
                    'extendModel' => $model,
                    'enterpriseModel' => isset($enterprise_model)?$enterprise_model:'',
                    'contractModel' => isset($contract_model)?$contract_model:'',
                    'storeData'=>$storeData,
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
    public function _operationsNew($model,$storeData,$enterprise_model,$contract_model,$id,$role){
        $auditing = $this->getPost('status');
        $auditing = $auditing * 1;
        try {
            //保存到进度表OfflineSignAuditLogging
            $loging = new OfflineSignAuditLogging();
            $loging->extend_id = $id;
            $loging->status = $auditing;
            $loging->audit_role = $role;
            $loging->behavior = '2001';
            $loging->save(false);
            if ($auditing == OfflineSignAuditLogging::STATUS_NO_PASS) {
                if (empty($_POST['contentHidden']))
                    throw new CHttpException(400, '请填写审核不通过原因');
                $c_error = array();
                $e_error = array();
                $s_error = array();
                preg_match_all('/(c\.[a-zA-Z_]+)/', $_POST['errorField'], $c_error);
                preg_match_all('/(e\.[a-zA-Z_]+)/', $_POST['errorField'], $e_error);
                preg_match_all('/(ex\.[a-zA-Z\d_]+)/', $_POST['errorField'], $ex_error);
                preg_match_all('/(s[\d]+\.[a-zA-Z_]+)/', $_POST['errorField'], $ss_error);
                if(!empty($ss_error)) {
                    foreach ($ss_error[1] as $key => $val) {
                        $s_error[$key] = explode('.',$val);
                    }
                }
                $storeId = OfflineSignStoreExtend::getAllStoreId($id);
                $store_error = array();
                $num = 0;
                if(!empty($storeId)){
                    foreach($storeId as $key=>$val){
                        $storeModel = OfflineSignStore::model()->findByPk($val['id']);
                        foreach($s_error as $err){
                            if($err[0] == 's'.$storeModel->id)
                                $store_error[$num++] = 's.'.$err[1];
                        }
                        if(!empty($store_error)) {
                            $storeModel->error_field = isset($store_error) ? json_encode($store_error) : '';
                            $storeModel->save(false);
                        }
                        $num = 0;
                        $store_error = array();
                    }
                }
                //将错误字段保存到各自表里面
                $enterprise_model->error_field = isset($e_error[1]) ? json_encode($e_error[1]) : '';
                $contract_model->error_field = isset($c_error[1]) ? json_encode($c_error[1]) : '';
                $model->error_field = isset($ex_error[1]) ? json_encode($ex_error[1]) : '';
                $enterprise_model->save(false,array('error_field'));
                $contract_model->save(false,array('error_field'));
                $model->save(false,array('error_field'));
                $loging->error_field = $this->getPost('errorField');
                $loging->remark = $this->getPost('contentHidden');
                $loging->save(false);
                OfflineSignStoreExtend::updateAuditStatus($id,$role,false); //审核不通过，更新审核状态
            }elseif($auditing == OfflineSignAuditLogging::STATUS_PASS) {
                //$loging->remark = $this->getPost('content');
                //当运作部经理审核通过后
                if ($role == OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER) {
                    $trans = Yii::app()->db->beginTransaction();
                    //生成 enterprise 表数据
                    $enterprise = array(
                        'name' => $enterprise_model->name,
                        'link_man' => $enterprise_model->linkman_name,
                        'service_start_time' => $contract_model->begin_time,
                        'service_end_time' => $contract_model->end_time,
                        'province_id' => $contract_model->province_id,
                        'city_id' => $contract_model->city_id,
                        'district_id' => $contract_model->district_id,
                        'street' => $contract_model->address,
                    );
                    Yii::app()->db->createCommand()->insert(Enterprise::model()->tableName(), $enterprise);
                    $enterpriseId = Yii::app()->db->getLastInsertID();
                    //生成gw_enterprise_data 表数据
                    $enterprise_data = array(
                        'enterprise_id' => $enterpriseId,
                        'license' => $enterprise_model->enterprise_license_number,
                        'license_photo' => OfflineSignFile::getPathById($enterprise_model->license_image),
                        'legal_man' => $enterprise_model->legal_man,
                        'tax_id' => $enterprise_model->tax_id,
                        'license_province_id' => $contract_model->province_id,
                        'license_city_id' => $contract_model->city_id,
                        'license_district_id' => $contract_model->district_id,
                    );
                    Yii::app()->db->createCommand()->insert(EnterpriseData::model()->tableName(), $enterprise_data);
                    $modelMember = new Member();
                    $modelMember->salt = Tool::generateSalt();
                    //生成 Member 表数据

                    $passWord = mt_rand(10000, 100000000);

                    $member = array(
                        'username' => $enterprise_model->name,
                        'enterprise_id' => $enterpriseId,
                        'gai_number' => $modelMember->generateGaiNumber(),
                        'password' => $modelMember->hashPassword($passWord),
                        'salt' => $modelMember->salt,
                        'register_time' => time(),
                        'mobile' => $contract_model->mobile,
                        'type_id' => MemberType::MEMBER_EXPENSE,
                        'member_type' => Member::REG_TYPE_OFFLINE,
                    );
                    $temp = Yii::app()->db->createCommand()->insert(Member::model()->tableName(), $member);
                    $memberId = Yii::app()->db->getLastInsertID();
                    if ($temp) {
                        //发送短信
                        $smsConfig = $this->getConfig('smsmodel');
                        $msg = str_replace('{0}', '企业会员', $smsConfig['newMemberContent']);
                        $msg = str_replace('{1}', $member['gai_number'], $msg);
                        $msg = str_replace('{2}', $passWord, $msg);
                        $rong = array('企业会员', $member['gai_number'], $passWord);
                        $tmpId = $smsConfig['newMemberContentId'];
                        //Sms::send($contract_model->mobile, $msg, $rong, $tmpId);
                        SmsLog::addSmsLog($contract_model->mobile, $msg, $memberId, SmsLog::TYPE_OTHER, null, true, $rong, $tmpId);
                    }
                    //生成 gw_bank_account 表数据
                    $bank_account = array(
                        'member_id' => $memberId,
                        'account_name' => $contract_model->account_name,
                        'bank_name' => $contract_model->bank_name,
                        'account' => $contract_model->account,
                        'province_id' => $enterprise_model->bank_province_id,
                        'city_id' => $enterprise_model->bank_city_id,
                        'district_id' => $enterprise_model->bank_district_id,
                        'licence_image' => OfflineSignFile::getPathById($enterprise_model->bank_permit_image),
                    );
                    Yii::app()->db->createCommand()->insert(BankAccount::model()->tableName(), $bank_account);
                    foreach ($storeData as $key => $storeMode) {
                        //生成 gw_franchisee 表信息
                        $franModel = new Franchisee();
                        $franModel->password = mt_rand(10000, 100000000);
                        $franModel->member_id = $memberId;
                        $franModel->province_id = $storeMode->install_province_id;
                        $franModel->city_id = $storeMode->install_city_id;
                        $franModel->district_id = $storeMode->install_district_id;
                        $franModel->street = $storeMode->install_street;
                        $franModel->gai_discount = $storeMode->gai_discount;
                        $franModel->member_discount = $storeMode->member_discount;
                        $franModel->name = $storeMode->franchisee_name;
                        $franModel->mobile = $storeMode->store_mobile;
                        $franModel->save(false);

                        //生成 gt_machine 表信息
                        $machineCode = Machine::createMachineCode();
                        $machine = array(
                            'create_time' => time(),
                            'biz_info_id' => $franModel->id,
                            'name' => $storeMode->franchisee_name,
                            'machine_code' => $machineCode,
                            'activation_code' => Machine::createActivationCode($machineCode),
                            'intro_member_id' => $storeMode->recommender_member_id_member,
                            'install_member_id' => $storeMode->recommender_member_id_agent,
                            'operate_member_id' => $storeMode->franchisee_operate_id,
                            'province_id' => $storeMode->install_province_id,
                            'city_id' => $storeMode->install_city_id,
                            'district_id' => $storeMode->install_district_id,
                            'address' => $storeMode->install_street,
                        );
                        Yii::app()->gt->createCommand()->insert(Machine::model()->tableName(), $machine);
                        $machineId = Yii::app()->gt->getLastInsertID();
                        $xinfa = array(
                            'machine_id' => $machineId,
                        );
                        Yii::app()->gt->createCommand()->insert('{{xinfa_config}}', $xinfa);
                        //修改 offline_sign_store 表信息
                        $off_line_sign_store = array(
                            'machine_id' => $machineId,
                            'franchisee_id' => $franModel->id,
                        );

                        Yii::app()->db->createCommand()->update(OfflineSignStore::model()->tableName(), $off_line_sign_store, 'id=:id', array(":id" => $storeMode->id));

                    }
                    //修改 offline_sign_store_extend 角色状态
                    $off_line_sign_store_extend = array(
                        'enterprise_id' => $enterpriseId,
                        'status' => OfflineSignStoreExtend::STATUS_HAS_PASS,
                        'audit_status' => OfflineSignStoreExtend::AUDIT_STATUS_EXA_SUCCES,
                    );
                    Yii::app()->db->createCommand()->update(OfflineSignStoreExtend::model()->tableName(),$off_line_sign_store_extend,'id=:id',array(":id"=>$id));
                    $trans->commit();
                }

                    $loging->error_field = ''; //清空错误字段
                    $enterprise_model->error_field = '';
                    $contract_model->error_field = '';
                    $model->error_field = '';
                    $storeId = OfflineSignStoreExtend::getAllStoreId($id);
                    if (!empty($storeId)) {
                        foreach ($storeId as $val) {
                            $storeEM = OfflineSignStore::model()->findByPk($val['id']);
                            $storeEM->error_field = '';
                            $storeEM->save(false);
                        }
                    }
                    $enterprise_model->save(false, array('error_field'));
                    $contract_model->save(false, array('error_field'));
                    $model->save(false, array('error_field'));
                    $loging->remark = $this->getPost('contentHidden');
                    $loging->save(false);
                    OfflineSignStoreExtend::updateAuditStatus($id,$role); //审核通过，更新审核状态
                }
                $this->setFlash('success', Yii::t('offlineSignAuditLogging', '审核成功'));
                $this->redirect(array('offlineSignStoreExtend/admin', 'role' => $role));
        }catch (Exception $e){
            $trans->rollback();
            $this->setFlash('error', Yii::t('offlineSignAuditLogging', $e->getMessage()));
        }
    }


    /**
     * 原有会员新增加盟商审核
     * @param object $model 店铺资质模型
     * @param int $id 店铺id
     * @param int $role 审核人角色
     * @throws CDbException
     */
    public function _operationsOld($model,$storeData,$id,$role){
        $auditing = $this->getPost('status');
        $auditing = $auditing * 1;
        try{
            //保存到进度表OfflineSignAuditLogging
            $loging = new OfflineSignAuditLogging();
            $loging->extend_id = $id;
            $loging->status = $auditing;
            $loging->audit_role = $role;
            $loging->behavior = '2001';
            $loging->save(false);
            if ($auditing == OfflineSignAuditLogging::STATUS_NO_PASS) {
                if (empty($_POST['contentHidden']))
                    throw new CHttpException(400, '请填写审核不通过原因');
                preg_match_all('/(ex\.[a-zA-Z\d_]+)/', $_POST['errorField'], $ex_error);
                $model->error_field = isset($ex_error[1]) ? json_encode($ex_error[1]) : '';
                $model->save(false,array('error_field'));
                $ss_error = explode(',',$_POST['errorField']);
                if(!empty($ss_error)){
                    foreach($ss_error as $key=>$val){
                        $s_error[$key] = explode('.',$val);
                    }
                }
                $storeId = OfflineSignStoreExtend::getAllStoreId($id);
                $store_error = array();
                $num = 0;
                if(!empty($storeId)){
                    foreach($storeId as $key=>$val){
                        $storeModel = OfflineSignStore::model()->findByPk($val['id']);
                        foreach($s_error as $err){
                            if($err[0] == 's'.$storeModel->id)
                                $store_error[$num++] = 's.'.$err[1];
                        }
                        if(!empty($store_error)) {
                            $storeModel->error_field = isset($store_error) ? json_encode($store_error) : '';
                            $storeModel->save(false);
                        }
                        $num = 0;
                        $store_error = array();
                    }
                }
                $loging->remark = $this->getPost('contentHidden');
                $loging->error_field = $this->getPost('errorField');
                $loging->save(false);
                OfflineSignStoreExtend::updateAuditStatus($id,$role,false); //审核不通过，更新审核状态
            }elseif($auditing == OfflineSignAuditLogging::STATUS_PASS){
                if($role == OfflineSignAuditLogging::ROLE_OPERATIONS_MANAGER) {
                    $trans = Yii::app()->db->beginTransaction();
                    //生成 gw_franchisee 表信息
                    $memberId = Yii::app()->db->createCommand()
                        ->select('id')
                        ->from(Member::model()->tableName())
                        ->where('enterprise_id = :id',array(':id' => $model->enterprise_id))
                        ->queryScalar();

                    if(empty($memberId)){
                        throw new Exception("会员id不存在", 1);
                    }
                    foreach ($storeData as $key => $storeMode) {
                        //生成 gw_franchisee 表信息
                        $franModel = new Franchisee();
                        $franModel->password = mt_rand(10000, 100000000);
                        $franModel->member_id = $memberId;
                        $franModel->province_id = $storeMode->install_province_id;
                        $franModel->city_id = $storeMode->install_city_id;
                        $franModel->district_id = $storeMode->install_district_id;
                        $franModel->street = $storeMode->install_street;
                        $franModel->gai_discount = $storeMode->gai_discount;
                        $franModel->member_discount = $storeMode->member_discount;
                        $franModel->name = $storeMode->franchisee_name;
                        $franModel->mobile = $storeMode->store_mobile;
                        $franModel->save(false);

                        //生成 gt_machine 表信息
                        $machineCode = Machine::createMachineCode();
                        $machine = array(
                            'create_time' => time(),
                            'biz_info_id' => $franModel->id,
                            'name' => $storeMode->franchisee_name,
                            'machine_code' => $machineCode,
                            'activation_code' => Machine::createActivationCode($machineCode),
                            'intro_member_id' => $storeMode->recommender_member_id_member,
                            'install_member_id' => $storeMode->recommender_member_id_agent,
                            'operate_member_id' => $storeMode->franchisee_operate_id,
                            'province_id' => $storeMode->install_province_id,
                            'city_id' => $storeMode->install_city_id,
                            'district_id' => $storeMode->install_district_id,
                            'address' => $storeMode->install_street,
                        );
                        Yii::app()->gt->createCommand()->insert(Machine::model()->tableName(), $machine);
                        $machineId = Yii::app()->gt->getLastInsertID();
                        $xinfa = array(
                            'machine_id' => $machineId,
                        );
                        Yii::app()->gt->createCommand()->insert('{{xinfa_config}}', $xinfa);
                        //修改 offline_sign_store 表信息
                        $off_line_sign_store = array(
                            'machine_id' => $machineId,
                            'franchisee_id' => $franModel->id,
                        );

                        Yii::app()->db->createCommand()->update(OfflineSignStore::model()->tableName(), $off_line_sign_store, 'id=:id', array(":id" => $storeMode->id));

                    }
                    //修改 offline_sign_store_extend 角色状态
                    $off_line_sign_store_extend =array(
                        'status' =>OfflineSignStoreExtend::STATUS_HAS_PASS,
                        'audit_status' =>OfflineSignStoreExtend::AUDIT_STATUS_EXA_SUCCES,
                    );
                    Yii::app()->db->createCommand()->update(OfflineSignStoreExtend::model()->tableName(),$off_line_sign_store_extend,'id=:id',array(":id"=>$id));
                    $trans->commit();
                }
                $storeId = OfflineSignStoreExtend::getAllStoreId($id);
                if(!empty($storeId)){
                    foreach($storeId as $val){
                        $storeEM = OfflineSignStore::model()->findByPk($val['id']);
                        $storeEM->error_field = '';
                        $storeEM->save(false);
                    }
                }
                $extendM = OfflineSignStoreExtend::model()->findByPk($id);
                $extendM ->error_field = '';
                $extendM->save(false);
                OfflineSignStoreExtend::updateAuditStatus($id,$role); //审核通过，更新审核状态
                $loging->remark = $this->getPost('contentHidden');
                $loging->save(false);
            }
            $this->setFlash('success', Yii::t('offlineSignAuditLogging', '审核成功'));
            $this->redirect(array('offlineSignStoreExtend/admin','role'=>$role));
        }catch (Exception $e){
            $trans->rollback();
            $this->setFlash('error', Yii::t('offlineSignAuditLogging', $e->getMessage()));
        }
    }
    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate(){
        $storeExtendId = $this->getParam('id');
        $role = $this->getParam('role');
        $enterprise = $this->getParam('enterprise');
        if(empty($enterprise)){
            $enterprise = 'partialView';
        }
        if(empty($storeExtendId) || empty($role)){
            $this->setFlash('error','参数错误');
            $this->redirect(array('admin'));
        }
        $storeInfoModel = $this->loadModel($storeExtendId);
        switch ($storeInfoModel->apply_type) {
            case  OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE:
                $this->updateNewFranchisee($storeExtendId,$role,$enterprise);
                break;
            case  OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE:
                $this->updateOldFranchisee($storeExtendId,$role,$enterprise);
                break;
            default:
                break;
        }
    }
    /**
     * 查看资质
     * @param int $id 资质id
     * @throws CHttpException
     */
    public function actionLookData(){
        $check = $this->getParam('check');
        $storeExtendId = $this->getParam('id');
        $checkSql =  $this->getParam('sql');
        $extendModel = new OfflineSignStoreExtend();
        if($check != 'save') {
            if (isset($_POST['OfflineSignStoreExtend'])) {
                $sql = $_POST['OfflineSignStoreExtend']['lookData'];
                if($checkSql == 'gaitong') {
                    $result = Yii::app()->gt->createCommand($sql)->queryAll();
                }else{
                    $result = Yii::app()->db->createCommand($sql)->queryAll();
                }
                echo "<pre>";
                var_dump($result);
            }
        }else{
            if (isset($_POST['OfflineSignStoreExtend'])) {
                $sql = $_POST['OfflineSignStoreExtend']['lookData'];
                if($checkSql == 'gaitong'){
                    $result = Yii::app()->gt->createCommand($sql)->execute();
                }else {
                    $result = Yii::app()->db->createCommand($sql)->execute();
                }
                echo "<pre>";
                var_dump($result);
            }
        }
        $this->render('saveStoreExtend',array(
            'model'=>$extendModel,
            'check'=>isset($check)?$check:'',
            'storeExtendId'=>$storeExtendId,
        ));
    }
    /**
     * 编辑新增用户
     *
     * @author xuegang.liu@g-emall.com
     * @since  2016-01-12T10:48:56+0800
     */
    protected function updateNewFranchisee($storeExtendId,$role,$enterprise='partialView'){
        $extendInfoModel = $this->loadModel($storeExtendId);
        $enterpriseInfoModel = OfflineSignEnterprise::model()->findByPk($extendInfoModel->offline_sign_enterprise_id);
        $contractInfoModel = OfflineSignContract::model()->findByPk($extendInfoModel->offline_sign_contract_id);
        $storeModel = new OfflineSignStore();
        $storeModel->extend_id = $extendInfoModel->id;
        $criteria = $storeModel->searchView();
        $storeInfoModel = $storeModel->findAll($criteria);
        if($this->isPost()){
            try{
                $storeArray = $this->getPost('OfflineSignEnterprise');
                $OldStoreModel =  $enterpriseInfoModel->attributes;
                $enterpriseInfoModel->attributes = $storeArray;
                if($enterpriseInfoModel->save()){
                    try {
                        $OldStoreModel['registration_time'] = empty($OldStoreModel['registration_time']) ? null : strtotime($OldStoreModel['registration_time']);
                        $OldStoreModel['license_begin_time'] = empty($OldStoreModel['license_begin_time']) ? null : strtotime($OldStoreModel['license_begin_time']);
                        $OldStoreModel['license_end_time'] = empty($OldStoreModel['license_end_time']) ? null : strtotime($OldStoreModel['license_end_time']);
                        $NewStoreModel = $enterpriseInfoModel->attributes;
                        $trans = Yii::app()->db->beginTransaction();
                        $array_diff = array_diff_assoc($NewStoreModel, $OldStoreModel);
                        $changeKeys = array_keys($array_diff);
                        $error_field = $enterpriseInfoModel->error_field;
                        foreach ($changeKeys as $val) {
                                $error_field = str_ireplace($val, '', $error_field);
                        }
                        if(!empty($error_field)) {
                            $error_field_arr = json_decode($error_field);
                            $arr_iner = array_intersect($error_field_arr, OfflineSignEnterprise::getErrorEnter());
                            if (empty($arr_iner)) {
                                $error_field = '';
                            }
                        }
                        $enterpriseInfoModel->error_field = $error_field;
                        $enterpriseInfoModel->save(false,array('error_field'));
                        $changeName = OfflineSignEnterprise::model()->attributeLabels();
                        $changeNames = '';
                        foreach ($changeKeys as $val) {
                            if ($val != 'update_time') {
                                $changeNames .= $changeName[$val] . '、';
                            }
                        }
                        $changeNames = rtrim($changeNames, '、');
                        $loging = new OfflineSignAuditLogging();
                        $loging->extend_id = $extendInfoModel->id;
                        $loging->audit_role = $role;
                        $loging->behavior = '2006';
                        $loging->remark = '被修改字段:'.(!empty($changeNames)?$changeNames:'无');
                        $loging->save(false);
                        $trans->commit();
                        $this->setFlash('success', Yii::t('offlineSignAuditLogging', '更新成功'));
                        $this->redirect(array('offlineSignStoreExtend/update', 'role' => $role, 'id' => $extendInfoModel->id));
                    }catch (Exception $e){
                        $trans->rollback();
                    }
                    $this->redirect(array('offlineSignStoreExtend/update','role'=>$role,'id'=>$extendInfoModel->id));
                }else{
                    $enterprise = 'enterprise';
                    $enterpriseInfoModel->registration_time = empty($enterpriseInfoModel->registration_time) ? null : date('Y-m-d',$enterpriseInfoModel->registration_time);
                    $enterpriseInfoModel->license_begin_time = empty($enterpriseInfoModel->license_begin_time) ? null : date('Y-m-d',$enterpriseInfoModel->license_begin_time);
                    $enterpriseInfoModel->license_end_time = empty($enterpriseInfoModel->license_end_time) ? null : date('Y-m-d',$enterpriseInfoModel->license_end_time);
                }
            }catch(Exception $e){
                $this->setFlash('error',$e->getMessage());
            }
        }

        OfflineSignContract::formatContractAdExpires($contractInfoModel);
        $demoImgs = Tool::getConfig('offlinesigndemoimgs');
        $this->render('update',array(
            'storeInfoModel'=>$storeInfoModel,
            'enterpriseInfoModel'=>$enterpriseInfoModel,
            'contractInfoModel'=>$contractInfoModel,
            'extendInfoModel'=>$extendInfoModel,
            'demoImgs'=>$demoImgs,
            'role' => $role,
            'enterprise'=>$enterprise,
        ));
    }
    /**
     * 编辑原有会员新增盟商列表
     */
    public function actionSaveOldFranchisee() {
        $storeId = $this->getParam('id');
        $role = $this->getParam('role');
        $storeNum = $this->getParam('num');
        $model=OfflineSignStore::model()->findByPk($storeId);
        $model->setScenario('OldFranchisee');
        if($model->extend_id)
            $extendInfoModel = $this->loadModel($model->extend_id);
        if (isset($_POST['OfflineSignStore'])) {
            $OldStoreModel = $model->attributes;
            $model->attributes = $this->getParam('OfflineSignStore');
            $model->franchisee_category_id = (!empty($model->depthOne)
                ? $model->depthOne : (!empty($model->depthZero) ? $model->depthZero : ''));
            if($model->save()){
                try {
                    $NewStoreModel = $model->attributes;
                    $trans = Yii::app()->db->beginTransaction();
                    $OldStoreModel['open_begin_time'] = strtotime($OldStoreModel['open_begin_time']);
                    $OldStoreModel['open_end_time'] = strtotime($OldStoreModel['open_end_time']);
                    if($NewStoreModel['exists_membership'] == OfflineSignStore::EXISTS_MEMBERSHIP_No){
                        $OldStoreModel['member_discount_type'] = $NewStoreModel['member_discount_type'];
                        $OldStoreModel['store_disconunt'] = $NewStoreModel['store_disconunt'];
                    }
                    $array_diff = array_diff_assoc($NewStoreModel, $OldStoreModel);
                    $changeKeys = array_keys($array_diff);
                    $error_field = $model->error_field;
                    foreach ($changeKeys as $val) {
                        if ($val == 'franchisee_category_id') {
                            $error_field = str_ireplace('depthOne', '', $error_field);
                            $error_field = str_ireplace('depthZero', '', $error_field);
                        } elseif ($val == 'recommender_member_id_member') {
                            $error_field = str_ireplace('recommender_member_gai_number', '', $error_field);
                        } elseif ($val == 'recommender_member_id_agent') {
                            $error_field = str_ireplace('recommender_agent_gai_number', '', $error_field);
                        } elseif ($val == 'franchisee_operate_id') {
                            $error_field = str_ireplace('franchisee_operate_gai_number', '', $error_field);
                        } else {
                            $error_field = str_ireplace($val, '', $error_field);
                        }
                    }
                    if(!empty($error_field_arr)) {
                        $error_field_arr = json_decode($error_field);
                        $arr_iner = array_intersect($error_field_arr, OfflineSignStore::getStoreField());
                        if (empty($arr_iner)) {
                            $error_field = '';
                        }
                    }
                    $model->error_field = $error_field;
                    $model->save(false,array('error_field'));
                    $changeName = OfflineSignStore::model()->attributeLabels();
                    $changeNames = '';
                    foreach ($changeKeys as $val) {
                        if ($val != 'update_time') {
                            $changeNames .= $changeName[$val] . '、';
                        }
                    }
                    $changeNames = rtrim($changeNames, '、');
                    $loging = new OfflineSignAuditLogging();
                    $loging->extend_id = $extendInfoModel->id;
                    $loging->audit_role = $role;
                    $loging->behavior = '2005';
                    $loging->remark = '加盟商-'.$storeNum.' 被修改字段:'.(!empty($changeNames)?$changeNames:'无');
                    $loging->save(false);
                    $trans->commit();
                    $this->setFlash('success', Yii::t('offlineSignAuditLogging', '更新成功'));
                    $this->redirect(array('offlineSignStoreExtend/update', 'role' => $role, 'id' => $extendInfoModel->id));
                }catch (Exception $e){
                    $trans->rollback();
                }
            }else{
                //echo "<pre>"; var_dump($model);exit;
            }
        }
        $demoImgs = Tool::getConfig('offlinesigndemoimgs');
        $this->render('saveStoreinfo', array(
            'model' => $model,
            'storeInfoModel'=>$model,
            'apply_type'=>$extendInfoModel->apply_type,
            'demoImgs'=>$demoImgs,
            'extendId'=>$extendInfoModel->id,
            'extendModel'=>$extendInfoModel,
            'storeNum'=>$storeNum,
            'role'=>$role
        ));
    }
    /**
     * 原有会员新增盟商列表
     *
     * @author xuegang.liu@g-emall.com
     * @since  2016-01-12T10:48:56+0800
     */
    protected function updateOldFranchisee($ExtendId,$role,$enterprise){
        $extendInfoModel = $this->loadModel($ExtendId);
        $storeModel = new OfflineSignStore();
        $storeModel->extend_id = $extendInfoModel->id;
        $criteria = $storeModel->searchView();
        $storeInfoModel = $storeModel->findAll($criteria);
        $storeModel->setScenario('OldFranchisee');

        if($this->isPost()){
            $storeInfoModel->attributes = $this->getPost('OfflineSignStore');
            $storeInfoModel->franchisee_category_id = (!empty($storeInfoModel->depthOne)
                ? $storeInfoModel->depthOne : (!empty($storeInfoModel->depthZero) ? $storeInfoModel->depthZero : ''));

            if($storeInfoModel->save()){
                $loging = new OfflineSignAuditLogging();
                $loging->extend_id = $ExtendId;
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
            'extendInfoModel'=>$extendInfoModel,
            'enterprise' => 'partialView',
            'demoImgs'=>$demoImgs,
            'role' => $role,
        ));
    }
    /**
     * 导出excel
     */
    public function actionExportExcel()
    {
        //筛选条件过滤
        $model = new OfflineSignStoreExtend('search');
        $model->unsetAttributes();
        if (isset($_GET['OfflineSignStoreExtend'])) {
            $searchArr = $this->getParam('OfflineSignStoreExtend');
            $model->attributes = $this->getParam('OfflineSignStoreExtend');
            $model->role = $_GET['role'];
            $model->enTerName = $searchArr['enTerName'];
            $model->createTimeStart = $searchArr['createTimeStart'];
            $model->createTimeEnd = $searchArr['createTimeEnd'];
            $model->apply_type = $_GET['apply_type'];
            $model->role_status = $_GET['role_audit_status'];
        }
        date_default_timezone_set('PRC');
        set_time_limit(0);
        ini_set('memory_limit','150M');
        ini_set('max_execution_time','0');
        $time =date('Ymd');

        // 输出Excel文件头
        header('Content-Type: application/vnd.ms-excel;charset=GBK');
        header("Content-Disposition: attachment;filename=".$time.".csv");
        header('Cache-Control: max-age=0');

        //输出表头
        $title = array_keys(OfflineSignStoreExtend::getExportTitle());

        // PHP文件句柄，php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');
        foreach ($title as $key => $value) {
            $title[$key]=@iconv("utf-8", "GBK//IGNORE",  $value);
        }
        fputcsv($fp, array_values($title)); // 写入列头

        $limit = 5000;
        $total = $model->countSearchManageExport($this->role);

        $maxTimes = ceil($total/$limit);
        for ($i=0; $i<$maxTimes; $i++) {
            $offset = max($i-1,0) * $limit;
            $data = $model->searchManageExport($this->role,$offset,$limit);
            foreach ($data as $val) {
                //$value = array_merge($val,OfflineSignStoreExtend::getStore());

                    $storeData = OfflineSignStoreExtend::getAllStoreData($val['id']);
                //echo "<pre>"; var_dump($storeData);
                array_pop($val); //删除资质id
                if(!empty($storeData)){
                    foreach($storeData as $key=>$sto){
                        array_pop($sto); //删除盖机号
                        if($key == 0) {
                            $value = array_merge($val, $sto);
                        }else{
                            $value = array_merge(OfflineSignStoreExtend::getNULLData(), $sto);
                        }
                       // echo "<pre>"; var_dump($sto);
                        $this->_formatExportData($value);
                        fputcsv($fp,$value);
                        unset($value);
                    }
                }
            }
            ob_flush();
            flush();
            unset($data);
        }
        Yii::app()->end();
    }

    /**
     * 格式化导出数据
     *
     * @param  mixed  &$data 输入数据
     * @return mixed  输出数据
     */
    private function _formatExportData(&$data,$Mark = false){
        foreach ($data as $k => $v) {
           if(($k == 'code' || $k == 'legal_man_identity' || $k == 'payee_identity_number' || $k == 'enterprise_license_number' || $k == 'account') && !empty($v)) {
                $v = "'".$v."'";
            }elseif($k == 'apply_type'){
                $v = OfflineSignStoreExtend::getApplyType($v);
            }elseif($k == 'GWtime'){
                $v =  $data['GWtime'] != 0 ? date('Y-m-d',$data['GWtime']) : '';
            }elseif($k == 'sign_type'){
                $v = OfflineSignStoreExtend::getSignType($v);
            }elseif($k == 'machine_belong_to'){
                $v = OfflineSignStoreExtend::getMachineBelongTo($v);
            }elseif($k == 'franchisee_developer'){
                $v = OfflineSignStoreExtend::getFranchiseeDeveloper($v);
            }elseif($k == 'extend_area_id' || $k == 'zz_extend_area_id' || $k =='install_area_id'){
                $v = Region::getAreaNameById($v);
            }elseif($k == 'is_chain'){
                $v = OfflineSignEnterprise::getIsChain($v);
            }elseif($k == 'chain_type'){
                $v = OfflineSignEnterprise::getChainType($v);
            }elseif($k == 'enterprise_type'){
                $v = OfflineSignEnterprise::getEnterType($v);
            }elseif($k == 'registration_time'){
                $v =  $data['registration_time'] != 0 ? date('Y-m-d',$data['registration_time']) : '';
            }elseif($k == 'license_begin_time'){
                $v =  $data['license_begin_time'] != 0 ? date('Y-m-d',$data['license_begin_time']) : '';
            }elseif($k == 'license_end_time'){
                $v =  $data['license_end_time'] != 0 ? date('Y-m-d',$data['license_end_time']) : '';
            }elseif($k == 'license_is_long_time'){
                $v = OfflineSignEnterprise::getLongTime($v);
            }elseif($k == 'create_timeM'){
                $v =  $data['create_timeM'] != 0 ? date('Y-m-d',$data['create_timeM']) : '';
            }elseif($k == 'create_timeF'){
                $v =  $data['create_timeF'] != 0 ? date('Y-m-d',$data['create_timeF']) : '';
            }elseif($k == 'account_pay_type'){
                $v = OfflineSignEnterprise::getAccountPayType($v);
            }elseif($k == 'open_begin_time'){
                $v =  $data['open_begin_time'] != 0 ? date('H:i',$data['open_begin_time']) : '';
            }elseif($k == 'open_end_time'){
                $v =  $data['open_end_time'] != 0 ? date('H:i',$data['open_end_time']) : '';
            }elseif($k == 'exists_membership'){
                $v = OfflineSignStore::getExistsMembership($v);
            }elseif($k == 'member_discount_type'){
                $v = OfflineSignStore::getDiscountType($v);
            }elseif($k == 'operation_type'){
                $v = OfflineSignContract::getOperationType($v);
            }elseif($k == 'machine_install_type'){
                $v = OfflineSignStore::getInstallType($v);
            }elseif($k == 'machine_install_style'){
                $v = OfflineSignStore::getInstallStyle($v);
            }elseif($k == 'machine_size'){
                $v = OfflineSignStore::getMachineSize($v);
            }elseif($k == 'sign_time'){
                $v =  $data['sign_time'] != 0 ? date('Y-m-d',$data['sign_time']) : '';
            }elseif($k == 'begin_time'){
                $v =  $data['begin_time'] != 0 ? date('Y-m-d',$data['begin_time']) : '';
            }elseif($k == 'end_time'){
                $v =  $data['end_time'] != 0 ? date('Y-m-d',$data['end_time']) : '';
            }elseif($k=='province_id' || $k== 'city_id'||$k =='district_id'){
                $v = Region::getRegionName($v);
            }elseif($k=='bank_province_id' || $k== 'bank_city_id'||$k =='bank_district_id'){
                $v = Region::getRegionName($v);
            }elseif($k=='install_province_id' || $k== 'install_city_id'||$k =='install_district_id'){
                $v = Region::getRegionName($v);
            }elseif($k=='franchisee_operate_id' || $k == 'recommender_member_id_member' || $k == 'recommender_member_id_agent'){
                $v = OfflineSignStoreExtend::getMemberInfoById($v,'gai_number');
            }elseif($k=='p_province_id' || $k=='p_city_id' || $k=='p_district_id'){
                $v = Region::getRegionName($v);
            }
            if($k == 'fci2'){
                $arr = array();
                OfflineSignStoreExtend::getParentCategory($v,$arr);
                if(count($arr) == 2){
                    $data['fci1'] = FranchiseeCategory::getFanchiseeCategoryNameFromCache($arr[1]);
                    $data['fci2'] = FranchiseeCategory::getFanchiseeCategoryNameFromCache($arr[0]);
                }elseif(count($arr) == 1){
                    $data['fci1'] = FranchiseeCategory::getFanchiseeCategoryNameFromCache($arr[0]);
                    $data['fci2'] = '';
                }
                $data['fci1'] = @iconv("utf-8", "GBK//IGNORE", $data['fci1']);
                $data['fci2'] = @iconv("utf-8", "GBK//IGNORE", $data['fci2']);
                unset($arr);
            }else{
                if($v == '未知') $v = '';
                $data[$k]=@iconv("utf-8", "GBK//IGNORE", $v);
            }
        }
        return true;
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
}
