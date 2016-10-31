<?php

/**
 * 会员控制器
 * 操作(列表、新增、删除、修改、重置密码)
 * @author zhenjun.xu<412530435@qq.com>
 */
class MemberController extends Controller {

    public function filters() {
        return array(
            'rights',
        );
    }

    /**
     * 不作权限控制的action
     * @return string
     */
    public function allowedActions() {
        return 'getUserName, getUser';
    }

    /**
     * 添加普通会员
     */
    public function actionCreate() {
        $this->breadcrumbs = array(Yii::t('member', '普通会员') => array('member/admin'), Yii::t('member', '创建'));
        $model = new Member('create');
        $this->performAjaxValidation($model);
        if (isset($_POST['Member'])) {
            $model->attributes = $this->getPost('Member');
            $password = mt_rand(100000, 999999);
            $model->password = $password;
            $model->birthday = empty($model->birthday) ? 0 : strtotime($model->birthday);
            if ($model->save()) {
                $smsConfig = $this->getConfig('smsmodel');
                $msg = strtr($smsConfig['addMemberContent'], array(
                    '{0}' => '普通会员',
                    '{1}' => $model->username,
                    '{2}' => $model->gai_number,
                    '{3}' => $password,
                ));
                $msg = Yii::t('member', $msg);
                $datas = array('普通会员', $model->username, $model->gai_number, $password);
                $tmpId = $smsConfig['addMemberContentId'];
                
                //同步数据到sku
                if (!empty($model['mobile'])) {
                	ApiSKU::updateInfo($model['gai_number']);
                }
                SmsLog::addSmsLog($model->mobile, $msg, $model->id, SmsLog::TYPE_OTHER,null,true,$datas,$tmpId);
                SystemLog::record($this->getUser()->name . "添加普通会员：" . $model->username);
                $this->setFlash('success', Yii::t('member', '添加普通会员成功'));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * 添加企业会员
     * @deprecated
     */
    public function actionEnterpriseCreate() {
        exit();
        $this->breadcrumbs = array(Yii::t('member', '会员管理 '), Yii::t('member', '添加企业会员'));
        $model = new Member('create');
        $infoModel = new Enterprise('create');
        $model->is_enterprise = $model::ENTERPRISE_YES;
        $store = new Store('enterpriseCreate');
        $this->performAjaxValidation($model);
        $this->performAjaxValidation($infoModel);
        if (isset($_POST['Member'])) {
            $model->attributes = $_POST['Member'];
            $password = mt_rand(100000, 999999);
            $model->password = $password;
            $model->is_internal = $model::INTERNAL;

            $store->attributes = $_POST['Store'];

            $trans = $model->dbConnection->beginTransaction();
            //如果是主账户，则将该手机账户设为非主账户
            if ($model->is_master_account == $model::IS_MASTER_ACCOUNT) {
                Member::model()->updateAll(array('is_master_account' => Member::NO_MASTER_ACCOUNT), "mobile='{$model->mobile}'");
            }
            try {

//                AccountInfo::bathCreate($model->id,$model->gai_number,$model->is_enterprise);
                ////添加商家信息
                $infoModel->attributes = $_POST['Enterprise'];
//                $infoModel->name = $model->username;
//                $infoModel->mobile = $model->mobile;
                $saveDir = 'enterprise/' . date('Y/n/j');
                $infoModel = UploadedFile::uploadFile($infoModel, 'license_photo', $saveDir, Yii::getPathOfAlias('att'));
                $infoModel = UploadedFile::uploadFile($infoModel, 'organization_image', $saveDir, Yii::getPathOfAlias('att'));
                $infoModel = UploadedFile::uploadFile($infoModel, 'tax_image', $saveDir, Yii::getPathOfAlias('att'));
                if ($infoModel->save()) {
                    UploadedFile::saveFile('license_photo', $infoModel->license_photo);
                    UploadedFile::saveFile('organization_image', $infoModel->organization_image);
                    UploadedFile::saveFile('tax_image', $infoModel->tax_image);
                } else {
                    throw new Exception('create enterprise error');
                }
                $model->enterprise_id = $infoModel->id;
                if (!$model->save()) {
                    throw new Exception('create member error');
                }

                //添加店铺信息
                $store->member_id = $model->id;
                if (!$store->save(false)) {
                    throw new Exception('create store error');
                }


                //发送短信
                $smsConfig = $this->getConfig('smsmodel');
                $msg = strtr($smsConfig['addMemberContent'], array(
                    '{0}' => '企业会员',
                    '{1}' => $model->username,
                    '{2}' => $model->gai_number,
                    '{3}' => $password,
                ));
                $msg = Yii::t('member', $msg);
                $datas = array('企业会员', $model->username, $model->gai_number, $password);
                $tmpId = $smsConfig['addMemberContentId'];
                SmsLog::addSmsLog($model->mobile, $msg, $model->id, SmsLog::TYPE_OTHER,null,true, $datas, $tmpId);
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

        $category = Category::getTopCategory();
        $this->render('enterprisecreate', array(
            'model' => $model,
            'infoModel' => $infoModel,
            'category' => $category,
            'store' => $store,
        ));
    }

    /**
     * 修改企业会员
     */
    public function actionEnterpriseUpdate($id) {
        /** @var Member $model */
        $model = $this->loadModel($id);
        $enterprise = Enterprise::model()->findByPk($model->enterprise_id);
        $store = Store::model()->findByAttributes(array('member_id' => $model->id));
        if (empty($store))
            $store = new Store('enterpriseCreate');
        if (!$enterprise)
            $enterprise = new Enterprise();
        $enterprise::$oldModelData = clone $enterprise;
        $model->scenario = 'enterpriseUpdate';
        $enterprise->scenario = 'enterpriseUpdate';
        $model->is_enterprise = $model::ENTERPRISE_YES;
        $this->performAjaxValidation($model);
        $this->performAjaxValidation($enterprise);
        $model->oldPassword = $model->password;
        if (isset($_POST['Member'])) {
            $model->attributes = Tool::filterPost($_POST['Member'], 'signins,gai_number,account_sign_in', true);
            $enterprise->attributes = Tool::filterPost($_POST['Enterprise'], 'cash', true);
            $model->email = $enterprise->email;
            $trans = $model->dbConnection->beginTransaction();
            //如果是主账户，则将该手机账户设为非主账户
            if ($model->is_master_account == $model::IS_MASTER_ACCOUNT) {
                Member::model()->updateAll(array('is_master_account' => Member::NO_MASTER_ACCOUNT), "mobile='{$model->mobile}'");
            }
            try {
                //修改商家信息
                $old_license_photo = $enterprise->license_photo;
                $old_organization_image = $enterprise->organization_image;
                $old_tax_image = $enterprise->tax_image;
                $enterprise->name = $model->username;
                $enterprise->mobile = $model->mobile;
                $saveDir = 'license_photo/' . date('Y/n/j');
                $enterprise = UploadedFile::uploadFile($enterprise, 'license_photo', $saveDir, Yii::getPathOfAlias('att'));
                $enterprise = UploadedFile::uploadFile($enterprise, 'organization_image', $saveDir, Yii::getPathOfAlias('att'));
                $enterprise = UploadedFile::uploadFile($enterprise, 'tax_image', $saveDir, Yii::getPathOfAlias('att'));
                if ($enterprise->save()) {
                    UploadedFile::saveFile('license_photo', $enterprise->license_photo, $old_license_photo, true);
                    UploadedFile::saveFile('organization_image', $enterprise->organization_image, $old_organization_image, true);
                    UploadedFile::saveFile('tax_image', $enterprise->tax_image, $old_tax_image, true);
                } else {
                    throw new Exception('update enterprise error ');
                }
                $model->enterprise_id = $enterprise->id;
                if (!$model->save())
                    throw new Exception('update member error ');

                $store->attributes = $_POST['Store'];
                $store->member_id = $model->id;
                if (!$store->save())
                    throw new Exception('update store error ');

                //同步数据到sku
                if (!empty($model['mobile'])) {
                	ApiSKU::updateInfo($model['gai_number']);
                }

                $trans->commit();
                @SystemLog::record($this->getUser()->name . "修改企业会员：" . $model->username);
                $this->setFlash('success', Yii::t('member', '修改企业会员成功'));
                $this->redirect(array($this->getParam('action')));
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('member', '修改企业会员失败') . $e->getMessage() . CHtml::errorSummary($model) . CHtml::errorSummary($enterprise));
            }
        }

        $category = Category::getTopCategory();
        $this->render('enterpriseupdate', array(
            'model' => $model,
            'infoModel' => $enterprise,
            'store' => $store,
            'category' => $category,
        ));
    }

    /**
     * 普通会员修改
     * @param int $id
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = 'update';
        $this->performAjaxValidation($model);
        if (isset($_POST['Member'])) {
            $model->attributes = Tool::filterPost($this->getPost('Member'), 'signins, gai_number', true);
            $model->birthday = empty($model->birthday) ? 0 : strtotime($model->birthday);
            if ($model->save()) {
            	
            	//同步数据到sku
            	if (!empty($model['mobile'])) {
            		ApiSKU::updateInfo($model['gai_number']);
            	}
            	
                SystemLog::record($this->getUser()->name . "修改普通会员：" . $model->username);
                $this->setFlash('success', Yii::t('member', '修改普通会员成功'));
                $this->redirect(array('member/admin'));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * 修改会员推荐人
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateRecommend($id) {
        /** @var Member $model */
        $model = $this->loadModel($id);
        $model->scenario = 'updateRecommend';
        $this->performAjaxValidation($model);

        if (isset($_POST['Member'])) {
            $model->attributes = Tool::filterPost($_POST['Member'], 'signins,gai_number', true);

            $model->referrals_time = time();

            if ($model->save()) {

                //保存记录
                $recommend_log = new RecommendLog();
                $recommend_log->member_id = $model->id;
                $recommend_log->parent_id = $model->referrals_id;
                $recommend_log->create_time = $model->referrals_time;
                $recommend_log->save();


                @SystemLog::record($this->getUser()->name . "修改会员" . $model->username . "（id：" . $model->id . "）的推荐人为" . $_POST['RefMemberUsername'] . "(id:" . $recommend_log->parent_id . ")");
                $this->setFlash('success', Yii::t('member', '修改会员推荐人成功'));
            } else {
                $this->setFlash('error', Yii::t('member', '修改会员推荐人失败') . CHtml::errorSummary($model));
            }
            if ($model->enterprise_id)
                $this->redirect(array('member/list'));
            else
                $this->redirect(array('member/admin'));
        }

        $this->render('updateRecommend', array(
            'model' => $model,
        ));
    }

    /**
     * 会员列表与新注册的企业会员的公共方法
     */
    private function _memberList() {
        $model = new Member('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Member']))
            $model->attributes = $_GET['Member'];

        $this->showExport = true;
        $this->exportAction = 'adminExport';

        $totalCount = $model->search()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'member/adminExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;


        $this->render('admin', array(
            'model' => $model,
            'exportPage' => $exportPage,
            'totalCount' => $totalCount,
        ));
    }

    /** @var int 审核状态 */
    public $auditing = null;

    /**
     * 普通会员列表
     */
    public function actionAdmin() {
        $this->breadcrumbs = array(Yii::t('member', '普通会员 ') => array('member/admin'), Yii::t('member', '列表'));
        $this->_memberList();
    }

    /**
     * 新注册的，未审核的企业会员
     */
    public function actionAuditing() {
        $this->breadcrumbs = array(Yii::t('member', '会员管理 '), Yii::t('member', '新注册的企业会员'));
        $this->auditing = Enterprise::AUDITING_NO;
        $this->_memberList();
    }

    /**
     * 会员列表导出
     */
    public function actionAdminExport() {
        $model = new Member('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Member']))
            $model->attributes = $_GET['Member'];


        @SystemLog::record($this->getUser()->name . "导出会员列表");

        $model->isExport = 1;
        $this->render('adminExport', array(
            'model' => $model,
        ));
    }

    /**
     * 获取会员搜索列表
     */
    public function actionGetUser() {
        $model = new Member('search');
        $model->unsetAttributes();


        //这里用模糊搜索
        if (isset($_GET['Member'])) {
            $model->searchKeyword = $_GET['Member']['searchKeyword'];
        }

        //加盟商条件 判断是否企业会员 @author LC
        $is_enterprise = $this->getQuery('isc');
        if ($is_enterprise == Member::ENTERPRISE_YES) {
        	//20160929 wyee 店铺推荐可以是普通会员
            //$model->is_enterprise = Member::ENTERPRISE_YES;
        }


        $this->render('getuser', array(
            'model' => $model,
        ));
    }

    /**
     * 获取会员名称 ajax 请求方式
     * @param type $id
     * @return json 
     */
    public function actionGetUserName($id) {
        if ($this->isAjax()) {
            $model = Member::model()->find('id = :id', array('id' => $id));
            if (!is_null($model))
                echo CJSON::encode($model->username);
            else
                echo CJSON::encode(null);
        }
    }

    /**
     * 重置密码
     * @param $id
     */
    public function actionResetPass($id) {
        /** @var Member $model */
        $model = $this->loadModel($id);
        $password = mt_rand(100000, 999999);
        //发送短信
        $smsConfig = $this->getConfig('smsmodel');
        $userType = $model->is_enterprise ? '企业会员' : '普通会员';
        $msg = strtr($smsConfig['resetPass'], array(
            '{0}' => $model->gai_number,
            '{1}' => $userType,
            '{2}' => $password,
        ));
        $datas = array($model->gai_number, $userType, $password);
        $tmpId = $smsConfig['resetPassId'];
        SmsLog::addSmsLog($model->mobile, $msg, $model->id, SmsLog::TYPE_OTHER,null,true, $datas, $tmpId);

        $model->password = $password;
        $model->scenario = 'updatePassword';
        if ($model->save(false)) {
            //同步修改密码到盖讯通
            if(defined('IS_STARTGXT') && IS_STARTGXT) {
                Member::getUpdatePassword($model->gai_number,$password,GXT_PASSWORD_KEY);
            }
            @SystemLog::record($this->getUser()->name . "重设会员密码：" . $id);
            $this->setFlash('success', '重设密码成功');
        } else {
            $this->setFlash('error', '重设密码失败');
        }
        echo '<script>history.back();</script>';
    }

    /**
     * 会员的角色列表
     * @param $id 会员id
     */
    public function actionMember2roleList($id) {
        $member = Member::model()->findByPk($id);
        $roles = MemberToRole::model()->findAllByAttributes(array('member_id' => $id));
        if (isset($_POST['ids'])) {
            foreach ($this->getPost('ids') as $v) {
                MemberToRole::model()->deleteByPk($v);
            }
            $this->refresh();
        }
        $this->render('member2rolelist', array('roles' => $roles, 'member' => $member));
    }

    /**
     * 添加会员角色
     * @param $id
     */
    public function actionAddRole($id) {
        $memberRoles = MemberRole::model()->findAll();
        if (isset($_POST['roleIds'])) {
            foreach ($_POST['roleIds'] as $v) {
                /** @var $roleModel  MemberRole */
                $roleModel = MemberRole::model()->findByPk($v);
                if (MemberToRole::model()->findByAttributes(array('member_role_id' => $v, 'member_id' => $id))) {
                    continue;
                }
                $member2Role = new MemberToRole();
                $member2Role->member_id = $id;
                $member2Role->member_role_id = $v;
                $member2Role->service_start_time = time();
                $member2Role->service_end_time = time() + $roleModel->deadline * 3600 * 24;
                $member2Role->save();
            }

            @SystemLog::record($this->getUser()->name . "添加会员角色：" . $id);

            echo '<script> var success = "True";</script>';
        }
        $this->render('addrole', array('memberRoles' => $memberRoles));
    }

    /**
     * 企业会员审核列表
     * @author hhb
     */
    public function actionEnterpriseMemberList() {
        $model = new Auditing();
        $model->unsetAttributes();  //清除属性
        if (isset($_GET['Auditing'])) {
            $model->attributes = $_GET['Auditing'];
        }

        $this->render('enterprisememberlist', array(
            'model' => $model,
        ));
    }

    /**
     * 企业会员审核列表查看单条记录信息(新增)
     * @author hhb
     */
    public function actionEnterprise() {
//    public function actionEnterpriseMemberAdd(){
        if ($_GET['type'] == 'add') {
            $model = Auditing::model()->findByPk($_GET['id']);
            $memberModel = new Member('enterpriseCreate');
            $enterpriseModel = new Enterprise('enterpriseCreate');

            $dataArr = CJSON::decode($model->apply_content);
            //    	Tool::p($dataArr);
            $memberModel->attributes = $dataArr['member'];
            $memberModel->apply_type = $model->apply_type;
            $memberModel->author_name = $model->author_name;
            $memberModel->author_type = $model->author_type;
            $memberModel->submit_time = $model->submit_time;
            $memberModel->audit_opinion = $model->audit_opinion;
            //    	Tool::pr($memberModel->attributes);

            $enterpriseModel->attributes = $dataArr['memberInfo'];
            $enterpriseModel->license_photo = $dataArr['memberInfo']['license_photo'];
            $enterpriseModel->mobile = $dataArr['member']['mobile'];
            //    	$enterpriseModel->service_start_time = $dataArr['memberInfo']['service_start_time'];
            //    	$enterpriseModel->service_end_time = $dataArr['memberInfo']['service_end_time'];
            $memberModel->referrals_id = $model->author_id;
            //    	Tool::pr($enterpriseModel->attributes);

            $this->performAjaxValidation($memberModel);
            $this->performAjaxValidation($enterpriseModel);
            //    	$enterpriseModel->validate();
            if (isset($_POST['Member'])) {  //如果页面提交了，根据提交的操作进行判断是通过还是不通过，如果通过，保存数据，同时添加企业会员数据到指定的表中
                if ($_POST['status'] == Auditing::STATUS_NOPASS) {
                    $model->status = Auditing::STATUS_NOPASS;
                    $model->audit_opinion = $_POST['Member']['audit_opinion'];
                    $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
                    $model->auditor_id = $this->getUser()->id;
                    $model->auditor_name = $this->getUser()->name;
                    $model->audit_time = time();
                    $model->save(false);
                    @SystemLog::record($this->getUser()->name . "企业会员编辑<<审核不通过>>：" . $model->apply_name);
                    $this->setFlash('success', Yii::t('member', '企业会员编辑<<审核不通过>>成功'));
                    $this->redirect(array('member/enterpriseMemberList'));
                } else {
                    //    			status,type_id,grade_id,is_master_account,referrals_id,gai_number,username,mobile
                    $memberModel->attributes = $_POST['Member'];
                    $memberModel->username = $_POST['Enterprise']['name'];
                    $member = MemberType::fileCache();
                    $memberModel->type_id = $member['defaultType'];
                    $memberModel->status = Member::STATUS_NORMAL;
                    $memberModel->is_enterprise = Member::ENTERPRISE_YES;
                    $memberModel->grade_id = 1;
                    $memberModel->referrals_id = $model->author_id;
                    //	    		$memberModel->gai_number = $model->author_name;
                    $memberModel->province_id = $_POST['Enterprise']['province_id'];
                    $memberModel->city_id = $_POST['Enterprise']['city_id'];
                    $memberModel->district_id = $_POST['Enterprise']['district_id'];
                    $memberModel->street = $_POST['Enterprise']['street'];
                    $memberModel->mobile = $_POST['Enterprise']['mobile'];
                    $memberModel->email = $_POST['Enterprise']['email'];
                    //	            $memberModel->password = $dataArr['member']['password'];
                    //	            $memberModel->is_internal = $memberModel::INTERNAL;
                    $trans = $memberModel->dbConnection->beginTransaction();
                    try {

                        ////添加商家信息
                        $enterpriseModel->attributes = $_POST['Enterprise'];
                        $enterpriseModel->service_start_time = strtotime($enterpriseModel->service_start_time);   //对于时间进行转换
                        $enterpriseModel->service_end_time = strtotime($enterpriseModel->service_end_time);

                        $enterpriseModel->license_photo = $_POST['Enterprise']['license_photo'];
                        $enterpriseModel->name = $memberModel->username;
                        if ($enterpriseModel->save(false)) {          //这里没有加入验证 是因为本来license_photo有值  但是就是验证说没有
                            //发送短信
                            $smsConfig = $this->getConfig('smsmodel');
                            $msg = str_replace('{0}', '企业会员', $smsConfig['addMemberContent']);
                            $msg = str_replace('{1}', $memberModel->username, $msg);
                            $msg = str_replace('{2}', $memberModel->gai_number, $msg);
                            $msg = Yii::t('home', str_replace('{3}', $dataArr['member']['password'], $msg));  //不适用$memberModel->password是因为$memberModel已经保存，密码已经加密
                            $datas = array('企业会员', $memberModel->username, $memberModel->gai_number, $dataArr['member']['password']);
                            $tmpId = $smsConfig['addMemberContentId'];
                            SmsLog::addSmsLog($memberModel->mobile, $msg, $memberModel->id, SmsLog::TYPE_OTHER, null,true,$datas, $tmpId);
                        } else {
                            throw new Exception('create enterprise error');
                        }
                        $memberModel->enterprise_id = $enterpriseModel->id;

                        if (!$memberModel->save()) {
                            throw new Exception('create member error');
                        }

                        @SystemLog::record($this->getUser()->name . "添加企业会员<<审核通过>>：" . $memberModel->username);

                        $model->status = Auditing::STATUS_PASS;
                        //	    			$model->audit_opinion = $_POST['Member']['audit_opinion'];
                        $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
                        $model->auditor_id = $this->getUser()->id;
                        $model->auditor_name = $this->getUser()->name;
                        $model->audit_time = time();
                        $model->save(false);

                        $trans->commit();
                        $this->setFlash('success', Yii::t('member', '添加企业会员<<审核通过>>成功'));
                        $this->redirect(array('member/enterpriseMemberList'));
                    } catch (Exception $e) {
                        $trans->rollback();
                        $this->setFlash('error', Yii::t('member', '添加企业会员失败') . $e->getMessage());
                    }
                }
            }

            $this->render('enterprisememberlook', array(
                'model' => $memberModel,
                'infoModel' => $enterpriseModel,
            ));
        } else {
            $model = Auditing::model()->findByPk($_GET['id']);
            $dataArr = CJSON::decode($model->apply_content);

            //    	Tool::pr($dataArr);

            $memberModel = Member::model()->findByPk($dataArr['member']['id']);
            $enterpriseModel = Enterprise::model()->findByPk($dataArr['memberInfo']['id']);

            $memberModel->attributes = $dataArr['member'];
            $memberModel->register_time = strtotime($dataArr['member']['register_time']);  //修改一下时间，防止验证不通过，因为验证时间长度为11位，没有发现注册时间有其它地方修改
            $memberModel->apply_type = $model->apply_type;
            $memberModel->author_name = $model->author_name;
            $memberModel->author_type = $model->author_type;
            $memberModel->submit_time = $model->submit_time;
            $memberModel->audit_opinion = $model->audit_opinion;

            $enterpriseModel->attributes = $dataArr['memberInfo'];
            $enterpriseModel->email = isset($dataArr['member']['email']) ? $dataArr['member']['email'] : "";
            $enterpriseModel->service_start_time = $dataArr['memberInfo']['service_start_time'];
            $enterpriseModel->service_end_time = $dataArr['memberInfo']['service_end_time'];

            $this->performAjaxValidation($memberModel);
            $this->performAjaxValidation($enterpriseModel);

            if (isset($_POST['Member'])) {  //如果页面提交了，根据提交的操作进行判断是通过还是不通过，如果通过，保存数据，同时添加企业会员数据到指定的表中
                if ($_POST['status'] == Auditing::STATUS_PASS) {
                    $isSaveMain = false;
                    foreach ($_POST['Member'] as $keyMain => $valMain) {
                        if ($memberModel->$keyMain != $valMain) {
                            $isSaveMain = true;
                            break;
                        }
                    }

                    $isSaveInfo = false;
                    foreach ($_POST['Enterprise'] as $keyInfo => $valInfo) {
                        if ($enterpriseModel->$keyInfo != $valInfo) {
                            $isSaveInfo = true;
                            break;
                        }
                    }
                    if ($isSaveMain) {
                        $memberModel->attributes = $_POST['Member'];
                        $memberModel->username = $_POST['Enterprise']['name'];

                        //下面这几个属性是基本信息和会员表都存在的，显示的时候是按照基本信息中显示的 所有需要重新赋值进行修改，免得不同
                        $memberModel->province_id = $_POST['Enterprise']['province_id'];
                        $memberModel->city_id = $_POST['Enterprise']['city_id'];
                        $memberModel->district_id = $_POST['Enterprise']['district_id'];
                        $memberModel->street = $_POST['Enterprise']['street'];
                        $memberModel->mobile = $_POST['Enterprise']['mobile'];
                        $memberModel->email = isset($_POST['Enterprise']['email']) ? $_POST['Enterprise']['email'] : "";
                        $memberModel->save();
                    }
                    if ($isSaveInfo) {
                        $enterpriseModel->attributes = $_POST['Enterprise'];
                        $enterpriseModel->service_start_time = strtotime($_POST['Enterprise']['service_start_time']);   //时间赋值不成功，需要单独赋值
                        $enterpriseModel->service_end_time = strtotime($_POST['Enterprise']['service_end_time']);
                        $enterpriseModel->save();
                    }

                    if ($isSaveInfo || $isSaveMain) {
                        //将修改后的数据重新赋值
                        $dataArr['member']['is_master_account'] = $_POST['Member']['is_master_account'];
                        $dataArr['memberInfo']['name'] = $_POST['Enterprise']['name'];
                        $dataArr['memberInfo']['short_name'] = $_POST['Enterprise']['short_name'];
                        $dataArr['memberInfo']['category_id'] = $_POST['Enterprise']['category_id'];
                        $dataArr['memberInfo']['license'] = $_POST['Enterprise']['license'];
                        $dataArr['memberInfo']['license_photo'] = $_POST['Enterprise']['license_photo'];
                        $dataArr['memberInfo']['province_id'] = $_POST['Enterprise']['province_id'];
                        $dataArr['memberInfo']['city_id'] = $_POST['Enterprise']['city_id'];
                        $dataArr['memberInfo']['district_id'] = $_POST['Enterprise']['district_id'];
                        $dataArr['memberInfo']['street'] = $_POST['Enterprise']['street'];
                        $dataArr['memberInfo']['link_man'] = $_POST['Enterprise']['link_man'];
                        $dataArr['memberInfo']['department'] = $_POST['Enterprise']['department'];
                        $dataArr['memberInfo']['email'] = isset($_POST['Enterprise']['email']) ? $_POST['Enterprise']['email'] : "";
                        $dataArr['memberInfo']['service_start_time'] = strtotime($_POST['Enterprise']['service_start_time']);
                        $dataArr['memberInfo']['service_end_time'] = strtotime($_POST['Enterprise']['service_end_time']);
                    }
                    $model->status = Auditing::STATUS_PASS;
                    $model->apply_content = CJSON::encode($dataArr);
                    $model->audit_opinion = $_POST['Member']['audit_opinion'];
                    $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
                    $model->auditor_id = $this->getUser()->id;
                    $model->auditor_name = $this->getUser()->name;
                    $model->audit_time = time();
                    $model->save(false);


                    @SystemLog::record($this->getUser()->name . "编辑企业会员<<审核通过>>：" . $memberModel->username);
                    $this->setFlash('success', Yii::t('member', '企业会员编辑<<审核通过>>成功'));
                    $this->redirect(array('member/enterpriseMemberList'));
                } else {
                    $model->status = Auditing::STATUS_NOPASS;
                    $model->audit_opinion = $_POST['Member']['audit_opinion'];
                    $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
                    $model->auditor_id = $this->getUser()->id;
                    $model->auditor_name = $this->getUser()->name;
                    $model->audit_time = time();
                    $model->save(false);
                    @SystemLog::record($this->getUser()->name . "编辑企业会员<<审核不通过>>：" . $memberModel->username);
                    $this->setFlash('success', Yii::t('member', '企业会员编辑<<审核不通过>>成功'));
                    $this->redirect(array('member/enterpriseMemberList'));
                }
            }

            $this->render('enterprisememberlook', array(
                'model' => $memberModel,
                'infoModel' => $enterpriseModel,
            ));
        }
    }

    /**
     * 企业会员审核列表查看单条记录信息(编辑)
     * @author hhb
     */
    public function actionEnterpriseMemberUpdate() {
        $model = Auditing::model()->findByPk($_GET['id']);
        $dataArr = CJSON::decode($model->apply_content);

//    	Tool::pr($dataArr);

        $enterpriseModel = Member::model()->findByPk($dataArr['member']['id']);
        $enterpriseInfoModel = Enterprise::model()->findByPk($dataArr['memberInfo']['id']);

        $enterpriseModel->attributes = $dataArr['member'];
        $enterpriseModel->register_time = strtotime($dataArr['member']['register_time']);  //修改一下时间，防止验证不通过，因为验证时间长度为11位，没有发现注册时间有其它地方修改
        $enterpriseModel->apply_type = $model->apply_type;
        $enterpriseModel->author_name = $model->author_name;
        $enterpriseModel->author_type = $model->author_type;
        $enterpriseModel->submit_time = $model->submit_time;
        $enterpriseModel->audit_opinion = $model->audit_opinion;

        $enterpriseInfoModel->attributes = $dataArr['memberInfo'];
        $enterpriseInfoModel->email = isset($dataArr['member']['email']) ? $dataArr['member']['email'] : "";
        $enterpriseInfoModel->service_start_time = $dataArr['memberInfo']['service_start_time'];
        $enterpriseInfoModel->service_end_time = $dataArr['memberInfo']['service_end_time'];

        $this->performAjaxValidation($enterpriseModel);
        $this->performAjaxValidation($enterpriseInfoModel);

        if (isset($_POST['Member'])) {  //如果页面提交了，根据提交的操作进行判断是通过还是不通过，如果通过，保存数据，同时添加企业会员数据到指定的表中
            if ($_POST['status'] == Auditing::STATUS_PASS) {
                $isSaveMain = false;
                foreach ($_POST['Member'] as $keyMain => $valMain) {
                    if ($enterpriseModel->$keyMain != $valMain) {
                        $isSaveMain = true;
                        break;
                    }
                }

                $isSaveInfo = false;
                foreach ($_POST['Enterprise'] as $keyInfo => $valInfo) {
                    if ($enterpriseInfoModel->$keyInfo != $valInfo) {
                        $isSaveInfo = true;
                        break;
                    }
                }
                if ($isSaveMain) {
                    $enterpriseModel->attributes = $_POST['Member'];
                    $enterpriseModel->username = $_POST['Enterprise']['name'];

                    //下面这几个属性是基本信息和会员表都存在的，显示的时候是按照基本信息中显示的 所有需要重新赋值进行修改，免得不同
                    $enterpriseModel->province_id = $_POST['Enterprise']['province_id'];
                    $enterpriseModel->city_id = $_POST['Enterprise']['city_id'];
                    $enterpriseModel->district_id = $_POST['Enterprise']['district_id'];
                    $enterpriseModel->street = $_POST['Enterprise']['street'];
                    $enterpriseModel->mobile = $_POST['Enterprise']['mobile'];
                    $enterpriseModel->email = isset($_POST['Enterprise']['email']) ? $_POST['Enterprise']['email'] : "";
                    $enterpriseModel->save();
                }
                if ($isSaveInfo) {
                    $enterpriseInfoModel->attributes = $_POST['Enterprise'];
                    $enterpriseInfoModel->service_start_time = strtotime($_POST['Enterprise']['service_start_time']);   //时间赋值不成功，需要单独赋值
                    $enterpriseInfoModel->service_end_time = strtotime($_POST['Enterprise']['service_end_time']);
                    $enterpriseInfoModel->save();
                }

                if ($isSaveInfo || $isSaveMain) {
                    //将修改后的数据重新赋值
                    $dataArr['member']['is_master_account'] = $_POST['Member']['is_master_account'];
                    $dataArr['memberInfo']['name'] = $_POST['Enterprise']['name'];
                    $dataArr['memberInfo']['short_name'] = $_POST['Enterprise']['short_name'];
                    $dataArr['memberInfo']['category_id'] = $_POST['Enterprise']['category_id'];
                    $dataArr['memberInfo']['license'] = $_POST['Enterprise']['license'];
                    $dataArr['memberInfo']['license_photo'] = $_POST['Enterprise']['license_photo'];
                    $dataArr['memberInfo']['province_id'] = $_POST['Enterprise']['province_id'];
                    $dataArr['memberInfo']['city_id'] = $_POST['Enterprise']['city_id'];
                    $dataArr['memberInfo']['district_id'] = $_POST['Enterprise']['district_id'];
                    $dataArr['memberInfo']['street'] = $_POST['Enterprise']['street'];
                    $dataArr['memberInfo']['link_man'] = $_POST['Enterprise']['link_man'];
                    $dataArr['memberInfo']['department'] = $_POST['Enterprise']['department'];
                    $dataArr['memberInfo']['email'] = isset($_POST['Enterprise']['email']) ? $_POST['Enterprise']['email'] : "";
                    $dataArr['memberInfo']['service_start_time'] = strtotime($_POST['Enterprise']['service_start_time']);
                    $dataArr['memberInfo']['service_end_time'] = strtotime($_POST['Enterprise']['service_end_time']);
                }
                $model->status = Auditing::STATUS_PASS;
                $model->apply_content = CJSON::encode($dataArr);
                $model->audit_opinion = $_POST['Member']['audit_opinion'];
                $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
                $model->auditor_id = $this->getUser()->id;
                $model->auditor_name = $this->getUser()->name;
                $model->audit_time = time();
                $model->save(false);

                @SystemLog::record($this->getUser()->name . "编辑企业会员<<审核通过>>：" . $enterpriseModel->username);
                $this->setFlash('success', Yii::t('member', '企业会员编辑<<审核通过>>成功'));
                $this->redirect(array('member/enterpriseMemberList'));
            } else {
                $model->status = Auditing::STATUS_NOPASS;
                $model->audit_opinion = $_POST['Member']['audit_opinion'];
                $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
                $model->auditor_id = $this->getUser()->id;
                $model->auditor_name = $this->getUser()->name;
                $model->audit_time = time();
                $model->save(false);
                @SystemLog::record($this->getUser()->name . "编辑企业会员<<审核不通过>>：" . $enterpriseModel->username);
                $this->setFlash('success', Yii::t('member', '企业会员编辑<<审核不通过>>成功'));
                $this->redirect(array('member/enterpriseMemberList'));
            }
        }

        $this->render('enterprisememberlook', array(
            'model' => $enterpriseModel,
            'infoModel' => $enterpriseInfoModel,
        ));
    }

    /**
     * 批量审核不通过
     * @author hhb
     */
    public function actionNotPass() {
        header("Content-type:text/html;charset=utf-8");
        $id = explode(',', $_GET['id']);
        $txtOpinion = $this->getParam('txtOpinion');
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $id);
        $criteria->addCondition('status = ' . Auditing::STATUS_APPLY);
        $criteria->addInCondition('apply_type', array(Auditing::APPLY_TYPE_COMPANY, Auditing::APPLY_TYPE_COMPANY_UPDATE));
        $models = Auditing::model()->findAll($criteria);
        foreach ($models as $model) {
            $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
            $model->auditor_id = $this->getUser()->id;
            $model->auditor_name = $this->getUser()->name;
            $model->audit_time = time();
            $model->status = Auditing::STATUS_NOPASS;
            $model->audit_opinion = $txtOpinion;
            $model->save();
        }
        @SystemLog::record($this->getUser()->name . "批量审核企业会员<<审核不通过>>：" . $_GET['id']);
        $this->setFlash('succeed', Yii::t('auditing', '批量不通过成功！'));
        $this->redirect(array('member/enterpriseMemberList'));
    }

    /**
     * 批量审核通过
     * @author hhb
     */
    public function actionPass() {
        header("Content-type:text/html;charset=utf-8");
        $id = explode(',', $_GET['id']);
        $txtOpinion = $this->getParam('txtOpinion');
        $criteria = new CDbCriteria;
        $criteria->addInCondition('id', $id);
        $criteria->addCondition('status = ' . Auditing::STATUS_APPLY);
        $criteria->addInCondition('apply_type', array(Auditing::APPLY_TYPE_COMPANY, Auditing::APPLY_TYPE_COMPANY_UPDATE));
        $models = Auditing::model()->findAll($criteria);
        foreach ($models as $model) {
            $dataArr = CJSON::decode($model->apply_content);  //拆分结果
            if ($model->apply_type == Auditing::APPLY_TYPE_COMPANY) {  //如果是添加会员
                $memberModel = new Member('enterpriseCreate');
                $enterpriseModel = new Enterprise('enterpriseCreate');

                $memberModel->attributes = $dataArr['member'];
                $member = MemberType::fileCache();
                $memberModel->type_id = $member['defaultType'];
                $memberModel->status = Member::STATUS_NORMAL;
                $memberModel->grade_id = 1;
                $memberModel->referrals_id = $model->author_id;
                $memberModel->province_id = $dataArr['memberInfo']['province_id'];
                $memberModel->city_id = $dataArr['memberInfo']['city_id'];
                $memberModel->district_id = $dataArr['memberInfo']['district_id'];
                $memberModel->street = $dataArr['memberInfo']['street'];
                $memberModel->email = isset($dataArr['memberInfo']['email']) ? $dataArr['memberInfo']['email'] : "";

                $trans = $memberModel->dbConnection->beginTransaction();
                try {

                    ////添加商家信息
                    $enterpriseModel->attributes = $dataArr['memberInfo'];
                    $enterpriseModel->name = $memberModel->username;
                    if ($enterpriseModel->save(false)) {          //这里没有加入验证 是在是不知道是什么情况导致的
                        //发送短信
                        $smsConfig = $this->getConfig('smsmodel');
                        $msg = str_replace('{0}', '企业会员', $smsConfig['addMemberContent']);
                        $msg = str_replace('{1}', $memberModel->username, $msg);
                        $msg = str_replace('{2}', $memberModel->gai_number, $msg);
                        $msg = Yii::t('home', str_replace('{3}', $dataArr['member']['password'], $msg));
                        $datas = array('企业会员', $memberModel->username, $memberModel->gai_number, $dataArr['member']['password']);
                        $tmpId = $smsConfig['addMemberContentId'];
                        SmsLog::addSmsLog($memberModel->mobile, $msg, $memberModel->id, SmsLog::TYPE_OTHER,null,true, $datas, $tmpId);
                    } else {
                        throw new Exception('create enterprise error');
                    }
                    $memberModel->enterprise_id = $enterpriseModel->id;
                    if (!$memberModel->save()) {
                        throw new Exception('create member error');
                    }
                    @SystemLog::record($this->getUser()->name . "添加企业会员：" . $memberModel->username);

                    $trans->commit();
                } catch (Exception $e) {
                    $trans->rollback();
                }
            } else {   //编辑企业会员
                $memberModel = Member::model()->findByPk($dataArr['member']['id']);
                $enterpriseModel = Enterprise::model()->findByPk($dataArr['memberInfo']['id']);
                $memberModel->attributes = $dataArr['member'];
                $memberModel->register_time = strtotime($dataArr['member']['register_time']);
                $enterpriseModel->attributes = $dataArr['memberInfo'];
//				Tool::p($enterpriseModel);
//				Tool::pr($memberModel);
                $memberModel->save(false);
                $enterpriseModel->save(false);
            }

            $model->status = Auditing::STATUS_PASS;
            $model->auditor_type = Auditing::AUDITOR_TYPE_ADMIN;
            $model->auditor_id = $this->getUser()->id;
            $model->auditor_name = $this->getUser()->name;
            $model->audit_time = time();
            $model->save();
        }

        @SystemLog::record($this->getUser()->name . "批量审核企业会员<<审核通过>>：" . $_GET['id']);
        $this->setFlash('succeed', Yii::t('auditing', '批量通过成功！'));
        $this->redirect(array('member/enterpriseMemberList'));
    }

    /**
     * 设置主账户
     * @param $id 会员id
     */
    public function actionSetMaster($id) {
        $this->layout = false;
        /** @var $model  Member */
        $model = $this->loadModel($id);
        //则将该手机账户设为非主账户
        Member::model()->updateAll(array('is_master_account' => Member::NO_MASTER_ACCOUNT), "mobile='{$model->mobile}'");
        $model->is_master_account = $model::IS_MASTER_ACCOUNT;
        if ($model->save(false)) {
            @SystemLog::record($this->getUser()->name . '设置主账户:' . $model->gai_number);
        }
        echo '<script>window.onerror=function(){return true;};history.back(); </script>';
    }

    /**
     * 生成企业会员
     * 
     * 老刘  16:18:46
      在些处添加个功能，生成企业会员
      role字段为1，点击这个按钮，就弹出框，填写数量的输入框，就生成相应的数量的GW号等信息
     */
    public function actionCreateEnterpriseMember() {

        $model = new Member('search');
        $model->unsetAttributes();

        if (isset($_GET['number']) && isset($_GET['password'])) {
            $password = htmlspecialchars(trim($_GET['password']));
            $number = $_GET['number'] * 1;

            //生成账号
            for ($i = 0; $i < $number; $i++) {
                $gai_number = $model->generateGaiNumber();
                $salt = Tool::generateSalt();
                $psw = CPasswordHelper::hashPassword($password . $salt);

                $insert = array();
                $insert['gai_number'] = $gai_number;
                $insert['salt'] = $salt;
                $insert['password'] = $psw;
                $insert['type_id'] = 1;
                $insert['role'] = 1;

                Yii::app()->db->createCommand()->insert('{{member}}', $insert);
            }

            @SystemLog::record($this->getUser()->name . "批量生成企业会员：数量->" . $number . ' , 密码->' . $password);
//            $this->setFlash('succeed', Yii::t('member', '生成企业会员成功！'));
            echo '<script>alert("' . Yii::t('member', '生成企业会员成功！') . '")</script>';
        }

        $this->render('createEnterpriseMember', array(
            'model' => $model,
        ));
    }

    /**
     * 生成批量普通会员列表数据
     */
    public function actionBatChCreateList() {
        $model = new Member('search');
        $model->unsetAttributes();
        $data = array();
        if (isset($_GET['number']) && isset($_GET['password'])) {
            //生成账号
            $number = $this->getParam('number');
            $password = $this->getParam('password');
            for ($i = 0; $i < $number; $i++) {

                $gai_number = $model->generateGaiNumber();
                $member = new Member();
                $member->gai_number = $gai_number;
                $member->password = strlen($password)>=6 ? $password : mt_rand(100000, 999999);
                $data[] = $member;
                ;
            }
            $this->render('batchCreateList', array('data' => $data, 'number' => $number));
        } else {
            $this->render('createEnterpriseMember', array(
                'model' => $model,
            ));
        }
    }

    /**
     * 将生成批量普通会员列表数据添加到会员表
     */
    public function actionBatchCreate() {

        if (isset($_POST['data'])) {
            $data = $this->getParam('data');
            $model = new Member('search');
            $model->unsetAttributes();
            $defaultVal = MemberType::fileCache();
            foreach ($data as $k => $v) {
                $salt = Tool::generateSalt();
                $password = $v['password'];
                $psw = CPasswordHelper::hashPassword($password . $salt);
                $username = '';
                $mobile = '';
                $gw = Member::model()->exists('gai_number=:gw', array(':gw' => $v['gai_number']));
                if(!empty($v['mobile'])){
                    $mobile = Member::model()->exists('mobile=:m',array(':m' => $v['mobile']));
                }
                if(!empty($v['username'])){
                    $username = Member::model()->exists('username=:u',array(':u' => $v['username']));
                }
                if ($username) {
                    $data[$k]['error'] = '失败：该用户名已经注册';
                } elseif ($mobile) {
                    $data[$k]['error'] = '失败：该手机号已经注册';
                } elseif (empty($v['password'])) {
                    $data[$k]['error'] = '失败：密码号码为空';
                }else if($gw){
                    $data[$k]['error'] = '失败：gw已经存在';
                } else{
                    $insert = array();
                    $insert['gai_number'] = $v['gai_number'];
                    $insert['salt'] = $salt;
                    $insert['password'] = $psw;
                    $insert['username'] = $v['username'];
                    $insert['mobile'] = $v['mobile'];
                    $insert['register_time'] = time();
                    $insert['type_id'] = $defaultVal['defaultType'];
                    $result = Yii::app()->db->createCommand()->insert('{{member}}', $insert);
                    if(!$result){
                        $data[$k]['error'] = '失败：插入数据失败';
                    }else{
                        $data[$k]['error'] = '成功！';
                    }
                }
            }
            @SystemLog::record($this->getUser()->name . "批量生成普通会员");
            $this->setFlash('success', Yii::t('member', '生成普通会员成功！'));
            $this->render('hiddenList',array('data'=>$data));
        }
    }

    /**
     * 导出批量生成会员的结果
     */
    public function actionBatchCreateExport(){
        if(isset($_POST['data'])){
            $data = unserialize($_POST['data']);
            //引入phpExcel
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
            require Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
            Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', '序号')
                ->setCellValue('B1', '盖网通编号')
                ->setCellValue('C1', '用户名')
                ->setCellValue('D1', '密码')
                ->setCellValue('E1', '手机号')
                ->setCellValue('F1', '结果');
            $i = 2;
            foreach ($data as $k => $v) {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $k + 1)
                    ->setCellValue('B' . $i, $v['gai_number'])
                    ->setCellValue('C' . $i, $v['username'])
                    ->setCellValue('D' . $i, $v['password'])
                    ->setCellValue('E' . $i, $v['mobile'])
                    ->setCellValue('F' . $i, $v['error']);
                $i++;
            }
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-type: application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="批量生成会员结果.xls"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
            @SystemLog::record(Yii::app()->user->name . "导出会员成功");
            unset($data, $objPHPExcel, $objWriter);

        }
    }

    /**
     * ajax验证
     * @param $model
     * @param $models
     * @param $validateAttribitus
     */
    protected function performAjaxValidationTabular($models, $validateAttribitus) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'bacthCreate-form') {
            $error = array();
            if (!empty($models)) {
                $tErr = CActiveForm::validateTabular($models, $validateAttribitus, false);
                Yii::app()->end();
            }
        }
    }

    /**
     * 企业会员列表
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function actionList() {
        $this->breadcrumbs = array(Yii::t('member', '企业会员 ') => array('member/list'), Yii::t('member', '列表'));
        $model = new Member('enterprise');
        $model->unsetAttributes();
        if (isset($_GET['Member']))
            $model->attributes = $this->getParam('Member');

        $this->showExport = true;
        $this->exportAction = 'enterpriseExport';
        $totalCount = $model->enterprise()->getTotalItemCount();
        $exportPage = new CPagination($totalCount);
        $exportPage->route = 'member/enterpriseExport';
        $exportPage->params = array_merge(array('grid_mode' => 'export'), $_GET);
        $exportPage->pageSize = $model->exportLimit;

        $this->render('list', array(
            'model' => $model,
            'totalCount' => $totalCount,
            'exportPage' => $exportPage,
        ));
    }

    /**
     * 企业会员列表导出
     */
    public function actionEnterpriseExport() {
        $model = new Member('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Member']))
            $model->attributes = $this->getParam('Member');

        @SystemLog::record($this->getUser()->name . "导出企业会员列表");

        $model->isExport = 1;
        $this->render('enterpriseExport', array(
            'model' => $model,
        ));
    }

}
