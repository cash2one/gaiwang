<?php

/**
 * 处理 通联支付微商城（WAP/HTML5） 推送的对账消息
 * 不需要给通联应答
 * Class TlzfWappayController
 * @author wyee <yanjie.wang@g-emall.com>
 */
class TlzfWappayController extends Controller {
    
    public function actionIndex() {
        $result = OnlineWapPay::tlzfPayCheck();        
        if (!isset($result['errorMsg'])) {
            //保存推送数据结果
            Process::savePayResult($result,Order::PAY_ONLINE_TLZF);
            $response='';
            //商品订单支付处理
            if ($result['orderType'] == OnlineWapPay::ORDER_TYPE_GOODS) {
                $orders = Order::getOrdersByParentCode($result['parentCode'],$result['code']);
                if (empty($orders)) exit('order null');
                Process::orderPay($result, $orders, OnlineWapPay::PAY_TLZF,$response);
            }    
          
        } else {
            echo $result['errorMsg'];
        }
    }


}
