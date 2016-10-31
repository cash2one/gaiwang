<?php

/**
 * 后台登录表单模型
 * @author chen.luo
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
            array('verifyCode', 'comext.validators.requiredExt', 'allowEmpty' => !self::captchaRequirement(), 'message' => '{attribute}不能为空！'),
            array('verifyCode', 'captcha', 'allowEmpty' => !self::captchaRequirement()),
            array('username, password', 'required', 'message' => '{attribute}不能为空！'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels() {
        return array(
            'username' => Yii::t('User', '用户名'),
            'password' => Yii::t('User', '密&nbsp;&nbsp;&nbsp;码'),
            'verifyCode' => Yii::t('User', '验证码'),
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
                    $this->addError('password', Yii::t('home', '用户名或密码错误'));
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
            return true;
        }
        else
            return false;
    }

    /**
     * 检查是否需要输入验证码，当用户登录失败一次，则开启验证码
     * @return type
     */
    public static function captchaRequirement() {
        return Yii::app()->user->getState('captchaRequired') && CCaptcha::checkRequirements();
    }

}
