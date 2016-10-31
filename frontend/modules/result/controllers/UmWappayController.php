<?php

/**
 * 处理 优势联动微商城（WAP/HTML5） 推送的对账消息
 * Class UmWappayController
 * @author wyee <yanjie.wang@g-emall.com>
 */
class UmWappayController extends Controller {

    public function actionIndex() {
        $result = OnlineWapPay::umPayCheck();
               
        if (!isset($result['errorMsg'])) {
            //保存推送数据结果
            Process::savePayResult($result,Order::PAY_ONLINE_UM);
            //处理完毕，应答接口,放在事务之后
            $response = $this->_getResponse($result);
            
            //商品订单支付处理
            if ($result['orderType'] == OnlineWapPay::ORDER_TYPE_GOODS) {
                $orders = Order::getOrdersByParentCode($result['parentCode'],$result['code']);
                if (empty($orders)) exit('order null');
                Process::orderPay($result, $orders, OnlineWapPay::PAY_UM_QUICK, $response);
            }    
          
        } else {
            echo $result['errorMsg'];
        }
    }

    /**
     * 组装相应数据
     * @param $result
     * @return mixed
     */
    private function _getResponse($result){
        $html = <<<EOF
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <META NAME="MobilePayPlatform" CONTENT="{data}" />
</head>
EOF;
        $params = array(
            'mer_id'=>$result['mer_id'],
            'version'=>'4.0',
            'order_id'=>$result['order_id'],
            'mer_date'=>$result['mer_date'],
            'ret_code'=>'0000',
        );
        $plain = RsaPay::plain($params);
        $sign = RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $params['sign'] = $sign;
        $params['sign_type'] = 'RSA';
        return str_replace('{data}',RsaPay::plain($params),$html);
    }

}
