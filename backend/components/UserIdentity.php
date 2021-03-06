<?php

class UserIdentity extends CUserIdentity {

    private $_id;

    public function authenticate() {
        $user = User::model()->find(array(
            'condition' => 'username=:username AND status=:status',
            'params' => array(
                ':username' => $this->username,
                ':status' => User::STATUS_ENABLE
            )
        ));
        if (!$user)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if (!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else {
            $this->_id = $user->id;
            $this->username = $user->username;
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId() {
        return $this->_id;
    }

}
