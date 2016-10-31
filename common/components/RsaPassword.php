<?php

/**
 * 密钥类
 * 加密，解密
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class RsaPassword {

    public $privateKey;     //私钥
    public $public_key;  //公钥


    /**
     * 初始化私钥
     */
    function __construct() {
        $private = Yii::getPathOfAlias('common') . DS .'rsaFile'. DS . 'memberpsw'. DS .'psw_private.pem';
        //私钥
        $fp = fopen($private, "r");
        $this->privateKey = fread($fp, 8192);
        fclose($fp);

        $public = Yii::getPathOfAlias('common') . DS .'rsaFile'. DS . 'memberpsw'. DS .'psw_public.pem';
        //公钥
        $fp = fopen($public, "r");
        $this->public_key = fread($fp, 8192);
        fclose($fp);
    }
    /**
     * 生成指定长度的随机字符串或md5后的唯一id
     * @param string $length
     * @return string
     */
    public static function generateSalt($length = '') {
        $string = md5(uniqid());
        return $length ? substr($string, -$length) : $string;
    }

    /**
     * 解密方法
     * @param string $value
     * @return string|null
     * @author wanyun.liu <wanyun_liu@163.com>
     */
    public function decrypt($value) {
        $string = base64_decode($value);
        $res = openssl_get_privatekey($this->privateKey);
        openssl_private_decrypt($string, $result, $res);
        return $result;
    }

    /**
     * 密码解密处理
     */
    public function decryptPassword($attributes,$param='password')
    {
        $search = $attributes['token'];
        unset($attributes['token']);
        $decrypt_password = json_decode($this->decrypt($attributes[$param]), true);
        $attributes[$param] = str_replace($search, '', $decrypt_password['password']);
        return $attributes;
    }

}
