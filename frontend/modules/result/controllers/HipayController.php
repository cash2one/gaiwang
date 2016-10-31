<?php

/**
 * 处理 汇卡支付 推送的对账消息
 * Class HipayController
 * @author zhenjun_xu <412530435@qq.com>
 */
class HipayController extends Controller {

    public function actionIndex() {
        $result = OnlinePay::hiPayCheck();
        if (!isset($result['errorMsg'])) {
            //保存推送数据结果
            Process::savePayResult($result,Order::PAY_ONLINE_HI);
            //单纯积分充值处理
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_RECHARGE) {
                $order = Recharge::getOneByCode($result['code']);
                if(!$order) exit('order null');
                Process::recharge($result, $order, 'OK');
            }
            //echo 'OK'; //处理完毕，应答接口,放在事务之后
            //订单支付处理
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_GOODS) {
                $orders =  Order::getOrdersByParentCode($result['parentCode'],$result['code']);
                if (empty($orders)) exit('order null');
                Process::orderPay($result, $orders, OnlinePay::PAY_UNION, 'OK');
            }
            if ($result['orderType'] == OnlinePay::ORDER_TYPE_HOTEL) {
                $order = HotelOrder::getOrderByLock($result['parentCode']);
                if(!$order) exit('order null');
                Process::hotelOrderPay($result, $order, OnlinePay::PAY_UNION, 'OK');
            }
        } else {
            echo $result['errorMsg'];
        }
    }

}
