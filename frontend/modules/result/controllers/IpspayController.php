<?php

/**
 * 处理 环迅支付 推送的对账消息
 * Class IpspayController
 * @author zhenjun_xu <412530435@qq.com>
 */
class IpspayController extends Controller {

    public function actionIndex() {
        $result = OnlinePay::ipsPayCheck();
        if (!isset($result['errorMsg'])) {
            //保存推送数据结果
            Process::savePayResult($result,Order::PAY_ONLINE_IPS);
            //单纯积分充值处理
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_RECHARGE) {
                $order = Recharge::getOneByCode($result['code']);
                if(!$order) exit('order null');
                Process::recharge($result, $order, 'ipscheckok');
            }
            //echo 'ipscheckok'; //处理完毕，应答接口,放在事务之后
            //订单支付处理
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_GOODS) {
                $orders =  Order::getOrdersByParentCode($result['parentCode'],$result['code']);
                if (empty($orders)) exit('order null');
                Process::orderPay($result, $orders, OnlinePay::PAY_IPS, 'ipscheckok');
            }
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_HOTEL) {
                $order = HotelOrder::getOrderByCode($result['parentCode'],$result['code']);
                if(!$order) exit('order null');
                Process::hotelOrderPay($result, $order, OnlinePay::PAY_IPS, 'ipscheckok');
            }
        } else {
            echo $result['errorMsg'];
        }
    }

}
