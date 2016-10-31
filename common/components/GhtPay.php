<?php 

/**
 * 高汇通快捷支付
 * 加密 解密 xml解析
 */

//define('SDK_GHT_PUBLIC_CER',Yii::getPathOfAlias('common').'/rsaFile/rsa_public_key_2048.pem');
//define('SDK_GHT_PRIVATE_CER',Yii::getPathOfAlias('common').'/rsaFile/gateway_pkcs8_rsa_private_key_2048.pem');

define('SDK_GHT_PUBLIC_CER',Yii::getPathOfAlias('common').'/rsaFile/ght/test_rsa_public_key_2048.pem');
define('SDK_GHT_PRIVATE_CER',Yii::getPathOfAlias('common').'/rsaFile/ght/test_pkcs8_rsa_private_key_2048.pem');


class GhtPay 
{
    public $merchant_id;
    public $url;//提交地址
    public $payType = array(
        'bind' => 'IFP001',
        'pay'  => 'IFP004',
        'ispay'=>'IFP006',
        'mobile'=>'IFP009',
        'unbind'=>'IFP002',
    );
    public function __construct()
    {   
        $this->merchant_id = GHT_QUICK_PAY_MERCHANTID;     
        //$this->url = GHT_QUICKNOTIFY_PAY_URL;
        $this->url = GHT_QUICKNOTIFY_PAY_TESTURL;
    }   
  
//    private function _getPayType($type){
//        if(array_key_exists('bind', $this->_payType)){
//            return 
//        }
//    }

    
    /**
     * 向高汇通网关提交数据
     * @param array $info 传递的参数
     */
    public function getHttpData(array $info,$type){
        $key=substr(Tool::buildOrderNo(19), 0,16);
        $xmlData=$this->set_data($info,$type);
        $encryptData=self::encrypt($xmlData,$key);
        $encryptKey=self::rsaEncrypt($key);
        $signData= self::create_sign($xmlData);
        $postData=array(
                'encryptData'=>$encryptData,
                'encryptKey'=>$encryptKey,
                'merchantId'=>$this->merchant_id,
                'signData'=>$signData,
                'tranCode'=>$this->payType[$type],
                'callBack'=>'http://www.gnet-mall.net/reslog/log',
        );
        $httpsUrl=new HttpClient('http','8081');
        $result=$httpsUrl->quickPost($this->url, $postData);
        $returnArr=array();
        if(!empty($result) && strpos($result,'encryptKey=')!==false && strpos($result,'encryptData=')!==false && strpos($result,'signData=')!==false){
            $postArr=explode('&', $result);
            foreach($postArr as $v){
                $arr=explode('=', $v, 2);
                $postData[$arr[0]]=$arr[1];
            }
        }else{
            $returnArr['status']=false;
            $returnArr['error']='无法收到官网返回的信息';
        }
        $eKey=self::rsaDecrypt($postData['encryptKey']);
        $xmlData=self::aseDecrypt($postData['encryptData'],$eKey);
        $signIstrue=self::verify_sign($xmlData, base64_decode($postData['signData']));
        if($signIstrue){
            $xmlToArray=simplexml_load_string($xmlData);
            $xmlHead=array($xmlToArray->head);
            $resCode=$xmlToArray->head->respCode;
            if($resCode=='000000'){
                $returnArr['info']=$xmlToArray;
                $returnArr['status']=true;
                $returnArr['error']='成功';
            }else{
                $returnArr['status']=false;
                $returnArr['error']='失败';
            }

        }else{
            $returnArr['status']=false;
            $returnArr['error']='验签失败';
        }
        return $returnArr;
    }
    
    
    public function set_data(array $info,$type='bind')
    {
        $xml = '';
        $head='<head>
                    <version>1.0.0</version>
                    <merchantId>'.$this->merchant_id.'</merchantId>
                    <msgType>01</msgType>
                    <tranCode>'.$this->payType[$type].'</tranCode>
                    <reqMsgId>'.$info['reqMsgId'].'</reqMsgId>
                    <reqDate>'.date("YmdHis").'</reqDate>
               </head>';
      switch ($type) {
            case 'bind':
                $xml = '<merchant>'
                      .$head.' 
                        <body>
                            <bankCardNo>'.$info['bank_num'].'</bankCardNo>
                            <accountName>'.$info['accountName'].'</accountName>
                            <bankCardType>'.$info['card_type'].'</bankCardType>
                            <certificateType>'.$info['certificateType'].'</certificateType>
                            <certificateNo>'.$info['certificateNo'].'</certificateNo>
                            <mobilePhone>'.$info['mobile'].'</mobilePhone>
                            <userId>'.$info['gw'].'</userId>
                            <validateCode>'.$info['messageId'].'</validateCode>
                            <sendReqMsgId>'. $info['messageCode'] .'</sendReqMsgId>';
                //绑卡分为借记卡和信用卡
                if($info['card_type'] == '02'){
                    $xml = $xml . '<valid>'.$info['valid'].'</valid><CVN2>'.$info['cvn2'].'</CVN2>';
                }
                
                $xml = $xml.'</body></merchant>';
                    break;
           case 'unbind':
                    $xml = '<merchant>'
                     .$head.'
                        <body>
                            <userId>'.$info['userId'].'</userId>
                            <bindId>'.$info['bindId'].'</bindId>
                            <validateCode>'.$info['validateCode'].'</validateCode>
                            <sendReqMsgId>'.$info['sendReqMsgId'].'</sendReqMsgId>
                        </body>
                </merchant>';
                   break;
          case 'isbind':
                    $xml = '<merchant>'
                     .$head.'
                    <body>
                        <oriReqMsgId>1061619585900000</oriReqMsgId>
                    </body>
                </merchant>';
                  break;
          case 'pay':
                  $xml = '<merchant>'
                     .$head.'
                    <body>
                        <terminalId>' . GHT_TERMINALID .'</terminalId>
                        <userId>'.$info['userId'].'</userId>
                        <bindId>'.$info['bindId'].'</bindId>
                        <currency>156</currency>
                        <amount>'.$info['amount'].'</amount>
                        <productCategory>01</productCategory>
                        <productName>'.$info['productName'] .'</productName>
                        <validateCode>'.$info['messageId'] .'</validateCode>
                        <sendReqMsgId>'. $info['messageCode'] .'</sendReqMsgId>
                        <reckonCurrency>156</reckonCurrency>
                    </body>
                </merchant>';
                 break;
         case 'ispay':
                   $xml = '<merchant>'
                     .$head.'
                    <body>
                        <oriReqMsgId>'.$info['oriReqMsgId'].'</oriReqMsgId>
                    </body>
                </merchant>';
                 break;
         case 'bindList':
                   $xml = '<merchant>'
                     .$head.'
                    <body>
                        <userId>test</userId>
                    </body>
                </merchant>';
               break;
       case 'mobile':
                   $xml = '<merchant>'
                           .$head.'
                    <body>
                        <mobilePhone>'.$info['mobilePhone'].'</mobilePhone>
                        <userId>'.$info['userId'].'</userId>
                    </body>
                </merchant>';
              break;
      }
        $xml = str_replace(array(' ', "\n", "\r"), '', $xml);
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'.$xml;
         return $xml;
    }
    
    /**
     * RSA对AES秘钥进行加密
     */
    public static function rsaEncrypt($Aeskey){
        $pubkey = file_get_contents(SDK_GHT_PUBLIC_CER);
        openssl_public_encrypt($Aeskey,$encrypted,$pubkey);//公钥加密
        $encrypted = base64_encode($encrypted);
        return $encrypted;
    }
    
    /**
     * RSA对数据进行解密
     */
    public static function rsaDecrypt($data){
        $pkey_content = file_get_contents(SDK_GHT_PRIVATE_CER);
        $pikey= openssl_get_privatekey($pkey_content);
        openssl_private_decrypt(base64_decode($data),$decrypted,$pikey);//私钥解密
        return $decrypted;
    }
    
    /**
     * 签名
     * @param unknown $data 签名数据
     * @return string
     */
    public static function create_sign($data)
    {
        $pkey_content = file_get_contents(SDK_GHT_PRIVATE_CER); //获取密钥文件内容
        $pkeyid = openssl_get_privatekey($pkey_content);
        openssl_sign($data, $sign, $pkeyid, OPENSSL_ALGO_SHA1); //注册生成加密信息
        $signMsg = base64_encode($sign);
        return $signMsg;
    }
    
    /**
     * 验签
     * @param unknown $data 验签明文
     * @param unknown $sign 验签 签名
     * @return number
     */
    public static function verify_sign($data, $sign) {
        $public_key=file_get_contents(SDK_GHT_PUBLIC_CER); //公钥
        $public_key_id=openssl_pkey_get_public($public_key);
        $res = openssl_verify($data, $sign, $public_key_id);   //验证结果，1：验证成功，0：验证失败
        return $res;
    }
    
    /**
     * 提交数据post
     * @param unknown $data post数据
     * @param unknown $url  网关网址
     * @return string
     */
    public static function curl_access($data,$url)
    {
       $ch = curl_init ();
       curl_setopt ( $ch, CURLOPT_URL, $url );
       curl_setopt ( $ch, CURLOPT_POST, 1 );
       curl_setopt ( $ch, CURLOPT_SSLVERSION, 3);
       curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
       curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
       $html = curl_exec ( $ch );
       curl_close ( $ch );
       return $html;
    }
    
    /******************************AES加解密 start*************************************/
    public static function encrypt($input, $key) {
        $input = self::pkcs5_pad($input, 16);
        $data=mcrypt_encrypt(MCRYPT_RIJNDAEL_128,$key,$input, MCRYPT_MODE_ECB);
        $data = base64_encode($data);
        return $data;
    }
    
    public static function pkcs5_pad ($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
    
    public static function aseDecrypt($sStr,$skey) {
        $decrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$skey,base64_decode($sStr),MCRYPT_MODE_ECB);
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }
  /*****************************AES加密 end***************************************/

    
    /**
     * 高汇通支付错误码
     * @param $k
     * @return null
     */
    public static function ghtError($k){
        $arr = array(
                '100001'=>'报文不合法',
                '100002'=>'商户标识不存在',
                '100003'=>'验证签名失败',
                '100004'=>'交互解密异常',
                '100005'=>'交易服务码不存在',
                '100006'=>'转换数据错误',
                '200001'=>'交易流水号重复',
                '200002'=>'查询的交易不存在',
                '200003'=>'原支付流水不存在',
                '200004'=>'绑卡（签约）ID 错误',
                '200005'=>'数据异常',
                '300001'=>'绑卡（签约）失败',
                '300002'=>'合作方商户用户银行卡已签约过',
                '300003'=>'银行卡号错误',
                '300004'=>'户名错误',
                '300005'=>'银行卡状态不正常',
                '300006'=>'证件类型错误',
                '300007'=>'证件号码错误',
                '300008'=>'身份证号码不匹配',
                '300009'=>'鉴权认证失败',
                '300010'=>'有效期错误',
                '300011'=>'CVN 错误',
                '300012'=>'解绑卡失败',
                '300013'=>'手机号错误',
                '300014'=>'发卡行处理失败',
                '300015'=>'银行卡过期',
                '400001'=>'支付失败',
                '400002'=>'密码校验次数超限',
                '400003'=>'该卡不支持无卡支付',
                '400004'=>'银行账户状态不允许该操作银行账户状态不允许该操作',
                '400005'=>'银行支付校验码输入错误',
                '400006'=>'银行支付校验码失效',
                '400007'=>'商户不支持该卡交易',
                '400008'=>'退货退款失败',
                '400009'=>'支付密码输入超限',
                '400010'=>'交易已过期或已撤销',
                '400011'=>'交易风险过高阻断交易',
                '400012'=>'绑卡已过期',
                '400013'=>'支付行错误',
                '400014'=>'银行预留手机号有误',
                '400015'=>'单卡超过单笔支付限额',
                '400016'=>'单卡超过单月累积支付限额',
                '400017'=>'单卡超过单日累积支付次数上限',
                '400018'=>'单卡超过单月累积支付次数上限',
                '500001'=>'金额超限',
                '500003'=>'余额不足',
                '500004'=>'银行交易处理中',
                '500005'=>'银行交易失败',
                '500006'=>'银行系统异常',
                '900001'=>'交易结果未知',
                '900002'=>'其他错误',
                '900003'=>'交易超时',
                '900004'=>'渠道不可用',
        );
        return isset($arr[$k]) ? $arr[$k] : '未知错误';
    }
}



?>