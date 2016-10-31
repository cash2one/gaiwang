<?php

/**
 * 前台会员登录模型
 *  @author zhenjun_xu <412530435@qq.com>
 */
class LoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    public $verifyCode;
    private $_identity;
    public $token;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('verifyCode', 'comext.validators.requiredExt', 'allowEmpty' => !self::captchaRequirement()),
            array('verifyCode', 'captcha', 'allowEmpty' => !self::captchaRequirement()),
            array('username', 'required'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => Yii::t('home', '用户名'),
            'password' => Yii::t('home', '密码'),
            'verifyCode' => Yii::t('home', '验证码'),
            'rememberMe' => Yii::t('home', '自动登录'),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()) {
                if (empty($this->_identity->errorMessage)) {
                    $lastTime=Tool::cache($this->username.'_login_LastTime')->get($this->username.'_login_LastTime');
                    $loginTimes=Tool::cache($this->username.'_login_times')->get($this->username.'_login_times');
                    //$this->addError('password', Yii::t('home', $loginTimes.'---'.$lastTime.'--------'.time()));
                    if($loginTimes > 5 && $lastTime){
                      $gqtime=ceil(($lastTime+600-time())/60);
                      $this->addError('password', Yii::t('home', '密码错误超过6次，请于'.$gqtime.'分钟后重新登陆'));
                    }
                    $this->addError('password', Yii::t('home', '用户名或密码错误,还有'.(6-$loginTimes).'次登陆机会'));
                } else {
                    $this->addError('username', $this->_identity->errorMessage);
                }
            }
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
             $siteConfig = Tool::getConfig($name = 'site');
//            $content = file_get_contents(Yii::getPathOfAlias('common') . '/webConfig/site.config.inc');
//            $siteConfig = unserialize(base64_decode($content));
            $duration = $this->rememberMe ? 3600 * 24 * $siteConfig['duration'] : 3600; // 7 days
            Yii::app()->user->login($this->_identity, $duration);
            $this->afterLoginUpdate($this->_identity->getMember());
            Yii::app()->db->createCommand()->insert("{{member_login_log}}", array('member_id'=>$this->_identity->getId(),'ip'=>Tool::getClientIP(),'login_time'=>time()));
            return true;
        } else
            return false;
    }

    /**
     * 检查是否需要输入验证码，当用户登录失败一次，则开启验证码
     * @return type
     */
    public static function captchaRequirement() {
        return Yii::app()->user->getState('captchaRequired') && CCaptcha::checkRequirements();
    }

    /**
     * 登录后更新相关数据
     * @param $member Member
     */
    public function afterLoginUpdate($member) {
        $member->logins = $member->logins + 1;
        $member->last_login_time = $member->current_login_time;
        $member->current_login_time = time();
        $member->save(false);
        //登录记录
        LoginHistory::create($member->id);
        if(Yii::app()->user->getState('enterpriseId')){
            SellerLog::create(SellerLog::CAT_LOGIN, SellerLog::logTypeUpdate, 0, '登录成功');
        }
        /**
         * 以下注释内容，被移动到 frontend/components/UserIdentity.php
         */
//        // 记录会员类型及GW号
//        Yii::app()->user->setState('typeId', $member->type_id);
//        Yii::app()->user->setState('gw', $member->gai_number);
//
//        //设置企业店铺相关session,店铺是store表，由会员在卖出中心申请
//        if ($member->is_enterprise==$member::ENTERPRISE_YES) {
//            /** @var Store $store */
//            $store = Store::model()->findByAttributes(array('member_id'=>$member->id));
//            if ($store) {
//                Yii::app()->user->setState('storeId', $store->id);
//                Yii::app()->user->setState('storeStatus', $store->status);
//                SellerLog::create(SellerLog::CAT_LOGIN,SellerLog::logTypeUpdate,0,'登录成功');
//            }
//        }
//        /**
//         * 企业会员相关信息，只有是企业会员才能登陆卖家平台
//         */
//        /** @var Enterprise $infoModel */
//        $infoModel = Enterprise::model()->findByAttributes(array('member_id' => $member->id));
//        if ($infoModel) {
//            Yii::app()->user->setState('enterpriseId', $infoModel->id);
//            Yii::app()->user->setState('enterpriseAuditing', $infoModel->auditing);
//        }
        /**
         * 登陆后.刷新购物车
         */
        $shopCart = new ShopCart();
        $shopCart->sync();
    }

}
