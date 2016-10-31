<?php

/**
 * 处理 高汇通 推送的对账消息
 * Class GhtpayController
 * @author wyee <yanjie.wang@g-emall.com>
 */
class GhtpayController extends Controller {

    public function actionIndex() {
        $result = OnlinePay::ghtPayCheck();
        if (!isset($result['errorMsg'])) {
            //保存推送数据结果
            Process::savePayResult($result,Order::PAY_ONLINE_GHT);
            
            $response ='success';
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
                Process::orderPay($result, $orders, $result['zfType'], $response);
            }
            //酒店订单
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_HOTEL) {
                $order = HotelOrder::getOrderByCode($result['parentCode'],$result['code']);
                if(!$order) exit('order null');
                Process::hotelOrderPay($result, $order, OnlinePay::ORDER_TYPE_HOTEL, $response);
            }
        } else {
            echo $result['errorMsg'];
        }
    }

}
