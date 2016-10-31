<?php

class DataMoveCommand extends CConsoleCommand {

    /**
	 * 将月流水表转移到散列表中
	 * Enter description here ...
	 * 昨天的数据转移，每天凌晨执行
	 * @author LC
	 */
	public function actionFlowMove()
	{
		@ini_set('memory_limit', '4000M');
		@ini_set("max_execution_time", "0");
		AccountFlow::moveHashTable();
		
		echo 'success';
	}
	
	/**
	 * 检测月流水是否转移到单列表中
	 * @author LC
	 */
	public function actionCheckFlowMove()
	{
		@ini_set('memory_limit', '4000M');
		@ini_set("max_execution_time", "0");
		AccountFlow::checkHashTable();
	}

}
