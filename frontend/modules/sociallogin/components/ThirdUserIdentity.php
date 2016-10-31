<?php

/**
 *
 * 第三方登陆时验证，不验证登录密码
 * @author zhenjun.xu<412530435@qq.com>
 */
class ThirdUserIdentity extends CUserIdentity
{

    private $_id;
    /** @var  $_member Member */
    private $_member;

    public function authenticate()
    {
        $selectMember = 'id,username,password,gai_number,mobile,status,head_portrait,type_id,enterprise_id,salt,logins,last_login_time,current_login_time';
        /** @var Member $user */
        $user = Member::model()->find(array(
                'select'=>$selectMember,
                'condition'=>'id=:id ',
                'params'=>array(':id'=>$this->username),
        ));
        if (!$user) {
            $enterprise = Enterprise::model()->find(array(
                'select'=>'id,auditing,flag',
                'condition'=>'name=:name',
                'params'=>array(':name' => $this->username),
            ));
            if ($enterprise){
                $user = Member::model()->find(array(
                    'select'=>$selectMember,
                    'condition'=>'enterprise_id=:params',
                    'params'=>array(':params'=>$enterprise->id),
                ));
            }
        }
        if (!$user)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        /* else if (!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID; */
        else {
            if ($user->status == $user::STATUS_DELETE || $user->status == $user::STATUS_REMOVE) {
                $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
                $msg = Yii::t('home', '{username}已经禁用, 禁止登录');
                $msg = strtr($msg, array(
                    '{username}' => $user->gai_number,
                ));
                $this->errorMessage = $msg;
            } else {
                $this->_id = $user->id;
                $this->username = empty($user->username) ? $user->gai_number : $user->username;
                //保存必要的数据到session
                $states = array(
                    'avatar' => $user->head_portrait,
                    'typeId' => $user->type_id,
                    'gw' => $user->gai_number,
                    'selectLanguage'=>Yii::app()->user->getState('selectLanguage'),
                );
                if ($user->enterprise_id > 0 ) {
                    /** @var Store $store */
                    $store = Store::model()->find(array(
                        'select'=>'id,status',
                        'condition'=>'member_id=:mid',
                        'params'=>array(':mid'=> $user->id),
                    ));
                    if ($store) {
                        $states['storeId'] = $store->id;
                        $states['storeStatus'] = $store->status;
                    }
                }
                /** @var Enterprise $enterprise */
                if (!isset($enterprise)){
                    $enterprise = Enterprise::model()->find(array(
                        'select'=>'id,auditing,flag',
                        'condition'=>'id=:id',
                        'params'=>array(':id' => $user->enterprise_id),
                    ));
                }
                if ($enterprise) {
                    $states['enterpriseId'] = $enterprise->id;
                    $states['enterpriseFlag'] = $enterprise->flag;
                    $states['enterpriseAuditing'] = $enterprise->auditing;
                    if(isset($user->franchisee) && is_object($user->franchisee)){
                        $states['franchiseeId'] = $user->franchisee->id;
                    }
                }

                $this->setPersistentStates($states); //保存用户数据 到 Yii::app()->user
                $this->_member = $user;
                $this->errorCode = self::ERROR_NONE;
            }

        }
        //验证出错，则session设置需要验证码的标记
        if ($this->errorCode > 0)
            Yii::app()->user->setState('captchaRequired', 1);
        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getMember(){
        return $this->_member;
    }

}