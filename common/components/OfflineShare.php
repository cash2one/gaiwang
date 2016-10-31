<?php 
/**
 * 对账分配
 * @author qinghao.ye <qinghao.ye@g-emall.com>
 */
class OfflineShare
{
    /**
     * 抛出异常
     * @param string $error
     * @param array $param
     * @throws Exception
     */
    public static function throwError($error,$param=array())
    {
        throw new Exception(Yii::t("OfflineShare", $error, $param));
    }

    public static function checkRecordData($record_data = array())
    {
        if(empty($record_data))
        {
            throw new Exception(Yii::t("OfflineShare", '未对账的消费记录不存在'));
        }
        // 禁止重复对账
        if($record_data['status'] != FranchiseeConsumptionRecord::STATUS_NOTCHECK)
        {
            throw new Exception(Yii::t("OfflineShare", '未对账的记录才能分配'));
        }
        // 禁止重复分配
        if($record_data['is_distributed'] != FranchiseeConsumptionRecord::IS_DISTRIBUTED_NO)
        {
            throw new Exception(Yii::t("OfflineShare", '该记录此前已完成了分配'));
        }
        // 除了来自盖网通和售货机的消费，其他不对账
        if($record_data['record_type'] != FranchiseeConsumptionRecord::RECORD_TYPE_POINT && $record_data['record_type'] != FranchiseeConsumptionRecord::RECORD_TYPE_VENDING)
        {
            self::throwError('暂时只支付盖网通和售货机的消费对账');
        }
        // 消费金额
        if($record_data['spend_money'] <= 0)
        {
            self::throwError('消费金额异常');
        }
        // 消费类型
        if($record_data['record_type'] == false)
            self::throwError('record_type参数错误');
        // 币种
        if($record_data['symbol'] === false)
        {
            self::throwError('消费币种异常');
        }
        elseif($record_data['symbol'] == 'HKD')
        {
            Yii::app()->language = 'zh_tw';
        }
        else
        {
            Yii::app()->language = 'zh_cn';
        }
    }

    public static function checkSettingRule(){

    }

    public static function run($record_id){

        $time = time();



        $transaction = Yii::app()->db->beginTransaction();
        try {
            $db_gaiwang = Yii::app()->db;
            $db_gaitong = Yii::app()->gt;
            $db_account = Yii::app()->ac;

            # 锁行
            $record_table = FranchiseeConsumptionRecord::model()->tableName();
            $sql_record = "select * from $record_table where id = {$record_id} and  is_checked={FranchiseeConsumptionRecord::IS_CHECKED_NO} for update";
            $record_data = $db_gaiwang->createCommand($sql_record)->queryRow();


            # 检查数据规范
            self::checkRecordData($record_data);

            # 检查配置的对账条件
            self::checkSettingRule();

            //创建相关流水表
            $account_flow_table = AccountFlow::monthTable();

            # 角色分配
            self::runDistribution($record_data);

            # 更新消费记录信息

            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollBack();
            throw new Exception($e->getMessage());
            return false;
        }

    }

    /**
     * 角色分配
     */
    public static function runDistribution($record){
        # 获取消费所在的机器信息
        $sql = "select * from {db} where id={id}";
        $sql = self::reSql($sql,array('{db}'=>Machine::model()->tableName(),'{id}'=>$record['machine_id']));
        $machine = Yii::app()->db->createCommand($sql)->queryRow();


        # 获取各个角色信息，并生成流水
        OfflineRole::getAgent($machine['id']);





    }

    public static function reSql($sql,array $params){
        $search = array_keys($params);
        $replace = array_values($params);
        return str_replace($search,$replace,$sql);
    }

    
}


?>