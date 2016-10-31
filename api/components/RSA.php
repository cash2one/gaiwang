<?php

/*
 * openssl rsa 加密
 */

class RSA {

    public $private_key;    //私钥
    public $public_key;  //公钥

    const PASSWORD_SALT = 'gaiwangapi';

    /*
     * 初始化私钥
     */

    function __construct() {
        //206
        $private = Yii::getPathOfAlias('keyPath') . DS . 'rsa_private_key.pem';
        //$public = Yii::getPathOfAlias('keyPath') . DS . 'public_test.key';
        //本地
        //$private = Yii::getPathOfAlias('keyPath') . DS . 'private.key';
        $public = Yii::getPathOfAlias('keyPath') . DS . 'public.key';

        //私钥
        $fp = fopen($private, "r");
        $this->private_key = fread($fp, 8192);
        fclose($fp);

        // 公钥,测试用
        $fp = fopen($public, "r");
        $this->public_key = fread($fp, 8192);
        fclose($fp);
    }

    /*
     * 加密
     * 后台接口不加密数据,此函数作测试用
     */

    public function encrypt($data) {
        $res = openssl_get_publickey($this->public_key);
        openssl_public_encrypt($data, $encrypted, $res);
        $encrypted = bin2hex($encrypted);  //转换成十六进制
        return $encrypted;
    }

    /*
     * 解密
     */

    public function decrypt($data) {
        $data = self::hex2bin($data);
        $res = openssl_get_privatekey($this->private_key);
        if (@openssl_private_decrypt($data, $decrypted, $res))
            $data = $decrypted;
        else
            throw new ErrorException('发送的数据解密失败', 400);

        return $data;
    }

    public static function hex2bin($data) {
        $len = strlen($data);
        return pack("H" . $len, $data);
    }

    /*
     * 密码加密-用于盖网通
     */

    public static function passwordEncrypt($string) {
        $string = base64_encode($string);
        $salt = base64_encode(self::PASSWORD_SALT);
        $string = base64_encode($string . $salt);
        return $string;
    }

    /*
     * 密码解密-用于盖网通
     */

    public static function passwordDecrypt($string) {
        $string = base64_decode($string);
        $salt = base64_encode(self::PASSWORD_SALT);
        $string = str_replace($salt, '', $string);
        $string = base64_decode($string);
        return $string;
    }

}

?>