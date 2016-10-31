<?php
/**
 * 自动对账的脚本
 */
class AutoCheckCommand extends CConsoleCommand
{
	public function actionCheck()
	{
        die('脚本暂停');
        try {
        	//先查出最近的那笔已经自动对账的
        	$id = Yii::app()->db->createCommand("select id from {{franchisee_consumption_record}} 
        										where auto_check_fail<>'' order by id desc limit 1")
        				->queryScalar();
        	//在将未自动对账的查询出来，进行自动对战
			$ids = false;
			if($id == false)
			{
				$id = 0;
			}
        //当时间是凌晨的时候拿出所有的未对账的单进行自动对账，并排除申请中或者撤销中的
        	$cur_hour = date('H');
        	if($cur_hour>=2 && $cur_hour<=7){
        		$start_time = strtotime('2014-06-25 00:00:00');
        		$sql = "SELECT a.id,b.id as confirm_id,c.id as repeal_id,a.symbol FROM {{franchisee_consumption_record}} a 
						LEFT JOIN {{franchisee_consumption_record_confirm}} b ON (a.id=b.record_id AND b.`status`=0)
						LEFT JOIN {{franchisee_consumption_record_repeal}} c ON  (a.id=c.record_id AND c.`status`=0)
						WHERE a.`status`=".FranchiseeConsumptionRecord::STATUS_NOTCHECK." AND a.is_auto=0 AND a.create_time>$start_time";
        			$ids = Yii::app()->db->createCommand($sql)
        				->queryAll();
        			
        	}
        	else 
        	{
        		$ids = Yii::app()->db->createCommand("SELECT a.id,b.id as confirm_id,c.id as repeal_id ,a.symbol
        				FROM {{franchisee_consumption_record}} a 
						LEFT JOIN {{franchisee_consumption_record_confirm}} b ON (a.id=b.record_id AND b.`status`=0)
						LEFT JOIN {{franchisee_consumption_record_repeal}} c ON  (a.id=c.record_id AND c.`status`=0)
						WHERE a.id>$id AND a.`status`=".FranchiseeConsumptionRecord::STATUS_NOTCHECK." AND a.is_auto=0")
        				->queryAll();
        	}
        	if($ids)
        	{
        		foreach ($ids as $row)
        		{
        			if(isset($row['confirm_id']) && $row['confirm_id'] != '')
        			{
        				continue;
        			}
        			if(isset($row['repeal_id']) && $row['repeal_id'] != '')
        			{
        				continue;
        			}
        			$symbol = $row['symbol'];
        			if($symbol === false)
        			{
        				continue;
        			}
        			if($symbol == 'HKD')
        			{
        				Yii::app()->language = 'zh_tw';
        			}
        			else 
        			{
        				Yii::app()->language = 'zh_cn';
        			}
        			FranchiseeConsumptionRecord::autoRecon($row['id']);
        		}
        	}
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
	}
	/**
	 * 自动对账
	 */
	public function actionVerify()
	{
	    
	    while(true)
	    {
            $this->addLog('autochecktime.log','start');
            $sleep = 30;
            $limit = 30;//300
            $hours = date("H");
            if($hours > 1 && $hours < 8){
                $sleep = 10*60;
                $limit = 100;
            }
        	try {
        		//先查出最近的那笔已经自动对账的
        		$id = Yii::app()->db->createCommand("select id from " . FranchiseeConsumptionRecord::model()->tableName(). " where auto_check_fail<>'' and auto_check_fail!='post-bulu' order by id desc limit 1")->queryScalar();
        		//在将未自动对账的查询出来，进行自动对帐
        		$ids = false;
        		if($id == false) $id = 0;
        		
        		if($hours>=1 && $hours<=7)
        		{
        		    $start_time = strtotime('2014-06-25 00:00:00');
        		    $sql = "SELECT a.* ,b.id as confirm_id,c.id as repeal_id ,f.id as franMemberId 
    		            FROM {{franchisee_consumption_record}} a
						LEFT JOIN {{franchisee_consumption_record_confirm}} b ON (a.id=b.record_id AND b.`status`=0)
						LEFT JOIN {{franchisee_consumption_record_repeal}} c ON  (a.id=c.record_id AND c.`status`=0)
    		            LEFT JOIN {{franchisee}} e ON (a.franchisee_id=e.id)
    		            LEFT JOIN {{member}} f ON (e.member_id=f.id)
						WHERE a.`status`=".FranchiseeConsumptionRecord::STATUS_NOTCHECK." AND auto_check_fail = '' AND a.is_auto=0 AND e.`auto_check`=".Franchisee::IS_AUTO_CHECK." AND a.create_time>$start_time limit ".$limit;
        		}else{
        		    $sql = "SELECT a.* ,b.id as confirm_id,c.id as repeal_id ,f.id as franMemberId
        					FROM ".FranchiseeConsumptionRecord::model()->tableName()." a
        					LEFT JOIN {{franchisee_consumption_record_confirm}} b ON (a.id=b.record_id AND b.`status`=0)
        					LEFT JOIN {{franchisee_consumption_record_repeal}} c ON  (a.id=c.record_id AND c.`status`=0)
        					LEFT JOIN {{franchisee}} e ON (a.franchisee_id=e.id)
        					LEFT JOIN {{member}} f ON (e.member_id=f.id)
        					WHERE a.id>$id and a.auto_check_fail='' and a.`status`=".FranchiseeConsumptionRecord::STATUS_NOTCHECK." AND a.`is_auto`=0 AND e.`auto_check`=".Franchisee::IS_AUTO_CHECK." limit ".$limit;
        		}
        		$ids = Yii::app()->db->createCommand($sql)->queryAll();
        		if($ids)
        		{
        			foreach ($ids as $row)
        			{
        				if(isset($row['confirm_id']) && $row['confirm_id'] != '')
        				{
        					continue;
        				}
        				if(isset($row['repeal_id']) && $row['repeal_id'] != '')
        				{
        					continue;
        				}
        				$symbol = $row['symbol'];
        				if($symbol === false)
        				{
        					continue;
        				}
        				if($symbol == 'HKD')
        				{
        					Yii::app()->language = 'zh_tw';
        				}
        				else
        				{
        					Yii::app()->language = 'zh_cn';
        				}
        				OfflineAccountNew::autoRecon($row);
        			}
        		}
        	} catch (Exception $e) {
        		echo $e->getMessage() . "\n";
        		if(isset($row) && isset($row['id']))IntegralOfflineNew::saveAutoReconFailMemo($row, $e->getMessage());
        		$this->addLog('autocheck.log',$e->getMessage());
        		
        	}

            if($hours == 2 || $hours == 3) $this->deleteLog('autocheck.log');
            $this->addLog('autochecktime.log','end');
            sleep($sleep);
        }
	}
	
	/**
	 * 记录访问日志
	 * @param $fileName
	 * @param string $content
	 * @param array $array
	 */
	protected function addLog($fileName,$content='',$array=array()){
	    $root = Yii::getPathOfAlias('root');
	    //        $num = date("Ym").(date("W")-date("W",strtotime(date("Y-m-01"))));
//	    $num = date("mda");
        $num = date("md").'-'.ceil(date("H")/8);
	    $path = $root . DS .'frontend' . DS . 'runtime' . DS . $fileName.'-'.$num;
	    $str = PHP_EOL."------------------------------------------" .PHP_EOL.
	     "time: " . date("m-d H:i:s") .
	    PHP_EOL . $content;
	    if(!empty($array)){
	        $str .= PHP_EOL;
	        $str .= var_export($array, TRUE);
	    }
	    $str .= PHP_EOL;
	    @file_put_contents($path, $str, FILE_APPEND);
	}

    protected function deleteLog($fileName){
        $root = Yii::getPathOfAlias('root');
        $path = $root . DS .'frontend' . DS . 'runtime' . DS . $fileName.'-'.date("md",time()-(5*3600)).'-';
        @unlink($path.'1');
        @unlink($path.'2');
        @unlink($path.'3');
    }

}