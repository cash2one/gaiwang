<?php

/**
 * 处理 微商城 翼支付 推送的对账消息
 * Class BestWappayController 修改  BestpayController
 * @author wyee <yanjie.wang@g-emall.com>
 */
class BestWappayController extends Controller {
    public function actionIndex() {
        $result = OnlineWapPay::bestPayCheck();
        if (!isset($result['errorMsg'])) {
            //保存推送数据结果
            Process::savePayResult($result,Order::PAY_ONLINE_BEST); 
            //商品订单支付处理
            if ($result['orderType'] == OnlineWapPay::ORDER_TYPE_GOODS) {
                $orders = Order::getOrdersByParentCode($result['parentCode'],$result['code']);
                if (empty($orders)) exit('order null');
                Process::orderPay($result, $orders, OnlineWapPay::PAY_BEST, 'UPTRANSEQ_' . $result['uptranseq']);
            }
        } else {
            echo $result['errorMsg'];
        }
    }

}
