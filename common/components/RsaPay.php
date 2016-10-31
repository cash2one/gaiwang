<?php

/**
 * RSA 支付 数据加密/解密/数据签名/验签处理工具类
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2015/3/5
 * Time: 11:37
 */

define("BCCOMP_LARGER", 1);
// 签名证书路径 （联系运营获取两码，在CFCA网站下载后配置，自行设置证书密码并配置）
define('SDK_SIGN_CERT_PATH',Yii::getPathOfAlias('common').'/rsaFile/unioncerts/keyold.pfx');
// 签名证书密码
define('SDK_SIGN_CERT_PWD','666888');
// 验签证书
define('SDK_VERIFY_CERT_PATH',Yii::getPathOfAlias('common'). '/rsaFile/unioncerts/UpopRsaCert.cer');
// 密码加密证书
define('SDK_ENCRYPT_CERT_PATH',Yii::getPathOfAlias('common'). '/rsaFile/unioncerts/encryptpub.cer');
// 验签证书路径
define('SDK_VERIFY_CERT_DIR',Yii::getPathOfAlias('common'). '/rsaFile/unioncerts');

class RsaPay
{  
    /**
     * 将数组转换成 签名明文串
     *
    对数组里的每一个值从 a 到 z 的顺序排序，若遇到相同首字母，则看第二个字母，以此类推。
    排序完成之后，再把所有数组值以“&”字符连接起来
     * @param array $array
     * @return string
     */
    public static function plain($array){
        ksort($array);
        $plain = '';
        foreach($array as $k=>$v){
            $plain .= $k.'='.$v.'&';
        }
        return substr($plain,0,-1);
    }
    /**
     * 数据签名
     * @param string $plain 签名明文串
     * @param string $priv_key_file 商户租钥证书 路径
     * @return bool|string
     */
    public static function sign($plain, $priv_key_file)
    {
        try {
            if (!File_exists($priv_key_file)) {
                exit("The key is not found, please check the configuration!");
            }
            $fp = fopen($priv_key_file, "rb");
            $priv_key = fread($fp, 8192);
            @fclose($fp);
            $pkeyid = openssl_get_privatekey($priv_key);
            if (!is_resource($pkeyid)) {
                return FALSE;
            }
            // compute signature
            openssl_sign($plain, $signature, $pkeyid);
            // free the key from memory
            openssl_free_key($pkeyid);
            return base64_encode($signature);
        } catch (Exception $e) {
            exit("Signature attestation failure" . $e->getMessage());
        }
    }

    /**
     * 签名数据验签
     * @param string $plain 验签明文
     * @param string $signature 验签密文
     * @param string $cert_file 公钥文件路径
     * @return bool
     */
    public static function verify($plain,$signature,$cert_file){
        if(!file_exists($cert_file)){
            die("未找到密钥,请检查配置!");
        }
        $signature = base64_decode($signature);
        $fp = fopen($cert_file, "r");
        $cert = fread($fp, 8192);
        fclose($fp);
        $pubkeyid = openssl_get_publickey($cert);
        if(!is_resource($pubkeyid)){
            return FALSE;
        }
        $ok = openssl_verify($plain,$signature,$pubkeyid);
        @openssl_free_key($pubkeyid);
        if ($ok == 1) {//1
            return TRUE;
        } elseif ($ok == 0) {//2
            return FALSE;
        } else {//3
            return FALSE;
        }
    }

    /**
     * 通联支付验证
     * @param string $document 明文字符串
     * @param string $signature 签名
     * @param string $public_key 公钥
     * @param string $modulus 内容
     * @param int $keylength 证书长度
     * @param string $hash_func 加密方式
     * @return boolean 通过返回true 失败返回false
     */
   public static function rsa_verify($document, $signature, $public_key, $modulus, $keylength,$hash_func)
    {
        //only suport sha1 or md5 digest now
        if (!function_exists($hash_func) && (strcmp($hash_func ,'sha1') == 0 || strcmp($hash_func,'md5') == 0))
            return false;
        $document_digest_info = $hash_func($document);
    
        $number    = self::binary_to_number(base64_decode($signature));
        $decrypted = self::pow_mod($number, $public_key, $modulus);
        $decrypted_bytes    = self::number_to_binary($decrypted, $keylength / 8);
        if($hash_func == "sha1" )
        {
            $result = self::remove_PKCS1_padding_sha1($decrypted_bytes, $keylength / 8);
        }
        else
        {
            $result = self::remove_PKCS1_padding_md5($decrypted_bytes, $keylength / 8);
        }
        return(self::hexTobin($document_digest_info) == $result);
    }
    
    /**
     * 
     * @param string $p  转成16进制的签名$signature
     * @param string $q  公钥$public_key
     * @param string $r  内容$modulus
     * @return string
     */
   public static function pow_mod($p, $q, $r)
    {
        // Extract powers of 2 from $q
        $factors = array();
        $div = $q;
        $power_of_two = 0;
        while(bccomp($div, "0") == BCCOMP_LARGER)
        {
            $rem = bcmod($div, 2);
            $div = bcdiv($div, 2);
    
            if($rem) array_push($factors, $power_of_two);
            $power_of_two++;
        }
        $partial_results = array();
        $part_res = $p;
        $idx = 0;
        foreach($factors as $factor)
        {
            while($idx < $factor)
            {
                $part_res = bcpow($part_res, "2");
                $part_res = bcmod($part_res, $r);
                $idx++;
            }
            array_push($partial_results, $part_res);
        }
        $result = "1";
        foreach($partial_results as $part_res)
        {
            $result = bcmul($result, $part_res);
            $result = bcmod($result, $r);
        }
        return $result;
    }
      /**
       * 二进制转成数字
       * @param  $data
       * @return string
       */
    public static function binary_to_number($data)
    {
        $base = "256";
        $radix = "1";
        $result = "0";
    
        for($i = strlen($data) - 1; $i >= 0; $i--)
        {
        $digit = ord($data{$i});
        $part_res = bcmul($digit, $radix);
        $result = bcadd($result, $part_res);
        $radix = bcmul($radix, $base);
        }
        return $result;
        }

       /**
        * 
        * @param unknown $number
        * @param unknown $blocksize
        * @return string
        */
    public static function number_to_binary($number, $blocksize)
        {
            $base = "256";
            $result = "";
            $div = $number;
            while($div > 0)
            {
                $mod = bcmod($div, $base);
                $div = bcdiv($div, $base);
                $result = chr($mod) . $result;
            }
            return str_pad($result, $blocksize, "\x00", STR_PAD_LEFT);
        }
           /**
            * 
            * @param unknown $data
            * @return string
            */ 
         public static function hexTobin($data) {
                $len = strlen($data);
                $newdata='';
                for($i=0;$i<$len;$i+=2) {
                    $newdata .= pack("C",hexdec(substr($data,$i,2)));
                }
                return $newdata;
            }
           /**
            * 
            * @param unknown $data
            * @param unknown $blocksize
            * @return string
            */
        public static function remove_PKCS1_padding($data, $blocksize)   
        {     
                $data = substr($data, 1);   
                if($data{0} == '\0')   
                    die("Block type 0 not implemented.");     
                $offset = strpos($data, "\0", 1);   
                return substr($data, $offset + 1);   
        }   
          /**
           * 
           * @param unknown $data
           * @param unknown $blocksize
           * @return string
           */  
        public static function remove_PKCS1_padding_sha1($data, $blocksize) {
                $digestinfo = self::remove_PKCS1_padding($data, $blocksize);
                $digestinfo_length = strlen($digestinfo);
                return substr($digestinfo, $digestinfo_length-20);
            }
          /**
           * 
           * @param unknown $data
           * @param unknown $blocksize
           * @return string
           */
        public static function sremove_PKCS1_padding_md5($data, $blocksize) {
                $digestinfo = self::remove_PKCS1_padding($data, $blocksize);
                $digestinfo_length = strlen($digestinfo);
                return substr($digestinfo, $digestinfo_length-16);
            }

        /**
         * 通联支付封装返回结果验证
         * @param array $result 需要验证的参数
         * @param array $signArr //验证参数
         * @param array $canEmptyParams //可为空参数
         * @throws Exception
         */
        public static function verifyRequest($result,$signArr,$canEmptyParams = array())
        {
            if(!isset($result['signMsg']) || empty($result['signMsg']))
                throw new Exception('signMsg参数为空');
            $sign = array();
            foreach($signArr as $val)
            {
                if(!isset($result[$val]) || $result[$val]==='')
                {
                    if(in_array($val, $canEmptyParams))
                        continue;
                    else
                        throw new Exception($val.'参数为空');
                }else
                    $sign[$val] = $result[$val];
            }
            $signMsg = urldecode(http_build_query($sign));
            $pubkeyFile=Yii::getPathOfAlias('common') . '/rsaFile/tlzfpublickey.txt';
            if(empty($pubkeyFile)){
                throw new Exception('未找到密钥,请检查配置!');
            }
            $publickeycontent = file_get_contents($pubkeyFile);
            $publickeyarray = explode(PHP_EOL, $publickeycontent);
            $publickey = explode('=',$publickeyarray[0]);
            //去掉publickey[1]首尾可能的空字符
            $publickey[1]=trim($publickey[1]);
            $modulus = explode('=',$publickeyarray[1]);
            //去掉modulus[1]首尾可能的空字符
            $modulus[1]=trim($modulus[1]);
            $keylength = 1024;
            //验签结果
            $verify_result = self::rsa_verify($signMsg,$result['signMsg'], $publickey[1], $modulus[1], $keylength,"sha1");       
            if($verify_result)
                return $verify_result;
            else
                return false;
        }
        
        /**
         * 
         * 银联支付签名
         * @param array $params 代签名字符串
         */
        public static function unionSign($params){
            if(isset($params['transTempUrl'])){
                unset($params['transTempUrl']);
            }
            $params_str = self::plain($params);
            $params_sha1x16 = sha1 ( $params_str, FALSE );
            $cert_path =SDK_SIGN_CERT_PATH;
            if(empty($cert_path)){
                throw new Exception('未找到密钥,请检查配置!');
            }
            $private_key = self::getPrivateKey ( $cert_path );
            // 签名
            $sign_falg = openssl_sign($params_sha1x16, $signature, $private_key, OPENSSL_ALGO_SHA1);
            if ($sign_falg) {
                $signature_base64 = base64_encode ( $signature );
                $params ['signature'] = $signature_base64;
                return $params;
            } else {
                throw new Exception('签名失败!');
            }
            
        }  
        /**
         * 返回(签名)证书私钥 -
         * @return unknown
         */
        public static function getPrivateKey($cert_path) {
            $pkcs12 = file_get_contents ( $cert_path );
            openssl_pkcs12_read ( $pkcs12, $certs, SDK_SIGN_CERT_PWD );
            return $certs ['pkey'];
        }
        
        /**
         * 签名证书ID
         * @return unknown
         */
       public static function getSignCertId() {
            // 签名证书路径   
            return self::getCertId (SDK_SIGN_CERT_PATH);
        }
        
        /**
         * 取证书ID(.pfx)
         * @return unknown
         */
      public static function getCertId($cert_path) {
            $pkcs12certdata = file_get_contents ($cert_path);
            openssl_pkcs12_read ($pkcs12certdata,$certs,SDK_SIGN_CERT_PWD );
            $x509data = $certs ['cert'];
            openssl_x509_read ($x509data);
            $certdata = openssl_x509_parse ($x509data);
            $cert_id = $certdata ['serialNumber'];
            return $cert_id;
        }
        
        /**
         * 
         *验签
         * @param String $params_str        	
         * @param String $signature_str        	
         */
        public static function unionVerify($params) {
        	 // 公钥
        	$public_key = self::getPulbicKeyByCertId ($params ['certId']);
        	// 签名串
        	$signature_str = $params['signature'];
        	unset ($params ['signature']);
        	$params_str = self::plain( $params );
        	$signature = base64_decode ( $signature_str );
        	$params_sha1x16 = sha1 ( $params_str, FALSE );	
        	$isSuccess = openssl_verify($params_sha1x16,$signature,$public_key,OPENSSL_ALGO_SHA1);
        	return $isSuccess;
     }
      
       /**
        * 根据证书ID 加载 证书
        *
        * @param unknown_type $certId
        * @return string NULL
        */
       public static function getPulbicKeyByCertId($certId) {
           // 证书目录
           $filePath=SDK_VERIFY_CERT_PATH;
           $fileExt=pathinfo ($filePath,PATHINFO_EXTENSION);
           if(empty($filePath) && $fileExt=='cer'){
               throw new Exception('未找到证书,请检查配置!');
              }
           $x509data = file_get_contents ($filePath);
           openssl_x509_read ( $x509data );
           $certdata = openssl_x509_parse ( $x509data );
           $cert_id = $certdata ['serialNumber']; 
           if ($cert_id == $certId) {
               return file_get_contents($filePath);
            }
          return file_get_contents($filePath);
       }
   
       /**
        * 模拟提交post
        * @param unknown $params
        * @param unknown $url
        * @return mixed
        */
       public static  function sendHttpRequest($params, $url) {
           $opts=http_build_query($params);
           $ch = curl_init ();
           curl_setopt ( $ch, CURLOPT_URL, $url );
           curl_setopt ( $ch, CURLOPT_POST, 1 );
           curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false);//不验证证书
           curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false);//不验证HOST
           curl_setopt ( $ch, CURLOPT_SSLVERSION, 3);
           curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
           'Content-type:application/x-www-form-urlencoded;charset=UTF-8'
                   ) );
           curl_setopt ( $ch, CURLOPT_POSTFIELDS, $opts );
         //设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。
           curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
           $html = curl_exec ( $ch );
           curl_close ( $ch );
           return $html;
       }
   
   
       /**
        * 字符串转换为 数组(parse_str不可用)
        *
        * @param unknown_type $str
        * @return multitype:unknown
        */
       public static function coverStringToArray($str) {
           $result = array ();
           if (! empty ( $str )) {
               $temp = preg_split ( '/&/', $str );
               if (! empty ( $temp )) {
                   foreach ( $temp as $key => $val ) {
                       $arr = preg_split ( '/=/', $val, 2 );
                       if (! empty ( $arr )) {
                           $k = $arr ['0'];
                           $v = $arr ['1'];
                           $result [$k] = $v;
                       }
                   }
               }
           }
           return $result;
       }
   
/*************************************************EBC钱包支付START*************************************/
       /**
        * EBC钱包支付签名
        * @param unknown $encrypt
        * @return string
        */
        public static function ebcEncrypt($encrypt,$key) {
    		$encrypt = self::ebc_pkcs5_pad ( $encrypt );
    		$iv = mcrypt_create_iv ( mcrypt_get_iv_size ( MCRYPT_DES, MCRYPT_MODE_ECB ), MCRYPT_RAND );
    		$passcrypt = mcrypt_encrypt ( MCRYPT_DES, $key, $encrypt, MCRYPT_MODE_ECB, $iv );
    		return strtoupper ( bin2hex ( $passcrypt ) );
    	}
	
    	/**
    	 * EBC支付验签
    	 * @param unknown $decrypt
    	 */
    	public static function ebcDecrypt($decrypt,$key) {
    		$decoded = pack ( "H*", $decrypt );
    		$iv = mcrypt_create_iv ( mcrypt_get_iv_size ( MCRYPT_DES, MCRYPT_MODE_ECB ), MCRYPT_RAND );
    		$decrypted = mcrypt_decrypt ( MCRYPT_DES, $key, $decoded, MCRYPT_MODE_ECB, $iv );
    		return self::ebc_pkcs5_unpad ( $decrypted );
    	}
    	
    	public static function ebc_pkcs5_unpad($text) {
    		$pad = ord ( $text {strlen ( $text ) - 1} );
    		if ($pad > strlen ( $text ))
    			return $text;
    		if (strspn ( $text, chr ( $pad ), strlen ( $text ) - $pad ) != $pad)
    			return $text;
    		return substr ( $text, 0, - 1 * $pad );
    	}
    	public static function ebc_pkcs5_pad($text) {
    		$len = strlen ( $text );
    		$mod = $len % 8;
    		$pad = 8 - $mod;
    		return $text . str_repeat ( chr ( $pad ), $pad );
    	}

    /**
     * 将字符串转化为16进制
     * @param unknown $str
     * @return string
     */
       public static function ebc_iconv_str($str){
        	$str=iconv("UTF-8","UTF-16be",$str); // 转16进制
        	$string="";
        	$m1="";
        	for($i=0;$i<=strlen($str);$i++){
        		$sub_str=ord(substr($str,$i,1));
        		$m1=base_convert($sub_str,10,16);
        		if ($i<strlen($str)){
        			if ($sub_str<=15){
        				$string=$string.'0'.$m1;
        			}else{
        				$string=$string.$m1;
        			}
        		}
        	}
    	//字符串大写
    	return strtoupper($string);
    }    

/****************************************EBC对账START***********************************************/

        private $sign_arr;
        
        public function getConfigData(){
            $configArr=array(
                    'aid' => EBC_CARD_AID,
                    'key' => 'gw|m2|20151211',
                    'api_id' => array('T613'=>'bonuspay_general@T613'),
                    'bonuse_merchno'=>EBC_MERCHANT_ID,
                    'bonuse_key'=>EBC_CARD_KEY,
                    'nonce' =>rand(000000,999999),
                    'url_ac' => 'http://api.ebcm2.com/CoreServlet',
                    'url_ac_token' => 'http://api.ebcm2.com/access_token',
                    'max_token' => 2,
            );
            return $configArr;
        }


        public  function get_url_data($api='T613',$post_data, $method = 'post') {
            $url = $this->create_m2_url ($api,$post_data, $method);
            $data = $this->sendPostUrl( $url, $post_data );
            $data_result = json_decode ( $data, true );  
            return $data_result;
        }

        /**
         * @param json $post_data
         * @param string $method
         * @return string
         */
        public  function create_m2_url($api,$post_data,$method = 'POST') {
                $mArr=$this->getConfigData();
                $token = $this->get_access_token ($api,$mArr);
                if ($token) {
                    $creat_url_arr = array (
                            'aid' => $mArr['aid'],
                            'api_id' => $mArr['api_id'][$api],
                            'access_token' => $token ['access_token']
                    );
                    $url = $this->create_url ($api, $mArr['url_ac'], $creat_url_arr );
            }
            return $url;
        }

        /**
    	 * EBC钱包订单查询获取token
    	 * 
    	 * @return boolean mixed
    	 */
    	public function get_access_token($api,$mArr) {
    	    $this->sign_arr = array (
    	            'aid' => $mArr['aid'],
    	            'nonce' =>$mArr['nonce'],
    	            'timestamp' =>time () * 1000,
    	    );
    		$sign_str = $this->get_signature ($api,$mArr);
    		$creat_url_arr = $this->sign_arr;
    		$creat_url_arr['signature']=$sign_str;
    		$url = $this->create_url ($api,$mArr['url_ac_token'], $creat_url_arr);
    		$data = $this->sendPostUrl($url);		
    		$data_arr = json_decode ( $data, true );
    		return $data_arr;
    	}

            /**
             * 加密函数
             *
             * @return string
             */
        public  function get_signature($api,$mArr='') {
            $sign_arr = array ();
            $sign_arr ['nonce'] = $this->sign_arr ['nonce'];
            $sign_arr ['aid'] = $this->sign_arr ['aid'];
            $sign_arr ['key'] = $mArr['key'];
            $sign_arr ['timestamp'] = $this->sign_arr ['timestamp'];
            usort ($sign_arr, 'nextpermu' );
            $sign_str = sha1 (implode ( '', $sign_arr ) );
            return strtoupper ( $sign_str );
        }

        /**
         * 根据给定的参数组合成url
         *
         * @param str $url
         *        	网关地址
         * @param arr $creat_url_arr
         *        	需要的参数数组
         * @param string $sign_str
         *        	加密串
         * @return string
         */
        public function create_url($api,$url, $creat_url_arr, $sign_str = '') {
             $plain = '';
             foreach($creat_url_arr as $k=>$v){
                    $plain .= $k.'='.$v.'&';
               }
            $plain=substr($plain,0,-1);
            $url = $url . "?" . $plain;
            return $url;
        }
        /**
         * 模拟浏览器提交数据
         * @param unknown $url
         * @param string $post_data
         * @return string
         */
        public function sendPostUrl($url,$post_data = ''){
            $params = array (
                    'http' => array (
                            'method' => 'POST',
                            'header' => "Content-Type: multipart/form-data\r\n",
                            'content' => $post_data
                    )
            );
            $ctx = stream_context_create ( $params );
            $fp = fopen ( $url, 'rb', false, $ctx );
            $data = stream_get_contents ( $fp );
            return $data;
        }
   /*************************************************EBC钱包支付END***************************************/
}

/**
 *
 * @param unknown $a
 * @param unknown $b
 * @return number
 */
function nextpermu($a, $b) {
    if (strcmp ( $a, $b ) == 0)
        return 0;
    return strcmp ( $a, $b ) > 0 ? 1 : - 1;
}