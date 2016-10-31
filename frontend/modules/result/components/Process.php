<?php

/**
 * 处理支付结果
 *
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 14-4-18
 * Time: 上午11:13
 */
class Process {
    /**
     * 保存推送日志,存在则更新次数，不存在则新增
     * @param array $result GET or POST
     * @param $payType
     */
    public static function savePayResult($result,$payType){
        $db = Yii::app()->db;
        $sql = 'SELECT id FROM gw_pay_result WHERE code=:code';
        $log = $db->createCommand($sql)->bindValue(':code',$result['parentCode'])->queryRow();
        if($log){
            $sql = 'UPDATE gw_pay_result SET times=times+1,update_time=:t WHERE id=:id';
            $db->createCommand($sql)->bindValues(array(':t'=>time(),':id'=>$log['id']))->execute();
        }else{
            $db->createCommand()->insert('gw_pay_result',array(
                'code'=>$result['parentCode'],
                'pay_result'=> $payType==Order::PAY_ONLINE_IPS || $payType==Order::PAY_ONLINE_UM ? serialize($_GET) : serialize($_POST),
                'pay_type'=>$payType,
                'order_type'=>$result['orderType'],
                'update_time'=>time(),
                'create_time'=>time(),
                'times'=>1,
            ));
        }
    }
    /**
     * 积分充值 处理
     * @param array $result
     * @param array $order
     * @param string $response 响应接口字符串
     */
    public static function recharge(Array $result, $order, $response) {
        if ($order['money'] == $result['money']) {
            if (RechargeProcess::operate($order, $result)){
                echo $response;
            }else{
               echo '对账失败';
            }
        }else{
            echo '订单金额不对';
        }
    }

    /**
     * 在线订单支付处理
     * @param array $result 在线支付响应的结果
     * @param array $orders 订单信息
     * @param string $payType 支付类型(0:环迅 1:银联 2:翼支付)
     * @param string $response 响应接口字符串
     */
    public static function orderPay(array $result, $orders, $payType, $response) {
        $payPrice = 0;
//                    var_dump($orders);exit;
        foreach ($orders as $order) {
            $payPrice =bcadd($payPrice,bcsub($order['pay_price'],$order['jf_price'],2),2);
            
        }
//        echo $payPrice;exit;
        $status = Tool::floatcmp($payPrice, $result['money']);
        if ($status || in_array($orders[0]['source_type'],array(Order::SOURCE_TYPE_JFXJ,Order::SOURCE_TYPE_SINGLE))) { //如果支付金额等于订单金额，或者是特殊商品的订单
            if (OnlinePayment::payWithUnionPay($orders, $result, $payType)) {
                echo $response;
            }else{ 
                echo '对账失败';
            }
        }else{
            echo '订单金额不对';
        }
    }

    /**
     * 酒店订单支付处理
     * @param array $result 酒店订单响应的结果
     * @param array $order 订单信息
     * @param string $payType 支付类型(0:环迅 1:银联 2:翼支付)
     * @param string $response 响应接口字符串
     */
    public static function hotelOrderPay(array $result, $order, $payType, $response) {
        $lotteryPrice = $order['is_lottery'] == HotelOrder::IS_LOTTERY_YES ? $order['lottery_price'] : 0.00; // 抽奖支付金额
        $orderAmount = bcadd($order['total_price'], $lotteryPrice, HotelCalculate::SCALE); // 订单总额
        if ($orderAmount == $result['money']) {
            if (HotelPayment::payWithThirdParty($order, $result) === true) {
                echo $response;
            }else{
                echo '对账失败';
            }
        }else{
            echo '订单金额不对';
        }
    }
    
    /**
     * 联动优势首次支付绑定协议号入库操作处理  
     * @param array $result
     */
    public static function umUserAgreeId($result){
            
         if(!empty($result['usr_pay_agreement_id'])){   
              $bank['gw']=$result['gw'];
              $bank['bank']=$result['gate_id'];
              $bank['card_type']=$result['pay_type'];
              $bank['mobile']=$result['media_id'];
              $bank['pay_agreement_id']=$result['usr_pay_agreement_id'];
              $bank['busi_agreement_id']=$result['usr_busi_agreement_id'];
              $bank['bank_num']=$result['last_four_cardid'];
              $bank['create_time']=time();
             //判断pay_agreement_id是否跟$result['usr_pay_agreement_id']相等，相等不插入，不相等插入数据
             //2015-8-19修改一个卡可以绑定多个gw号
             $model=new PayAgreement;
             $payAgr=PayAgreement::model()->exists(array(
                     'condition'=>'pay_agreement_id=:pay_agreement_id AND gw=:gw',
                     'params'=>array(':pay_agreement_id'=>$result['usr_pay_agreement_id'],':gw'=>$result['gw']),
             ));
             if(empty($payAgr)){
                 $model->attributes=$bank;
                 $model->save();
                 return "快捷支付绑定成功";
             }else{
                 return "已经绑定过快捷支付";
             } 
          }else{
               return "快捷支付绑定失败";
          }    
    }

}
