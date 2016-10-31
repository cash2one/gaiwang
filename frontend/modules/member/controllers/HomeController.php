<?php

/**
 * 会员中心控制器
 * 操作(登录、退出、注册、重置密码)
 * @author zhenjun_xu <412530435@qq.com>
 */
class HomeController extends Controller
{

    public $showTitle;
    public $model;
    const LOGIN_ADV = 'login_adv';

    public function init()
    {
        parent::init();
        $this->showTitle = Yii::t('memberHome', '欢迎注册');
        Yii::app()->setComponents(array(
            'errorHandler' => array(
                'class' => 'CErrorHandler',
                'errorAction' => '/site/error',
            )));
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'height' => '30',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
                'testLimit' => 30,
            ),
            'captcha2' => array(
                'class' => 'CaptchaAction',
                'height' => '30',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
                'testLimit' => 0,
            ),
        );
    }

    /**
     * 会员登录
     */
    public function actionLogin()
    {
 
        $this->layout = 'reg';

        $this->pageTitle = Yii::t('memberHome', '用户登录_盖网_盖象商城');
        $this->showTitle = Yii::t('memberHome', '用户登录');
        $model = new LoginForm;
        $model->username = $this->getCookie('uname');
        $this->performAjaxValidation($model);
        
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->homeUrl);
        $users = array();
        $adver = array();
        $adver = Advert::getChannelIndexAdver(self::LOGIN_ADV,1);

        //登录的时候用session记录来路
        if(!isset($_POST['LoginForm'])){
            if(isset(Yii::app()->user->returnUrl)){
                if( strpos(Yii::app()->user->returnUrl, 'member') === false ){
                    $returnUrl = Yii::app()->user->returnUrl;
                    if(isset($_SERVER['HTTP_REFERER']) && $returnUrl=='/'){
                        $returnUrl = $_SERVER['HTTP_REFERER'];
                    }
                    //不是购物车、支付页面，加 member
                    if(stripos($returnUrl,'order/pay')===false && stripos($returnUrl,'orderFlow')===false && stripos($returnUrl,DOMAIN)===false){
                        $returnUrl = '/member'.$returnUrl;
                    }
                    if(stripos($returnUrl,DOMAIN)===false){
                        Yii::app()->session['login_referer'] = $this->createAbsoluteUrl($returnUrl);
                    }else{
                        Yii::app()->session['login_referer'] = $returnUrl;
                    }

                }
            }else{
                if(isset($_SERVER['HTTP_REFERER'])){
                    if( strpos($_SERVER['HTTP_REFERER'], 'member') === false ){
                        Yii::app()->session['login_referer'] = $_SERVER['HTTP_REFERER'];
                    }
                }
            }
        }
        if (isset($_POST['LoginForm'])) {
            $RsaPassword = new RsaPassword();
            $model->attributes = $RsaPassword->decryptPassword($this->getPost('LoginForm'));
            if (isset($_POST['gai_number'])) {
                $model->username = $_POST['gai_number'];
            }
            //手机号登录，多个账号情况
            if (is_numeric($model->username)) {

                $users = Yii::app()->db->createCommand()->select('gai_number')
                    ->from('{{member}}')->where('mobile=:m', array(':m' => $model->username))->queryAll();
                if (count($users) > 1) {
                    $tmpUsers = array();
                    foreach ($users as $k => $v) {
                        $tmpUsers[$v['gai_number']] = $v['gai_number'];
                    }
                    $users = $tmpUsers;
                    $model->addError('username', '');
                } else {
                    $users = array();
                }
            }
            if ($model->validate(null, false) && $model->login()) {
                $this->setCookie('uname', $model->username, 3600 * 30 * 365);

                /*$phone = Member::getUserInfoByGw($model->username); //  检测手机是否绑定
                if(empty($phone['mobile'])){
                    $this->redirect('/member/mobile');
                }*/

                $flag = Yii::app()->db->createCommand()->select('flag')
                    ->from('{{member}}')->where('id=:id', array(':id' => $this->getUser()->id))->queryScalar();
                if($flag==Member::FLAG_NO){
                     $this->setSession('activation','登录并激活');
                }else{
                    //不是首页进来的,跳转到来路页面
                    $redirectUrl = Yii::app()->session['login_referer'] ? Yii::app()->session['login_referer'] : $this->createAbsoluteUrl('');;

                    if (stripos(Yii::app()->user->returnUrl, 'logout') === false) {
                        Yii::app()->session['login_redirect_confirm'] = false;
                        Yii::app()->session['login_redirect'] = $redirectUrl;
                        $this->redirect(DOMAIN.'/confirm/index');
                        // $this->redirect(Yii::app()->homeUrl);
                    } else {
                        $this->redirect(array('/member'));
                    }
                }
            }
        }

        $this->render('login', array('model' => $model, 'users' => $users,'adver'=>$adver));
        
    }

    /**
     * 会员激活
     */
    public function actionActivation(){
        $model = Member::model()->findByPk($this->getUser()->id);
        $model->flag = Member::FLAG_YES;
        $model->activation_time = time();
        $model->save(false);
        $this->setSession('activation',null);
        Yii::app()->user->logout();
        if (stripos(Yii::app()->user->returnUrl, 'logout') === false) {
            $this->redirect(Yii::app()->user->returnUrl);
        } else {
            $this->redirect(array('/member'));
        }
    }

    /**
     * 普通会员注册
     */
    public function actionRegister()
    {    
        if (!$this->getUser()->isGuest) {
            $this->redirect(DOMAIN);
        }
        $this->layout = 'reg';
        $this->pageTitle = Yii::t('memberHome', '注册_填写账户信息_盖网_盖象商城');
        $model = new Member('register');
        $this->performAjaxValidation($model);
        $ad = $this->getParam('ad');
        if(!empty($ad))
        {
            $sql = "update {{promotion_channels}} set visits = visits + 1 where number = '{$ad}'";
            Yii::app()->db->createCommand($sql,array(':number'=>$ad))->execute();
        }
        if (isset($_POST['Member'])) {

            $attributes = $this->getPost('Member');
            //解密密码
            $RsaPassword = new RsaPassword();
            $attributes = $RsaPassword->decryptPassword($attributes);
            $model->attributes = $attributes;
            //更新推荐时间
            if (!empty($_POST['Member']['tmp_referrals_id'])) {
                $model->referrals_time = time();
            }
            //如果没有显示验证码，则赋值验证码，用于规则检查
//            if($this->getSession('showCaptcha')!=3){
//                $captcha = Yii::app()->getController()->createAction("captcha2");
//                $code = $captcha->verifyCode;
//                $model->verifyCode = $code;
//            }
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
                    //给推荐者派发红包
                    RedEnvelopeTool::createRedisActivity($model->referrals_id, RedisActivity::SOURCE_TYPE_ONLINE, Activity::TYPE_SHARE);
                }
                //给新注册的会员派发红包
                RedEnvelopeTool::createRedisActivity($model->id, RedisActivity::SOURCE_TYPE_ONLINE, Activity::TYPE_REGISTER);
                if(isset($ad) && !empty($ad))
                    PromotionChannels::addMemberFromPromotion($model->id,$ad);
                $trans->commit();
            } catch (Exception $e) {
                $trans->rollback();
                throw new CHttpException(503, Yii::t('memberHome', '注册失败!'.$e->getMessage()));
            }
            //同步注册到盖讯通
            if(defined('IS_STARTGXT') && IS_STARTGXT) {
                $nickname = !empty($model->nickname) ? $model->nickname : $model->gai_number;
                Member::getSynchronous($model->gai_number,$_POST['Member']['password'],$nickname,$model->mobile,GXT_PASSWORD_KEY);
            }
            //注册后自动登录
            $loginForm = new LoginForm;
            $loginForm->username = $model->gai_number;
            $loginForm->password = $attributes['password'];
            $loginForm->login();
            $this->redirect(array('/member/home/tipDefault'));
        }
        $this->render('register', array('model' => $model));
    }

    /**
     * 用户名快速注册
     * @date 2014-12-3
     * @author binbin.liao 修改
     */
    public function actionQuickRegister()
    {
        if (!$this->getUser()->isGuest) {
            $this->redirect(DOMAIN);
        }
        $this->layout = 'reg';
        $this->pageTitle = Yii::t('memberHome', '注册_填写账户信息_盖网_盖象商城');
        $model = new Member('quickRegister');
        $this->performAjaxValidation($model);

        $ad = $this->getParam('ad');
        if(!empty($ad))
        {
            $sql = "update {{promotion_channels}} set visits = visits + 1 where number = '{$ad}'";
            Yii::app()->db->createCommand($sql,array(':number'=>$ad))->execute();
        }
        if (isset($_POST['Member'])) {
            $attributes = $this->getPost('Member');
            //解密密码
            $RsaPassword = new RsaPassword();
            $attributes = $RsaPassword->decryptPassword($attributes);
            $model->attributes = $attributes;
            //更新推荐时间
            if (!empty($_POST['Member']['tmp_referrals_id'])) {
                $model->referrals_time = time();
            }
            $trans = Yii::app()->db->beginTransaction();
            try {
                if (!$model->save()) {
                    throw new Exception('create member error');
                }
                //保存推荐记录
                if (!empty($model->referrals_id)) {
                    $recommend_log = new RecommendLog();
                    $recommend_log->member_id = $model->id;
                    $recommend_log->parent_id = $model->referrals_id;
                    $recommend_log->create_time = $model->referrals_time;
                    $recommend_log->save();
                }
                if(isset($ad) && !empty($ad))
                    PromotionChannels::addMemberFromPromotion($model->id,$ad);
                $trans->commit();
            } catch (Exception $e) {
                $trans->rollback();
                throw new CHttpException(503, Yii::t('memberHome', '注册失败!'.$e->getMessage()));
            }
            //同步注册到盖讯通
            if(defined('IS_STARTGXT') && IS_STARTGXT) {
                $nickname = !empty($model->nickname) ? $model->nickname : $model->username;
                Member::getSynchronous($model->gai_number,$_POST['Member']['password'],$nickname,$model->mobile,GXT_PASSWORD_KEY);
            }
            //注册后自动登录
            $loginForm = new LoginForm;
            $loginForm->username = $model->username;
            $loginForm->password = $attributes['password'];
            $loginForm->login();
            $url = Yii::app()->createAbsoluteUrl('/member/home/tipDefault');
            $this->redirect($url);
        }

        $this->render('registerquick',array('model'=>$model));
    }

    /**
     * 普通会员注册，提示信息
     * @author binbin.liao 修改
     */
    public function actionTipDefault()
    {
        $this->layout = 'reg';
        $this->pageTitle = Yii::t('memberHome', '注册成功提示信息_盖网_盖象商城');
        $model = Member::model()->find(array(
            'select' => 'id,username,gai_number,mobile,type_id',
            'condition' => 'id = :id',
            'params' => array(':id' => $this->getUser()->id)
        ));
        $this->render('tipdefault', array('model' => $model));
    }

    /**
     * 普通会员注册，完成注册页面
     */
    public function actionRegisterStep3()
    {
        $this->layout = 'reg';
        $this->pageTitle = Yii::t('memberHome', '盖象商城-普通用戶注册step3');
        $model = Member::model()->findByPk($this->getUser()->id);
        $this->render('registerstep3', array('model' => $model));
    }
    
    /**
     * ajax 获取验证码
     */
    public function actionGetCaptcha(){    
          header('Content-Type:text/html;charset=utf-8');
         if(Yii::app()->request->isAjaxRequest){
           $captcha = Yii::app()->getController()->createAction("captcha2");
                $code = $captcha->verifyCode;
               echo $code;
        }
         Yii::app()->end();
    }
    /**
     * ajax 获取手机验证码
     */
    public function actionGetMobileVerifyCode()
    {                    
        if (Yii::app()->request->isAjaxRequest && isset($_POST['mobile']) && preg_match("/(^\d{11}$)|(^852\d{8}$)/", $_POST['mobile'])) {          
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
                  SmsLog::addSmsLog($_POST['mobile'], $msg,0,  SmsLog::TYPE_CAPTCHA,null,true,array($verifyCode), $tmpId);
//                SmsLog::addSmsLog($_POST['mobile'], $msg);
                echo 'success';
            } else {
                echo Yii::t('memberHome', '发送失败,请点此重试');
            }

            Yii::app()->end();
        }
    }

    /**
     * 获取语音验证码
     */
    public function actionGetMobileVerifyCall(){

        if (!Yii::app()->request->isAjaxRequest) {
           exit;
        }
        /**
         * 如果是登录状态没有传递手机号码，则查询手机号
         */
        if(isset($_POST['mobile']) && !empty($_POST['mobile'])){
            $mobile = $_POST['mobile'];
        }else{
            $member = Member::model()->find(array('select'=>'mobile','condition'=>'id='.$this->getUser()->id));
            $mobile = $member->mobile;
            if(empty($mobile)) $mobile = $_POST['mobile'];
        }
        if(!preg_match("/(^\d{11}$)/", $mobile)) exit($mobile);;
        $verifyCodeCheck = $this->getSession($mobile);
        if ($verifyCodeCheck) {
            $verifyArr = unserialize(Tool::authcode($verifyCodeCheck, 'DECODE'));
            if ($verifyArr && (time() - $verifyArr['time'] < 60)) {
                echo Yii::t('memberHome', '请等待{time}秒后重试', array('{time}' => '60'));
                Yii::app()->end();
            }
        }
        //$verifyCode = '000000';
        $verifyCode = mt_rand(10000, 99999);
        $data = array('time' => time(), 'verifyCode' => $verifyCode);
        //验证码同时写cookie\session 防止丢失
        $this->setCookie($mobile, Tool::authcode(serialize($data), 'ENCODE', '', 60 * 5), 60 * 5);
        $this->setSession($mobile, Tool::authcode(serialize($data), 'ENCODE', '', 60 * 5));

        if (Yii::app()->request->cookies[$mobile]) {
            Sms::voiceVerify($verifyCode,$mobile);
            echo 'success';
        } else {
            echo Yii::t('memberHome', '操作失败,请重试');
        }
        Yii::app()->end();
    }

    /**
     * 企业注册
     */
    public function actionRegisterEnterprise()
    {

        if (!$this->getUser()->isGuest) {
            $this->redirect(DOMAIN);
        }
        $this->layout = 'reg';
        $this->pageTitle = Yii::t('memberHome', '企业注册_填写账户信息_盖网_盖象商城');
        $model = new Member('regEnterprise');
        $modelEnterprise = new Enterprise('register');
        $model->is_enterprise = $model::ENTERPRISE_YES;
        $this->performAjaxValidation($model);
        $this->performAjaxValidation($modelEnterprise);
//        $category = Category::getTopCategory();
        if (isset($_POST['Member']) && isset($_POST['Enterprise'])) {
            //解密密码
            $RsaPassword = new RsaPassword();
            $attributes = $RsaPassword->decryptPassword($this->getPost('Member'));
            $model->attributes = $attributes;
//            var_dump($this->getPost('Member'));exit;
            $modelEnterprise->attributes = $_POST['Enterprise'];
            $modelEnterprise->name = $model->username;
            $modelEnterprise->mobile = $model->mobile;
            $modelEnterprise->email = $model->email;
            $modelEnterprise->flag = Enterprise::FLAG_ONLINE;
            $trans = Yii::app()->db->beginTransaction();

            //更新推荐时间
            if (!empty($_POST['Member']['tmp_referrals_id'])) {
                $model->referrals_time = time();
            }

            try {
                if (!$modelEnterprise->save()) {
                    throw new Exception('create enterprise error');
                }
                $model->enterprise_id = $modelEnterprise->id;
                if (empty($model->enterprise_id)) throw new Exception('Enterprise is empty');
                if (!$model->save()) {
                    throw new Exception('create Member error');
                }

                //保存推荐记录
                if (!empty($model->referrals_id)) {
                    $recommend_log = new RecommendLog();
                    $recommend_log->member_id = $model->id;
                    $recommend_log->parent_id = $model->referrals_id;
                    $recommend_log->create_time = $model->referrals_time;
                    $recommend_log->save();
                }
                $trans->commit();
                //同步注册到盖讯通
                if(defined('IS_STARTGXT') && IS_STARTGXT) {
                    $nickname = !empty($model->nickname) ? $model->nickname : $model->gai_number;
                    Member::getSynchronous($model->gai_number,$_POST['Member']['password'],$nickname,$model->mobile,GXT_PASSWORD_KEY);
                }
                //自动登录
                $loginForm = new LoginForm;
                $loginForm->username = $model->gai_number;
                $loginForm->password = $attributes['password'];
                $loginForm->login();
                $this->redirect(array('home/enterpriseRegisterComplete'));
            } catch (Exception $e) {
                $trans->rollback();
                $this->setFlash('error', Yii::t('memberHome', '注册失败!'));
            }            
        }


        $this->render('registerenterprise', array(
            'model' => $model,
            'modelEnterprise' => $modelEnterprise,
//            'category' => $category,
        ));
    }

    /**
     * 企业会员注册完成页面
     */
    public function actionEnterpriseRegisterComplete()
    {
        $this->layout = 'reg';
        $this->pageTitle = Yii::t('memberHome', '盖象商城-企业用户注册完成');
        $model = Member::model()->find(array(
                'select' => 'id,gai_number',
                'condition' => 'id = :id',
                'params' => array(':id' => $this->getUser()->id)
        ));
        $this->render('enterpriseRegisterComplete',array('model'=>$model));
    }

    /**
     * 重置密码
     */
    public function actionResetPassword()
    {
        $users = array();
        $this->pageTitle = Yii::t('memberHome', '找回密码');
        $this->layout = 'reg';
        $model = new Member('resetPassword');
        if (!isset($_POST['Member']['password'])) {
            $model->rules = array(
                array('username', 'required', 'on' => 'resetPassword', 'message' => Yii::t('memberHome', '请输入您的已验证手机/盖网编号/用户名/邮箱')),
                array('verifyCode', 'captcha', 'allowEmpty' => false),
                array('verifyCode', 'required'),

            );
            $model->scenario = "FindPassCheck";
        }
        $this->performAjaxValidation($model);
        $members = array();
        if (isset($_POST['Member'])) {
            $model->attributes = $this->getPost('Member');
            if (isset($_POST['Member']['gai_number'])) {
                $model->username = $_POST['Member']['gai_number'];
                $model->gai_number = null;
            }

            if ($model->validate()) {
                if ($model->username) {
                    //第一步，输入已验证手机/盖网编号/用户名/邮箱
                    $members = Member::model()->findAll('username=:params or gai_number=:params or mobile=:params or email=:params', array(
                        ':params' => $model->username,
                    ));
                    if (count($members) > 1) {
                        $model->addError('username', Yii::t('memberHome', '找到多个账户注册了') . $model->username . Yii::t('memberHome', ',请选择：'));

                        foreach($members as $key => $value){
                            $users[$value->gai_number] = $value->gai_number;
                        }
                    } else if (!$members) {
                        $model->addError('username', $model->username . '未注册');
                    } else {
                        $model->mobile = $members[0]->mobile;
                        if (empty($model->mobile)) {
                            $model->addError('username', $model->username . Yii::t('memberHome', '未验证手机号，无法找回密码，请联系客服'));
                        } else {
                            $model->username = $members[0]->username;
                            $model->id = $members[0]->id;
                            $model->gai_number = $members[0]->gai_number;
                        }
                    }

                } else {
                    $RsaPassword = new RsaPassword();
                    $model->attributes = $RsaPassword->decryptPassword($this->getPost('Member'));
                    //修改密码
                    /** @var  $findOneMember  Member */
                    $findOneMember = Member::model()->findByPk(Tool::authcode($_POST['Member']['id'], 'DECODE'));
                    if ($findOneMember) {
                        if ($findOneMember->mobile == $_POST['Member']['mobile']) {
                            $findOneMember->password = $model->password;
                            $findOneMember->scenario = 'updatePassword';
                            $findOneMember->save(false);
                            //同步修改密码到盖讯通
                            if(defined('IS_STARTGXT') && IS_STARTGXT) {
                                Member::getUpdatePassword($model->gai_number,$_POST['Member']['password'],GXT_PASSWORD_KEY);
                            }
                            $this->redirect(array('home/resetPasswordComplete','g_num'=>$findOneMember->gai_number,'returnUrl'=>$this->getParam('returnUrl')));
                        } else {
                            $model->addError('username', Yii::t('memberHome', '警告：非法操作'));
                        }
                    }
                }

            }
        }
        $this->render('resetpassword', array('model' => $model, 'members' => $members,'users'=>$users));
    }

    /**
     * 重置密码 完成提示页面
     */
    public function actionResetPasswordComplete()
    {
        $this->pageTitle = Yii::t('memberHome', '盖象商城-找回密码完成');
        $this->layout = 'reg';
        $this->render('resetpasswordcomplete',array('g_num'=>$_GET['g_num'],'returnUrl'=>$this->getParam('returnUrl')));
    }

    /**
     * 退出登录
     */
    public function actionLogout()
    {
		header("Content-type:text/html;charset=UTF-8");
        header("Expires: Mon, 20 Jul 2015 00:00:00 GMT");
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
		
//        Tool::pr(Yii::app()->user);
        Yii::app()->user->logout();
        $this->redirect(array('/member/home/login'));
    }

    /**
     * 判断登陆状态,如果登陆成功,就跳转到会员中心页面.
     * 因为某些浏览器第一次不会跳转到会员中心页面
     * @author binbin.liao
     * @date 2014-12-15
     */
    public function actionCheckLogin(){
        $status['status'] = false;
        if(!Yii::app()->user->isGuest){
            $status['status'] = true;
        }
        exit(CJSON::encode($status));
    }

    /**
     * 普通会员升级企业会员
     * @throws CDbException
     */
    public function actionMemberUpgrade(){

        $this->pageTitle = Yii::t('memberHome','升级为企业会员_').$this->pageTitle;
        $this->showTitle = Yii::t('memberHome','欢迎升级');
        $this->layout = 'reg';

        $model = new Member();
        $model ->setScenario('upgrade');

        $enterprise = new Enterprise('register');
        $model->is_enterprise = $model::ENTERPRISE_YES;
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'member-form') {
            $validate =  json_decode(CActiveForm::validate($enterprise),true);
            $validate2 =  json_decode(CActiveForm::validate($model,array('password')),true);
            $validateAll = array_merge($validate,$validate2);
            echo json_encode($validateAll);
            Yii::app()->end();
        }

        if(isset($_POST['Member'])){
            Yii::app()->session['tryLoginCount'] = 0; //清除session
            $model->attributes = $this->getParam('Member');
            $enterprise->attributes = $this->getParam('Enterprise');
            $enterprise->flag = Enterprise::FLAG_ONLINE;
            $enterprise->auditing = Enterprise::AUDITING_NO;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                if($model->validate(array('password'))) {
                    $Member = Member::model()->find(array('condition' => 'gai_number=:gai_number', 'params' => array(':gai_number' => $model->gai_number)));
                    if ($Member) {
                        if ($Member->enterprise_id) {
                            $this->setFlash('error', Yii::t('member', '您已经是企业会员,不用升级！'));
                            $this->_login($model->gai_number,$model->password);
                            $this->redirect($this->createAbsoluteUrl('/member/site/index'));
                        }else{
                            if ($enterprise->save()) {
                                $Member->enterprise_id = $enterprise->id;
                                if($Member->update(array('enterprise_id'))){
                                    $transaction->commit();
                                    $this->setFlash('success',Yii::t('member','升级企业会员成功，请提交网络店铺签约资料！'));
                                    $this->_login($model->gai_number,$model->password);
                                    $this->redirect($this->createAbsoluteUrl('enterpriseLog/enterprise'));
                                }else{
                                    throw new Exception('member update error'.CHtml::errorSummary($Member));
                                }
                            }else{
                                throw new Exception('enterprise add error');
                            }
                        }
                    }else{
                        throw new Exception(Yii::t('member', '盖网编号或密码错误！'));
                    }
                }
            }catch (Exception $e){
                $transaction->rollback();
                $this->setFlash('error', Yii::t('member', '升级企业会员失败！').$e->getMessage());
            }
        }
        $this->render('memberUpgrade',array('model'=>$model,'enterprise'=>$enterprise));
    }

    /**
     * 自动登陆
     * @param $gai_number
     * @param $password
     */
    public function _login($gai_number,$password){
        $loginForm = new LoginForm;
        $loginForm->username = $gai_number;
        $loginForm->password = $password;
        $loginForm->login();
    }

//        /*
//     * 测试
//     */
//    public function actionRedis(){
//        $tmpId= $this->getParam('id');
//        $data = $this->getParam('datas');
//        $phone = $this->getParam('phone');
//        if(empty($tmpId)){
//            $tmpId=null;
//        }
//         if(empty($data)){
//            $data=null;
//        }
//        $this->layout=false;
////        @$rs = SmsLogTest::addSmsLog(13760671419, '测试',0, SmsLogTest::TYPE_CAPTCHA,  null, true, array('123'), $tmpId=73711, SmsLog::GW_SEND_SMS);
//        $rs = SmsLogTest::addSmsLog($phone, '123456789这是个测试例子',0, 0, null, true, array($data), $tmpId, SmsLog::GW_SEND_SMS);
//        echo 123;die;
//    }
//       public function actionRediscode(){
//           $tmpId= $this->getParam('id');
//            $data = $this->getParam('datas');
//           $phone = $this->getParam('phone');
//        if(empty($tmpId)){
//            $tmpId=null;
//        }
//         if(empty($data)){
//            $data=null;
//        }
//        $this->layout=false;
//        @$rs = SmsLogTest::addSmsLog($phone, '123456789这是个测试例子2',0, SmsLogTest::TYPE_CAPTCHA,  null, true, array($data), $tmpId, SmsLog::GW_SEND_SMS);
////        @$rs = SmsLogTest::addSmsLog(13760671419, '测试',0, 0, null, true, array('321'), 73711, SmsLog::GW_SEND_SMS);
//        echo 123;die;
//    }

}
