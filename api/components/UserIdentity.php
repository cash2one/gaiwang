<?php

/**
 * api身份验证
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    private $_memberData;

    public function authenticate() {
        /** @var Member $user */
        $user = Member::model()->find('username=:params or gai_number=:params or mobile=:params', array(':params' => $this->username));
//        if (!$user) {
//            $store = Store::model()->find('name=:name', array(':name' => $this->username));
//            if ($store) $user = Member::model()->findByPk($store->member_id);
//        }
        if (!$user)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            if($user->status==$user::STATUS_DELETE || $user->status==$user::STATUS_REMOVE){
                $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
                $this->errorMessage = Yii::t('home',$this->username.'已经被'.$user::status($user->status).'，禁止登录');
            }else{
                $this->_id = $user->id;
                $this->username = empty($user->username)? $user->gai_number : $user->username;
                $this->errorCode = self::ERROR_NONE;
                $this->_memberData = $user->attributes;
                $this->setPersistentStates(array('gw'=>$user->gai_number)); //保存用户数据 到 Yii::app()->user
            }

        }
        //验证出错，则session设置需要验证码的标记
//        if ($this->errorCode > 0)
//            Yii::app()->user->setState('captchaRequired', 1);
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

    public function getMemberData() {
        return $this->_memberData;
    }
}