<?php

/**
 * 处理 高汇通 快捷支付推送的对账消息
 * Class GhtpayController
 * @author wyee <yanjie.wang@g-emall.com>
 */
class GhtQuickPayController extends Controller {

    public function actionIndex() {
        $result = OnlinePay::ghtQuickCeck();
        if (!isset($result['errorMsg'])) {
            //保存推送数据结果
            Process::savePayResult($result,Order::PAY_ONLINE_GHT);
            $response ='000000';
            //单纯积分充值处理
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_RECHARGE) {
                $order = Recharge::getOneByCode($result['code']);
                if(!$order) exit('order null');
                Process::recharge($result, $order, $response);
            }
            //处理完毕，应答接口,放在事务之后
            //商品订单支付处理
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_GOODS) {
                $orders = Order::getOrdersByParentCode($result['parentCode'],$result['code']);
                if (empty($orders)) exit('order null');
                Process::orderPay($result, $orders, OnlinePay::PAY_GHT_QUICK, $response);
            }
            //酒店订单
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_HOTEL) {
                $order = HotelOrder::getOrderByLock($result['parentCode']);
                if(!$order) exit('order null');
                Process::hotelOrderPay($result, $order, OnlinePay::ORDER_TYPE_HOTEL, $response);
            }
        } else {
            echo $result['errorMsg'];
        }
    }
    
    /**
     * 高汇通接口 绑卡 推送信息处理
     */
    public function actionBind(){
        
    }
    
    /**
     * 高汇通接口 解卡 推送信息处理
     */
    public function actionUnbind(){
        $payType = $this->getParam('tranCode');
        if($payType === 'IFP002'){
            $result = $this->_decrept();
            if(!isset($result['errorMsg'])){
                $gw = (string)$result['gw'];
                $info = $result['info'];
                if(is_object($info) && $info instanceof SimpleXMLElement){
                    $bindId = $info->body->bindId;
                    $res = PayAgreement::model()->updateAll(
                                array('bindid'=>'','status'=>PayAgreement::STATUS_FALSE), 
                                'bindid=:bindid AND gw=:gw', 
                                array(':bindid'=>$bindId,'gw'=>$gw)
                            );
                    if($res) echo '解绑成功!';
                    else echo '解绑失败';
                }
            } else {
                echo $result['errorMsg'];exit;
            }
            
        } else {
            exit('异步信息返回有误');
        }
    }
    
    private function _decrept(){
        $result = array();
//        $request = Yii::app()->request;
        $encryptKeyData = $this->getParam('encryptKey');
        $encryptData= $this->getParam('encryptData');
        $signData = $this->getParam('signData');
        $key=GhtPay::rsaDecrypt($encryptKeyData);
        $xmlData=GhtPay::aseDecrypt($encryptData,$key);
        $signIstrue=GhtPay::verify_sign($xmlData, base64_decode($signData));
        if(!$signIstrue){
            $result['errorMsg'] = '验签失败';
        }else{
            $xmlToArray=@simplexml_load_string($xmlData);
            $head=$xmlToArray->head;
            $body=$xmlToArray->body;
            $resCode=$xmlToArray->head->respCode;
          if(!empty($head) && !empty($body)){
            if($resCode=='000000'){
                $result['gw'] = $body->userId;
                $result['info']=$xmlToArray;
            }else{
                $result['errorMsg'] = '解绑失败';
            } 
           }else{
                $result['errorMsg'] = '异步信息错误';
           }
        }
        
        return $result;
    }
}
