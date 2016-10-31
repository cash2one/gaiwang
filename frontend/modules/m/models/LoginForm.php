<?php

/**
 *  微商城登录模型
 *  @author xiaoyan.luo<xiaoyan.luo@gatewang.com>
 */
class LoginForm extends CFormModel {

    public $username;
    public $password;
    public $rememberMe;
    public $verifyCode;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('username, password', 'required','message'=>'{attribute}不可为空'),
            array('password', 'authenticate'),
            array('rememberMe', 'boolean'),
            array('verifyCode', 'captcha', 'allowEmpty' => !self::captchaRequirement()),
            array('verifyCode', 'comext.validators.requiredExt', 'allowEmpty' => !self::captchaRequirement()),
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
            'rememberMe' => Yii::t('home','自动登录'),
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
                    if($loginTimes>5 && $lastTime){
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
            $duration = $this->rememberMe ? 3600 * 24 * $siteConfig['duration'] : 0; // 7 days
            Yii::app()->user->login($this->_identity, $duration);
            $this->afterLoginUpdate($this->_identity->getMember());
            Yii::app()->db->createCommand()->insert("{{member_login_log}}", array('member_id'=>$this->_identity->getId(),'ip'=>Tool::getClientIP(),'login_time'=>time()));
            return true;
        } else
            return false;
    }

    /**
     * 检查是否需要输入验证码，当用户登录失败三次，则开启验证码
     * @return boolean
     */
    public static function captchaRequirement() {
        $loginTimes = (int)Yii::app()->user->getState('login_error_times');
        if($loginTimes > 2 && CCaptcha::checkRequirements()){
            return true;
        }else{
            return false;
        }
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
    }

}