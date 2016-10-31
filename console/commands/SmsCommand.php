<?php

/**
 * 短信队列
 * @author csj
 */
class SmsCommand extends CConsoleCommand {

    /**
     * 发送短信认任务
     *
     * @param int $limit 每次运行发送条数
     */
    public function actionRun($limit=10) {
    	
    	$criteria = new CDbCriteria();
    	$criteria->select = 'id,mobile,status,content';
    	$criteria->order = 'create_time';
    	$criteria->condition = 'status='.SmsQueue::STATUS_UNSEND;
    	$criteria->limit = $limit;
    	
    	$smss = SmsQueue::model()->findAll($criteria);
    	
		 if (empty($smss)){
		 	echo 'over';
		 	Yii::app()->end();
		 }
		 
		 $success_count = 0;
		 foreach ($smss as $sms){
		 	$rs = Sms::send($sms->mobile, $sms->content);
		 	
		 	$sms->send_time = time();
		 	$sms->status = $rs['result']==0?SmsQueue::STATUS_SENDED:SmsQueue::STATUS_FAIL;
		 	$sms->send_details = serialize($rs);
		 	$sms->save();
		 	
		 	if ($rs['result']==0) $success_count++;
		 	
		 }
		 
		 echo 'send '.$success_count.' message successfully';
		 Yii::app()->end();
    	
        
    }
    
    
    /**
     * 每个季度转移数据
     */
    public function actionTransfer()
    {
        try {
            $his_db_name = 'gaiwang_history'; //历史表名
            $db = Yii::app()->db;
            $nowYear = intval(date('Y'));
            $nowMonth = intval(date('m'));
            $backupTime = strtotime(date('Ym',strtotime('-3 month')).'01');
            $smsTable = SmsLog::tableName();
            while(true)
            {
                $sql = 'select id,create_time from '.$smsTable.' where create_time < '.$backupTime.' order by id asc limit 1';
                $sms = $db->createCommand($sql)->queryRow();
                if(empty($sms)) break;
                //建立季度表  存在不建，不存在则建立
                $season = ceil((date('n',$sms['create_time']))/3);
                $tableName = 'gw_sms_log_'.date('Y',$sms['create_time']).'_'.$season;
                $sql = " SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='{$his_db_name}' AND TABLE_NAME='{$tableName}'";
                $isExistextable = $db->createCommand($sql)->queryRow();
                if(!$isExistextable)
                {
                    $sql ="CREATE TABLE `{$his_db_name}`.`{$tableName}` LIKE gaiwang.`{$smsTable}`";
                    $db->createCommand($sql)->execute();
                }
                
                //进行备份删除操作
                $time_start = strtotime(date("Y-m-01",$sms['create_time']));
                $time_end = strtotime(date('Ymd',$time_start)."+1 month");
                
                $transaction = $db->beginTransaction();
                $where = " where create_time >= {$time_start} and create_time < {$time_end} ";
                $int_sql = "INSERT INTO `{$his_db_name}`.$tableName SELECT * FROM {$smsTable} ".$where;
                $del_sql = "DELETE FROM `{$smsTable}` ".$where;
                
                if($db->createCommand($int_sql)->execute() && $db->createCommand($del_sql)->execute())
                {
                    $transaction->commit();
                }
            }
        }catch(Exception $e){
            if(isset($transaction))$transaction->rollBack();
            echo $e->getMessage();
        }

    }
    
    
    /**
     * 补发盖网通未发送的短信，5分钟执行一次
     * 修改为非验证码短信都进行补发---2015-07-20
     * @author LC
     */
    public function actionAgain()
    {
    	SmsLog::againSmsLog();
    	echo "\n".'success'."\n";
    }
    

}
