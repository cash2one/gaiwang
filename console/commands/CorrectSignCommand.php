<?php
class CorrectSignCommand extends CConsoleCommand
{
	/**
	 * 删除自动签收多出的流水
	 * @author LC
	 */
	public function actionIndex()
	{
		$flowTableName = 'gw_account_flow_201502';
		$sql = "SELECT gai_number,order_code,operate_type,node,remark,transaction_type,ip,COUNT(id) as t, GROUP_CONCAT(id) as ids FROM ".$flowTableName." WHERE node IN (0214,0213,0211,0201,0212) AND operate_type = 2
GROUP BY order_code,operate_type,node,remark,transaction_type,ip HAVING COUNT(id)>1;";
		$data = Yii::app()->ac->createCommand($sql)->queryAll();  //查出多出的流水
		
		foreach ($data as $row)
		{
			$hashTable = AccountFlow::hashTable($row['gai_number']);
			$row['t'] = $row['t']-1;
			$deleteSql = "DELETE FROM $flowTableName WHERE id IN (".$row['ids'].") ORDER BY id DESC LIMIT ".$row['t'].";";
			
			$sql = "SELECT GROUP_CONCAT(id) as ids,COUNT(id) as t FROM $hashTable 
WHERE node IN (0214,0213,0211,0201,0212) AND operate_type = 2 AND gai_number = '".$row['gai_number']."' AND order_code = '".$row['order_code']."' AND operate_type = '".$row['operate_type']."' AND node = '".$row['node']."' AND remark = '".$row['remark']."' AND transaction_type = '".$row['transaction_type']."' AND ip = '".$row['ip']."';";
			$deleteData = Yii::app()->ac->createCommand($sql)->queryRow();//在散列表里查出对应多出的流水
			if(!empty($deleteData) && $deleteData['t']>1)
			{
				$deleteData['t'] = $deleteData['t']-1;
				$deleteSql .= "DELETE FROM $hashTable WHERE id IN (".$deleteData['ids'].") ORDER BY id DESC LIMIT ".$deleteData['t'].";";
			}
			
			$transaction = Yii::app()->ac->beginTransaction();
			try {
				Yii::app()->ac->createCommand($deleteSql)->execute();
				$transaction->commit();
			} catch (Exception $e) {
				$transaction->rollBack();
			}
		}
		
	}
}