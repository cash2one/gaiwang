<?php 

/**
 * 第三方代收付
 * @date 2015-12-26
 * @author wyee <yanjie.wang@g-emall.com>
 *
 */

class ThirdPartyPayment{

/**********************************高汇通代收付START***************************************/
    
        public $user_name='000000000100443';
        public $merchant_id='000000000100443'; 
        public $privateKye='';//私钥 --实时跟批量不一样的商户号
        public $publicKey='';//公钥--实时跟批量不一样的商户号
        public $private_key_pw='123456';
        public $url='https://rps.gaohuitong.com:8443/d/merchant/';
        public $send_data;
        public $ret_data;
        
        /**
         * 对返回结果做处理
         * @param unknown $type
         * @return string
         */
        public function verify_ret()
        {
            $result=array();
            if (trim($this->ret_data) == '') {
                $result['status']=false;
                $result['error']='返回数据为空';
            }else{
                $xml_obj = @simplexml_load_string($this->ret_data);
                if (empty($xml_obj->INFO)) {
                    $result['status']=false;
                    $result['error']='返回格式错误';
                }else{
                //校验签名
                $sign_data = preg_replace('/<SIGNED_MSG>(.+)<\/SIGNED_MSG>/', '', $this->ret_data);
                preg_match('/<SIGNED_MSG>(.+)<\/SIGNED_MSG>/', $this->ret_data, $match);
                $verify_result = $this->verify_sign($sign_data, $match[1]);
                if(!$verify_result){
                    $result['status']=false;
                    $result['error']='签名错误';
                }else{
                    $result['status']=true;
                    $result['info']=$xml_obj;
                    $result['res']=$this->ret_data;
                } 
             }
                return $result;
            }
        }
        /**
         * 根据不同的类别组装不同的报文
         * @param array $info  数据
         * @param string $type 接口类别
         */
        public function set_data($info, $type = 'pay')
        {
            $xml = '';
            $num=isset($info['num']) ? $info['num'] : 1;
            switch ($type){
                 case 'pay':
                    $xml = '<GHT>
                            <INFO>
                                <TRX_CODE>'.$info['trxCode'].'</TRX_CODE>
                                <VERSION>04</VERSION>
                                <DATA_TYPE>2</DATA_TYPE>
                                <LEVEL>0</LEVEL>
                                <USER_NAME>'.$this->user_name.'</USER_NAME>
                                <REQ_SN>'.$info['order_id'].'</REQ_SN>
                                <SIGNED_MSG></SIGNED_MSG>
                            </INFO>
                            <BODY>
                            <TRANS_SUM>
                                <BUSINESS_CODE>'.$info['businessCode'].'</BUSINESS_CODE>
                                <MERCHANT_ID>'.$this->merchant_id.'</MERCHANT_ID>
                                <SUBMIT_TIME>'.date('YmdHis').'</SUBMIT_TIME>
                                <TOTAL_ITEM>1</TOTAL_ITEM>
                                <TOTAL_SUM>'.$info['amount'].'</TOTAL_SUM>
                            </TRANS_SUM>
                            <TRANS_DETAILS>
                                <TRANS_DETAIL>
                                    <SN>000'.$num.'</SN>
                                    <BANK_CODE>'.$info['bank_code'].'</BANK_CODE>
                                    <ACCOUNT_TYPE>00</ACCOUNT_TYPE>
                                    <ACCOUNT_NO>'.$info['account_no'].'</ACCOUNT_NO>
                                    <ACCOUNT_NAME>'.$info['account_name'].'</ACCOUNT_NAME>           
                                    <ACCOUNT_PROP>0</ACCOUNT_PROP>
                                    <AMOUNT>'.$info['amount'].'</AMOUNT>
                                    <CURRENCY>CNY</CURRENCY>
                                    <ID_TYPE>0</ID_TYPE>
                                    <REMARK>盖网通传媒</REMARK>
                                </TRANS_DETAIL>
                            </TRANS_DETAILS>
                            </BODY>
                        </GHT>';
                    break;
                case 'paymore':
                        $xml = '<GHT>
                            <INFO>
                                <TRX_CODE>'.$info['trxCode'].'</TRX_CODE>
                                <VERSION>04</VERSION>
                                <DATA_TYPE>2</DATA_TYPE>
                                <LEVEL>5</LEVEL>
                                <USER_NAME>'.$this->user_name_paymore.'</USER_NAME>
                                <REQ_SN>'.$info['order_id'].'</REQ_SN>
                                <SIGNED_MSG></SIGNED_MSG>
                            </INFO>
                            <BODY>
                            <TRANS_SUM>
                                <BUSINESS_CODE>'.$info['businessCode'].'</BUSINESS_CODE>
                                <MERCHANT_ID>'.$this->merchant_id_paymore.'</MERCHANT_ID>
                                <SUBMIT_TIME>'.date('YmdHis').'</SUBMIT_TIME>
                                <TOTAL_ITEM>'.$info['totalItem'].'</TOTAL_ITEM>
                                <TOTAL_SUM>'.$info['totalAmount'].'</TOTAL_SUM>
                            </TRANS_SUM>
                                   '.$info['moreStr'].'             
                            </BODY>
                        </GHT>';
                        break;
                  case 'query':
                     $xml = '<GHT>
                            <INFO>
                                <TRX_CODE>200001</TRX_CODE>
                                <VERSION>03</VERSION>
                                <DATA_TYPE>2</DATA_TYPE>
                                <REQ_SN>'.$info['order_id'].'</REQ_SN>
                                <USER_NAME>'.$this->user_name.'</USER_NAME>
                                <SIGNED_MSG></SIGNED_MSG>
                            </INFO>
                            <BODY>
                                <QUERY_TRANS>
                                    <QUERY_SN>'.$info['order_id'].'</QUERY_SN>
                                </QUERY_TRANS>
                            </BODY>
                        </GHT>';
                     break;
                 case 'auth':
                         $xml = '<GHT>
                            <INFO>
                                <TRX_CODE>100003</TRX_CODE>
                                <VERSION>04</VERSION>
                                <DATA_TYPE>2</DATA_TYPE>
                                <LEVEL>5</LEVEL>
                                <USER_NAME>'.$this->user_name.'</USER_NAME>
                                <REQ_SN>'.$info['req_id'].'</REQ_SN>
                                <SIGNED_MSG></SIGNED_MSG>
                            </INFO>
                            <BODY>
                            <TRANS_DETAILS>
                                <TRANS_DETAIL>
                                    <SN>0001</SN>
                                    <BANK_CODE>'.$info['bank_code'].'</BANK_CODE>
                                    <ACCOUNT_TYPE>00</ACCOUNT_TYPE>
                                    <ACCOUNT_NO>'.$info['account_no'].'</ACCOUNT_NO>
                                    <ACCOUNT_NAME>'.$info['account_name'].'</ACCOUNT_NAME>
                                    <ID>'.$info['card_id'].'</ID>
                                    <TEL>'.$info['mobile'].'</TEL>
                                </TRANS_DETAIL>
                            </TRANS_DETAILS>
                            </BODY>
                   </GHT>';
                 break;
            }
            $xml = str_replace(array(' ', "\n", "\r"), '', $xml);
            $xml = '<?xml version="1.0" encoding="UTF-8"?>'.$xml;
            $sign_data = str_replace('<SIGNED_MSG></SIGNED_MSG>', '', $xml);
            $sign = $this->create_sign($sign_data);
            $xml = str_replace('<SIGNED_MSG></SIGNED_MSG>', '<SIGNED_MSG>'.$sign.'</SIGNED_MSG>', $xml);
                //Tool::pr($xml);
            $this->send_data = $xml;
        }
        
        /**
         * 签名
         * @param array $data 签名报文
         * @return string
         */
        public function create_sign($data)
        {
            $pfx_path=$this->privateKye;
            $pkey_content = file_get_contents($pfx_path); //获取密钥文件内容
            openssl_pkcs12_read($pkey_content, $certs, $this->private_key_pw); //读取公钥、私钥
            $pkey = $certs['pkey']; //私钥
            openssl_sign($data, $signMsg, $pkey, OPENSSL_ALGO_SHA1); //注册生成加密信息
            $signMsg = bin2hex($signMsg);
            return $signMsg;
        }
        
        /**
         * 验签
         * @param array $data 明文
         * @param string $sign 签名
         * @return number
         */
        public function verify_sign($data, $sign) {
            $publicKey_path=$this->publicKey;
            $data = iconv('GBK', 'UTF-8', $data); //高汇通那边计算签名是用UFT-8编码
            $sign = $this->HexToString($sign);
            $public_key=file_get_contents($publicKey_path);
            $public_key_id=openssl_pkey_get_public($public_key);
            $res = openssl_verify($data, $sign, $public_key_id);   //验证结果，1：验证成功，0：验证失败
            return $res;
        }
        
        /**
         * post方式发送报文
         * @param string $url 提交网址
         */
        public function curl_access($goTourl='')
        { 
            $url= $goTourl ? $goTourl :$this->url;
            $data = iconv('UTF-8', 'GBK', $this->send_data);
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_TIMEOUT,60);
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_POST,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            if (strpos($url, 'https') !== false) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_SSLVERSION, 1);    //高汇通那边的版本
            }
            $ret_data = trim(curl_exec($ch));
            curl_close($ch);
            $this->ret_data = $ret_data;
        }
        
        /**
         * 数据转为16进制
         * @param unknown $s
         * @return string
         */
        public function HexToString($s){
            $r = "";
            for($i=0; $i<strlen($s); $i+=2){
                $r .= chr(hexdec('0x'.$s{$i}.$s{$i+1}));
            }
            return $r;
        }

/**********************************高汇通实时代收付END***************************************/



}









?>