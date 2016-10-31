<?php

/**
 * 回收积分
 * @author qinghao.ye
 */
class RecoverCommand extends CConsoleCommand {


    /**
     * 回收积分-2016-07-25
     */
    public function actionDo()
    {

    	$flowTableName = AccountFlow::monthTable(); //流水按月分表日志表名

		//充值记录
		$recharges = array('21047'=>'394.00','21051'=>'394.00');

    	$error = array();
    	$trans = Yii::app()->db->beginTransaction();
    	try{
    		foreach ($recharges as $id=>$amount)
    		{
    			$flows = array();
				//充值记录
    			$rechargeRecord = Yii::app()->db->createCommand(
					"SELECT * FROM gaiwang.`gw_recharge` WHERE `id` = :id AND `status` <> :status")
					->bindValues(array(':id'=>$id,':status'=> 3))
					->queryRow();
                if(empty($rechargeRecord)){
                    $error['none'][] = $id;
                    continue;
                }
				//消费会员账户
				$arr = array('account_id' => $rechargeRecord['member_id'], 'type' => AccountBalance::TYPE_CONSUME, 'gai_number' => $rechargeRecord['by_gai_number']);
				$memberAccount = AccountBalance::findRecord($arr);
				if($memberAccount['today_amount'] < $amount)
				{
					$error['account'][] = $id;
					echo 'error '.$id.' - '.$memberAccount['today_amount'].PHP_EOL;
					continue;
				}
				//旧流水
				$oldFlow = Yii::app()->db->createCommand(
					"SELECT * FROM account.`gw_account_flow_201604` WHERE `account_id` = :mid AND order_id=:oid")
					->bindValues(array(':mid'=>$rechargeRecord['member_id'],':oid'=> $rechargeRecord['id']))
					->queryRow();
				if(empty($oldFlow)){
					$error['oldFlow'][] = $id;
					continue;
				}
				unset($oldFlow['id']);
				unset($oldFlow['date']);
				unset($oldFlow['create_time']);
				unset($oldFlow['debit_amount']);
				unset($oldFlow['credit_amount']);
				unset($oldFlow['remark']);
				//新流水
				$time = time();
    			$flows = array_merge($oldFlow,array(
    					'date' => date('Y-m-d',$time),
    					'create_time' => $time,
    					'debit_amount' => 0.00,
    					'credit_amount' => -$amount,
    					'remark' => '扣除积分，退款金额：￥' . $amount,
    			));
				if($id == '21051'){
					$flows['remark'] = '扣除积分';
				}
				//扣回积分
    			if (!AccountBalance::calculate(array('today_amount' => -$amount), $memberAccount['id'])) {
    				throw new Exception('update memberAccount error');
    			}
    			//写入流水
				Yii::app()->db->createCommand()->insert($flowTableName, $flows);
				//更新充值状态
				$sql = 'UPDATE gaiwang.`gw_recharge`  SET `status`=:status, remark="RECOVERED"  WHERE id = :id';
				Yii::app()->db->createCommand($sql)->execute(array(':status'=>3,':id'=>$id));
                echo 'success '.$id.PHP_EOL;
    		}
    		$trans->commit();
    	} catch (Exception $e) {
            $trans->rollback();
            print_r($e->getMessage());
        }
        
        echo 'error'.PHP_EOL;print_r($error);
    }
    
}
