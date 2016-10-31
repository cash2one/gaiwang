<?php

/**
 * 企业信息控制器
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class EnterpriseController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 不受权限控制的动作
     * @return string
     * @author jianlin.lin
     */
    public function allowedActions() {
        return 'getEnterprise, getEnterpriseName,storeStatistical,update2';
    }

    /**
     * 查看电子版详情
     * Enter description here ...
     */
    public function actionView($id) {
        $model = Enterprise::model()->findByPk($id);
        $enterpriseData = $model->enterpriseData;
        $store_cri = new CDbCriteria();
        $store_cri->addCondition("member_id=" . $model->member->id);
        $store = Store::model()->find($store_cri);
        $cat_cri = new CDbCriteria();
        $cat_cri->select = 'name';
        $cat_cri->addCondition("id=" . $store->category_id);
        $cat = Category::model()->find($cat_cri);
        $bankAccount = BankAccount::model()->findByAttributes(array('member_id' => $model->member->id));

        $log_cri = new CDbCriteria();
        $log_cri->order = 'id DESC';
        $id = $id * 1;
        $log_cri->addCondition("enterprise_id={$id}");
        $log = EnterpriseLog::model()->find($log_cri);

        $this->render('view', array(
            'model' => $model,
            'enterpriseData' => $enterpriseData,
            'cat' => $cat,
            'bankAccount' => $bankAccount,
            'log' => $log,
            'store' => $store,
        ));
    }

    /**
     * 添加企业会员
     */
    public function actionCreate() {
        $this->breadcrumbs = array(Yii::t('member', '会员管理 '), Yii::t('member', '添加企业会员'));
        $model = new Member('create_enterprise');
        $infoModel = new Enterprise('create');
        $enterpriseData = new EnterpriseData('insert');
        $model->is_enterprise = $model::ENTERPRISE_YES;
        $infoModel->flag = Enterprise::FLAG_OFFLINE;

        if (isset($_POST['ajax']) && $_POST['ajax'] == 'member-form') {
            $validate = json_decode(CActiveForm::validate($model), true);
            $validate2 = json_decode(CActiveForm::validate($enterpriseData), true);
            $validate3 = json_decode(CActiveForm::validate($infoModel), true);
            $validateAll = array_merge($validate, $validate2, $validate3);
            echo json_encode($validateAll);
            Yii::app()->end();
        }
        if (isset($_POST['Member'])) {
            $model->attributes = $this->getPost('Member');
            $password = mt_rand(100000, 999999);
            $model->password = $password;
            $model->is_internal = $model::INTERNAL;

            $trans = $model->dbConnection->beginTransaction();
            //如果是主账户，则将该手机账户设为非主账户
            if ($model->is_master_account == $model::IS_MASTER_ACCOUNT) {
                Member::model()->updateAll(array('is_master_account' => Member::NO_MASTER_ACCOUNT), "mobile='{$model->mobile}'");
            }
            try {

                ////添加商家信息
                $infoModel->attributes = $this->getPost('Enterprise');
                $enterpriseData->attributes = $this->getPost('EnterpriseData');
                $infoModel->mobile = $model->mobile;

                if (!$infoModel->save()) {
                    throw new Exception('create enterprise error');
                }
                $model->enterprise_id = $infoModel->id;
                if (!$model->save()) {
                    throw new Exception('create member error');
                }
                $enterpriseData->enterprise_id = $infoModel->id;
                if (!$enterpriseData->save()) {
                    throw new Exception('create enterpriseData error');
                }
                //发送短信
                $smsConfig = $this->getConfig('smsmodel');
                $tmpId = $this->getConfig('smsmodel','addMemberContentId');
                $msg = strtr($smsConfig['addMemberContent'], array(
                    '{0}' => '企业会员',
                    '{1}' => $model->username,
                    '{2}' => $model->gai_number,
                    '{3}' => $password,
                ));
                $msg = Yii::t('member', $msg);
                $datas = array('企业会员', $model->username, $model->gai_number, $password);
                SmsLog::addSmsLog($model->mobile, $msg,$model->id, SmsLog::TYPE_OTHER,null,true, $datas, $tmpId);
                //写短信记录

                @SystemLog::record($this->getUser()->name . "添加企业会员：" . $model->username);
                $this->setFlash('success', Yii::t('member', '添加企业会员成功'));
                $trans->commit();
//                $this->refresh();
                $this->redirect(array('member/list'));
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('member', '添加企业会员失败') . $e->getMessage());
            }
        }

        $this->render('create', array(
            'model' => $model,
            'infoModel' => $infoModel,
            'enterpriseData' => $enterpriseData,
        ));
    }

    /**
     * 修改企业会员，线下，无网签
     *
     * @param int $id
     * @throws Exception
     */
    public function actionUpdate($id) {
        /** @var Enterprise $model */
        $model = Enterprise::model()->findByPk($id);
        if (!$model) {

            $model = new Enterprise('create');
            $member = Member::model()->findByPk($id);
        } else {
            //如果是线上，跳转
            if ($model->flag == Enterprise::FLAG_ONLINE)
                $this->redirect(array('enterprise/update2', 'id' => $id));
            $member = $model->member;
        }

        $member->is_enterprise = Member::ENTERPRISE_YES;
        $member->scenario = 'update_enterprise';
        $model->scenario = 'update';
        /** @var EnterpriseData $enterpriseData */
        if (!($enterpriseData = $model->enterpriseData)) {
            $enterpriseData = new EnterpriseData();
            $enterpriseData->enterprise_id = $model->id;
        }

        if (isset($_POST['ajax']) && $_POST['ajax'] == 'member-form') {
            $validate = json_decode(CActiveForm::validate($model), true);
            $validate2 = json_decode(CActiveForm::validate($enterpriseData), true);
            $validate3 = json_decode(CActiveForm::validate($member), true);
            $validateAll = array_merge($validate, $validate2, $validate3);
            echo json_encode($validateAll);
            Yii::app()->end();
        }
        if (isset($_POST['Enterprise'])) {
            $trans = Yii::app()->db->beginTransaction();
            try {

                $model->attributes = $this->getPost('Enterprise');
                $member->attributes = $this->getPost('Member');
                $enterpriseData->attributes = $this->getPost('EnterpriseData');
                $member->email = $model->email;
                if (!$member->save()) {
                    throw new Exception('update member errror');
                }
                if (!$enterpriseData->save()) {
                    throw new Exception('update enterpriseData error');
                }

                if ($model->save()) {
                    @SystemLog::record(Yii::app()->user->name . "修改企业信息：{$model->name}" . ' 成功（id->' . $model->id . '）');
                    $trans->commit();
                    $this->setFlash('success', Yii::t('enterprise', '修改企业信息成功'));
//                    $this->refresh();
                    $this->redirect(array('member/list'));
                } else {
                    throw new Exception('update model error');
                }
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('member', '修改企业信息失败') . $e->getMessage());
            }
        }

        $this->render('update', array(
            'model' => $model,
            'member' => $member,
            'enterpriseData' => $enterpriseData,
        ));
    }

    /**
     * 修改企业会员，线上，有网签
     *
     * @param int $id
     * @throws Exception
     */
    public function actionUpdate2($id) {
        /** @var Enterprise $model */
        $model = $this->loadModel($id);
        $member = $model->member;
        $member->is_enterprise = Member::ENTERPRISE_YES;
        $member->scenario = 'update_enterprise';
        $model->scenario = 'update';
        /** @var EnterpriseData $enterpriseData */
        $enterpriseData = $model->enterpriseData;
        if (!$enterpriseData)
            $enterpriseData = new EnterpriseData();
        $store = Store::model()->findByAttributes(array('member_id' => $member->id));
        if (!$store)
            $store = new Store();
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'member-form') {
            $validate = json_decode(CActiveForm::validate($model), true);
            $validate2 = json_decode(CActiveForm::validate($enterpriseData), true);
            $validate3 = json_decode(CActiveForm::validate($member), true);
            $validateAll = array_merge($validate, $validate2, $validate3);
            echo json_encode($validateAll);
            Yii::app()->end();
        }
        if (isset($_POST['Enterprise'])) {
            $trans = Yii::app()->db->beginTransaction();
            try {

                $model->attributes = $this->getPost('Enterprise');
                $member->attributes = $this->getPost('Member');
                $enterpriseData->attributes = $this->getPost('EnterpriseData');
                $store->attributes = $this->getPost('Store');
                $enterpriseData->license_start_time = strtotime($enterpriseData->license_start_time);
                $enterpriseData->license_end_time = strtotime($enterpriseData->license_end_time);
                if (empty($store->mobile)) {
                    $store->mobile = $member->mobile;
                }
                if (!$store->save()) {
                    throw new Exception('update store error');
                }

                if (!$member->save()) {
                    throw new Exception('update member error');
                }
                if (!$enterpriseData->save()) {
                    throw new Exception('update enterpriseData error');
                }

                if ($model->save()) {
                    @SystemLog::record(Yii::app()->user->name . "修改企业信息：{$model->name}" . ' 成功（id->' . $model->id . '）');
                    $trans->commit();
                    $this->setFlash('success', Yii::t('enterprise', '修改企业信息成功'));
//                    $this->refresh();
                    $this->redirect(array('member/list'));
                } else {
                    throw new Exception('update model error');
                }
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('member', '修改企业信息失败') . $e->getMessage());
            }
        }

        $this->render('update2', array(
            'enterprise' => $model,
            'member' => $member,
            'enterpriseData' => $enterpriseData,
            'store' => $store,
        ));
    }

    public function actionAdmin() {
        $this->redirect(array('finishAdmin'));

        return;

        $model = new Enterprise('search');
        $model->unsetAttributes();
        if (isset($_GET['Enterprise']))
            $model->attributes = $this->getParam('Enterprise');

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * 已完成审核列表
     * Enter description here ...
     */
    public function actionFinishAdmin() {
        $model = new Enterprise('search');
        $model->unsetAttributes();
        if (isset($_GET['Enterprise']))
            $model->attributes = $this->getParam('Enterprise');


        $this->render('finishadmin', array(
            'model' => $model,
        ));
    }

    /**
     * 电子版审核列表  招商
     * Enter description here ...
     */
    public function actionDzbAdminZhaoshang() {
        $model = new Enterprise('search');
        $model->unsetAttributes();
        if (isset($_GET['Enterprise']))
            $model->attributes = $this->getParam('Enterprise');

        $this->render('dzb', array(
            'model' => $model,
            'role' => Enterprise::AUDITING_ROLE_ZHAOSHANG,
        ));
    }

    /**
     * 电子版审核列表  法务
     * Enter description here ...
     */
    public function actionDzbAdminFawu() {
        $model = new Enterprise('search');
        $model->unsetAttributes();
        if (isset($_GET['Enterprise']))
            $model->attributes = $this->getParam('Enterprise');

        $this->render('dzb', array(
            'model' => $model,
            'role' => Enterprise::AUDITING_ROLE_FAWU,
        ));
    }

    /**
     * 纸质版审核列表  招商
     * Enter description here ...
     */
    public function actionZzbAdminZhaoshang() {
        $model = new Enterprise('search');
        $model->unsetAttributes();
        if (isset($_GET['Enterprise']))
            $model->attributes = $this->getParam('Enterprise');

        $this->render('zzb', array(
            'model' => $model,
            'role' => Enterprise::AUDITING_ROLE_ZHAOSHANG,
        ));
    }

    /**
     * 纸质版审核列表  法务
     * Enter description here ...
     */
    public function actionZzbAdminFawu() {
        $model = new Enterprise('search');
        $model->unsetAttributes();
        if (isset($_GET['Enterprise']))
            $model->attributes = $this->getParam('Enterprise');

        $this->render('zzb', array(
            'model' => $model,
            'role' => Enterprise::AUDITING_ROLE_FAWU,
        ));
    }

    /**
     * 审核  电子版
     * Enter description here ...
     */
    private function _auditingDzb($id, $role = '') {
        $model = Enterprise::model()->findByPk($id);

        $auditing = $this->getPost('status');
        $auditing = $auditing * 1;
        $store = Store::model()->findByAttributes(array('member_id' => $model->member->id));
        if (!empty($auditing)) {
            $trans = Yii::app()->db->beginTransaction();

            try {
                if ($auditing != EnterpriseLog::STATUS_PASS) {
                    if (empty($_POST['content']))
                        throw new CHttpException(400, '请填写审核不通过原因');
                    $step2_log = EnterpriseLog::model()->findByPk($model->last_log_id);
                    $step2_log->status = $auditing;
                    $content = $role == Enterprise::AUDITING_ROLE_ZHAOSHANG ? '资质电子档未通过招商专员审核' : '资质电子档未通过法务专员审核';
                    $step2_log->content = $content . '<hr/>' . $this->getPost('content');
                    $step2_log->auditor = $this->getUser()->name;
                    $step2_log->error_field = $this->getPost('errorField');
                    $step2_log->save(false);
                    if ($role == Enterprise::AUDITING_ROLE_ZHAOSHANG) {
                        $model = Enterprise::model()->findByPk($id);
                        $data = Store::model()->findByAttributes(array('member_id' => $model->member->id));

                        $data->mode = Store::MODE_NOT;
                        $data->save(false);
                    }
                }
                //修改是否收费
                if ($role == Enterprise::AUDITING_ROLE_ZHAOSHANG && $store->mode != $this->getPost('StoreMode') && $auditing == EnterpriseLog::STATUS_PASS) {
                    $store->mode = $this->getPost('StoreMode');
                    if (!$store->save()) {
                        throw new Exception('update store error');
                    }
                }
                //招商逻辑
                if ($role == Enterprise::AUDITING_ROLE_ZHAOSHANG && $auditing == EnterpriseLog::STATUS_PASS) {
                    //保存当前记录
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_PASS;
                    $ent_log->progress = EnterpriseLog::PROCESS_CHECK_INFO_ZHAOSHANG_OK;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time();
                    $ent_log->save(false);


                    //保存下一步记录
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_NO;
                    $ent_log->progress = EnterpriseLog::PROCESS_CHECK_INFO_FAWU;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time() + 1;
                    $ent_log->save(false);


                    $model->last_log_id = Yii::app()->db->lastInsertID;
                    $model->save(false);
                }
                /**
                 * 法务审核不通过，返回招商审核电子版
                 */
                if ($role == Enterprise::AUDITING_ROLE_FAWU && $auditing == EnterpriseLog::STATUS_NOT_PASS) {
                    //保存当前记录
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_NO;
                    $ent_log->progress = EnterpriseLog::PROCESS_CHECK_INFO_ZHAOSHANG;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time();
                    $ent_log->save(false);

                    $model->last_log_id = Yii::app()->db->lastInsertID;
                    $model->save(false);
                }

                //法务逻辑   如果通过则插入下一步记录    审核纸质合同资质
                if ($role == Enterprise::AUDITING_ROLE_FAWU && $auditing == EnterpriseLog::STATUS_PASS) {
                    //保存当前记录
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_PASS;
                    $ent_log->progress = EnterpriseLog::PROCESS_CHECK_INFO_FAWU_OK;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress) . '<hr />温馨提示：您可在卖家平台创建商品或装修店铺等操作。
';
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time();
                    $ent_log->save(false);

                    //下一步  招商纸质
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_NO;
                    $ent_log->progress = EnterpriseLog::PROCESS_CHECK_PAPER_ZHAOSHANG;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress) . '&nbsp;&nbsp;打印资质<hr/>温馨提示：请尽快打印您已通过审核的资质电子档合同并加盖相关盖章，邮寄回盖网招商专员，<strong>超过30日未完成纸质资质合同审核的商家有可能会受到关店处理</strong>。';
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time();
                    $rs2 = $ent_log->save(false);
                    //修改enterprise审核状态
                    $model->last_log_id = Yii::app()->db->lastInsertID;
                    $model->auditing = Enterprise::AUDITING_YES;
                    $model->save(false);
                    /**
                     *
                     * gw_store update_time 记录当前审核电子版通过时间,自动开店
                     *
                     * */
                    $memberId = $model->member->id;
                    Yii::app()->db->createCommand()->update('gw_store', array('update_time' => time()), 'member_id=' . $memberId);
                }

                @SystemLog::record(Yii::app()->user->name . "审核网签资质电子版：{$model->name}" . ' ' . $ent_log->progress . ' ');
                $this->setFlash('success', Yii::t('advert', '审核成功'));
                $trans->commit();


                $route = $role == Enterprise::AUDITING_ROLE_ZHAOSHANG ? array('dzbAdminZhaoshang') : array('dzbAdminFawu');
                $this->redirect($route);
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('memberHome', '审核失败!'));
            }
        }



        $cat_cri = new CDbCriteria();
        $cat_cri->select = 'id,name';
        $cat_cri->addCondition("id=" . $store->category_id);
        $cat = Category::model()->find($cat_cri);
        $bankAccount = BankAccount::model()->findByAttributes(array('member_id' => $model->member->id));
        $this->render('auditingdzb', array(
            'model' => $model,
            'cat' => $cat,
            'bankAccount' => $bankAccount,
            'store' => $store,
            'role' => $role,
        ));
    }

    /**
     * 审核  电子版
     * Enter description here ...
     */
    public function actionAuditingDzb($id) {
        $this->_auditingDzb($id);
    }

    /**
     * 审核  电子版  招商
     * Enter description here ...
     */
    public function actionAuditingDzbZhaoshang($id) {
        $this->_auditingDzb($id, Enterprise::AUDITING_ROLE_ZHAOSHANG);
    }

    /**
     * 审核  电子版   法务
     * Enter description here ...
     */
    public function actionAuditingDzbFawu($id) {
        $this->_auditingDzb($id, Enterprise::AUDITING_ROLE_FAWU);
    }

    /**
     * 审核 网签  纸质版
     * Enter description here ...
     */
    private function _auditingZzb($id, $role = '') {
        /** @var Enterprise $model */
        $model = Enterprise::model()->findByPk($id);
        $store = Store::model()->findByAttributes(array('member_id' => $model->member->id));

        $auditing = $this->getPost('status');

        $auditing = $auditing * 1;
        if (!empty($auditing)) {
            $trans = Yii::app()->db->beginTransaction();

            try {
                if ($auditing != EnterpriseLog::STATUS_PASS) {
                    $step2_log = EnterpriseLog::model()->findByPk($model->last_log_id);
//                    Tool::p($step2_log);exit;
                    $step2_log->status = $auditing;
                    $content = $role == Enterprise::AUDITING_ROLE_ZHAOSHANG ? '资质纸质版未通过招商专员审核' : '资质纸质版未通过法务专员审核';
                    $step2_log->content = $content . '<hr/>' . $this->getPost('content');
                    $step2_log->auditor = $this->getUser()->name;
                    $step2_log->error_field = $this->getPost('errorField');
                    $step2_log->save(false);
                }

                //招商逻辑
                if ($role == Enterprise::AUDITING_ROLE_ZHAOSHANG && $auditing == EnterpriseLog::STATUS_PASS) {
                    //保存当前记录
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_PASS;
                    $ent_log->progress = EnterpriseLog::PROCESS_CHECK_PAPER_ZHAOSHANG_OK;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time();
                    $ent_log->save(false);


                    //保存下一步记录  法务审核纸质版
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_NO;
                    $ent_log->progress = EnterpriseLog::PROCESS_CHECK_PAPER_FAWU;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time() + 1;
                    $ent_log->save(false);


                    $model->last_log_id = Yii::app()->db->lastInsertID;
                    $model->save(false);
                }
                /**
                 * 招商审核不通过，返回法务审核电子版
                 */
                if ($role == Enterprise::AUDITING_ROLE_ZHAOSHANG && $auditing == EnterpriseLog::STATUS_NOT_PASS) {
                    //保存当前记录
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_NO;
                    $ent_log->progress = EnterpriseLog::PROCESS_CHECK_INFO_FAWU;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time();
                    $ent_log->save(false);

                    $model->last_log_id = Yii::app()->db->lastInsertID;
                    $model->save(false);
                }
                /**
                 * 法务审核不通过，返回招商审核纸质版
                 */
                if ($role == Enterprise::AUDITING_ROLE_FAWU && $auditing == EnterpriseLog::STATUS_NOT_PASS) {
                    //保存当前记录
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_NO;
                    $ent_log->progress = EnterpriseLog::PROCESS_CHECK_PAPER_ZHAOSHANG;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time();
                    $ent_log->save(false);

                    $model->last_log_id = Yii::app()->db->lastInsertID;
                    $model->save(false);
                }
                //法务逻辑   如果通过则插入下一步记录
                if ($role == Enterprise::AUDITING_ROLE_FAWU && $auditing == EnterpriseLog::STATUS_PASS) {
                    //保存当前记录
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_PASS;
                    $ent_log->progress = EnterpriseLog::PROCESS_CHECK_PAPER_FAWU_OK;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time();
                    $ent_log->save(false);

                    //下一步  最终完成
                    $ent_log = new EnterpriseLog();
                    $ent_log->status = EnterpriseLog::STATUS_PASS;
                    $ent_log->progress = EnterpriseLog::PROCESS_LAST_OK;
                    $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                    $ent_log->auditor = $this->getUser()->name;
                    $ent_log->enterprise_id = $id;
                    $ent_log->create_time = time();
                    $rs2 = $ent_log->save(false);


                    $model->last_log_id = Yii::app()->db->lastInsertID;
                    $model->save(false);

                    //gw_store 状态修改为审核通过
                    $memberId = $model->member->id;
                    Yii::app()->db->createCommand()->update('gw_store', array('status' => Store::STATUS_PASS), 'member_id=' . $memberId);
                }


                @SystemLog::record(Yii::app()->user->name . "审核网签纸质版：{$model->name}" . ' ' . $ent_log->progress . ' ');
                $this->setFlash('success', Yii::t('advert', '审核成功'));
                $trans->commit();

                //审核通过，发送邮件通知用户开店成功
                if ($role == Enterprise::AUDITING_ROLE_FAWU && $auditing == EnterpriseLog::STATUS_PASS && !empty($store->email)) {
                    $subject = Tool::getConfig('emailmodel', 'kdtheme');
                    $message = Tool::getConfig('emailmodel', 'kdcontent');
                    $content = strtr($message, array(
                        '{0}' => $model->member->gai_number,
                        '{1}' => $store->name,
                    ));
                    //邮件模板参数,使用闪达邮件代发商
                    $value = array(
                        '%name%' => array($model->member->gai_number),
                        '%store%' => array($store->name)
                    );
                    //保存日志并发送邮件
                    EmailLog::addEmailLog($store->email, $subject, $content, $value, 'spkd_template', EmailLog::TEMPLATE_MAIL, $type = EmailLog::EMAIL_SHOP);
                }

                $route = $role == Enterprise::AUDITING_ROLE_ZHAOSHANG ? array('zzbAdminZhaoshang') : array('zzbAdminFawu');
                $this->redirect($route);
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('memberHome', '审核失败!'));
            }
        }


        $cat_cri = new CDbCriteria();
        $cat_cri->select = 'name';
        $cat_cri->addCondition("id=" . $store->category_id);
        $cat = Category::model()->find($cat_cri);

        $this->render('auditingzzb', array(
            'model' => $model,
            'cat' => $cat,
            'store' => $store,
            'role' => $role,
        ));
    }

    /**
     * 审核  网签  纸质版
     * Enter description here ...
     */
    public function actionAuditingZzb($id) {
        $this->_auditingZzb($id);
    }

    /**
     * 审核  网签  纸质版  招商
     * Enter description here ...
     */
    public function actionAuditingZzbZhaoshang($id) {
        $this->_auditingZzb($id, Enterprise::AUDITING_ROLE_ZHAOSHANG);
    }

    /**
     * 审核  网签  纸质版 法务
     * Enter description here ...
     */
    public function actionAuditingZzbFawu($id) {
        $this->_auditingZzb($id, Enterprise::AUDITING_ROLE_FAWU);
    }

    /**
     * 开店管理列表
     * Enter description here ...
     */
    public function actionStoreAdmin() {
        $model = new Enterprise('search');
        $model->unsetAttributes();
        if (isset($_GET['Enterprise']))
            $model->attributes = $this->getParam('Enterprise');

        $this->render('storeadmin', array(
            'model' => $model,
        ));
    }

    /**
     * 开店
     * @param $id
     * @throws CHttpException
     */
    public function actionStoreOpen($id) {
        $sql = 'SELECT
                    s.id,s.name,el.progress ,m.gai_number ,s.mobile,s.email
                FROM
                    gw_enterprise AS t
                LEFT JOIN gw_member AS m ON m.enterprise_id = t.id
                LEFT JOIN gw_store AS s ON m.id = s.member_id
                LEFT JOIN gw_enterprise_log as el ON el.id=t.last_log_id
                WHERE
                    t.id =:id';
        $db = Yii::app()->db;
        $data = $db->createCommand($sql)->bindValue(':id', $id)->queryRow();
//        var_dvar_dump('<pre>',$data);die;
        if ($data) {

            //如果已经通过纸质审核，店铺审核状态是审核通过，否则是试用中
            $status = $data['progress'] == EnterpriseLog::PROCESS_LAST_OK ? Store::STATUS_PASS : Store::STATUS_ON_TRIAL;
            //保存当前记录
            $trans = $db->beginTransaction();
            try {
                $sql = 'UPDATE gw_store SET status=:status WHERE id=:id';
                $db->createCommand($sql)->bindValues(array(':status' => $status, ':id' => $data['id']))->execute();
                $ent_log = new EnterpriseLog();
                $ent_log->status = EnterpriseLog::STATUS_PASS;
                $ent_log->progress = EnterpriseLog::PROCESS_OPEN_STORE_OK;
                $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                $ent_log->auditor = $this->getUser()->name;
                $ent_log->enterprise_id = $id;
                $ent_log->create_time = time();
                $ent_log->save(false);
                $trans->commit();
                //开店成功发送短信
                $smsTemp = Tool::getConfig('smsmodel', 'theShopSucc');
                $content = strtr($smsTemp, array(
                    '{0}' => $data['gai_number'],
                    '{1}' => $data['name'],
                ));
                $datas = array($data['gai_number'],$data['name']);
                $tmpId = $this->getConfig('smsmodel','theShopSuccId');
                SmsLog::addSmsLog($data['mobile'], $content,0, SmsLog::TYPE_OTHER,null,true, $datas, $tmpId);
                if ($data['email']) {
                    $subject = Tool::getConfig('emailmodel', 'kdtheme');
                    $message = Tool::getConfig('emailmodel', 'kdcontent');
                    $content = strtr($message, array(
                        '{0}' => $data['gai_number'],
                        '{1}' => $data['name'],
                    ));
                    //邮件模板参数,使用闪达邮件代发商
                    $value = array(
                        '%name%' => array($data['gai_number']),
                        '%store%' => array($data['name'])
                    );
                    //开店成功发送邮件
                    EmailLog::addEmailLog($data['email'], $subject, $content, $value, 'spkd_template', EmailLog::TEMPLATE_MAIL, $type = EmailLog::EMAIL_SHOP);
//                    EmailLog::addEmailLog($data['email'], $subject, $content, $type = EmailLog::EMAIL_SHOP);
                }
                $this->setFlash('success', Yii::t('enterprise', '开店成功'));
//                $data['mobible'];
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('enterprise', '开店失败'));
            }
            @SystemLog::record(Yii::app()->user->name . '开店：' . $data['name']);
            echo '<script>history.back();</script>';
        } else {
            throw new CHttpException(404);
        }
    }

    /**
     * 关店
     * @param $id
     * @throws CHttpException
     */
    public function actionStoreClose($id) {
        $sql = 'SELECT
                    s.id
                FROM
                    gw_enterprise AS t
                LEFT JOIN gw_member AS m ON m.enterprise_id = t.id
                LEFT JOIN gw_store AS s ON m.id = s.member_id
                WHERE
                    t.id =:id';
        $db = Yii::app()->db;
        $data = $db->createCommand($sql)->bindValue(':id', $id)->queryRow();
        if ($data) {
            $trans = $db->beginTransaction();
            try {
                $sql = 'UPDATE gw_store SET status=:status WHERE id=:id';
                $db->createCommand($sql)->bindValues(array(':status' => Store::STATUS_CLOSE, ':id' => $data['id']))->execute();
                //保存当前记录
                $ent_log = new EnterpriseLog();
                $ent_log->status = EnterpriseLog::STATUS_NOT_PASS;
                $ent_log->progress = EnterpriseLog::PROCESS_CLOSE_STORE;
                $ent_log->content = EnterpriseLog::getProcess($ent_log->progress);
                $ent_log->auditor = $this->getUser()->name;
                $ent_log->enterprise_id = $id;
                $ent_log->create_time = time();
                $ent_log->save(false);
//                Enterprise::model()->updateByPk($id,array('last_log_id'=>$db->lastInsertID));
                //商品下架
                Goods::model()->updateAll(array('is_publish' => Goods::PUBLISH_NO), 'store_id=:id', array(':id' => $data['id']));
                $trans->commit();
                $this->setFlash('success', Yii::t('enterprise', '关店成功'));
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('enterprise', '关店失败'));
            }
            @SystemLog::record(Yii::app()->user->name . '关店：' . $data['name']);
            echo '<script>history.back();</script>';
        } else {
            throw new CHttpException(404);
        }
    }

    /**
     * 审核进度
     * Enter description here ...
     * @param unknown_type $id
     */
    public function actionProgress($id) {
        $enterpriseLog = EnterpriseLog::model()->findAllByAttributes(
                array('enterprise_id' => $id * 1), array('order' => 'create_time ASC'));

        $this->render('progress', array(
            'enterpriseLog' => $enterpriseLog,
        ));
    }

    /**
     * 获取商家信息
     */
    public function actionGetEnterprise() {
        $model = new Enterprise('getHotelEnterprise');
        $model->unsetAttributes();
        if (isset($_GET['Enterprise']))
            $model->attributes = $this->getParam('Enterprise');

        $this->render('getenterprise', array(
            'model' => $model,
        ));
    }

    /**
     * 获取商家名称
     * @param $id
     */
    public function actionGetEnterpriseName($id) {
        if ($this->isAjax()) {
            $data = Yii::app()->db->createCommand()
                    ->select('e.name,m.id as member_id')
                    ->from('{{enterprise}} e')
                    ->leftJoin('{{member}} m', 'e.id=m.enterprise_id')
                    ->where('e.id = :id', array(':id' => $id))
                    ->queryRow();

            if (!is_null($data)) {
                echo CJSON::encode($data);
                die();
            } else {
                echo CJSON::encode(null);
            }
        }
    }

    /**
     * 修改招商服务编号
     * @param $id
     * @throws CException
     */
    public function actionChangeServiceId($id) {
        /** @var Enterprise $model */
        $model = $this->loadModel($id);
        $this->performAjaxValidation($model);
        if (isset($_POST['Enterprise'])) {
            $model->attributes = $this->getPost('Enterprise');
            if ($model->save()) {
                echo '<script> var success = true; </script>';
            } else {
                $this->setFlash('error', '修改失败');
            }
            @SystemLog::record(Yii::app()->user->name . '招商服务编号：' . $model->service_id);
        }
        $this->render('changeServiceId', array('model' => $model));
    }

    /**
     * ajax 开店统计
     */
    public function actionStoreStatistical() {
        if ($this->isAjax()) {
            $msg = array();
            $publicSql = 'SELECT COUNT(*) FROM (SELECT t.id
                   FROM `gw_enterprise` `t` LEFT JOIN gw_enterprise_log AS el ON t.last_log_id=el.id
                   LEFT JOIN gw_member AS m ON m.enterprise_id=t.id
                   LEFT JOIN gw_store AS s ON m.id=s.member_id
                   LEFT JOIN gw_category AS cat ON s.category_id=cat.id WHERE el.progress>=5 {params} GROUP BY t.id ) sq';
            //总店铺
            $sql = str_replace('{params}', '', $publicSql);
            $msg['total'] = Yii::app()->db->createCommand($sql)->queryScalar();

            //等待
            $sql = str_replace('{params}', 'and s.status=' . Store::STATUS_APPLYING, $publicSql);
            $msg['wait'] = Yii::app()->db->createCommand($sql)->queryScalar();
            //已经开店
            $sql = str_replace('{params}', 'and s.status=' . Store::STATUS_PASS, $publicSql);
            $msg['open'] = Yii::app()->db->createCommand($sql)->queryScalar();
            //已经关闭
            $sql = str_replace('{params}', 'and s.status=' . Store::STATUS_CLOSE, $publicSql);
            $msg['close'] = Yii::app()->db->createCommand($sql)->queryScalar();
            echo CJSON::encode($msg);
        }
    }

    /**
     * 网签后台添加备注功能
     * @param $id
     *  @author zhangshengjie
     */
    public function actionRemarts($id) {
        $model = new EnterpriseLog();
        $this->performAjaxValidation($model);
        if ($this->getParam('EnterpriseLog')) {
            $data = $this->getParam('EnterpriseLog');
            $model->status = 0;
            $model->content = $data['content'];
            $model->auditor = $this->getUser()->name;
            $model->enterprise_id = $id;
            $model->create_time = time();
            $model->is_remarts = EnterpriseLog::IS_REMARTS;
            if ($model->save()) {
//                  $this->setFlash('success',  '添加成功！');
                //跳转
//                    $this->turnback();
                echo"<script>alert('添加成功')</script>";
                echo '<script> var success = true; </script>';
            } else {
                $this->setFlash('error', '添加失败');
            }
        }

        $this->render('remarts', array('model' => $model));
    }

    /**
     * 网签后台添加一键返回招商审核资质电子档功能
     * @param $id
     *  @author zhangshengjie
     */
    public function actionKeyReturn($id, $role) {
        //保存当前记录
        $enterpriseLog = EnterpriseLog::model()->findAllByAttributes(array('enterprise_id' => $id * 1, 'is_key_return' => 1));
        $model = Enterprise::model()->findByPk($id);
        $store = Store::model()->findByAttributes(array('member_id' => $model->member->id));
        $trans = Yii::app()->db->beginTransaction();
        try {
            EnterpriseLog::model()->updateAll(array('is_key_return' => EnterpriseLog::NOT_KEY_RETURN), 'enterprise_id =' . $id . ' and is_key_return=' . EnterpriseLog::IS_KEY_RETURN);
            $role = $role == Enterprise::AUDITING_ROLE_ZHAOSHANG ? '招商专员' : '法务专员';
            $ent_log = new EnterpriseLog();
            $ent_log->status = EnterpriseLog::STATUS_NO;
            $ent_log->progress = EnterpriseLog::PROCESS_CHECK_INFO_ZHAOSHANG;
            $ent_log->content = EnterpriseLog::getProcess($ent_log->progress) . '(备注：' . $role . '已实施"一键返回"招商审核资质电子档的操作)';
            $ent_log->auditor = $this->getUser()->name;
            $ent_log->enterprise_id = $id;
            $ent_log->is_key_return = EnterpriseLog::IS_KEY_RETURN;
            $ent_log->create_time = time();
            $ent_log->save(false);
            $model->last_log_id = Yii::app()->db->lastInsertID;
            $model->save(false);
            $store->status = Store::STATUS_CLOSE;
            $store->save(false);
            $trans->commit();
            $this->redirect(array('finishAdmin'));
        } catch (Exception $e) {
            $trans->rollback();
            $this->setFlash('error', Yii::t('enterprise', '一键返回招商审核资质电子档失败'));
        }
    }

}

