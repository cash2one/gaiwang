<?php

/**
 * This is the model class for table "{{franchisee_consumption_pay_result_log}}".
 *
 */
class FranchiseeConsumptionPayResultLog extends CActiveRecord
{
    
    const RESULT_STATUS_FAIL = 0;		//0表示没交易完成 交易失败
    const RESULT_STATUS_FINISH = 1;		//已完成
    
    const PAY_TYPE_UM = 1;//联动支付
    const PAY_TYPE_TL = 2;//通联支付
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{franchisee_consumption_pay_result_log}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FranchiseeConsumptionRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 记录结果
     * @param string $orderId 订单号
     * @param int $payType 类型
     * @param string $result
     * @param array $params
     * @param string $log
     */
    public static function savelog($orderId,$resultStatus,$params,$log='',$payType = self::PAY_TYPE_UM)
    {
        try {
            $db = Yii::app()->db;
            $resultlog = $db->createCommand()
                        ->select('id,request_times')
                        ->from(self::tableName())
                        ->where('serial_number=:orderId',array(':orderId'=>$params['order_id']))
                        ->queryRow();
            $is_New = empty($resultlog)?true:false;
            $time = time();
//             $transaction = $db->beginTransaction();
            if($is_New)
            {
                $db->createCommand()->insert(self::tableName(),
                array(
                'serial_number'=>$orderId,
                'pay_type'=>$payType,
                'platform_result'=>serialize($params),
                'result_status'=>$resultStatus,
                'result_log'=>$log,
                'create_time'=>$time,
                'update_time'=>$time,
                'request_times'=>1,
                ));
            }else{
                self::model()->updateByPk(
                        $resultlog['id'],array(
                        'pay_type'=>$payType,
                        'platform_result'=>serialize($params),
                        'result_status'=>$resultStatus,
                        'result_log'=>$log,
                        'update_time'=>$time,
                        'request_times'=>($resultlog['request_times']+1)
                        ));
            }
        } catch (Exception $e) {
//             if(isset($transaction))$transaction->rollBack();
            throw new ErrorException($e->getMessage());
        }
        
    }
    
    /**
     * 错误结果
     * @param string $orderId
     * @param array $params
     * @param log $log
     * @param 支付 $payType
     */
    public static function errorlog($orderId,$params,$log,$payType = self::PAY_TYPE_UM)
    {
        self::savelog($orderId, self::RESULT_STATUS_FAIL, $params,$log);
    } 
    
    /**
     * 成功结果
     * @param string $orderId
     * @param array $params
     * @param log $log
     * @param 支付 $payType
     */
    public static function successlog($orderId,$params,$log,$payType = self::PAY_TYPE_UM)
    {
        self::savelog($orderId, self::RESULT_STATUS_FAIL, $params,$log);
    }
    
}
