<?php

/**
 * 补充充值短信发送
 * @author zc
 */
class SupplRechargeSmsCommand extends CConsoleCommand {    
    
    const STATUS_NO = 0;
    const STATUS_YES = 1;
    /**
     * 补充充值短信
     */
    public function actionSuppl()
    {
        $data = Yii::app()->db->createCommand()->select('id,mobile,card_num,value,gai_num,target_id,status,content')
                ->from('bc_suppl_recharges_sms')->where('status=:status',array(':status'=>self::STATUS_NO))->queryAll();

        if(!empty($data)){
            foreach ($data as $arr) {
                
                $transaction = Yii::app()->db->beginTransaction();
                try{
                    
                Yii::app()->db->createCommand()->select('status')->from('bc_suppl_recharges_sms')->where('id = ' . $arr['id'] . ' FOR UPDATE')->queryRow();
                
                if ($arr['mobile'] && $arr['status'] == self::STATUS_NO) {
                    $msg = '尊敬的'.$arr['gai_num'].'用户，您使用了充值卡'.$arr['card_num'].'充值成功，获得了'.$arr['value'].'盖网积分，'.$arr['content'].'。';
                    $flag = SmsLog::addSmsLog($arr['mobile'], $msg, $arr['target_id'], SmsLog::TYPE_CARD_RECHARGE); // 记录并短息日志   
                    if($flag == true) {
                        Yii::app()->db->createCommand()->update('bc_suppl_recharges_sms', array('status' => self::STATUS_YES, ), 'id=:id', array(':id' => $arr['id']));
                    } else {
                        throw new Exception('SupplSms error');
                    }
                }
                
                $transaction->commit();

                }catch (Exception $e) {                          
                    $transaction->rollback();
                    echo 'fail:'.$e->getMessage(),"\n\r";
                }      
            }            
        }
    }
}

