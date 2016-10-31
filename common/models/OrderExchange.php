<?php

class OrderExchange extends CActiveRecord{

    public function tableName() {
        return "{{order_exchange}}";
    }

    static public function model($className = __CLASS__){
        return parent::model($className);
    }

    public static function checkOrderById($orderId){
        $result = Yii::app()->db->createCommand()->select('exchange_id')->from("{{order_exchange}}")->where("order_id=:order_id",array(':order_id'=>$orderId))->order('exchange_id desc')->limit(1)->queryRow();
        return $result;
    }

    //检测是否自我取消的订单
    public static function checkOrderStatus($orderId){
        $result = Yii::app()->db->createCommand()->select('exchange_id')->from("{{order_exchange}}")->where("order_id=:order_id AND exchange_status=:status",array(':order_id'=>$orderId,':status'=>Order::EXCHANGE_STATUS_CANCEL))->order('exchange_id desc')->limit(1)->queryRow();
        return $result;
    }

    //检测申请次数是否大于3次
    public static function checkOrderCount($orderId){
        $result = Yii::app()->db->createCommand()->select('count(exchange_id) as cid')->from("{{order_exchange}}")->where("order_id=:order_id",array(':order_id'=>$orderId))->queryRow();
        return ($result['cid'] < 3) ? true : false;
    }
}


?>