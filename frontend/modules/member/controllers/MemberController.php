<?php

/**
 * 会员信息
 * 操作(显示，修改，上传头像，修改密码,推荐链接)
 * @author zhenjun_xu <412530435@qq.com>
 */
class MemberController extends MController
{

    public $layout = 'member';
    /*
     * 修改账号信息定义步骤
    */
    const STEP_ONE = 1;
    const STEP_TWO = 2;
    const STEP_THREE = 3;
    
    public function init()
    {
        $this->pageTitle = Yii::t('member', '_用户中心_') . Yii::app()->name;
    }

    /**
     * 修改
     */
    public function actionUpdate()
    {
        $this->pageTitle = Yii::t('member', '基本资料修改') . $this->pageTitle;
        if(Yii::app()->theme){
            $this->model->scenario = 'editinfo';
        } else {
            $this->model->scenario = 'update_base';            
        }
        $this->performAjaxValidation($this->model);

//        Tool::pr($param);
        $enterpriseId = $this->getSession('enterpriseId');
        //企业会员
        if ($enterpriseId) {
            $modelInfo = Enterprise::model()->findByPk($enterpriseId);
            $modelInfo->scenario = 'update_base';
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'member-form') {
                echo CActiveForm::validate($modelInfo);
                Yii::app()->end();
            }
        }
        if (isset($_POST['Member'])) {
            $this->model->attributes = Tool::filterPost($_POST['Member'], 'username,real_name,identity_number,identity_type,sex,province_id,city_id,district_id,street,birthday,email');
            $this->model->birthday = strtotime($_POST['Member']['birthday']);
            $trans = Yii::app()->db->beginTransaction();
            try {
                if (isset($_POST['Enterprise']) && isset($modelInfo)) {
                    $modelInfo->attributes = Tool::filterPost($_POST['Enterprise'], 'short_name,province_id,city_id,district_id,street,link_man,email,department');
                    $modelInfo->mobile = $this->model->mobile;
                    if (!$modelInfo->save()) {
                        throw new Exception(Yii::t('memberMember',"会员更新失败"));
                    }
                }
                if (!$this->model->save()) {
                    throw new Exception(Yii::t('memberMember',"会员更新失败"));
                }
                $trans->commit();
                //删除验证码
                if ($this->getCookie($this->model->mobile))
                    $this->setCookie($this->model->mobile, null);
                $this->setFlash('success', Yii::t('member', '账户信息修改成功'));
                //判断上个路由是否需要返回
                if (!empty($_REQUEST['croute']))
                    $this->redirect($this->createUrl($_REQUEST['croute']));
                else
                    $this->redirect(array('site/index'));
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', $e->getMessage());
            }
        }
        if ($enterpriseId) {
            $this->render('updateenterprise', array('model' => $this->model, 'modelInfo' => $modelInfo));
        } else {
            $this->render('update', array('model' => $this->model));
        }
    }

    /**
     * 上传头像
     */
    public function actionAvatar()
    {
        $this->pageTitle = Yii::t('member', '用户头像') . $this->pageTitle;
        $this->model->scenario = 'update_avatar';
        //$this->performAjaxValidation($model);
        $model2 = new Enterprise('register');
        $this->performAjaxValidation($model2);
        $old_pic = $this->model->head_portrait;
        if (isset($_POST['Member'])) {
            $this->model->attributes = Tool::filterPost($_POST['Member'], 'head_portrait');
            $saveDir = 'head_portrait/' . date('Y/n/j');
            $this->model = UploadedFile::uploadFile($this->model, 'head_portrait', $saveDir, Yii::getPathOfAlias('att'));
            if ($this->model->save()) {
                UploadedFile::saveFile('head_portrait', $this->model->head_portrait, $old_pic, true);
                $this->setFlash('success', Yii::t('member', '修改头像成功'));
                $this->refresh();
            } else {
                $this->model->head_portrait = $old_pic;
                $this->setFlash('error', Yii::t('member', '很遗憾，修改头像失败'));
            }
        }

        $this->render('avatar', array('model' => $this->model, 'model2' => $model2));
    }

    /**
     * 安全信息
     */
    public function actionSafe()
    {
        $this->pageTitle = Yii::t('member', '安全信息') . $this->pageTitle;
        $this->render('safe', array('model' => $this->model));
    }

    /**
     * 密码设置
     */
    public function actionPassword()
    {
        $this->pageTitle = Yii::t('member', '密码设置') . $this->pageTitle;
        $this->render('password');
    }

    /**
     * 修改一级密码
     */
    public function actionSetPassword1()
    {
        $this->pageTitle = Yii::t('member', '修改一级密码') . $this->pageTitle;
        $this->checkPhone($this->model);
        $this->model->scenario = 'resetPassword';
        $this->performAjaxValidation($this->model);
        if (isset($_POST['Member'])) {
            $this->model->attributes = Tool::filterPost($_POST['Member'], 'password,confirmPassword,mobileVerifyCode');
            if ($this->model->save()) {
                //同步修改密码到盖讯通
                if (defined('IS_STARTGXT') && IS_STARTGXT) {
                    Member::getUpdatePassword($this->model->gai_number, $_POST['Member']['password'], GXT_PASSWORD_KEY);
                }

                //删除所有线下机器登陆状态
                OfflineMachines::loginOut($this->model->id);

                $this->setFlash('success', Yii::t('member', '恭喜您，修改成功！'));
                //删除验证码
                if ($this->getCookie($this->model->mobile))
                    $this->setCookie($this->model->mobile, null);
                if ($this->getSession($this->model->mobile))
                    $this->setSession($this->model->mobile, null);
            } else {
                $this->setFlash('error', Yii::t('member', '抱歉，修改密码失败！') . CHtml::errorSummary($this->model));
            }
        }

        $this->render('setpassword1', array('model' => $this->model));
    }

    /**
     * V2.0版 修改一级密码
     */
    public function actionSetPwd1()
    {
        $this->layout = 'save';
        $this->pageTitle = Yii::t('member', '修改登陆密码') . $this->pageTitle;
        $this->title = '修改登陆密码';
        $this->checkPhone($this->model);

        $cacheName = 'member_pwd1_' . $this->user->id;
        //$vcodeName = 'member_vcode_' . $this->user->id;
        $step = Tool::cache($cacheName)->get($cacheName);
        $step = ($step >= 1 && $step <= 3) ? $step : 1;
//        if($step == 1){
        $this->model->scenario = 'resetPassword';
//        }
        $this->performAjaxValidation($this->model);

        if (isset($_POST['Member'])) {
            if ($step == 1) {
                $this->_StepOne($_POST['Member'], $cacheName);
            } else if ($step == 2) {
                $RsaPassword = new RsaPassword();
                $this->model->attributes = $RsaPassword->decryptPassword(Tool::filterPost($_POST['Member'], 'password,token'));
                if ($this->model->save(false)) {
                    //同步修改密码到盖讯通
                    if (defined('IS_STARTGXT') && IS_STARTGXT) {
                        Member::getUpdatePassword($this->model->gai_number, $_POST['Member']['password'], GXT_PASSWORD_KEY);
                    }

                    //删除所有线下机器登陆状态
                    OfflineMachines::loginOut($this->model->id);

                    $this->_StepTwo($cacheName);
                } else {
                    $this->setFlash('error', Yii::t('member', '抱歉，修改密码失败！') . CHtml::errorSummary($this->model));
                }
            }
        }

        if ($step == 3) {
            Tool::cache($cacheName)->set($cacheName, 1, 3600);
        }

        $this->render('setpwd1', array('model' => $this->model, 'step' => $step));
    }

    /**
     * 修改二级密码
     */
    public function actionSetPassword2()
    {
        $this->pageTitle = Yii::t('member', '修改二级密码') . $this->pageTitle;
        $this->checkPhone($this->model);
        $this->model->scenario = 'resetPassword2';
        $this->performAjaxValidation($this->model);
        if (isset($_POST['Member'])) {
            $this->model->attributes = Tool::filterPost($_POST['Member'], 'password2,confirmPassword,mobileVerifyCode');
            if ($this->model->save()) {
                $this->setFlash('success', Yii::t('member', '恭喜您，修改成功！'));
                //删除验证码
                if ($this->getCookie($this->model->mobile))
                    $this->setCookie($this->model->mobile, null);
                if ($this->getSession($this->model->mobile))
                    $this->setSession($this->model->mobile, null);
            } else {
                $this->setFlash('error', Yii::t('member', '抱歉，修改密码失败！'));
            }
        }

        $this->render('setpassword2', array('model' => $this->model));
    }

    /**
     * 修改三级密码
     */
    public function actionSetPassword3()
    {
        $this->pageTitle = Yii::t('member', '修改三级密码') . $this->pageTitle;
        $this->checkPhone($this->model);
        $this->model->scenario = 'resetPassword3';
        $this->performAjaxValidation($this->model);
        if (isset($_POST['Member'])) {
            $this->model->attributes = Tool::filterPost($_POST['Member'], 'password3,confirmPassword,mobileVerifyCode');
            if ($this->model->save()) {
                $this->setFlash('success', Yii::t('member', '恭喜您，修改成功！'));
                //删除验证码
                if ($this->getCookie($this->model->mobile))
                    $this->setCookie($this->model->mobile, null);
                if ($this->getSession($this->model->mobile))
                    $this->setSession($this->model->mobile, null);
                $this->refresh();
            } else {
                $this->setFlash('error', Yii::t('member', '抱歉，修改密码失败！'));
            }
        }
        $this->render('setpassword3', array('model' => $this->model));
    }

    /**
     * V2.0版 修改三级密码(支付密码)
     */
    public function actionSetPwd3()
    {
        $this->layout = 'save';
        $this->pageTitle = Yii::t('member', '修改支付密码') . $this->pageTitle;
        $this->title = '修改支付密码';
        $this->checkPhone($this->model);

        $cacheName = 'member_pwd3_' . $this->user->id;
        //$vcodeName = 'member_vcode_' . $this->user->id;
        $step = Tool::cache($cacheName)->get($cacheName);
        $step = ($step >= 1 && $step <= 3) ? $step : 1;

        $this->model->scenario = 'resetPassword3';
        $this->performAjaxValidation($this->model);

        ///$post = Yii::app()->request->getPost('Member');
        if (isset($_POST['Member'])) {
            if ($step == 1) {
                $this->_StepOne($_POST['Member'], $cacheName);
            } else if ($step == 2) {
                $RsaPassword = new RsaPassword();
                $this->model->attributes = $RsaPassword->decryptPassword(Tool::filterPost($_POST['Member'], 'password3,token'),'password3');
                if ($this->model->save(false)) {
                    $this->_StepTwo($cacheName);
                } else {
                    $this->setFlash('error', Yii::t('member', '抱歉，修改密码失败！') . CHtml::errorSummary($this->model));
                }
            }
        }

        if ($step == 3) {
            Tool::cache($cacheName)->set($cacheName, 1, 3600);
        }

        $this->render('setpwd3', array('model' => $this->model, 'step' => $step));
    }

    public function actionSetPwd2()
    {
        $this->layout = 'save';
        $this->pageTitle = Yii::t('member', '修改积分管理密码') . $this->pageTitle;
        $this->title = Yii::t('member', '修改积分管理密码');
        $this->checkPhone($this->model);

        $cacheName = 'member_pwd2_' . $this->user->id;
        //$vcodeName = 'member_vcode_' . $this->user->id;
        $step = Tool::cache($cacheName)->get($cacheName);
        $step = ($step >= 1 && $step <= 3) ? $step : 1;

        $this->model->scenario = 'resetPassword2';
        $this->performAjaxValidation($this->model);

        ///$post = Yii::app()->request->getPost('Member');
        if (isset($_POST['Member'])) {
            if ($step == 1) {
                $this->_StepOne($_POST['Member'], $cacheName);
            } else if ($step == 2) {
                $this->model->attributes = Tool::filterPost($_POST['Member'], 'password2,confirmPassword');
                if ($this->model->save(false)) {
                    $this->_StepTwo($cacheName);
                } else {
                    $this->setFlash('error', Yii::t('member', '抱歉，修改密码失败！') . CHtml::errorSummary($this->model));
                }
            }
        }

        if ($step == 3) {
            Tool::cache($cacheName)->set($cacheName, 1, 3600);
        }

        $this->render('setpwd2', array('model' => $this->model, 'step' => $step));
    }

    /**
     * v2.0修改密码第一步
     * @param array $post post数据
     * @param string $cacheName
     */
    protected function _StepOne($post, $cacheName)
    {
        $this->checkPhone($this->model);
        $this->model->attributes = Tool::filterPost($_POST['Member'], 'mobile,mobileVerifyCode');
        if ($this->model->validate(array('mobile', 'mobileVerifyCode'))) {
            Tool::cache($cacheName)->set($cacheName, 2, 3600);
            // Tool::cache($vcodeName)->set($vcodeName, 2, 3600);
            $this->refresh();
        }
    }

    /**
     * v2.0修改密码第二步
     * @param array $post post数据
     * @param string $cacheName 缓存名称
     */
    protected function _StepTwo($cacheName)
    {
        Tool::cache($cacheName)->set($cacheName, 3, 3600);
        $this->setFlash('success', Yii::t('member', '恭喜您，修改成功！'));
        //删除验证码
        if ($this->getCookie($this->model->mobile))
            $this->setCookie($this->model->mobile, null);
        if ($this->getSession($this->model->mobile))
            $this->setSession($this->model->mobile, null);
        $this->refresh();
    }

    /**
     * 推荐链接
     */
    public function actionRecommendUrl()
    {
        $this->pageTitle = Yii::t('member', '推荐链接') . $this->pageTitle;
        $code = rawurlencode(Tool::lowEncrypt($this->model->gai_number, 'encrypt'));
        $this->render('recommendurl', array('model' => $this->model, 'code' => $code));
    }

    /**
     * 检查用户是否填写手机号，否则跳转到修改资料页面
     *
     * Enter description here ...
     */
    private function checkPhone($model)
    {
        if (empty($model->mobile)) {
            //跳转到修改资料页面
            $this->setFlash('error', Yii::t('member', '很抱歉，请先完善资料'));
            $this->redirect($this->createUrl('member/update', array('croute' => strtolower($this->action->id))));
        }
    }

    /**
     * 修改绑定手机
     */
    public function actionUpdateMobile()
    {
        $this->pageTitle = Yii::t('member', '修改绑定手机') . $this->pageTitle;
        $this->model->scenario = 'updateMobile';
        $this->performAjaxValidation($this->model);
        $this->checkPhone($this->model);
        $enterpriseId = $this->getSession('enterpriseId');
        if ($enterpriseId) {
            $this->setFlash('error', Yii::t('member', '抱歉，企业会员请联系客服人员进行手机号码修改！'));
            $this->redirect($this->createUrl('member/update'));
         }
        if (isset($_POST['Member'])) {
            $this->model->attributes = Tool::filterPost($_POST['Member'], 'password,mobile2,mobileVerifyCode2');
            if ($this->model->validate()) {
                $this->model->mobile = $this->model->mobile2;
                $trans = Yii::app()->db->beginTransaction();
                try {
                    if (!$this->model->save(true, array('mobile'))) {
                        throw new Exception("save member error");
                    } 
                    //企业会员
                    if ($enterpriseId) {
                        $modelInfo = Enterprise::model()->findByPk($enterpriseId);
                        $modelInfo->mobile = $this->model->mobile;
                        if (!$modelInfo->save(true, array('mobile'))) {
                            throw new Exception("save enterprise error");
                        }
                    }
                    $this->setFlash('success', Yii::t('member', '恭喜您，修改绑定手机成功！'));
                    $trans->commit();
                    $this->refresh();
                } catch (Exception $e) {
                    $trans->rollback();
                    $this->setFlash('error', Yii::t('member', '抱歉，修改绑定手机失败！'));
                }
            } else {
                $this->setFlash('error', Yii::t('member', '抱歉，修改绑定手机失败！') . CHtml::errorSummary($this->model));
            }
        }
        $this->render('updatemobile', array('model' => $this->model));
    }

    /**
     * V2.0版 修改绑定手机
     */
    public function actionBindMobile()
    {
        $this->layout = 'save';
        $this->pageTitle = Yii::t('member', '修改绑定手机') . $this->pageTitle;
        $this->title = '修改绑定手机';
        $this->model->scenario = 'bindMobile';
        $this->performAjaxValidation($this->model);

        $enterpriseId = $this->getSession('enterpriseId');
        if ($enterpriseId) {
            $this->setFlash('error', Yii::t('member', '抱歉，企业会员请联系客服人员进行手机号码修改！'));
            $this->redirect($this->createUrl('member/update'));
        }
        $cacheName = 'member_mobile_' . $this->user->id;
        $step = Tool::cache($cacheName)->get($cacheName);
        $step = ($step >= 1 && $step <= 3) ? $step : 1;
        if (isset($_POST['Member'])) {
            $this->model->attributes = $_POST['Member'];
            if ($step == 1) {
                if ($this->model->validate()  || 1==1) {
                    Tool::cache($cacheName)->set($cacheName, 2, 3600);
                    $this->refresh();
                }
            } else if ($step == 2) {
                if ($this->model->validate() || 1==1) {
                    $trans = Yii::app()->db->beginTransaction();
                    try {
                        if (!$this->model->save(true, array('mobile'))) {
                            throw new Exception("save member error");
                        }
                        //企业会员
                        if ($enterpriseId) {
                            $modelInfo = Enterprise::model()->findByPk($enterpriseId);
                            $modelInfo->mobile = $this->model->mobile;
                            if (!$modelInfo->save(true, array('mobile'))) {
                                throw new Exception("save enterprise error");
                            }
                        }

                        Tool::cache($cacheName)->set($cacheName, 3, 3600);
                        $trans->commit();
                        
                        //通知sku同步用户数据
                        @ApiSKU::updateInfo($this->model->gai_number);
                        
                        $this->refresh();
                    } catch (Exception $e) {
                        $trans->rollback();
                        $this->setFlash('error', Yii::t('member', '抱歉，修改绑定手机失败！'));
                    }
                } else {
                    $this->setFlash('error', Yii::t('member', '抱歉，修改绑定手机失败！') . CHtml::errorSummary($this->model));
                }
            }
        }

        if ($step == 3) {
            $this->model->mobileVerifyCode = '';
            Tool::cache($cacheName)->set($cacheName, 1, 3600);
        }

        $this->render('bindmobile', array('model' => $this->model, 'step' => $step));
    }

    /**
     * V2.0帐户安全
     */
    public function actionAccountSafe()
    {
        $this->pageTitle = Yii::t('member', '安全信息') . $this->pageTitle;
        $this->render('accountSafe', array('model' => $this->model));
    }

    /**
     * 推荐会员列表    我的推荐会员
     */
    public function actionRecommendUsers()
    {

        $dataProvider = new CActiveDataProvider('member', array(
            'criteria' => array(
                'select' => 'gai_number,username,register_time,referrals_time',
                'condition' => 'referrals_id = ' . $this->getUser()->id,
                'order' => 't.referrals_time DESC',
            ),
        ));

        $this->pageTitle = Yii::t('member', '我的推荐会员') . $this->pageTitle;
        $this->render('recommendusers', array('model' => $this->model, 'dataProvider' => $dataProvider));
    }

    /**
     * 升级为企业会员
     */
    public function actionUpgrade()
    {
        $this->pageTitle = Yii::t('memberMember', '升级为企业会员_') . $this->pageTitle;
        if ($this->getSession('enterpriseId')) {
            $this->setFlash('error', Yii::t('memberMember', '您已经是企业会员'));
            $this->redirect('/');
        }
        /** @var Member $model */
        $model = $this->model;
        $model->scenario = 'upgrade';
        $enterprise = new Enterprise('register');
        $model->is_enterprise = $model::ENTERPRISE_YES;
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'member-form') {
            $validate = json_decode(CActiveForm::validate($enterprise), true);
            $validate2 = json_decode(CActiveForm::validate($model), true);
            $validateAll = array_merge($validate, $validate2);
            echo json_encode($validateAll);
            Yii::app()->end();
        }
        if (isset($_POST['Member'])) {
            $model->attributes = $this->getParam('Member');
            $enterprise->attributes = $this->getParam('Enterprise');
            $enterprise->flag = Enterprise::FLAG_ONLINE;
            $enterprise->auditing = Enterprise::AUDITING_NO;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if ($enterprise->validate() && $enterprise->save()) {
                    $model->enterprise_id = $enterprise->id;
                    //不存在推荐人，才去查找
                    if (!$model->referrals_id && $model->tmp_referrals_id) {
                        $result = $model->find(array('select' => 'id', 'condition' => 'gai_number=:gai_number', 'params' => array(':gai_number' => $model->tmp_referrals_id)));
                        if ($result && ($result->id == $model->id)) {
                            throw new Exception('推荐人不能为自己！');
                        }
                        $model->referrals_id = $result->id;
                    }

                    if ($model->validate() && $model->save()) {
                        $transaction->commit();
                        //保存用户数据 到 Yii::app()->user
                        Yii::app()->user->setState('enterpriseId', $enterprise->id);
                        Yii::app()->user->setState('enterpriseFlag', $enterprise->flag);
                        Yii::app()->user->setState('enterpriseAuditing', $enterprise->auditing);
                        $this->setFlash('success', Yii::t('member', '升级企业会员成功，请提交网络店铺签约资料！'));
                        $this->redirect($this->createAbsoluteUrl('enterpriseLog/enterprise'));
                    } else {
                        throw new Exception('member update error');
                    }
                } else {
                    throw new Exception('enterprise add error');
                }
            } catch (Exception $e) {
                $transaction->rollback();
                $this->setFlash('error', Yii::t('member', '升级企业会员失败！') . $e->getMessage());
            }
        }
        $this->render('upgrade', array('model' => $model, 'enterprise' => $enterprise));
    }

    /**
     * v2.0版，邮箱绑定
     */
    public function actionBindEmail()
    {
        //如果用户已经绑定邮箱，不允许再绑定
        if ($this->model->active_email) {
            $this->setFlash('error', '已经绑定邮箱啦');
            $this->redirect(array('/member/member/accountSafe'));
        }
        $this->layout = 'save';
        $this->model->scenario = 'bindEmail';
        $this->title = Yii::t('memberMember','绑定邮箱');
        $post = Yii::app()->request->getPost('Member');
        $step = Yii::app()->request->getPost('step');
        $step = isset($step) ? $step : 1;
        $this->performAjaxValidation($this->model);
        if (isset($post)) {
            if ($step == self::STEP_ONE) {
                $this->model->attributes = Tool::filterPost($post,'password,email');
                if (!$this->model->validate('password','email')) {
                    $this->setFlash('error', $this->model->getError('password'));
                } else {
                    $result = $this->_sendVerdifyEmail();
                    if($result){
                        $step = self::STEP_TWO;
                    } else {
                       $this->setFlash('error', '邮件发送失败!');
                    }
                }
            }
        }
        $this->render('bindEmail', array('model' => $this->model,'step'=>$step));
    }

    /**
     * v20 验证邮箱
     */
    public function actionVerdifyEmail()
    {
        $this->layout = 'save';
        if(Yii::app()->request->getParam('flag')){
            $this->pageTitle = Yii::t('memberMember', '修改邮箱') . $this->pageTitle;
            $this->title = Yii::t('memberMember', '修改邮箱');
        } else {
            $this->pageTitle = Yii::t('memberMember', '绑定邮箱') . $this->pageTitle;
            $this->title = Yii::t('memberMember', '绑定邮箱');
        }

        $code = Yii::app()->request->getParam('code');
        $resource = Tool::authcode($code, 'DECODE', $this->model->gai_number);
        if ($resource) {
            $id = substr($resource, 0, stripos($resource, '|'));
            $email = substr($resource, stripos($resource, '|') + 1);
            $this->model->email = $email;
            $this->model->active_email = Member::FLAG_YES;
            if ($this->model->save(false)) {
                $this->render('verdifyEmail');
                Yii::app()->end();
            } else {
                $this->setFlash('error', '修改失败!');
            }
        }
        $this->redirect(array('/member'));
    }

    /**
     * 修改绑定邮件地址
     */
    public function actionUpdateBindEmail()
    {
        if (!$this->model->email && !$this->model->active_email) {
            $this->setFlash('error', '请先绑定邮箱');
            $this->redirect(array('/member/member/accountSafe'));
        }
        $this->layout = 'save';
        $this->model->scenario = 'updateBindEmail';
        $this->pageTitle = Yii::t('memberMember','修改邮箱') . $this->pageTitle;
        $this->title = Yii::t('memberMember','修改邮箱');
        $post = Yii::app()->request->getPost('Member');
        $step = Yii::app()->request->getPost('step');
        $step = isset($step) ? $step : 1;
        if (isset($post)) {
            if ($step == self::STEP_ONE) {
                $this->model->attributes = Tool::filterPost($post,'password');
                if (!$this->model->validate('password')) {
                    $this->setFlash('error', $this->model->getError('password'));
                } else {
                    $step = self::STEP_TWO;
                }
            } elseif ($step == self::STEP_TWO) {
                $this->model->scenario = 'emailUnqiue'; //修改验证场景，密码老是被验证
//                if(isset($_POST['ajax']) && $_POST['ajax'] == 'member-form')
                $this->model->attributes = Tool::filterPost($post,'email');
                $this->performAjaxValidation($this->model);
                if (!$this->model->validate('email')) {
                    $this->setFlash('error', $this->model->getError('email'));
                } else {
                    $result = $this->_sendVerdifyEmail(1);
                    if($result){
                        $step = self::STEP_THREE;
                    } else {
                       $this->setFlash('error', '邮件发送失败!');
                    }
                }
            }
        }
        $this->render('updateBindEmail', array('model' => $this->model, 'step' => $step));
    }
    /*
     * 发送邮件
     * @params int $flag 是否是绑定邮箱
     */
    protected function _sendVerdifyEmail($flag = 0)
    {
        $config = $this->getConfig('emailmodel');
        $email['subject'] = isset($config['esubject']) ? $config['esubject'] : '';
        $email['content'] = isset($config['econtent']) ? $config['econtent'] : '';
        $code = $this->model->id . '|' . $this->model->email; //ID + email
        $verdifyCode = Tool::authcode($code, 'ENCODE', $this->model->gai_number, 24 * 60 * 60);
        $verdifyUrl = $this->createAbsoluteUrl('/member/member/verdifyEmail', array('code' => $verdifyCode,'flag'=>$flag));
//        $email['content'] = str_replace('{0}', $this->model->username, $email['content']);
//        $email['content'] = str_replace('{1}', $verdifyUrl, $email['content']);
        $value = array(
            '%name%'=>array($this->model->username),
            '%url%'=> array($verdifyUrl)
        );

        try{
            $result = Tool::sendCouldEmail($this->model->email, $email['subject'] , 'email_verification', EmailLog::TEMPLATE_MAIL, $value);
//            $result = Tool::sendEmail($this->model->email, $email['subject'] ,$email['content'], $this->model->id);
//            if($result['send_status'] == EmailLog::STATUS_FAILD) 
//                return false;
//            else
                return true;
        }
        catch(Exception $e){
            return false;
        }
    }
    
    public function actionMobile()
    {
        $this->layout = 'save';
        $this->pageTitle = Yii::T('member','绑定手机').$this->pageTitle;
        $this->title = Yii::T('member','绑定手机');
        $this->model->scenario = 'bindMobile';
        $this->performAjaxValidation($this->model);
//        if(isset($_POST['ajax']) && $_POST['ajax'] == 'member-form'){
//            echo CActiveForm::validate($this->model);
//            Yii::app()->end();
//        }
        //已经绑定手机
        if($this->model->mobile) $this->redirect(array('/member/member/update'));
        $is = false;
        if(isset($_POST['Member'])){
            $post = $_POST['Member'];
            $this->model->attributes = $post;
            if($this->model->save()){
                $is = true;
            } else {
                $this->setFlash('error','手机绑定失败');
            }
        }
        $this->render('mobile',array('model'=>$this->model,'is'=>$is));
    }
}
