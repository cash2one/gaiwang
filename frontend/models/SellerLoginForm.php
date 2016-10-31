<?php

/**
 * 商家登录模型
 * @author wanyun.liu <wanyun.liu@163.com>
 */
class SellerLoginForm extends CFormModel {

    public $username;
    public $password;
    public $verifyCode;
    private $_identity;

    public function rules() {
        return array(
            array('username, password', 'required'),
            array('password', 'authenticate'),
            array('verifyCode', 'captcha', 'allowEmpty' => !CCaptcha::checkRequirements()),
            array('username, password', 'safe')
        );
    }

    public function attributeLabels() {
        return array(
            'username' => Yii::t('home', '用户名'),
            'password' => Yii::t('home', '密码'),
            'verifyCode' => Yii::t('home', '验证码')
        );
    }

    public function authenticate($attribute, $params) {
        if (!$this->hasErrors()) {
            $this->_identity = new SellerUserIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate()) {
                if (empty($this->_identity->errorMessage)) {
                    $this->addError('password', Yii::t('home', '用户名或密码错误'));
                } else {
                    $this->addError('username', $this->_identity->errorMessage);
                }
            }
        }
    }

    public function login() {
        if ($this->_identity === null) {
            $this->_identity = new SellerUserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === SellerUserIdentity::ERROR_NONE) {
            $duration = 3600 * 24 * 1; // 1 days
            Yii::app()->user->login($this->_identity, $duration);
            Yii::app()->user->setState('enterpriseId', $this->_identity->getEnterpriseId());
//            Yii::app()->user->setState('assistantId', $this->_identity->getAssistantId()); 已经移动到SellerUserIdentity 103
            $this->afterLoginUpdate($this->_identity->getMember());
            return true;
        } else
            return false;
    }

    /**
     * 登录后更新相关数据
     * @param $member Member
     */
    public function afterLoginUpdate($member) {
        $assistantId = $this->_identity->getAssistantId();
        if($assistantId){ //店小二登录
            $assistant = Assistant::model()->findByPk($assistantId);
            $assistant->logins = $assistant->logins+1;
            $assistant->save(false);
        }else{
            $member->logins = $member->logins + 1;
            $member->last_login_time = $member->current_login_time;
            $member->current_login_time = time();
            $member->save(false);
            //登录记录
            LoginHistory::create($member->id);
        }
        /**
         * 以下注释内容，被移动到 frontend/components/SellerUserIdentity.php
         */
        // 记录会员类型及GW号
//        Yii::app()->user->setState('typeId', $member->type_id);
//        Yii::app()->user->setState('gw', $member->gai_number);

        //设置企业店铺相关session,店铺是store表，由会员在卖出中心申请
//        if ($member->is_enterprise==$member::ENTERPRISE_YES) {
//            /** @var Store $store */
//            $store = Store::model()->findByAttributes(array('member_id'=>$member->id));
//            if ($store) {
//                Yii::app()->user->setState('storeId', $store->id);
//                Yii::app()->user->setState('storeStatus', $store->status);
//            }
//        }
        /**
         * 登陆后.刷新购物车
         */
        $shopCart = new ShopCart();
        $shopCart->sync();
    }

}
