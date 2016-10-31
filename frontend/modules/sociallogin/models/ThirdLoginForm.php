<?php

/**
 * 前台会员登录模型
 *  @author zhenjun_xu <412530435@qq.com>
 */
class ThirdLoginForm extends CFormModel {

    public $id;
    public $rememberMe;
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules() {
        return array(
            array('username, password', 'required'),
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
    public function thirdLogin() {
        if ($this->_identity === null) {
            $this->_identity = new ThirdUserIdentity($this->id,'');
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === ThirdUserIdentity::ERROR_NONE) {
            $siteConfig = Tool::getConfig($name = 'site');
            $duration = $this->rememberMe ? 3600 * 24 * $siteConfig['duration'] : 3600; // 7 days
            Yii::app()->user->login($this->_identity, $duration);
            $this->afterLoginUpdate($this->_identity->getMember());
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
         * 登陆后.刷新购物车
         */
        $shopCart = new ShopCart();
        $shopCart->sync();
    }

}
