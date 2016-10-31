<?php

/**
 * 发送邮件设置 模型
 *
 * @author zhenjun_xu<412530435@qq.com>
 */
class EmailConfigForm extends CFormModel {

    public $host;
    public $port;
    public $fromMail;
    public $fromName;
    public $username;
    public $password;
    public $identity;

    const IDENTITY_YES = 1;
    const IDENTITY_NO = 0;

    /**
     * 是否需要登录验证
     * @return array
     */
    static function identity() {
        return array(
            self::IDENTITY_NO => '否',
            self::IDENTITY_YES => '是',
        );
    }

    public function rules() {
        return array(
            array('host, port, fromMail, fromName, username, password, identity', 'required'),
        );
    }

    public function attributeLabels() {
        return array(
            'host' => 'SMTP服务器',
            'port' => 'SMTP端口',
            'fromMail' => '发信人地址',
            'fromName' => '发信人呢称',
            'username' => '邮箱登录用户名',
            'password' => '邮箱登录密码',
            'identity' => '是否需要登录验证',
        );
    }

}
