<?php

/**
 *  会员注册登录控制器
 *  操作(登录、退出、注册、忘记密码)
 * @author xiaoyan.luo<xiaoyan.luo@gatewang.com>
 */
// 指定允许其他域名访问
$url='http://m.' . SHORT_DOMAIN;
header('Access-Control-Allow-Origin:'.$url);

class HomeController extends WController
{

    /**
     * 验证码参数配置
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'height' => '30',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
                //'offset' => 3,
                //'testLimit' => 30,
            ),
        );
    }

    /**
     * 会员登录
     */
    public function actionLogin()
    {
        $this->layout = 'home';
        $this->pageTitle = Yii::t('member', '盖象微商城_登录');
        $this->showTitle = Yii::t('member', '用户登录');
        $model = new LoginForm;
        $model->username = $this->getCookie('uname');
        $this->performAjaxValidation($model);
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->homeUrl);
        $users = array();
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $this->getPost('LoginForm');
            if (!empty($model->username)){
                //手机号登录，多个账号情况
                if (is_numeric($model->username)) {
                    if ($model->validate(null, false)) {
                        $users = Yii::app()->db->createCommand()->select('gai_number')
                            ->from('{{member}}')->where('mobile=:m', array(':m' => $model->username))->queryAll();
                        if (!empty($users) && count($users) > 1) { //一个手机号绑定多个GW号，提示用GW号登录
                            $tmpUsers = array();
                            foreach ($users as $v) {
                                $tmpUsers[$v['gai_number']] = $v['gai_number'];
                            }
                            $users = $tmpUsers;
                            $model->addError('username','');
                        }else{
                            $model->login();
                            $this->setSession('login_error_times', 0); //设置登录错误次数值为0
                            $this->setCookie('uname', $model->username, 3600 * 30 * 365);
                            if (stripos(Yii::app()->user->returnUrl, 'logout') === false) {
                                $this->redirect(Yii::app()->user->returnUrl);
                            } else {
                                $this->redirect(array('/m'));
                            }
                        }
                    }
                } else { //GW号登录，未绑定手机号的情况
                    $exists = Member::model()->exists('gai_number = :number', array(':number' => $model->username));
                    if (!$exists) {
                        $model->addError('username', '请输入正确的GW号或手机号');
                    } else {
                        if ($model->validate(null, false) && $model->login()) {
                            $this->setSession('login_error_times', 0); //设置登录错误次数值为0
                            $this->setCookie('uname', $model->username, 3600 * 30 * 365);
                            $users = Yii::app()->db->createCommand()->select('mobile')
                                ->from('{{member}}')->where('gai_number =:number', array(':number' => $model->username))->queryScalar();
                            if (empty($users)) {
                                $this->redirect(array('/m/home/setMobile'));
                            }
                            if (stripos(Yii::app()->user->returnUrl, 'logout') === false) {
                                $this->redirect(Yii::app()->user->returnUrl);
                            } else {
                                $this->redirect(array('/m'));
                            }
                        }
                    }
                }
            }
        }
        $this->render('login', array('model' => $model,'users' => $users));
    }

    /**
     * 会员注册
     */
    public function actionRegister()
    {
        if (!$this->getUser()->isGuest) {
            $this->redirect(array('/m/member/index'));
        }
        $this->layout = 'home';
        $this->pageTitle = Yii::t('member', '盖象微商城_注册');
        $this->showTitle = Yii::t('member', '用户注册');
        $gwNumber = isset($_GET['code']) ? Tool::lowEncrypt(rawurldecode($this->getQuery('code')), 'DECODE') : '';
        //检查盖网号的有效性
        if(!empty($gwNumber)){
            $rModel = Member::model()->find(array(
                'select' => 'id',
                'condition' => 'gai_number = :number',
                'params' => array(':number' => $gwNumber),
            ));
            $m_id = $rModel['id']; //推荐人会员id
        }
        $model = new Member('mRegister');
        $this->performAjaxValidation($model);
        $ad = $this->getParam('ad');
        if(!empty($ad))
        {
            $sql = "update {{promotion_channels}} set visits = visits + 1 where number = '{$ad}'";
            Yii::app()->db->createCommand($sql,array(':number'=>$ad))->execute();
        }
        if (isset($_POST['Member'])) {
            $attributes = $this->getPost('Member');
            $model->attributes = $attributes; 
            $model->referrals_id = !empty($m_id) ? $m_id : 0;
            $model->referrals_time = !empty($m_id) ? time() : 0;
            $trans = Yii::app()->db->beginTransaction();
            try {     
                if (!$model->save()) {
                    throw new Exception(strip_tags(CHtml::errorSummary($model)));
                }
                //保存推荐记录
                if (!empty($model->referrals_id)) {
                    $recommend_log = new RecommendLog();
                    $recommend_log->member_id = $model->id;
                    $recommend_log->parent_id = $model->referrals_id;
                    $recommend_log->create_time = $model->referrals_time;
                    $recommend_log->save();
                    //通过链接邀请过来的用户，其推荐人可以获得红包
                    RedEnvelopeTool::createRedisActivity($model->referrals_id, RedisActivity::SOURCE_TYPE_ONLINE, Activity::TYPE_SHARE);
                }
                //给新注册的会员派发红包
                RedEnvelopeTool::createRedisActivity($model->id, RedisActivity::SOURCE_TYPE_ONLINE, Activity::TYPE_REGISTER);
                if(isset($ad) && !empty($ad))
                    PromotionChannels::addMemberFromPromotion($model->id,$ad);
                $trans->commit();
            } catch (Exception $e) {
                $trans->rollback();
                throw new CHttpException(404, Yii::t('home', '注册失败!' . $e->getMessage()));
            }
            //同步注册到盖讯通
            if(defined('IS_STARTGXT') && IS_STARTGXT) {
                $nickname = !empty($model->nickname) ? $model->nickname : $model->gai_number;
                Member::mGetRegister($model->gai_number,$_POST['Member']['password'],$nickname,$model->mobile,GXT_PASSWORD_KEY);
            }
            //注册后自动登录
            $loginForm = new LoginForm;
            $loginForm->username = $model->gai_number;
            $loginForm->password = $attributes['password'];
            $loginForm->login();

            //注册完成跳转到注册成功页面
            $this->redirect(array('home/registerSucceed', 'number' => $model->gai_number));
        }
        $this->render('register', array('model' => $model));
    }

    /**
     * 会员注册领取红包
     */
    public function actionReceiveRedBag()
    {
        $this->layout = false;
        $flag = isset($_POST['flag']) ? $this->getPost('flag') : '';
        if (!empty($flag)) {
            $this->pageTitle = Yii::t('member', '盖象微商城_分享领取红包');
            $this->showTitle = Yii::t('member', '分享领取红包');
            $gwNumber = isset($_GET['code']) ? Tool::lowEncrypt(rawurldecode($this->getQuery('code')), 'DECODE') : '';
            // 按要求暂时 取消限制 ----伍凌
//            if (empty($gwNumber)) {
//                throw new CHttpException(404, Yii::t('home', '请求的页面不存在'));
//            }
            $this->render('receiveRedBag', array('flag' => $flag));
        } else {
            $this->pageTitle = Yii::t('member', '盖象微商城_领取红包');
            $this->showTitle = Yii::t('member', '领取红包');
            if (!$this->getUser()->isGuest) {
                $this->redirect(array('/m/member/index'));
            }
            $gwNumber = isset($_GET['code']) ? Tool::lowEncrypt(rawurldecode($this->getQuery('code')), 'DECODE') : '';
            //检查盖网号的有效性
            $m_id = 0;
            if($gwNumber) {
                $exists = Member::model()->exists('gai_number = :number', array(':number' => $gwNumber));
                if ($exists) {
                    $rModel = Member::model()->find(array(
                        'select' => 'id',
                        'condition' => 'gai_number = :number',
                        'params' => array(':number' => $gwNumber),
                    ));
                    $m_id = $rModel['id']; //推荐人会员id
                }
            }
            $model = new Member('mRegister');
            $this->performAjaxValidation($model);
            $ad = $this->getParam('ad');
            if(!empty($ad))
            {
                $sql = "update {{promotion_channels}} set visits = visits + 1 where number = '{$ad}'";
                Yii::app()->db->createCommand($sql,array(':number'=>$ad))->execute();
            }
            if (isset($_POST['Member'])) {
                $attributes = $this->getPost('Member');
                $model->attributes = $attributes;
                $model->referrals_id = !empty($m_id) ? $m_id : 0;
                $model->referrals_time = !empty($m_id) ? time() : 0;
                $trans = Yii::app()->db->beginTransaction();
                try {
                    if (!$model->save()) {
                        throw new Exception(Yii::t('home', '用户创建失败'));
                    }
                    //保存推荐记录
                    if (!empty($model->referrals_id)) {
                        $recommend_log = new RecommendLog();
                        $recommend_log->member_id = $model->id;
                        $recommend_log->parent_id = $model->referrals_id;
                        $recommend_log->create_time = $model->referrals_time;
                        $recommend_log->save();
                        //通过链接邀请过来的用户，其推荐人可以获得红包
                        RedEnvelopeTool::createRedisActivity($model->referrals_id, RedisActivity::SOURCE_TYPE_ONLINE, Activity::TYPE_SHARE);
                    }
                    //给新注册的会员派发红包
                    RedEnvelopeTool::createRedisActivity($model->id, RedisActivity::SOURCE_TYPE_ONLINE, Activity::TYPE_REGISTER);
                    if(isset($ad) && !empty($ad))
                        PromotionChannels::addMemberFromPromotion($model->id,$ad);
                    $trans->commit();
                }catch (Exception $e) {
                    $trans->rollback();
                    throw new CHttpException(503, Yii::t('home', '注册失败!' . $e->getMessage()));
                }
                //同步注册到盖讯通
                if(defined('IS_STARTGXT') && IS_STARTGXT) {
                    $nickname = !empty($model->nickname) ? $model->nickname : $model->gai_number;
                    Member::mGetRegister($model->gai_number,$_POST['Member']['password'],$nickname,$model->mobile,GXT_PASSWORD_KEY);
                }
                //注册后自动登录
                $loginForm = new LoginForm;
                $loginForm->username = $model->gai_number;
                $loginForm->password = $attributes['password'];
                $loginForm->login();
                $this->redirect(array('home/registerSucceed', 'number' => $model->gai_number));
            }
            $this->render('receiveRedBag', array('model' => $model, 'gwNumber' => $gwNumber, 'flag' => $flag));
        }
    }

    /**
     * 注册成功
     */
    public function actionRegisterSucceed()
    {
        $this->layout = 'home';
        $this->pageTitle = Yii::t('member', '盖象微商城_注册成功');
        $this->showTitle = Yii::t('member', '注册成功');
        $gaiNumber = isset($_GET['number']) ? $this->getQuery('number') : '';
        $this->render('registerSucceed', array('gai_number' => $gaiNumber));
    }

    /**
     * 绑定手机号
     */
    public function actionSetMobile()
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        // 响应类型
        header('Access-Control-Allow-Methods:POST');
        // 响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        $this->layout = 'home';
        $this->pageTitle = Yii::t('member', '盖象微商城_用户绑定');
        $this->showTitle = Yii::t('member', '用户绑定');
        $model = new Member;
        $model->scenario = 'mSetMobile';
        $this->performAjaxValidation($model);
        if (isset($_POST['Member'])) {
            $model->attributes = $_POST['Member'];
            $data = Member::model()->find(array(
                'select' => 'id',
                'condition' => 'gai_number = :number',
                'params' => array(':number' => $model->gai_number),
            ));
            if (empty($data->id)) {
                $model->addError('gai_number', '不存在该盖网编号');
            } else {
                if (Member::model()->updateAll(array('mobile' => $model->mobile), 'id = :id', array(':id' => $data->id))) {
                    $this->setFlash('success', Yii::t('member', '恭喜您，绑定手机号成功！'));
                    $this->refresh();
                }
            }
        }
        $this->render('setMobile', array('model' => $model));
    }

    /**
     * 忘记密码
     */
    public function actionFindPassword()
    {
       
        $this->layout = 'home';
        $this->pageTitle = '盖象微商城_忘记密码';
        $this->showTitle = Yii::t('member', '重设登录密码');
        $model = new Member;
        $model->scenario = 'mResetPassword';
        $this->performAjaxValidation($model);
        if (isset($_POST['Member'])) {
            $model->attributes = $this->getPost('Member');
            $data = Member::model()->findAll(array(
                'select' => 'id,salt,gai_number',
                'condition' => 'mobile = :mobile',
                'params' => array(':mobile' => $model->mobile),
            ));
            if (empty($data)) {
                $model->addError('mobile', '该手机号还没有在盖网注册过');
            } else if (count($data) > 1) {
                $gwArr = array();
                foreach ($data as $value) {
                    $gwArr[] = $value->gai_number; //绑定该手机号的GW号
                }
                $gw = implode(',', $gwArr);
                $model->addError('mobile', '手机号绑定多个GW号:' . $gw);
            } else {
                $model->password = $model->hashPassword($_POST['Member']['password'] . $data[0]->salt);
                if (Member::model()->updateByPk($data[0]->id, array('password' => $model->password))) {   
                    //同步修改密码到盖讯通
                    if(defined('IS_STARTGXT') && IS_STARTGXT) {
                        Member::mGetUpdatePassword($model->gai_number,$_POST['Member']['password'],GXT_PASSWORD_KEY);
                    }
                    $this->setFlash('success', Yii::t('member', '恭喜您，重置密码成功！'));
                    //删除验证码
                    if ($this->getCookie($model->mobile)) $this->setCookie($model->mobile, null);
                    if ($this->getSession($model->mobile)) $this->setSession($model->mobile, null);
                    $this->refresh();
                }
                
            }
        }
        $this->render('findPassword', array('model' => $model));
    }

    /**
     * 重设登录密码
     */
    public function actionSetPassword()
    {
        $this->layout = 'home';
        $this->pageTitle = '盖象微商城_重置密码';
        $this->showTitle = Yii::t('member', '重设登录密码');
        $memberId = $this->getUser()->id; //会员id
        if (empty($memberId)) {
            $this->redirect(array('home/login'));
        }
        $model = new Member;
        $model->scenario = 'mResetPassword';
        $this->performAjaxValidation($model);
        if (isset($_POST['Member'])) {
            $model->attributes = $this->getPost('Member');
            $data = Member::model()->find(array(
                'select' => 'salt',
                'condition' => 'id = :id and mobile = :mobile',
                'params' => array(':id' => $memberId, ':mobile' => $model->mobile),
            ));
            $model->password = $model->hashPassword($_POST['Member']['password'] . $data->salt);
            if (Member::model()->updateByPk($memberId, array('password' => $model->password))) {
                //同步修改密码到盖讯通
                if(defined('IS_STARTGXT') && IS_STARTGXT) {
                    Member::mGetUpdatePassword($model->gai_number,$_POST['Member']['password'],GXT_PASSWORD_KEY);
                }
                $this->setFlash('success', Yii::t('member', '恭喜您，重置密码成功！'));
                //删除验证码
                if ($this->getCookie($model->mobile)) $this->setCookie($model->mobile, null);
                if ($this->getSession($model->mobile)) $this->setSession($model->mobile, null);
                $this->refresh();
            }
        }
        $this->render('findPassword', array('model' => $model));
    }

    /**
     * 退出登录
     */
    public function actionLogout()
    {
        $this->showTitle="未登录";
        Yii::app()->user->logout();
        $this->render('logout');
    }

    /**
     * 微商城注册协议
     */
    public function actionAgreement()
    {
        $this->layout = 'home';
        $this->pageTitle = '盖象微商城_注册协议';
        $this->showTitle = Yii::t('home', '盖网通软件许可及服务协议');
        $this->render('agreement');
    }

    /**
     * ajax 获取手机验证码
     */
    public function actionGetMobileVerifyCode()
    {
      //if (Yii::app()->request->isAjaxRequest && isset($_POST['mobile']) && preg_match("/(^\d{11}$)|(^852\d{8}$)/", $_POST['mobile'])) {
        if(isset($_POST['mobile']) && preg_match("/(^\d{11}$)|(^852\d{8}$)/", $_POST['mobile'])) {
          $verifyCodeCheck = $this->getSession($_POST['mobile']);
            if ($verifyCodeCheck) {
                $verifyArr = unserialize(Tool::authcode($verifyCodeCheck, 'DECODE'));
                if ($verifyArr && (time() - $verifyArr['time'] < 60)) {
                    echo Yii::t('memberHome', '验证码正在发送，请等待{time}秒后重试', array('{time}' => '60'));
                    Yii::app()->end();
                }
            }
            $smsConfig = $this->getConfig('smsmodel');
            $tmpId = $smsConfig['phoneVerifyContentId'];
            //$verifyCode = '000000';
            $verifyCode = mt_rand(10000, 99999);
            $msg = Yii::t('memberHome', $smsConfig['phoneVerifyContent'], array('{0}' => $verifyCode));
            $data = array('time' => time(), 'verifyCode' => $verifyCode);
            //验证码同时写cookie\session 防止丢失
            $this->setCookie($_POST['mobile'], Tool::authcode(serialize($data), 'ENCODE', '', 60 * 5), 60 * 5);
            $this->setSession($_POST['mobile'], Tool::authcode(serialize($data), 'ENCODE', '', 60 * 5));

            if (Yii::app()->request->cookies[$_POST['mobile']]) {
                SmsLog::addSmsLog($_POST['mobile'], $msg,0,  SmsLog::TYPE_CAPTCHA,null,true, array($verifyCode), $tmpId);
                echo 'success';
            } else {
                echo Yii::t('memberHome', '发送失败,请重试');
            }

            Yii::app()->end();
        }
    }

    public function actionTest()
    {
        var_dump($_POST);
    }
    
    public function actionMobileExits(){
        $mobile=$this->getParam('mobile');
        $msg=0;
        if ($this->isAjax()) {
            if ($mobile) {
               //判断手机号码是否存在
                $exists = Member::model()->exists('mobile = :mobile', array(':mobile' => $mobile));
                if($exists)
                    $msg=1;
                else 
                    $msg=0;
            }
            echo $msg;
        } 
    }
}