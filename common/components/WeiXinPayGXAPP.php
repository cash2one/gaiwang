<?php

/**
 * 盖象优选微信支付专用
 *
 * @author zhaoxiang.liu@g-emall.com
 * @since  2016-09-13
 */
class WeiXinPayGXAPP extends WeiXinPayBase
{
	
    const APPID = 'wx8a2c31ecf38f87b5'; 
    const API_KEY = 'sdufGcEsue64Ec1jDfyKEY83uems7GWk';
    const MCH_ID = '1289040601';

	//盖付通配置
// 	const APPID = 'wx9545c0b6ac76b862';
// 	const API_KEY = 'wm4pTJVi2bsMoydmmwipcKuTToaZkDmg';
// 	const MCH_ID = '1288868101';
    
   /**
     * 接受参数
     * @return unknown
     */
    public static function acceptParams()
    {
        try{
            $xml = self::getNotifyData();
            $result = self::sign($xml,self::API_KEY);

            if($result['return_code']=='SUCCESS'){
                if(!isset($result['err_code_des'])) return $result;

                throw new Exception($result['err_code_des']);
            }
            
            throw new Exception($result['return_msg']);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
    
    /**
     * 订单查询
     * @param unknown_type $orderNum
     */
    public static function orderquery($orderNum)
    {
    	$params = array();
    	$params['appid'] = self::APPID;
    	$params['mch_id'] = self::MCH_ID;
    	$params['nonce_str'] = Tool::random('32');
    	$params['out_trade_no'] = $orderNum;
    	$url = "https://api.mch.weixin.qq.com/pay/orderquery";
    	$xml = self::curlInt($params,$url,self::API_KEY);
    	$result = self::resultInit($xml);
    
    	if($result['return_code']=='SUCCESS'){
    
    		if(!isset($result['err_code_des'])) return $result;
    
    		return false;
    	}
    
    	return false;
    }
}