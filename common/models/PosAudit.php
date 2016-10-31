<?php
class PosAudit extends CActiveRecord
{
   public $endTime;
    public $startTime;
    public $updateTime;
    public $posStartTime;
    public $posEndTime;
    public $svc_start_time;
    public $svc_end_time;

    public function tableName()
    {
        return '{{pos_audit}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OfflineSignStoreExtend the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, remark, month, terminal_number, terminal_transaction_serial_number, transaction_time, transaction_datetime, amount, pos_info_id, callback_data, create_time, status, type, admin_id, update_time', 'safe'),
        );
    }
    const AGENT_TYPE = 1;
    const MACHINE_TYPE = 2;
    public static function getMachineName($terminal_number,$type){
        if(!empty($terminal_number) && !empty($type)){
            $MachineInfo =  Yii::app()->gt->createCommand()
                ->select('biz_info_id,name')
                ->from(Machine::model()->tableName())
                ->where("pos_code=:pos_code",array(':pos_code'=>$terminal_number))
                ->queryRow();
            if(!empty($MachineInfo)){
                if($type == PosAudit::MACHINE_TYPE){
                    return $MachineInfo['name'];
                }else{
                    $FranchiseeName =  Yii::app()->db->createCommand()
                        ->select('name')
                        ->from(Franchisee::model()->tableName())
                        ->where('id=:id',array(':id'=>$MachineInfo['biz_info_id']))
                        ->queryScalar();
                    if(!empty($FranchiseeName)){
                        return $FranchiseeName;
                    }
                }
            }
        }
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'terminal_number' => '终端号',
            'terminal_transaction_serial_number' => '终端交易流水号',
            'transaction_datetime' => '交易时间',
            'amount' => '交易金额',
            'status' => '处理状态',
            'type' => '对账情况',
            'transaction_time' => '交易时间',
            'updateTime' => '更新时间段',
            'transaction_time' => '交易时间',
        );
    }
    /*
     * 处理状态
     * */
    const PROCESS_TYPE_NO = 3;						    //无需处理
    const PROCESS_TYPE_YET_NO = 1;						//未处理
    const PROCESS_TYPE_END = 2;                         //已处理
    /**
     * 处理状态
     * @param null $key
     * @return array|string
     */
    public static function getProcessType($key = null){
        $data = array(
            self::PROCESS_TYPE_NO => '无需处理',
            self::PROCESS_TYPE_YET_NO => '未处理',
            self::PROCESS_TYPE_END => '已处理',
        );

        if($key === null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
    }
    /*
     * 对账结果
     * */
    const TYPE_NORMAL = 0;						    //正常
    const TYPE_PLATFORM = 1;						//平台异常
    const TYPE_SYSTEM = 2;						//系统异常
    const TYPE_DATA = 3;                         //数据异常
    /**
     * 处理状态
     * @param null $key
     * @return array|string
     */
    public static function getPosAuditType($key = null){
        $data = array(
            self::TYPE_NORMAL => '正常',
            self::TYPE_PLATFORM => '平台异常',
            self::TYPE_SYSTEM => '系统异常',
            self::TYPE_DATA => '数据异常',
        );

        if($key === null) return $data;
        return isset($data[$key]) ? $data[$key] : '未知';
    }
    public function search(){
        $criteria=new CDbCriteria;
        $criteria->compare('terminal_number',$this->terminal_number);
        $criteria->compare('terminal_transaction_serial_number',$this->terminal_transaction_serial_number);
        $criteria->compare('status',$this->status);
        $criteria->compare('type',$this->type);
        $criteria->compare('transaction_time >',$this->startTime);
        $criteria->compare('transaction_time <',$this->endTime);
        $criteria->compare('status >',PosAudit::PROCESS_TYPE_YET_NO);
        $criteria->order = 'create_time desc';
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 10
            ),
        ));
    }
    /**
     * 返回操作按钮
     * @param int $id 流水id
     * @return string	返回按钮
     */

    public static function createButton($id = null,$status = null){
        $string = '';
        if (Yii::app()->user->checkAccess('AccountPosRecord.Remark')) {
            $string .= '<a class="regm-sub" style="width:83px;" href="javascript:addRemark(' . $id . ')">添加备注</a>';
        }
        if(Yii::app()->user->checkAccess('AccountPosRecord.Detail')) {
            $string .= '<a class="regm-sub" style="width:83px;" href="' . Yii::app()->controller->createUrl("accountPosRecord/detail", array("id" => $id)) . '">查看详情</a>';
        }
        if($status == PosAudit::PROCESS_TYPE_YET_NO && Yii::app()->user->checkAccess('AccountPosRecord.Transactions')) {
            $string .= '<a class="regm-sub" style="width:83px;" href="'.Yii::app()->controller->createUrl("accountPosRecord/SupplementTransactions", array("id"=>$id)).'">增补流水</a>';
        }
        return $string;
    }
    /*
     * 获取pos_information Model
     * */
    public static function getPosInformation($posStartTime,$posEndTime){
        $model = Yii::app()->db->createCommand()
            ->select()
            ->from(PosInformation::model()->tableName())
            ->where('transaction_time > :posStartTime and transaction_time < :posEndTime', array(':posStartTime' => $posStartTime, ':posEndTime' => $posEndTime))
            ->queryAll();
        return !empty($model)?$model:'';
    }
    /*
     * 将对账信息插入Audit表
     *
    */
    public static function insetPosAudit($posData,$months){
        $time = time();
        $array_a = array('month','terminal_number','terminal_transaction_serial_number','transaction_time','transaction_datetime','amount','pos_info_id','callback_data','create_time','status','type','admin_id','remark','update_time');
        $terminal_time_array = array();
        $terminal_serial_number = array();
        $insetData = array();
        $CardNumPos4 = array();
        $CardNumPos6 = array();
        $month = implode(',',$months);
        $sql = "select month,terminal_transaction_serial_number from {{pos_audit}} where month in($month)";
        $pos_audit_info = Yii::app()->db->createCommand($sql)->queryAll();
        $pos_audit_info_b = array();
        $monthKey = '';
        if(!empty($pos_audit_info)){
            foreach($pos_audit_info as $val){
                if($val['month'] != $monthKey) {
                    $pos_audit_info_b[$val['month']][] = $val['terminal_transaction_serial_number'];
                    $monthKey = $val['month'];
                    }else{
                    $pos_audit_info_b[$monthKey][] = $val['terminal_transaction_serial_number'];
                }
            }
        }
        if(!empty($posData)){
            foreach($posData as $key=>$val){
                $transction_time = strtotime($val['交易发生日'].substr($val['交易时间'],0,6));
                $array_b = array(date("m",$transction_time),$val['终端号'],(int)$val['POS交易流水号'],$transction_time,$val['交易发生日'].$val['交易时间'],$val['交易金额'],'',json_encode($val),$time,PosAudit::PROCESS_TYPE_YET_NO,PosAudit::TYPE_SYSTEM,Yii::app()->user->id,'',$time);
                $insetData[$key] = array_combine($array_a,$array_b);
                $CardNumPos4[$key] = substr($val['交易账号'],-4);
                $CardNumPos6[$key] = substr($val['交易账号'],0,6);
                if(!in_array($val['POS交易流水号'],$terminal_serial_number))
                    $terminal_serial_number[] = $val['POS交易流水号'];
                if(!in_array($transction_time,$terminal_time_array))
                    $terminal_time_array[] = $transction_time;
            }
            $terminal_number = implode(',',$terminal_serial_number);
            $terminal_time_str = implode(',',$terminal_time_array);
            $sql = "select transaction_time,serial_num,amount,card_num from {{pos_information}} where transaction_time in($terminal_time_str) or serial_num in($terminal_number)";
            $pos_information = Yii::app()->db->createCommand($sql)->queryAll();
            foreach($insetData as $key=>$posAudit){
                $posCheck = true;
                if(!empty($pos_audit_info_b[$posAudit['month']])){
                        foreach($pos_audit_info_b[$posAudit['month']] as $pos_terminal_serial_number){
                            if($pos_terminal_serial_number == $posAudit['terminal_transaction_serial_number']){
                                $posCheck = false;continue;
                            }
                        }
                }
                if(!$posCheck) continue;
                if(!empty($pos_information)){
                    foreach($pos_information as $pos_infom){
                        if(($pos_infom['amount'] == $posAudit['amount'] && $pos_infom['transaction_time'] == $posAudit['transaction_time'] && strlen($pos_infom['card_num']) > 10)){
                            $LastCar4Sys = substr($pos_infom['card_num'],-4);
                            $FirstCar6Sys = substr($pos_infom['card_num'],0,6);
                            if($LastCar4Sys == $CardNumPos4[$key] && $FirstCar6Sys == $CardNumPos6[$key]) {
                                $posCheck = false;
                                continue;
                            }
                        }
                        $mon = date("m",$pos_infom['transaction_time']);
                        if($posAudit['terminal_transaction_serial_number'] == $pos_infom['serial_num'] && $posAudit['month'] == $mon){
                            $posCheck = false;
                            continue;
                        }
                    }
                }
                if($posCheck) {
                    $model = new PosAudit();
                    $model->attributes = $posAudit;
                    $model->save(false);
                }
            }
        }

        /*if(empty($posData) && !empty($posInfo)){
            foreach($posInfo as $val){
                $array_b = array(date("m",$val['transaction_time']),$val['device_num'],$val['serial_num'],$val['transaction_time'],date("Ymd",$val['transaction_time']),$val['amount'],$val['id'],'',$time,0,0,Yii::app()->user->id,'',$time);
                $bool = Yii::app()->db->createCommand()
                    ->select('pos_info_id')
                    ->from(self::model()->tableName())
                    ->where('pos_info_id=:pos_info_id',array(':pos_info_id'=>$val['id']))->queryScalar();
                if(!$bool) {
                    $model = new PosAudit();
                    $insetData = array_combine($array_a, $array_b);
                    $model->attributes = $insetData;
                    $model->save(false);
                }
            }
        } elseif(!empty($posData) && empty($posInfo)){
            foreach($posData as $val){
                $transction_time = strtotime($val['交易发生日'].substr($val['交易时间'],0,6));
                $array_b = array(date("m",$transction_time),$val['终端号'],$val['POS交易流水号'],$transction_time,$val['交易发生日'].$val['交易时间'],$val['交易金额'],'',json_encode($val),$time,PosAudit::PROCESS_TYPE_YET_NO,PosAudit::TYPE_SYSTEM,Yii::app()->user->id,'',$time);
                $insetData = array_combine($array_a,$array_b);
                $bool = Yii::app()->db->createCommand()
                    ->select('id')
                    ->from(self::model()->tableName())
                    ->where('month=:month and terminal_number=:terminal_number and terminal_transaction_serial_number=:terminal_transaction_serial_number
',array(':month'=>date("m",$transction_time),':terminal_number'=>$val['终端号'],':terminal_transaction_serial_number'=>$val['POS交易流水号']))->queryScalar();
                if(!$bool) {
                    $model = new PosAudit();
                    $model->attributes = $insetData;
                    $model->save(false);
                }
            }
        }else{
            foreach($posInfo as $info){
                foreach($posData as $val){
                    $transction_time = strtotime($val['交易发生日'].substr($val['交易时间'],0,6));
                    $monthData = date("m",$transction_time);
                    $monthInfo = date("m",$info['transaction_time']);
                    file_put_contents("txt.php",$monthData.'..'.$monthInfo.'//'.$transction_time.'//'.$info['transaction_time']);
                    if(($monthData == $monthInfo) && ($val['POS交易流水号'] == $info['serial_num'])){
                        $json_data = json_encode($val);
                        $bool = Yii::app()->db->createCommand()
                            ->select('id')
                            ->from(self::model()->tableName())
                            ->where('month=:month and terminal_number=:terminal_number and terminal_transaction_serial_number=:terminal_transaction_serial_number
',array(':month'=>date("m",$transction_time),':terminal_number'=>$val['终端号'],':terminal_transaction_serial_number'=>$val['POS交易流水号']))->queryScalar();
                        if(!$bool) {
                            $type = self::TYPE_NORMAL;
                            $status = self::PROCESS_TYPE_NO;
                            $array_b = array(date("m",$transction_time),$val['终端号'],$val['POS交易流水号'],$transction_time,$val['交易发生日'].substr($val['交易时间'],0,6),$val['交易金额'],$info['id'],$json_data,$time,$status,$type,Yii::app()->user->id,'',$time);
                            $insetData = array_combine($array_a,$array_b);

                            $model = new PosAudit();
                            $model->attributes = $insetData;
                            $model->save(false);
                        }else{
                            $model = PosAudit::model()->findByPk($bool);
                            if(empty($model->callback_data)) {
                                $model->callback_data = $json_data;
                                $model->type = self::TYPE_NORMAL;
                                $model->status = self::PROCESS_TYPE_NO;
                                $model->save(false);
                            }
                        }
                    }
                }
            }
            self::insetPosAudit('',$posData);
        }*/
    }

    public static function getCVSkv(){
        return array(
            'ShopID'=>'','Name'=>'','Amount'=>'','UserPhone'=>'','CardNum'=>'',
            //'ShopName'=>'',
            /*'Operator'=>'',
            'DocNum'=>'',
            'BatchNum'=>'',
            'CardValidDate'=>'',*/
            'Money'=>'交易金额',
            'TransactionSerialNum'=>'POS交易流水号',
            'BusinessNum'=>'商户号',
            'DeviceNum'=>'终端号',
            'TransactionDate'=>'交易发生日',
            'TransactionTime'=>'交易时间',
            'TransactionType'=>'交易类型标识',
            'SendCardBank'=>'发卡行代号',
            'ReceiveBank'=>'收单行代号',
            'ClearAccountDate'=>'清算日',
            'CardNumPos'=>'交易账号',
        );
    }
    /**
     *
     * 利用盖网编号获取用户信息
     * @param string $gaiNumber
     * @return array

     */
    public static function getMemberByGainumber($gaiNumber){
        return Yii::app()->db->createCommand()->from('{{member}}')
            ->where('gai_number=:params and status<=:status', array(
                ':params' => $gaiNumber,':status'=>Member::STATUS_NORMAL))->queryRow();
    }
    /*
     * 获取加盟商信息
     * */
    public static function getFranchisee($franchiseeId){
        $franchisee = Yii::app()->db->createCommand()
            ->from('{{franchisee}}')->where('id=:fid', array(':fid'=>$franchiseeId))
            ->queryRow();
        return $franchisee;
    }
    private static $_baseTableName = '{{account_flow}}';
    /**
     * 按月创建表
     * @return string
     */
    public static function monthTable($timeM = null) {
        if($timeM === null)
            $timeM = time();
        $time = date('Ym', $timeM);
        $table = self::$_baseTableName . '_' . $time;
        $baseTable = self::$_baseTableName;

        $exist = Yii::app()->ac->createCommand("SHOW TABLES LIKE '$table'")->queryScalar();
        if ( $exist === false ) {
            $sql = "CREATE TABLE IF NOT EXISTS $table LIKE $baseTable;";
            Yii::app()->ac->createCommand($sql)->execute();
        }

        return ACCOUNT . '.' . $table;
    }
}


