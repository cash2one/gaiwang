<?php
/**
 * @author lhao qinghao
 * 联动支付相关方法
 */
class Umpay
{
    public static $charset = 'UTF-8';
    public static $res_format = 'HTML';
    public static $version = '4.0';
    public static $sign_type = 'RSA';
        
    /**
     * 共用方法
     * @author lhao
     * @param unknown_type $service
     * @return array
     */
    public static function processFun($service,$params=array())
    {
        $map = array_merge(array(
                'charset' =>self::$charset,
                'mer_id' => UM_MEMBER_ID,
                'res_format' =>self::$res_format,
                'version' => self::$version,
        ),$params);
        $map['service'] = $service;
        $rsaPay = new RsaPay();
        $plain=$rsaPay::plain($map);
        $priv_key_file = Yii::getPathOfAlias('common').DS.'rsaFile'.DS.'um.key.pem';
        $map['sign'] = $rsaPay->sign($plain,$priv_key_file);
        $map['sign_type'] = self::$sign_type;
        //1.初始化，创建一个新cURL资源
        $ch = curl_init();
        $url = UM_PAY_URL.'?'.http_build_query($map);
        curl_setopt ( $ch, CURLOPT_URL, $url );//获取URL地址
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );//在页面输出结果，true为不输出，false为输出
        $content = curl_exec ( $ch );
        curl_close ( $ch );
        unset($ch);
        if(!$content) return false;
        $matches = array();
        $partern='/CONTENT=\"([^<>]+)\">/';
        preg_match_all($partern, $content, $matches);
        $html= $matches[1][0];
        self::addLog('pay',$html);
        $retArr=explode("&", $html);
        foreach($retArr as $k){
            $res=explode("=", $k);
            $resArr[$res[0]]=$res[1];
        }
        ksort($resArr);
        if($resArr['ret_code']!='0000')
        {
            throw new Exception($resArr['ret_msg']);
        }
        return $resArr;

    }
    
    /**
     * 记录访问日志
     * @param $fileName
     * @param string $content
     * @param array $array
     */
    public static function addLog($fileName,$content='',$array=array()){
    	$root = Yii::getPathOfAlias('root');
    	//        $num = date("Ym").(date("W")-date("W",strtotime(date("Y-m-01"))));
    	$num = date("mda");
    	$path = $root . DS . 'runtime' . DS . $fileName.'-'.$num;
    	$str = PHP_EOL."------------------------------------------" .PHP_EOL.
    	", time: " . date("m-d H:i:s") .
    	PHP_EOL . $content;
    	if(!empty($array)){
    		$str .= PHP_EOL;
    		$str .= var_export($array, TRUE);
    	}
    	$str .= PHP_EOL;
    	@file_put_contents($path, $str, FILE_APPEND);
    }
    
    /**
     * 
     * @param string $orderId
     * @param float $amount
     * @param string $symbol
     * @param intval $expire_time
     * @param string $url
     * @param string $mer_priv
     * @return return array
     */
    public static function getTradeNo($orderId,$amount,$symbol='RMB',$expire_time = '',$url = '',$mer_priv = '')
    {
        $params=array(
                'order_id' => $orderId,
                'mer_date' => date("Ymd"),
                'amount' => $amount*100,
                'amt_type' => 'RMB',
                'expire_time' => '',
                'notify_url' =>$url=='' ? 'http://token.'.SHORT_DOMAIN.'/umPayRes/submitPay':$url,
        );
        if(!empty($mer_priv)){
        	$params['mer_priv']=$mer_priv;
        }
        return self::processFun('pay_req_shortcut',$params);
        
    }
    
    const PAY_TPYE_DEBITCARD = '1';
    const PAY_TPYE_CREDITCARD = '2';

    /**
     * 获取支付类型编码
     * @param null $key
     * @return array|string
     */
    public static function getPayTpyeCode($key=null){
        $ary = array(
            self::PAY_TPYE_DEBITCARD => 'DEBITCARD',
            self::PAY_TPYE_CREDITCARD => 'CREDITCARD'
        );
        return (isset($key) && $key) ? (isset($ary[$key]) ? $ary[$key] : '') : $ary;
    }
    /**
     * @param $param
     * @return mixed
     * pay_type 1：DEBITCARD, 2：CREDITCARD
     */
    public static function getBankSigned($param)
    {
        $map = array(
            'pay_type' => self::getPayTpyeCode($param['pay_type']),
            'mer_cust_id' => $param['GWnumber'],
            'usr_pay_agreement_id' => isset($param['payAgr']) && $param['payAgr'] ? $param['payAgr'] : '',
        );
        return self::processFun('query_mercust_bank_shortcut',$map);
    }

    public static function deleteBankSigned($param)
    {
        $map = array(
            'mer_cust_id' => $param['GWnumber'],
            'usr_pay_agreement_id' => isset($param['usr_pay_agreement_id']) && $param['usr_pay_agreement_id'] ? $param['usr_pay_agreement_id'] : '',
        );
        return self::processFun('unbind_mercust_protocol_shortcut',$map);
    }
    
    /**
     * 验证请求签名并且返回参数
     */
    public static function verifyRequest()
    {
        $result = array(); //订单数据
        $request = Yii::app()->request;
        $signMsg = $request->getParam('sign');
        $statusCode = $request->getParam('error_code');
        if ($statusCode && $statusCode != '0000') {
            $result['errorMsg'] = '交易错误码：' . $statusCode;
        } else if ($signMsg) {
            $data = isset($_POST['service']) ? $_POST : $_GET;
            ksort($data);
            unset($data['sign']);
            unset($data['sign_type']);
            //明文
            $plain = '';
            foreach ($data as $k => $v) {
                $plain .= $k . '=' . $v . '&';
            }
            $plain = substr($plain, 0, -1);
            $RsaPay = new RsaPay();;
            if (!$RsaPay->verify($plain,$signMsg)) {
                $result['errorMsg'] = '验签失败';
            }
            return $data;
        } else {
            $result['errorMsg'] = '接收到的数据格式错误';
        }
    
    }
    
    /**
     * 组装相应数据
     * @param $result
     * @return mixed
     */
    public static function response($result=array(),$retCode='0000',$retMsg=''){
        header("Content-type:text/html;charset=utf-8");
        $html = <<<EOF
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <META NAME="MobilePayPlatform" CONTENT="{data}" />
</head>
EOF;
        $params = array(
                'mer_id'=>UM_MEMBER_ID,
                'version'=>'4.0',
                'ret_msg'=>$retMsg,
                'ret_code'=>$retCode,
        );
        $params = array_merge($params,$result);
        $RsaPay = new RsaPay();
        $plain = $RsaPay->plain($params);
        $sign = $RsaPay->sign($plain);
        $params['sign'] = $sign;
        $params['sign_type'] = 'RSA';
        echo str_replace('{data}',$RsaPay->plain($params),$html);
        Yii::app()->end();
    }
    
    /**
     * 联动优势对账请求
     * @param string $code 支付单号
     * @return array
     * @throws CHttpException
     */
    public static function _umPayResult($code)
    {
        $map=array(   
                'service' =>'query_order',
                'order_id' =>$code,
                'mer_date' =>substr(strstr($code,'2'),0,8),
        );
        $result = array();
        $array=array();
        $array=self::processFun('query_order',$map);
        if(isset($array['trade_state']) && $array['trade_state']=='TRADE_SUCCESS'){
            $result['status'] = true;
            $result['money'] = $array['amount']/100;
            $result['info'] = $array;
        }else{
            $result['info'] = $array;
            $result['status'] = false;
        }
        return $result;
        
    }

}