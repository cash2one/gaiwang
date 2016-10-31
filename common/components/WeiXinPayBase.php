<?php

/**
 * 微信支付基类
 *
 * @author xuegang.liu@g-emall.com
 * @since  2016-04-18T15:27:04+0800
 */
class WeiXinPayBase
{   
    
    /**
     * xml 结果转换数组
     * @param string $xml
     * @return mixed
     */
    public static function resultInit($xml)
    {
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }
    
    /**
     * 签名
     * @param string $xml
     * @throws Exception
     * @return mixed
     */
    public static function sign($xml,$apiKey)
    {
        try{
            $result = self::resultInit($xml);
            $sign = $result['sign'];
            unset($result['sign']);
            ksort($result);
            $str = http_build_query($result);
            $str.='&key='.$apiKey;
            $rsign = strtoupper(md5(urldecode($str)));
            if(strcmp($rsign, $sign)!=0)
                throw new Exception('签名失败');
            return $result;
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    
    /**
     * 异步输出格式
     * @param unknown_type $error_msg
     */
    public static function formartResultXml($error_msg = '')
    {
        if(empty($error_msg))
        {
            $return_msg = 'OK';
            $return_code = 'SUCCESS';
        }else{
            $return_msg = $error_msg;
            $return_code = 'FAIL';
        }
        $xml = '<xml>';
        $xml.= '<return_code><![CDATA['.$return_code.']]></return_code>';
        $xml.= '<return_msg><![CDATA['.$return_msg.']]></return_msg>';
        $xml.= '</xml>';
        echo $xml;
        Yii::app()->end();
    }
    

    /**
     * 获取微信回调数据
     * 
     * @author xuegang.liu@g-emall.com
     * @since  2016-02-24T15:37:06+0800
     * @return xml
     */
    public static function getNotifyData()
    {
        $xml = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
        if(empty($xml)){
            $xml = file_get_contents("php://input");
        }
        return $xml;
    }
    
    /**
     * 
     * 银联提交接口
     * @param array $params
     * @return mixed
     */
    public static function curlInt($params,$url,$apiKey)
    {
        ksort($params);
        $str = http_build_query($params);
        $str.='&key='.$apiKey;
        $str = strtoupper(md5(urldecode($str)));
        $params['sign'] = $str;
        $xml = '<xml>';
        foreach($params as $key=>$val)
        {
            $xml.="<{$key}>{$val}</{$key}>";
        }
        $xml.='</xml>';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);  //url地址
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true); //是否post请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); //post请求传递的数据
        curl_setopt($ch, CURLOPT_PORT, 443);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//返回获取的输出文本流
        
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        
        
        $xml = curl_exec($ch);   //获取返回的数据
        curl_close($ch);
        return $xml;
    }


    /**
     * [showTips description]
     */
    public static function tradeState2Msg($tradeState)
    {
        $tradeStateMsg = array(
            'SUCCESS'=>'支付成功',//1
            'REFUND'=>'转入退款',
            'NOTPAY'=>'未支付',
            'CLOSED'=>'已关闭',
            'REVOKED'=>'已撤销（刷卡支付）',
            'USERPAYING'=>'用户支付中',//2
            'PAYERROR'=>'支付失败',
        );

        return isset($tradeStateMsg[$tradeState]) ? $tradeStateMsg[$tradeState] : '未知';
    }
}