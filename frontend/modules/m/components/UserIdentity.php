<?php

/**
 * 微商城身份验证
 * @author xiaoyan.luo<xiaoyan.luo@gatewang.com>
 */
class UserIdentity extends CUserIdentity
{

    private $_id;
    /** @var  $_member Member */
    private $_member;

    
    public $loginTimes;//缓存登陆错误次数
    public $lastTime;//缓存最后一次登陆错误时间
    
    public function authenticate()
    {
        $selectMember = 'id,username,password,gai_number,mobile,status,head_portrait,type_id,enterprise_id,salt,logins,last_login_time,current_login_time';
        $user = null;
        //手机号登录
        if(preg_match('/(^1[34578]{1}\d{9}$)|(^852\d{8}$)/',$this->username)){
            $user = Member::model()->findAll(array(
                'select'=>$selectMember,
                'condition'=>'mobile=:params order by is_master_account DESC limit 1',
                'params'=>array(':params'=>$this->username),
            ));
        }

        //用户名登录
        if(!$user && !preg_match('/GW\d{8,10}/',$this->username)){
            $user = Member::model()->findAll(array(
                'select'=>$selectMember,
                'condition'=>'username=:params order by is_master_account DESC limit 1',
                'params'=>array(':params'=>$this->username),
            ));
        }
        //gw号登录
        if(!$user && preg_match('/GW\d{8,10}/',$this->username)){
            $user = Member::model()->findAll(array(
                'select'=>$selectMember,
                'condition'=>'gai_number=:params order by is_master_account DESC limit 1',
                'params'=>array(':params'=>$this->username),
            ));
        }
        /** @var Member $user  三个一起找，再试一次*/
        if(!$user){
            $user = Member::model()->findAll(array(
                'select'=>$selectMember,
                'condition'=>'username=:params or gai_number=:params or mobile=:params order by is_master_account DESC limit 1',
                'params'=>array(':params'=>$this->username),
            ));
        }

        if ($user) $user = $user[0];
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
        $this->loginTimes=(int)Tool::cache($this->username.'_login_times')->get($this->username.'_login_times');
        $this->lastTime=Tool::cache($this->username.'_login_LastTime')->get($this->username.'_login_LastTime');
        
        if (!$user)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (!$user->validatePassword($this->password))
         {
         	$cacheKey=$this->username.'_login_times';
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            if($this->loginTimes > 6 && empty($this->lastTime)){
            	Tool::cache($this->username.'_login_times')->delete($this->username.'_login_times');
            	$this->loginTimes=0;
            } 
              $this->loginTimes++;
             Tool::cache($cacheKey)->set($cacheKey,$this->loginTimes);//连续输错后10分钟才可以再次输入
            if($this->loginTimes==6)
                Tool::cache($this->username.'_login_LastTime')->set($this->username.'_login_LastTime', time(), 60*10);//连续输错后10分钟才可以再次输入  	  	
            }
         else {
        	    if($this->loginTimes > 5 && $this->lastTime){
        	    return false;
        	  }
            if ($user->status == $user::STATUS_DELETE || $user->status == $user::STATUS_REMOVE) {
                $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
                $msg = Yii::t('home', '{username}已经禁用, 禁止登录');
                $msg = strtr($msg, array(
                    '{username}' => $this->username,
                ));
                $this->errorMessage = $msg;
            } else {
            	Tool::cache($this->username.'_login_times')->delete($this->username.'_login_times');
            	Tool::cache($this->username.'_login_LastTime')->delete($this->username.'_login_LastTime');
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
        if ($this->errorCode > 0){
            $loginErrorTimes = (int)Yii::app()->user->getState('login_error_times');
            if($loginErrorTimes === 0){
                $loginErrorTimes = 1;
            }else{
                $loginErrorTimes++;
            }
            Yii::app()->user->setState('login_error_times', $loginErrorTimes);
        }
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