<?php

/**
 * 盖机pos消费，异常订单流水矫正脚本：
 *    tips : 主要针对，pos机扣钱2000，后台生成订单金额156【少于pos实际支付金额问题】
 *           通过模拟用户消费，补流水
 *
 * 模拟订单创建 ： 取出相关异常订单记录，修改订单编号，插入订单表
 * 调用pos机消费接口， 模拟用户消费相关处理
 *     gw_consume_pre_order 
 *     gw_consume_order
 *     integral/consumePos
 *     
 *     模拟充值，
 *     模拟消费扣钱
 *     记录流水
 *
 * 错误账户余额冲正处理：
 *     模拟用户消费，扣除账户余额，写流水
 **/

class DealPosConsumeExceptionOrderCommand extends CConsoleCommand 
{

    protected $db;
    protected $rootDir;
    protected $targetPath;

    public function __construct()
    {
        $this->db = Yii::app()->db;
        $this->rootDir = realpath(Yii::getPathOfAlias('root.console.data')).DS;
        $this->targetPath = $this->rootDir.'deal_pos_exception_'.time().'.txt';
    }

    public function actionIndex()
    {
        set_time_limit(0);
        ini_set('memory_limit','128M');
        
        $posInfoDatas = array(
            '703' => '402',
            '702' => '128',
            '592' => '2000',
            '529' => '684',
            '487' => '251',
        );

        $posInfoIds = array_unique(array_keys($posInfoDatas));
        $selectSql = "select t.*,rd.serial_number as orderCode".
                    " from gw_pos_information as t ".
                    " left join gw_franchisee_consumption_record rd on rd.machine_serial_number = t.machine_serial_num ".
                    "where t.id in (".implode(',', $posInfoIds).") limit ".count($posInfoIds);

        $posinfoRecords = $this->db->createCommand($selectSql)->queryAll();
        $this->log($posinfoRecords,'--------------beign query all data -----------');

        try {

            foreach ($posinfoRecords as $key => $value) {

                $this->log($value,'--------------beign moni xiaofei -----------');

                $machine = Yii::app()->gt->createCommand()->from('{{machine}}')->where('id =:id', array(':id' => $value['machine_id']))->queryRow();
                if (empty($machine)){
                    throw new Exception("盖机不存在", 1);
                }
                $post['ShopID'] = $machine['machine_code'];

                $member = Yii::app()->db->createCommand()->from('{{member}}')->where('id=:id', array(':id' => $value['member_id']))->queryRow();
                if (empty($member)){
                    throw new Exception("用户不存在", 1);
                }
                $post['Name'] = $member['gai_number'];
                $post['Amount'] = $posInfoDatas[$value['id']] - $value['amount'];

                $post['TransactionID'] =  $value['machine_serial_num']."0";
                $post['UserPhone'] = $value['phone'];
                $post['CardNum'] = $value['card_num'];
                $post['TransactionSerialNum'] = $value['serial_num'];
                $post['BusinessNum'] = $value['business_num'];
                $post['DeviceNum'] = $value['device_num'];
                $post['ShopName'] = $value['shopname'];
                $post['DocNum'] = $value['doc_num'];
                $post['orderCode'] = $value['orderCode'].'-MN';

                // $post['BatchNum'] = $value['batch_num'];
                $post['BatchNum'] = mt_rand(110101,999999) ;
                $post['TransactionType'] = $value['transaction_type'];

                !empty($value['operator']) && $post['Operator'] = $value['operator'];
                !empty($value['send_card_bank']) && $post['SendCardBank'] = $value['send_card_bank'];
                !empty($value['receive_bank']) && $post['ReceiveBank'] = $value['receive_bank'];

                $post['CardValidDate'] = date('Y-m-d H:i:s',$value['card_valid_date']);
                !empty($value['clear_account_date']) && $post['ClearAccountDate'] = date('Y-m-d H:i:s',$value['clear_account_date']);

                $post['TransactionDate'] = date('Y-m-d H:i:s',$value['transaction_time']);
                $post['TransactionTime'] = "";

                $this->log($post,'--------------------------post--------------------------');
                $this->posConsume($post);
            }    
        } catch (Exception $e) {
            $this->log($e->getMessage(),'--------------------------exception error--------------------------');
        }
    }

    /**
     * 冲正处理
     */
    public function actionIndex2(){

        $dataArr = array(
            '222' => array(
                'amount' => -12,
                'gw' => 'GW54597953',
            ),
            '221' => array(
                'amount' => -12,
                'gw' => 'GW54597953',
            ),
            '84' => array(
                'amount' => -1.2,
                'gw' => 'GW66493393',
            ),
        );

        foreach ($dataArr as $id => $value) {

            $this->log(array($id=>$value),'--------------beign moni chuangzi -----------');
            //加盟商对应的信息
            $member = Yii::app()->db->createCommand()->select('id,gai_number,status,type_id,mobile')
                    ->from('{{member}}')->where('gai_number=:gwNumber', array(':gwNumber' => $value['gw']))->queryRow();

            $orderId = 'SNt'.Tool::buildOrderNo().'-CZ';
            $trans = $this->db->beginTransaction();  //事务处理
            try {
                $this->payPlatformRecharge($orderId,$member,$value['amount']); 
                $trans->commit();
            } catch (Exception $e) {
                $trans->rollback(); //回滚
                $logInfos = array('error'=>$e->getMessage(),'value'=>$value);
                $this->log($logInfos,PHP_EOL."---------------error-----------".PHP_EOL);
            }  
        }
    }
    
    /**
     * 刷卡支付
     */
    private function posConsume($post)
    {
        try {
            
            if(!PosInformation::checkCardNum($post['CardNum'])) throw new Exception("不是合法的卡号", 1);
            if(!is_numeric($post['Amount']) || $post['Amount']<=0) throw new Exception('输入金额请大于0的数字', 1);
            
            $amount = $post['Amount'];
            $machine = Yii::app()->gt->createCommand()->from('{{machine}}')->where('machine_code =:machine_code', array(':machine_code' => $post['ShopID']))->queryRow();
            if (empty($machine)) throw new Exception("盖机不存在", 1);
            $symbol = $machine['symbol'];
            
            // 消费金额转换成人民币
            if ($symbol == Symbol::RENMINBI || $symbol == Symbol::EN_DOLLAR) {
                $basePrice = 100;
                $symbol = Symbol::RENMINBI;
            } elseif ($symbol == Symbol::HONG_KONG_DOLLAR && $hkRate = $this->getConfig('rate', 'hkRate')) {
                $basePrice = $hkRate;
            } else {
                throw new Exception("币种错误", 1);
            }

            // 转换为人民币(100*0.75)
            $moneyRMB = bcmul($amount, bcdiv($basePrice, 100, 5), 2);
            $gaiNumber = $post['Name'];

            $member = Yii::app()->db->createCommand()->from('{{member}}')
                    ->where('gai_number=:params and status<=:status', array(
                        ':params' => $gaiNumber,':status'=>Member::STATUS_NORMAL
                    ))->queryRow();
            // $member = ApiMember::getMemberByGainumber($gaiNumber);
            if (empty($member)) throw new Exception("账号不存在", 1);
            
            // 获取加盟商信息
            // $franchisee = ApiFranchisee::getFranchisee($machine['biz_info_id']);
            $franchisee = Yii::app()->db->createCommand()->from('{{franchisee}}')->where('id=:fid', array(':fid'=>$machine['biz_info_id']))->queryRow();
            if (empty($franchisee)) throw new ErrorException(Yii::t('Machine', '不存在该商家'), 400);
            
            //盖网通接口加入了折扣设定验证，这里也加入，为了防止截取url直接访问这边。
            if ($franchisee['member_discount'] == 0 || $franchisee['gai_discount'] == 0) {
                throw new Exception("盖机参数设定异常，无法消费", 1);
            } else if($franchisee['gai_discount'] > $franchisee['member_discount']){
                throw new Exception("盖机参数设定异常，无法消费", 1);
            }

            //加盟商对应的信息
            $franchiseeMember = Yii::app()->db->createCommand()
                                ->select('id,gai_number,status')
                                ->from('{{member}}')
                                ->where('id=:id',array(':id'=>$franchisee['member_id']))
                                ->queryRow();

            if(empty($franchiseeMember)) throw new Exception("商家的账号不存在!", 1);
            if($franchiseeMember['status'] > Member::STATUS_NORMAL) throw new Exception("商家的账号已被禁用或删除!", 1);
            if($franchisee['member_id'] == $member['id']) throw new Exception("您作为商家，不能在本店消费", 1);
            
            $accountFlowTable = AccountFlow::monthTable();

            // 人民币转换为积分
            $score = Common::convertSingle($moneyRMB, $member['type_id']);
            $recordId = "";
            // $order_id = 'SNt'.Tool::buildOrderNo().'-CZ';
            $order_id = $post['orderCode'];
            
            $data = array(
                'moneyRMB' => $moneyRMB,
                'basePrice' => $basePrice,
                'symbol' => $symbol,
                'machineSN' => $post['TransactionID'],//原本是TransactionSerialNum
                'accountFlowTable' => $accountFlowTable,
                'money' => $amount,
                'serial_number'=>$order_id,
                'pay_type'=>FranchiseeConsumptionRecord::RECORD_TYPE_POS,
                'record_type'=>FranchiseeConsumptionRecord::RECORD_TYPE_POINT,
            );
            
            if(empty($member)) throw new Exception("盖网号没有对应的该盖网会员", 1);
            
            $pos_info = Yii::app()->db->createCommand()
                        ->select("id")
                        ->from(PosInformation::tableName())
                        ->where("machine_id = :mid and serial_num = :serial_num  and doc_num = :doc_num and batch_num = :batch_num",
                                array(
                                    ':mid'=>(string)$machine['id'],
                                    ':serial_num'=>(string)$post['TransactionSerialNum'],
                                    ':doc_num'=>(string)$post['DocNum'],
                                    ':batch_num'=>(string)$post['BatchNum']
                                )
                        )->queryRow();
            if(!empty($pos_info)) throw new Exception("已经提交过此订单，请重新下单", 1);
            
            
            $monthTable = AccountFlow::monthTable();  // 当月的流水表 在开启事务之前创建
            $transaction = Yii::app()->db->beginTransaction();  //开启事务
            
            $time = time();
            $pay_time = strtotime($post['TransactionDate'].$post['TransactionTime']);
            
            $posInformation_mod = new PosInformation();
            $posInformation_mod->is_supply = (isset($post['isSupply']) && !empty($post['isSupply'])) ? $post['isSupply'] : 0;
            $posInformation_mod->machine_id = $machine['id'];
            $posInformation_mod->machine_serial_num = $post['TransactionID'];
            $posInformation_mod->member_id = $member['id'];
            $posInformation_mod->phone = $post['UserPhone'];
            $posInformation_mod->card_num = $post['CardNum'];
            $posInformation_mod->amount = $amount;
            $posInformation_mod->serial_num = $post['TransactionSerialNum'];
            $posInformation_mod->transaction_time = $pay_time;
            $posInformation_mod->business_num = $post['BusinessNum'];
            $posInformation_mod->device_num = $post['DeviceNum'];
            $posInformation_mod->shopname = $post['ShopName'];
            $posInformation_mod->operator = isset($post['Operator'])?$post['Operator']:'';
            $posInformation_mod->doc_num = $post['DocNum'];
            // $posInformation_mod->batch_num = 100000;
            $posInformation_mod->batch_num = $post['BatchNum'];
            $posInformation_mod->card_valid_date = strtotime($post['CardValidDate']);
            $posInformation_mod->transaction_type = $post['TransactionType'];
            $posInformation_mod->send_card_bank = isset($post['SendCardBank'])?$post['SendCardBank']:'';
            $posInformation_mod->receive_bank = isset($post['ReceiveBank'])?$post['ReceiveBank']:'';
            $posInformation_mod->clear_account_date = isset($post['ClearAccountDate'])?strtotime($post['ClearAccountDate']):'';
            
            $this->log($posInformation_mod->attributes,'--------------posInfomation infos-----------');
            if(!$posInformation_mod->save()) throw new ErrorException('保存失败');
            
            $ratio = Yii::app()->db->createCommand()->select("ratio")->from("{{member_type}}")->where("id = {$member['type_id']}")->queryScalar();
            $score = bcdiv($amount,$ratio,2);
            //插入recharge 因为冲突不能用save
            $rechargeData =  array(
                'member_id' => $member['id'],
                'code' =>$order_id,
                'ratio' => $ratio,
                'score'=>$score,
                'money' =>  $amount,
                'create_time' =>  $time,
                'pay_time' =>$pay_time,
                'status' => Recharge::STATUS_SUCCESS,
                'description' => '通过盖网通'.$post['ShopID'].'pos刷卡充值消费--金额异常，模拟消费',
                'pay_type' => Recharge::PAY_TYPE_POS,
                'pay_mode' => 1,
                'by_gai_number' =>$member['gai_number'],
                'ip' => Tool::getIP(),
            );
            Yii::app()->db->createCommand()->insert(Recharge::tableName(),$rechargeData);
            $this->log($rechargeData,'--------------recharge infos-----------');
            $recarge_id = Yii::app()->db->getLastInsertID();
            
            // 会员余额表记录创建
            $arr = array(
                    'account_id'=>$member['id'],
                    'type'=>AccountBalance::TYPE_CONSUME,
                    'gai_number'=>$member['gai_number']
            );
            $memberAccountBalance = AccountBalance::findRecord($arr);
            
            // 会员充值流水 贷 +
            $MemberCredit = array(
                    'account_id' => $memberAccountBalance['account_id'],
                    'gai_number' => $memberAccountBalance['gai_number'],
                    'card_no' => $memberAccountBalance['card_no'],
                    'type' => AccountFlow::TYPE_CONSUME,
                    'credit_amount' => $amount,
                    'operate_type' => AccountFlow::OPERATE_TYPE_EBANK_RECHARGE,
                    'order_id' =>  $recarge_id,
                    'order_code' => $order_id,
                    'remark' => '使用POS机刷卡充值消费,金额为￥'.$amount,
                    'node' => AccountFlow::BUSINESS_NODE_EBANK_POS,
                    'transaction_type' => AccountFlow::TRANSACTION_TYPE_RECHARGE,
                    'recharge_type' => AccountFlow::RECHARGE_TYPE_BANK,
                    'by_gai_number' => $member['gai_number'],
            );
            $this->log($MemberCredit,'--------------flow infos-----------');
            AccountBalance::calculate(array('today_amount' => $amount), $memberAccountBalance['id']);  // 会员账户余额表更新
            Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($MemberCredit));  // 借贷流水1.按月
            
            $transaction->commit();
            $this->log(array('franchisee'=>$franchisee,'machine'=>$machine,'member'=>$member,'data'=>$data,'recordId'=>$recordId),'--------------integral  infos-----------');
            $resule = IntegralOfflineNew::offlineConsume($franchisee, $machine, $member, $data, $recordId);
            if($resule!==true){
                throw new Exception("扣钱失败:". var_export($resule,true), 1);
            }
        }catch (Exception $e) {
            if(isset($transaction) && $transaction->getActive()){
                $transaction->rollBack();
            }
            $this->log($e->getMessage());
            return false;
        }
    }

    /**
     * 冲正
     */
    public function payPlatformRecharge($order_code,$member,$amount)
    {
        $this->log(array('orderId'=>$order_code,'member'=> $member),'--------------member infos-----------');
        $ratio = Yii::app()->db->createCommand()->select("ratio")->from("{{member_type}}")->where("id = {$member['type_id']}")->queryScalar();
        $score = bcdiv($amount,$ratio,2);
        $time = time();        
        $monthTable = AccountFlow::monthTable();  //月表

        //插入充值记录
        $rechargeData = array(
            'member_id' => $member['id'],
            'code' =>$order_code,
            'ratio' => $ratio,
            'score'=>$score,
            'money' =>  $amount,
            'create_time' =>  $time,
            'pay_time' =>$time,
            'status' => Recharge::STATUS_SUCCESS,
            'description' => '模拟充值--冲正',
            'pay_type' => Recharge::PAY_TYPE_POS,
            'pay_mode' => 1,
            'by_gai_number' =>$member['gai_number'],
            'ip' => Tool::getIP(),
        );
        $this->log($rechargeData,'--------------recharge infos-----------');
        Yii::app()->db->createCommand()->insert(Recharge::tableName(),$rechargeData);
        $recarge_id = Yii::app()->db->getLastInsertID();

        // 会员余额表记录创建
        $arr = array(
            'account_id'=>$member['id'],
            'type'=>AccountBalance::TYPE_CONSUME,
            'gai_number'=>$member['gai_number']
        );
        $memberAccountBalance = AccountBalance::findRecord($arr);

        // 会员充值流水 贷 +
        $MemberCredit = array(
            'account_id' => $memberAccountBalance['account_id'],
            'gai_number' => $memberAccountBalance['gai_number'],
            'card_no' => $memberAccountBalance['card_no'],
            'type' => AccountFlow::TYPE_CONSUME,
            'credit_amount' => $amount,
            'operate_type' => AccountFlow::OPERATE_TYPE_EBANK_RECHARGE,
            'order_id' =>  $recarge_id,
            'order_code' => $order_code,
            'remark' => '冲正---充值消费'.$amount,
            'node' =>AccountFlow::BUSINESS_NODE_EBANK_POS,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_RECHARGE,
            'recharge_type' => AccountFlow::RECHARGE_TYPE_BANK,
            'by_gai_number' => $member['gai_number'],
        );
        $this->log($MemberCredit,'--------------flow infos-----------');
        self::calculate(array('today_amount' => $amount), $memberAccountBalance['id']);  // 会员账户余额表更新
        Yii::app()->db->createCommand()->insert($monthTable, AccountFlow::mergeField($MemberCredit)); // 借贷流水1.按月
    }

    public static function calculate($records, $param) {

        if(empty($records) || ! $param){
            throw new Exception("参数有误", 1);
        }

        $condition = '';
        foreach ($records as $key => $value){
            $condition .= '`' . $key . '` = `' . $key . '` ' . ($value < 0 ? $value : ('+ ' . $value)) . ',';
        }
        $condition = rtrim($condition, ',');
        $account = Yii::app()->db->createCommand('select * from '.ACCOUNT.'.gw_account_balance where id='.$param)->queryRow();
        if(empty($account['amount_salt'])){
            throw new Exception("金额密钥不能为空 new", 1);
        }

        if($account['type']!=AccountBalance::TYPE_COMMON && $account['type']!=AccountBalance::TYPE_TOTAL){ //公共账户、总账户不做检查
            //记录加行锁
            $account = Yii::app()->db->createCommand('select * from '.ACCOUNT.'.gw_account_balance where id='.$param.' for update')->queryRow();
            //校验金额
            $hash = sha1($account['gai_number'].$account['account_id'].$account['today_amount'].$account['amount_salt'].AMOUNT_SIGN_KEY);
            if($account['amount_hash']!=$hash){
                self::addHashLog('更新余额时金额校验失败 new '.$hash,$account);
                throw new Exception("更新余额时金额校验失败 new-".$account['amount_hash'].'-'.$hash);
            }
        }
        //新的hash
        $data = array($account['gai_number'],$account['account_id'],sprintf('%0.2f',$account['today_amount']+$records['today_amount']),$account['amount_salt'],AMOUNT_SIGN_KEY);
        $newHash = sha1(implode('',$data));
        $sql = 'UPDATE ' . ACCOUNT . '.' . "{{account_balance}}" . ' SET ' . $condition .', last_update_time='.time(). ',amount_hash="'.$newHash.'"  WHERE id = ' . $param;
        return Yii::app()->db->createCommand($sql)->execute();
    }

    /**
     * [log description]
     */
    protected function log($logInfos,$separator='',$subfix='')
    {
        //记录日志，便于后期分析
        $path = $this->targetPath;

        $defaultSeparator = "------------------------------------------";
        $separator = $separator ? $separator : $defaultSeparator;
        $separator = PHP_EOL."--------------------------".date("m-d H:i:s")."--------------------------".PHP_EOL . $separator.PHP_EOL;

        $resLog = '';
        if(is_string($logInfos)){
            $resLog = $logInfos;
        }else{
            $resLog = var_export($logInfos,true);
            // $resLog = json_encode($logInfos);
        }
        $resLog = $separator.$resLog .PHP_EOL. $subfix.PHP_EOL;
        @file_put_contents($path, $resLog, FILE_APPEND);
        return true;
    }
}