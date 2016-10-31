<?php

/**
 * 处理异常流水
 *    1： 充值错误充值到历史流水表 ：同步历史流水表指定流水记录到流水表中并删除流水流水表记录
 *    2： 别人错误充值到自己账户上，新增流水，平账
 *
 * @author xuegang.liu@g-emall.com
 * @since  2016-04-11T19:15:09+0800
 */
class DealExceptionFlowCommand extends CConsoleCommand 
{
    const ACCOUNT = 'account';

    protected $db;
    protected $rootDir;
    protected $sourcePathOne;
    protected $logPathOne;
    protected $sourcePathTwo;
    protected $logPathTwo;
    protected $logPathThree;
    protected $debug;

    public function __construct()
    {
        $this->debug = false;
        $this->db = Yii::app()->db;
        $this->rootDir = realpath(Yii::getPathOfAlias('root.console.data')).DS;
        $this->sourcePathOne = $this->rootDir.'histroy_flow.json';
        $this->logPathOne = $this->rootDir.'flow_log_1.txt';
        $this->sourcePathTwo = $this->rootDir.'add_flow.json';
        $this->logPathTwo = $this->rootDir.'flow_log_2.txt';
        $this->logPathThree = $this->rootDir.'flow_log_3.txt';
    }

    /**
     * 处理--充值错误充值到历史流水表
     */
    public function actionHistory2balance()
    {
        set_time_limit(0);
        ini_set('memory_limit','128M');

        if(file_exists($this->logPathOne)){
            die("scripy run over ,no repeaty");
        }

        $data = file_get_contents($this->sourcePathOne);
        $data = json_decode($data,true);

        foreach ($data as $k => $val) {
            foreach ($val as $key => $value) {
                $trans = $this->db->beginTransaction();  //事务处理
                try {
                    $this->dealHistroyFlow($value,$this->logPathOne);   
                    $trans->commit();
                } catch (Exception $e) {
                    $trans->rollback(); //回滚
                    $logInfos = array('error'=>$e->getMessage(),'value'=>$value);
                    $this->log($this->logPathOne,$logInfos,PHP_EOL."---------------error-----------".PHP_EOL);
                }
            }
        }
        // Yii::app()->end();
    }

    /**
     * 处理--别人错误充值到自己账户上
     */
    public function actionDealErrorFlow()
    {
        set_time_limit(0);
        ini_set('memory_limit','128M');

        if(file_exists($this->logPathTwo)){
            die("scripy run over ,no repeaty");
        }

        $data = file_get_contents($this->sourcePathTwo);
        $data = json_decode($data,true);

        foreach ($data as $k => $val) {
            foreach ($val as $key => $value) {
                $trans = $this->db->beginTransaction();  //事务处理
                try {
                    $this->dealHistroyFlow($value,$this->logPathTwo);   
                    $trans->commit();
                } catch (Exception $e) {
                    $trans->rollback(); //回滚
                    $logInfos = array('error'=>$e->getMessage(),'value'=>$value);
                    $this->log($this->logPathTwo,$logInfos,PHP_EOL."---------------error-----------".PHP_EOL);
                }
            }
        }
        // Yii::app()->end();
    }

    /**
     * 处理--未找到的差额
     */
    public function actionAddFlow()
    {
        set_time_limit(0);
        ini_set('memory_limit','128M');

        if(file_exists($this->logPathThree)){
            die("scripy run over ,no repeaty");
        }

        $data = array(
            array('gaiNumber'=>'GW64223047','money'=>'63.22'),
            array('gaiNumber'=>'GW74735510','money'=>'187.15'),
            array('gaiNumber'=>'GW75675701','money'=>'0.98'),
            array('gaiNumber'=>'GW92098475','money'=>'0.31'),
            array('gaiNumber'=>'GW93452976','money'=>'4.03'),
        );

        foreach ($data as $k => $val) {
            $trans = $this->db->beginTransaction();  //事务处理
            try {
                $this->addFlow($val['gaiNumber'],$val['money'],$this->logPathThree);   
                $trans->commit();
            } catch (Exception $e) {
                $trans->rollback(); //回滚
                $tips = PHP_EOL."---------------error-----------".PHP_EOL;
                $logInfos = array('error'=>$e->getMessage(),'value'=>$val);
                $this->log($this->logPathThree,$logInfos,$tips);
            }    
        }
        // Yii::app()->end();
    }

    private function dealHistroyFlow($data,$logPath)
    {
        //获取错误历史流水记录
        $where = "order_code =:orderCode  and account_id=:accountId and type=:type and credit_amount=:amount ";
        $params = array(
            'orderCode' => $data['serial_number'],
            'accountId' => $data['flowInfos.account_id'],
            'type' => AccountFlow::TYPE_CONSUME,
            'amount' => $data['amount']
        );
        $histroyFlowData = $this->db->createCommand()
                        ->from(self::ACCOUNT.'.gw_account_flow_history_201603')
                        ->where($where,$params)->queryAll();

        if(empty($histroyFlowData) || count($histroyFlowData)!=1){
            throw new Exception("flow history error", 1);
        }
        $histroyFlowData = $histroyFlowData[0];

        //获取明账余额表
        $arr = array(
            'account_id'=>$data['error_ruzhang_account_infos.account_id'],
            'type'=>AccountBalance::TYPE_CONSUME,
            'gai_number'=>$data['error_ruzhang_account_infos.gai_number']
        );
        $memberAccountBalance = AccountBalance::findRecord($arr);
        if(empty($memberAccountBalance)){
            throw new Exception("账户不存在", 1);
        }

        $flowData = $histroyFlowData;
        unset($flowData['id']);
        $flowData['account_id'] = $memberAccountBalance['account_id'];
        $flowData['gai_number'] = $memberAccountBalance['gai_number'];
        $flowData['card_no'] = $memberAccountBalance['card_no'];
        
        // insert()
        $sql = "insert into ".self::ACCOUNT.".gw_account_flow_201603 (".implode(',', array_keys($flowData)).") values ( '".implode("','",$flowData)."' )";
        if($this->debug==false){
            if(!$this->db->createCommand($sql)->execute()){
                throw new Exception("insert fail", 1);
            }    
        }
        $flowData['id'] = $this->db->getLastInsertID();
        $logInfos = array('sql'=>$sql,'flowInfos'=>$flowData);
        $tips = PHP_EOL."---------------insert flow-----------".PHP_EOL;
        $this->log($logPath,json_encode($logInfos),$tips);

        //del
        $sql = "delete from ".self::ACCOUNT.".gw_account_flow_history_201603 where id = ".$histroyFlowData['id']." limit 1";
        if($this->debug==false){
            if(!$this->db->createCommand($sql)->execute()){
                throw new Exception("delete fail", 1);
            }
        }
        $logInfos = array('sql'=>$sql,'histroy_flow_infos'=>$histroyFlowData);
        $tips = PHP_EOL."---------------delete history flow-----------".PHP_EOL;
        $this->log($logPath,json_encode($logInfos),$tips);
    }

    private function addFlow($gaiNumber,$money,$logPath)
    {
        $orderId = 0;
        $code = Tool::buildOrderNo();
        $remark = "处理异常流水--调拨平账";

        $member = $this->db->createCommand()->from('{{member}}')
                    ->where('gai_number=:params and status<=:status', array(
                            ':params' => $gaiNumber,':status'=>Member::STATUS_NORMAL))
                    ->queryRow();
        if(empty($member)){
            throw new Exception("会员不存在", 1);
        }

        //获取明账余额表
        $arr = array(
            'account_id'=>$member['id'],
            'type'=>AccountBalance::TYPE_CONSUME,
            'gai_number'=>$member['gai_number']
        );
        $memberAccountBalance = AccountBalance::findRecord($arr);
        if(empty($memberAccountBalance)){
            throw new Exception("账户不存在", 1);
        }

        //借方(会员)
        $creditOld = array(
            'account_id' => $memberAccountBalance['account_id'],
            'gai_number' => $memberAccountBalance['gai_number'],
            'card_no' => $memberAccountBalance['card_no'],
            'type' => AccountFlow::TYPE_CONSUME,
            'debit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_ASSIGN_ONE,
            'order_id' => $orderId,
            'order_code' => $code,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_ASSIGN_ONE,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_ASSIGN,
            'flag' => AccountFlow::FLAG_SPECIAL,
        );

        //贷方(会员)
        $creditNew = array(
            'account_id' => $memberAccountBalance['account_id'],
            'gai_number' => $memberAccountBalance['gai_number'],
            'card_no' => $memberAccountBalance['card_no'],
            'type' => AccountFlow::TYPE_CONSUME,
            'credit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_ASSIGN_TWO,
            'order_id' => $orderId,
            'order_code' => $code,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_ASSIGN_TWO,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_ASSIGN,
            'flag' => AccountFlow::FLAG_SPECIAL,
        );

        // 借贷流水1.按月
        $newMonthTable = self::ACCOUNT.".gw_account_flow_201603";
        $oldMonthTable = self::ACCOUNT.".gw_account_flow_history_201603";
        
        $flowData = self::mergeField($creditNew,strtotime('2016-03-21 00:00:00') );
        if($this->debug==false){
            $this->db->createCommand()->insert($newMonthTable, $flowData );
        }

        $flowData['id'] = $this->db->getLastInsertID();
        $logInfos = array('flowInfos'=>$flowData);
        $tips = PHP_EOL."---------------insert flow creditNew -----------".PHP_EOL;
        $this->log($logPath,json_encode($logInfos),$tips);

        $flowData = self::mergeField($creditOld,strtotime('2016-03-21 00:00:00') );
        if($this->debug==false){
            $this->db->createCommand()->insert($oldMonthTable, $flowData);
        }

        $flowData['id'] = $this->db->getLastInsertID();
        $logInfos = array('flowInfos'=>$flowData);
        $tips = PHP_EOL."---------------insert flow creditOld -----------".PHP_EOL;
        $this->log($logPath,json_encode($logInfos),$tips);

        return true;
    }

    public static function mergeField(Array $field,$oderTime) 
    {
        $time = $oderTime;
        $publicArr = array(
            'date' => date('Y-m-d', $time),
            'create_time' => $time,
            'week' => date('W', $time),
            'week_day' => date('N', $time),
            'hour' => date('G', $time),
            'ip' => Tool::ip2int(Yii::app()->request->userHostAddress),
        );
        return CMap::mergeArray($publicArr, $field);
    }

    /**
     * [log description]
     */
    protected function log($path,$logInfos,$separator='',$subfix='')
    {
        //记录日志，便于后期分析
        $defaultSeparator = PHP_EOL."------------------------------------------" .PHP_EOL;
        $separator = $separator ? $separator.PHP_EOL : $defaultSeparator;
        $separator = PHP_EOL."--------------------------".date("m-d H:i:s")."--------------------------".PHP_EOL . $separator;

        $resLog = '';
        if(is_string($logInfos)){
            $resLog = $logInfos;
        }else{
            $resLog = json_encode($logInfos);
        }
        $resLog = $separator.$resLog .PHP_EOL. $subfix.PHP_EOL;
        @file_put_contents($path, $resLog, FILE_APPEND);
        return true;
    }
}