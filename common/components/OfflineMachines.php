<?php 
/**
 * 所有线下机器管理类
 */
class OfflineMachines
{
    /**
     * 
     * @param int $machineId 机器ID
     * @param int $record_type 机器类型
     * @param array $fields  额外搜索字段 二维数组表示
     * @throws Exception
     * @return boolean|multitype:unknown
     */
    public static function getMachineByType($machineId,$record_type,$fields = array())
    {
        $gt = Yii::app()->gt;
        $offlineMachine = array();
        $select_fields = '';
        
        //检查消费类型
        switch ($record_type)
        {
            case FranchiseeConsumptionRecord::RECORD_TYPE_POINT:
                if(isset($fields[$record_type]))
                    $select_fields = ','.implode(',', $fields[$record_type]);
                // 检查盖网通
                $machine = $gt->createCommand()
                            ->select('id,machine_code,name,biz_info_id,symbol,run_status,status '.$select_fields)->from(Machine::model()->tableName())
                            ->where('id=:machine_id',array(':machine_id'=>$machineId))->queryRow();
                if(empty($machine))
                {
                    throw new Exception('盖网通不存在或没激活');
                    return false;
                }
                $offlineMachine['machine_id'] = $machine['id'];
                $offlineMachine['machine_name'] = $machine['name'];
                $offlineMachine['franchisee_id'] = $machine['biz_info_id'];
                
                break;
            case FranchiseeConsumptionRecord::RECORD_TYPE_PHONE:
                if(isset($fields[$record_type]))
                    $select_fields = ','.implode(',', $fields[$record_type]);
                // 检查掌柜
                $machine = $gt->createCommand()
                                ->select('id,name,is_activate,franchisee_id,status '.$select_fields)
                                ->from(Shopkeeper::tableName())
                                ->where('id=:machine_id and status = '.Shopkeeper::STATUS_ENABLE.' and is_activate = '.Shopkeeper::IS_ACTIVATE_YES,array(':machine_id'=>$machineId))
                                ->queryRow();
                if(empty($machine))
                {
                    throw new Exception('掌柜不存在或没激活');
                    return false;
                }
                $offlineMachine['machine_id'] = $machine['id'];
                $offlineMachine['machine_name'] = $machine['name'];
                $offlineMachine['franchisee_id'] = $machine['franchisee_id'];
                break;
            case FranchiseeConsumptionRecord::RECORD_TYPE_VENDING:
                if(isset($fields[$record_type]))
                    $select_fields = ','.implode(',', $fields[$record_type]);
                $machine = $gt->createCommand()
                            ->select('id,name,is_activate,franchisee_id,status '.$select_fields)
                            ->from(VendingMachine::tableName())
                            ->where('id=:machine_id and status = '.VendingMachine::STATUS_ENABLE,array(':machine_id'=>$machineId))
                            ->queryRow();
                if(empty($machine))
                {
                    throw new Exception('售货机不存在或没激活');
                    return false;
                }
                $offlineMachine['machine_id'] = $machine['id'];
                $offlineMachine['machine_name'] = $machine['name'];
                $offlineMachine['franchisee_id'] = $machine['franchisee_id'];
                break;
            case FranchiseeConsumptionRecord::RECORD_TYPE_POS:
                if(isset($fields[$record_type]))
                	$select_fields = ','.implode(',', $fields[$record_type]);
                $machine = $gt->createCommand()
                		->select('id,name,is_activate,franchisee_id,status '.$select_fields)
                		->from(PosMachine::tableName())
                		->where('id=:machine_id and status = '.PosMachine::STATUS_ENABLE,array(':machine_id'=>$machineId))
                		->queryRow();
                if(empty($machine))
                {
                	throw new Exception('POS不存在或没激活');
                	return false;
                }
                $offlineMachine['machine_id'] = $machine['id'];
                $offlineMachine['machine_name'] = $machine['name'];
                $offlineMachine['franchisee_id'] = $machine['franchisee_id'];
                break;
            default:
                if(isset($fields[$record_type]))
                    $select_fields = ','.implode(',', $fields[$record_type]);
                // 检查盖网通
                $machine = $gt->createCommand()
                    ->select('id,machine_code,name,biz_info_id,symbol,run_status,status '.$select_fields)->from(Machine::tableName())
                    ->where('id=:machine_id',array(':machine_id'=>$machineId))->queryRow();
                if(empty($machine))
                {
                    throw new Exception('盖网通不存在或没激活');
                    return false;
                }
                $offlineMachine['machine_id'] = $machine['id'];
                $offlineMachine['machine_name'] = $machine['name'];
                $offlineMachine['franchisee_id'] = $machine['biz_info_id'];

                break;
                /*throw new Exception('recordType参数错误');
                return false;
                break;*/
        }
        if (!empty($offlineMachine))
        {
            $offlineMachine['record'] = $record_type;
            if(!empty($fields[$record_type]) && is_array($fields[$record_type]))
            {
                foreach($fields[$record_type] as $val)
                {                  
                    if($machine[$val])$offlineMachine[$val] = $machine[$val];
                }
            }
        }
        return $offlineMachine;
    }
    
    /**
     * 删除线下机器登陆状态
     * @param int $memberId
     */
    public static function loginOut($memberId)
    {
        //删除盖付通登录状态
        self::tokenLoginOut($memberId);
    }
    
    /**
     * 盖付通删除登录状态 删除token
     * @param $memberId
     * @return bool
     */
    public static function tokenLoginOut($memberId)
    {
        $cache = 'redis';//盖付通订的redis缓存
        $prefix = 'LPT';//盖付通订的缓存前缀
        $db =  Yii::app()->db;
        $tokenId = $db->createCommand()
                    ->select("token")
                    ->from('{{member_token}}')
                    ->where("target_id = {$memberId}")
                    ->queryScalar();
        $cacheServer = Yii::app()->$cache;
        if(!empty($tokenId))
        {
            $memberIdKey = $prefix . ':tokenId:' . $tokenId . ':memberId';
            $tokenIdKey = $prefix . ':memberId:' . $memberId . ':tokenId';
            $cacheServer->del($memberIdKey);
            $cacheServer->del($tokenIdKey);
            $db->createCommand()->delete('{{member_token}}','token=:token',array(':token'=>$tokenId));
        }
        return true;
    }
}


?>