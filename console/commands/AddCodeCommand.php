<?php

/**
 *
 * 提现流水添加订单编号
 *
 *
 * @author zhenjun.xu
 */
class AddCodeCommand extends CConsoleCommand {

    public function actionDo(){
        @ini_set('memory_limit','1280M');
        $sql = 'select id,code,member_id from gw_cash_history';
        $command = Yii::app()->db->createCommand($sql);
        $dataReader = $command->query();

        // 重复调用 read() 直到它返回 false
        while(($data=$dataReader->read())!==false) {
            if(empty($data['code'])){
                $code = Tool::buildOrderNo(20,3);
                $sql = 'update gw_cash_history set code=:code where id=:oid;';
                //更新流水
                $sql .= 'update account.`gw_account_flow_201501` set order_code=:code where account_id=:mid and order_id=:oid and transaction_type in(10,11);';
                $sql .= 'update account.`gw_account_flow_201502` set order_code=:code where account_id=:mid and order_id=:oid and transaction_type in(10,11);';
                $sql .= 'update account.`gw_account_flow_201503` set order_code=:code where account_id=:mid and order_id=:oid and transaction_type in(10,11);';
                Yii::app()->db->createCommand($sql)->bindValues(array(':code'=>$code,':mid'=>$data['member_id'],':oid'=>$data['id']))->execute();
                echo $data['id'],"\n\r";
            }
        }

    }



}
