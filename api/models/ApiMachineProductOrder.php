<?php
class ApiMachineProductOrder extends ApiModel {
    public $tableName = '{{machine_product_order}}';

    public static function addOrder($orderCode,$machineId,$memberId,$userPhone,$payType,$moneyRMB,$marketPrice,$original_price,$ip,$franchiseeId,$symbol,$basePrice){
        $now = time();
        $orderData = array(
                'code' => $orderCode,
                'machine_id' => $machineId,
                'member_id' => $memberId,
                'phone' => $userPhone,
                'pay_type' => $payType,
                'status' => '1',
                'pay_status' => '2',
                'consume_status' => '1',
                'pay_price' => $moneyRMB,
                'real_price' => $moneyRMB,
                'original_price' => $marketPrice,
                'return_money' => '0',
                'create_time' => $now,
                'pay_time' => $now,
                'consume_time' => '0',
                'is_read' => '0',
                'ip_address' => $ip,
                'remark' => '',
                'franchisee_id' => $franchiseeId,
                'symbol' => $symbol,
                'base_price' => $basePrice
        );
        $status = Yii::app()->db->createCommand()->insert('{{machine_product_order}}', $orderData);
        return $status ? Yii::app()->db->getLastInsertID() : false;
    }
    
    public static function addOrderDetial($orderId,$goods,$quantity,$verifyCode){
        $orderData = array(
            'machine_product_order_id' => $orderId,
            'product_id' => $goods['id'],
            'product_name' => $goods['name'],
            'quantity' => $quantity,
            'product_thumbnail_id' => $goods['thumbnail_id'],
            'total_price' => $goods['price']*$quantity,
            'price' => $goods['price'],
            'original_price' => $goods['price']*$quantity,
            'return_money' => 0,
            'verify_code' => $verifyCode,
            'is_consumed' => 0,
            'remark' => '',
            'gw_rate' => Common::getConfig('allocation','gaiIncome'),
            'gt_rate' => $goods['gt_rate'],
            'back_rate' => $goods['back_rate'],
        );
        $status = Yii::app()->db->createCommand()->insert('{{machine_product_order_detail}}', $orderData);
        return $status ? Yii::app()->db->getLastInsertID() : false;
    }
    

}

?>