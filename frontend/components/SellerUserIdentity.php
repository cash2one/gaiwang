<?php

/**
 * 商家用户验证类
 * @author wanyun.liu <wanyun@163.com>
 */
class SellerUserIdentity extends CUserIdentity
{

    private $_id;
    private $_enterpriseId;
    /** @var  int 店小二 id */
    private $_assistantId;
    /** @var  $_member Member */
    private $_member;

    public function authenticate()
    {
        $selectMember = 'id,username,password,gai_number,mobile,status,head_portrait,type_id,enterprise_id,salt,logins,last_login_time,current_login_time';

        /** @var  $user  Member*/
        /** @var $enterprise Enterprise */
        /** @var $assistant Assistant */

        if(isset($_POST['assistant'])){ //店小二登录
            $assistant = Assistant::model()->find('username=:params or mobile=:params',array(':params' => $this->username,));
            $user = null;
            if($assistant){
                if(!$assistant->validatePassword($this->password)){
                    $this->errorCode = self::ERROR_PASSWORD_INVALID;
                }else{
                    if($assistant->status==$assistant::STATUS_NO){
                        $msg = Yii::t('home','{username} {limit}, 禁止登录 卖家平台');
                        $msg = strtr($msg,array('{username}'=>$this->username,'{limit}'=>$assistant::status($assistant->status) ));
                        $this->errorMessage = $msg;
                        $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
                    }else{
                        $user = Member::model()->find(array(
                            'select'=>$selectMember,
                            'condition'=>'id=:id',
                            'params'=>array(':id'=>$assistant->member_id),
                        ));
                        $this->_assistantId = $assistant->id;
                    }
                }
            }else{
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            }

        }else{ //企业会员登录
            $user = Member::model()->findAll(array(
                'select'=>$selectMember,
                'condition'=>'username=:params or gai_number=:params or mobile=:params order by is_master_account DESC limit 1',
                'params'=>array(':params'=>$this->username),
            ));
            if($user) $user = $user[0];
        }
        //查找企业信息
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
        }else{
            $enterprise = Enterprise::model()->find(array(
                'select'=>'id,auditing,flag',
                'condition'=>'id=:id',
                'params'=>array(':id' => $user->enterprise_id),
            ));
        }

        //两个表都查找不到
        if (!$user || !$enterprise){
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        //密码错误
        else if (!$user->validatePassword($this->password) && empty($this->_assistantId)){
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        }else {
            //被删除，禁止登录
            if($user->status==$user::STATUS_DELETE || $user->status==$user::STATUS_REMOVE){
                $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
                $msg = Yii::t('home','{username}已经被 {limit}, 禁止登录');
                $msg = strtr($msg,array('{username}'=>$this->username, '{limit}'=>$user::status($user->status)));
                $this->errorMessage = $msg;
            //还未审核
            }else if($enterprise->auditing!=$enterprise::AUDITING_YES){
                $this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
                $msg = Yii::t('home','{username} {limit}, 禁止登录 卖家平台');
                $msg = strtr($msg,array('{username}'=>$this->username,'{limit}'=>$enterprise::auditingArr($enterprise->auditing) ));
                $this->errorMessage = $msg;
            }else{
                $this->errorCode = self::ERROR_NONE;
                $this->_id = $user->id;
                $this->_enterpriseId = $enterprise->id;
                /** 如果是店小二登录，username是店小二的username */
                $states = array(
                    'avatar'=>$user->head_portrait,
                    'typeId'=>$user->type_id,
                    'gw'=>$user->gai_number,
                    'selectLanguage'=>isset($_POST['select_language']) ? $_POST['select_language'] : HtmlHelper::LANG_ZH_CN,
                );
                if ($enterprise) {
                    $states['enterpriseId'] = $enterprise->id;
                    $states['enterpriseFlag'] = $enterprise->flag;
                    $states['enterpriseAuditing'] = $enterprise->auditing;
                    if(isset($user->franchisee) && is_object($user->franchisee)){
                        $states['franchiseeId'] = $user->franchisee->id;
                    }
                }
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
                if(empty($this->_assistantId)){
                    $this->username = empty($user->username)? $user->gai_number : $user->username;
                    $this->setPersistentStates($states);
                }else{
                    $this->username = $assistant->username;
                    $states['avatar'] = $assistant->avatar;
                    $states['assistantId'] = $this->_assistantId;
                    $this->setPersistentStates($states);
                }
                $this->_member = $user;
            }
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getEnterpriseId(){
        return $this->_enterpriseId;
    }

    public function getAssistantId(){
        return $this->_assistantId;
    }

    public function getMember(){
        return $this->_member;
    }
}
