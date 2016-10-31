<?php

class UserIdentity extends CUserIdentity {

    private $_id;

	public function authenticate() {
        /** @var Member $user */
        $user = Member::model()->find('username=:params or gai_number=:params or mobile=:params', array(
            ':params' => $this->username,
        ));
        
        if (!$user)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            if($user->status==$user::STATUS_DELETE || $user->status==$user::STATUS_REMOVE){
                $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
                $this->errorMessage = Yii::t('home','已经被'.$user::status($user->status).'，禁止登录');
            }
            else{
             if(count($user->region) == 0)
	         {
	        	$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
	        	$this->errorMessage = Yii::t('home', '该用户不是代理商');
	         }
	         else 
	         {
//	         	if(in_array($user->gai_number, array('GW69902407'))){
//	         		$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
//                	$this->errorMessage = Yii::t('home','禁止登录');
//	         	}else{
		         	$this->_id = $user->id;
	                $this->username = empty($user->username)? $user->gai_number : $user->username;
	                $agent_region = array();
	                foreach ($user->region as $region)
	                {
	                	$agent_region[] = array(
	                		'id'=>$region->id,
	                		'name'=>$region->name,
	                		'depth'=>$region->depth,
	                		'tree'=>$region->tree,
	                	);
	                }
	                $this->setState('agent_region', $agent_region); //保存用户数据 到 Yii::app()->user
	                $this->setState('gw', $user->gai_number);
	                $this->errorCode = self::ERROR_NONE;
	         	}
//	         }
            }

        }
        //验证出错，则session设置需要验证码的标记
        if ($this->errorCode > 0)
            Yii::app()->user->setState('captchaRequired', 1);
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }
}