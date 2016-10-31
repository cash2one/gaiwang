<?php
/**
 * 获取网银支付结果
 * @author zhenjun_xu <412530435@qq.com>
 */
class OnlinePayCheck
{

    /**
     * 根据支付类型、查询支付单号的支付结果
     * @param string $code 支付单号
     * @param string $mainCode 商城订单号
     * @param int $payType 支付类型
     * * @param int $orderType 订单类型   积分充值  商品订单支付  酒店订单
     * @return array
     */
    public static function payCheck($code,$payType,$mainCode='',$orderType='',$source=''){
        if(empty($mainCode)) $mainCode = $code;
        $result = array();
        switch ($payType) {
            case Order::PAY_ONLINE_IPS:
                $result = self::_ipsPayResult($code);
                break;
            case Order::PAY_ONLINE_UN:
                $result = self::_unionPayResult($code,$mainCode);
                break;
            case Order::PAY_ONLINE_BEST:
                $result = self::_bestPayResult($code,$mainCode);
                break;
            case Order::PAY_ONLINE_UM:
                $result = self::_umPayResult($code);
                break;
            case Order::PAY_ONLINE_TLZF:
                $result = self::_tlzfPayResult($code,$payType,$source);
                break;
            case Order::PAY_ONLINE_TLZFKJ:
                $result = self::_tlzfPayResult($code,$payType,$source);
                break;
           case Order::PAY_ONLINE_GHT:
                    $result = self::_ghtPayResult($code,$payType);
                break;
           case Order::PAY_ONLINE_GHTKJ:
                    $result = self::_ghtPayResult($code,$payType);
                    break;
           case Order::PAY_ONLINE_QUICK_GHTKJ:
                    $result = self::_ghtQuickPayResult($code);
                    break;
           case Order::PAY_ONLINE_WEIXIN:
                    $result = WeiXinPayGXAPP::orderquery($code);
                    break;
          case Order::PAY_ONLINE_EBC:
                    $result = self::_ebcPayResult($code);
              break;
        }

        return $result;
    }
    /**
     * 环迅支付对账请求
     * @param string $code 支付单号
     * @return array
     * @throws CHttpException
     */
    private static function _ipsPayResult($code)
    {
        $result = array();
        $p = array(
            'MerCode' => IPS_MER_CODE,
            'Flag' => 1,
            'TradeType' => 'NT',
            'StartNo' => $code,
            'EndNo' => $code,
            'Page' => 1,
            'Max' => 1,
        );
        $p['Sign'] = md5($p['MerCode'] . $p['Flag'] . $p['TradeType'] . $p['StartNo'] . $p['EndNo'] . $p['Page'] . $p['Max'] . IPS_MER_KEY);
        $http = new HttpClient('');
        $url = 'http://webservice.ips.net.cn/Sinopay/Standard/IpsCheckTrade.asmx';//测试
//        $url = 'http://webservice.ips.com.cn/Sinopay/Standard/IpsCheckTrade.asmx';//正式
        $string = $http->quickPost($url . '/GetOrderByNo', $p);
        $xml = simplexml_load_string($string);
        if ($xml->ErrCode == '0000') {
            $info = (array)$xml->OrderRecords->OrderRecord;
            $result['status'] = true;
            $result['money'] = $info['Amount'];
            $result['info'] = $info;
        } else {
            $result['status'] = false;
            $result['info'] = $string;
        }
        return $result;
    }

    /**
     * 翼支付对账请求
     * @param string $code 支付单号
     * @param string $mainCode 商城订单号
     * @return array
     * @throws CHttpException
     */
    private static function _bestPayResult($code,$mainCode)
    {
        $result = array();
        $params = array(
            'COMMCODE' => BEST_MER_CODE,
            'ORDERSEQ' => $mainCode,
            'ORDERREQTRANSEQ' => $code,
        );
        $params['MAC'] = strtoupper(md5('COMMCODE=' . $params['COMMCODE'] . '&ORDERSEQ=' . $params['ORDERSEQ'] . '&ORDERREQTRANSEQ=' . $params['ORDERREQTRANSEQ'] . '&KEY=' . BEST_KEY));
        $url = 'https://webpaynotice.bestpay.com.cn/commorderQuery.do';
        $http = new HttpClient('');
        $string = $http->quickPost($url, $params);
        $xml = simplexml_load_string($string);
        if ($xml) {
            if ($xml->RETURNCODE == '0' && $xml->TRANSTATUS == 'B') {
                $result['status'] = true;
                $result['info'] = (array)$xml;
                $result['money'] = $xml->ORDERAMOUNT / 100;
            } else {
                $result['status'] = false;
                $result['info'] = $string;
            }
        }
        return $result;
    }

    /**
     * 银联对账请求
     * @param string $code 支付单号
     * @return array
     * @throws CHttpException
     */
    private static function _unionPayResult($code,$mainCode = '')
    {
        $result = array();
        $shoppingtime = $year = $mouth = $day = $beginTime = $endTime = '';

        //ＰＯＳＴ的参数
        if($mainCode != ''){
            $datestr = strstr($code,'2');
            $date = substr($datestr,0,8);
            $year = substr($date,0,4);
            $mouth = substr($date,4,2);
            $day = substr($date,6,2);
            $beginTime = date('Y-m-d H:i:s', strtotime($year.'-'.$mouth.'-'.$day.' 00:00:00'));
            $endTime = date('Y-m-d H:i:s', strtotime($year.'-'.$mouth.'-'.$day.' 23:59:59'));
        }else{
            $shoppingtime = date('Y-m-d H:i:s', time() - 3600 * 24 * 28);
        }

        $params = array(
            'Merid' => UNION_MEMBER_ID,
            'userid' => UNION_CHECK_UID,
            'pwd' => UNION_CHECK_PWD,
            'paysuc' => 1,
            'shoppingtime' => $shoppingtime,
            'beginTime' => $beginTime,
            'endtime' => $endTime,
            'orderno' => $code
        );
        $url = 'https://www.gnete.com/bin/scripts/OpenVendor/gnete/V34/GetPayResult.asp';
        $http = new HttpClient('');
        $rs = $http->quickPost($url, $params);
        $array = explode('\n', $rs);
        if (count($array) == 7 && $array[5] == '00') {
            $result['status'] = true;
            $result['money'] = $array[1];
            $result['info'] = $array;
        } else {
            $result['status'] = false;
            $result['info'] = $rs;
        }
        return $result;
    }

    /**
     * 联动优势对账请求
     * @param string $code 支付单号
     * @return array
     * @throws CHttpException
     */
    private static function _umPayResult($code)
    {
        $map=array(
            'service' =>'query_order',
            'mer_id' => UM_MEMBER_ID,
            'version' =>'4.0',
            'charset' =>'UTF-8',
            'order_id' =>$code,
            'mer_date' =>substr(strstr($code,'2'),0,8),
        );
        $plain=RsaPay::plain($map);
        $sign=RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $map['sign'] = $sign;
        $map['sign_type'] = 'RSA';
        $html=get_meta_tags(UM_PAY_URL.'?'.http_build_query($map));
        $html=$html['mobilepayplatform'];
        parse_str($html,$array);
        $result = array();
        if(isset($array['trade_state']) && $array['trade_state']=='TRADE_SUCCESS'){
            $result['status'] = true;
            $result['money'] = sprintf('%0.2f', $array['amount']/100);
            $result['info'] = $html;
        }else{
            $result['info'] = $html;
            $result['status'] = false;
        }
        return $result;
    }

    /**
     * 通联支付对账请求
     * @param string $code 支付单号（8开头）
     * @param string $mainCode 订单号
     * @param int $orderType 订单类型
     * @return array
     * @throws CHttpException
     */
    private static function _tlzfPayResult($code,$payType,$source)
    {
        $key=$payType==Order::PAY_ONLINE_TLZF ? TLZF_MD5KEY :TLZFKJ_MD5KEY;
        $merId=$payType==Order::PAY_ONLINE_TLZF ? TLZF_MERCHANT_ID :TLZFKJ_MERCHANT_ID;
        if($source==Order::ORDER_SOURCE_WAP){
          $merId=TLZF_MERCHANT_WAPID;
        }
        $map=array(
                'merchantId' =>$merId,
                'version' => 'v1.5',
                'signType' =>'1',
                'orderNo' =>$code,
                'orderDatetime' =>substr($code, 1,14),
                'queryDatetime' =>date('YmdHis'),
                'key' =>$key,
        );
       $plain = http_build_query($map);
       $signMsg = strtoupper(md5($plain));
        unset($map['key']);
       $map['signMsg']=$signMsg;
       $url=TLZF_WEBPAY_URL.'?'.http_build_query($map);
       $ch = curl_init() ;
       curl_setopt($ch, CURLOPT_URL,$url) ;
       ob_start();
       curl_exec($ch);
       $ret = ob_get_contents() ;
       ob_end_clean();
       curl_close($ch);
       //$ret=file_get_contents($url);
       parse_str($ret,$data);
       $result = array(); 
       $signArr = array('merchantId','version','language','signType','payType','issuerId','paymentOrderId','orderNo','orderDatetime','orderAmount','payDatetime','payAmount','ext1','ext2','payResult','errorCode','returnDatetime');
       $canEmptyParams = array('language','payType','issuerId','ext1','ext2','errorCode');
       if(isset($data['ERRORCODE'])){
           $result['status'] = false;
           return $result;
         }
       $verify_result=RsaPay::verifyRequest($data, $signArr,$canEmptyParams);
       if(!$verify_result){
           $result['status'] = false;
           throw new CHttpException(503,'验签失败');
       }
       if(isset($data['payResult']) && $data['payResult']=='1'){
           $result['status'] = true;
           $result['money'] =sprintf('%0.2f', $data['payAmount']/100);
           $result['info'] = $data;
       }else{
           $result['status'] = false;
       }  
         return $result;
    }
    
    /**
     * 高汇通支付普通对账请求
     * @param string $code 支付单号（8开头）
     * @param string $mainCode 订单号
     * @param int $orderType 订单类型
     * @return array
     * @throws CHttpException
     */
    private static function _ghtPayResult($code,$payType)
    {
        $result=array();
        $signOrigStr='';
        $key=$payType==Order::PAY_ONLINE_GHT ? GHT_MD5KEY :GHTKJ_MD5KEY;
        $memno=$payType==Order::PAY_ONLINE_GHT ? GHT_MERCHANT_ID :GHTKJ_MERCHANT_ID;
        $terno=$payType==Order::PAY_ONLINE_GHT ? GHT_TERMINAL_ID :GHTKJ_TERMINAL_ID;
        $map=array(
                'busi_code' =>'SEARCH',
                'merchant_no' => $memno,
                'terminal_no' =>$terno,
                'order_no' =>$code,
                'sign_type' =>'SHA256',
        );
        $plain=RsaPay::plain($map);
        $signOrigStr=$plain."&"."key=".$key;
        $signMsg=strtolower(hash("sha256",$signOrigStr));
        $map['sign']=$signMsg;
        ksort($map);
        $url=GHT_WEBPAY_URL;
        $url=$url.'?'.urldecode(http_build_query($map));
        $ch = curl_init() ;
        curl_setopt($ch, CURLOPT_URL,$url) ;
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER,array('Content-Type:text/xml'));
        $string = curl_exec ( $ch );
        curl_close($ch);
        //$string=file_get_contents($url);
        $xml=@simplexml_load_string($string);
        if(isset($xml->resp_code) && $xml->resp_code=='00'){
         if(isset($xml->pay_result) && $xml->pay_result=='1'){
            $result['status'] = true;
            $result['money'] =  (float)$xml->amount;
            $result['info'] = (array)$xml;
          }else{
            $result['status'] = false;
            $result['info'] = json_encode($xml);
          }
        }else{
            $result['status'] = false;
        }
        return $result;
    }
    
    /**
     * 高汇通支付快捷对账请求
     * @param string $code 支付单号（8开头）
     * @return array
     * @throws CHttpException
     */
    private static function _ghtQuickPayResult($code){
        $info=array();
        $result=array();
        $ghtPay = new GhtPay();
        $info['oriReqMsgId']=$code;
        $info['reqMsgId']=Tool::buildOrderNo(19,'G');
        $getData=$ghtPay->getHttpData($info,'ispay');
        if($getData['status']){
            $res=$getData['info'];
            $resCode=$res->body->oriRespCode;
            if($resCode=='000000'){
              $result['status']=true;
              $result['money']=$result->body->remainFee;
              $result['info']=$res;
            }else{
              $result['status'] = false;
            }
        }else{
              $result['status'] = false;
        }
        return $result;  
    }
    
    
    /**
     * EBC钱包支付对账请求
     * @param string $code 支付单号（8开头）
     * @param string $mainCode 订单号
     * @param int $orderType 订单类型
     * @return array
     * @throws CHttpException
     */
    private static function _ebcPayResult($code)
    {
        $result=array();
        $map=array(
            'transcode' =>'T613',
            'version' => '0140',
            'ordersn' =>Tool::buildOrderNo(20,'E'),
            'merchno' =>EBC_MERCHANT_ID,
            'platform'=>'01',//01 网站；02 手机03 接口
            'ownerid' =>'EBC',
            'dsorderid' => $code,
            'flag'=>'1'
        );
        $plain = '';
        foreach($map as $k=>$v){
            $plain .= $k.'='.$v.'&';
        }
        $plain=substr($plain,0,-1);
        $dataSign=RsaPay::ebcEncrypt($plain,EBC_CARD_KEY);
        $map['dstbdatasign']=$dataSign;
        $jsonData=json_encode($map);
        $rsaPay=new RsaPay();
        $data = $rsaPay->get_url_data ('T613',$jsonData,"POST" );
        if(isset($data['returncode']) && $data['returncode']=='00'){
            $result['status'] = true;
            $result['money'] ='';
            $result['info'] = $data;
        }else{
            $result['status'] = false;
            $result['info'] =$data;
        }
        return $result;
    }
    
    /**
     *
     * 银联订单支付结果检查
     * @param 子订单号  $code
     * @param 父订单号  $mainCode
     */ 
    public static function orderUinonCheck($code){
        $result = array();
        $certId=RsaPay::getSignCertId ();
        $params = array(
                'version' => '5.0.0',			//版本号
                'encoding' => 'utf-8',			//编码方式
                'certId' =>$certId,	            //证书ID
                'signMethod' => '01',		    //签名方法
                'txnType' => '00',			    //交易类型
                'txnSubType' => '00',		    //交易子类
                'bizType' => '000201',		    //业务类型
                'channelType' => '08',		    //渠道类型，07-PC，08-手机
                'accessType' => '0',		    //接入类型
                'merId' =>UNION_WAPPAY_MID,	    //商户代码，请改自己的测试商户号
                'orderId' => $code,	            //商户订单号
                'txnTime' => substr($code, 1,14),	//订单发送时间
        );
        $url="https://gateway.95516.com/gateway/api/queryTrans.do";
        $params=RsaPay::unionSign($params);
        $res=RsaPay::sendHttpRequest($params,$url);
        $result=RsaPay::coverStringToArray($res);
        $res=RsaPay::unionVerify($result);
        if($res){
        if(isset($result['respCode']) && $result['respCode']=='00'){
            if(isset($result['origRespCode']) && $result['origRespCode']=='00')
            {
              $result['status']=true;
              $result['money']=sprintf('%0.2f', $result['txnAmt'] / 100);
              $result['payTranNo']=$result['queryId'];
            }else{
              $result['status']=false;
            }
        }else{
            $result['status']=false;
          } 
        }else{
            $result['status'] = false;
            throw new CHttpException(500,'验签失败');
          }
            return $result;
    }
}