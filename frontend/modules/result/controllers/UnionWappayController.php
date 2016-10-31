<?php

/**
 * 处理银联推送的对账消息
 * @author wyee<yanjie.wang@g-emall.com>
 */
class UnionWappayController extends Controller {

    public function actionIndex() {
        $result = OnlineWapPay::unionPayCheck();
        if (!isset($result['errorMsg'])) {
            //保存推送数据结果
            Process::savePayResult($result,Order::PAY_ONLINE_UN);
            
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_RECHARGE) {
                $order = Recharge::getOneByCode($result['code']);
                if(!$order) exit('order null');
                Process::recharge($result, $order, 'OK');
            }

                        //订单支付处理
            if ($result['orderType'] == OnlineWapPay::ORDER_TYPE_GOODS) {
                $orders =  Order::getOrdersByParentCode($result['parentCode'],$result['code']);
                if (empty($orders)) exit('order null');
                Process::orderPay($result, $orders, OnlinePay::PAY_UNION,'ok');
            } 
        } else {
            echo $result['errorMsg'];
        }
    }  

}
