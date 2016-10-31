<?php

/**
 * pos对账
 */
class AccountPosRecordController extends Controller {
    /**
     * 列表
     */
    public function actionAdmin() {
        $model = new PosAudit('search');
        $model->unsetAttributes();
        if (isset($_GET['PosAudit'])) {
            $paramData = $this->getParam('PosAudit');
                $StartTime = !empty($paramData['startTime'])?strtotime($paramData['startTime']):'';
                $EndTime = !empty($paramData['endTime'])?strtotime($paramData['endTime']):'';
            if ($StartTime > $EndTime) {
                throw new CHttpException(400, '结束时间不能比开始时间小');
            }else {
                $model->attributes = $this->getParam('PosAudit');
                $model->endTime = $EndTime;
                $model->startTime = $StartTime;
            }
        }
        $dirMk = Yii::getPathOfAlias('att') . DS . 'posrecon';
        $mfile = $this->get_files1($dirMk);
        $this->render('admin', array(
            'model' => $model,
            'modelData' => $model->search(),
            'files' => isset($mfile)?$mfile:'',
        ));
    }
    /*
     * 读取文件，进行比较
     * */
    public function actionReadeFile($posStartTime,$posEndTime){
        @ini_set('memory_limit', '2048M');
        set_time_limit(0);
        $oneData = 24*60*60;
        $posData = array();
        $months = array();
        $posInfo = '';
        //获取数据库pos_information数据
        //$posInfo = PosAudit::getPosInformation($posStartTime,$posEndTime);
        $dirMk = Yii::getPathOfAlias('att') . DS . 'posrecon';
            if(!file_exists($dirMk)) {
                 mkdir($dirMk);
            }
        $conn = ftp_connect("121.8.157.114",'21') or die("Could not connect");
        ftp_login($conn,"gaiwang","gaiwang");
        while($posStartTime != $posEndTime) {
            $fileName = date("Ymd", $posStartTime) . '盖网.csv';
            $mkFile = $dirMk .DS.date("Ymd", $posStartTime).'.csv';
            if (!file_exists($mkFile)) {
                fopen($mkFile, "w");
                @ftp_get($conn,$mkFile,$fileName,FTP_ASCII);
            }
            //获取cvs文件数据
            if (file_exists($mkFile)) {
                $posData = self::importCvs($mkFile,$posData);
            }
            $month = date("m", $posStartTime);
            if(!in_array($month,$months))
                $months[] = $month;
            $posStartTime += $oneData;
        }
        ftp_close($conn);
            if(!empty($posData)){
               PosAudit::insetPosAudit($posData,$months);
            }
        $this->redirect(array('accountPosRecord/admin'));
    }
    /**
     * ajax添加备注
     */
    public function actionAddRemarks(){
        if ($this->isAjax() && $this->isPost()) {
            $id = $this->getPost('id');
            $remark = $this->getPost('remark');
            $model = PosAudit::model()->findByPk($id);
            if ($remark == 'data') {
                    echo json_encode($model->remark);
                exit;
            } else {
                $model->remark = addslashes($remark);
                if ($model->save(false)) {
                    SystemLog::record($this->getUser()->name . "Pos对账修改备注：" . $model->remark);
                    exit(json_encode(array('success' => '添加备注成功')));
                } else
                    exit(json_encode(array('error' => '添加备注失败')));
            }
        }
    }
    /*
     * 查看详情
     * */
    public function actionDetail($id){
        $model = PosAudit::model()->findByPk($id);
        $callbackData = json_decode($model->callback_data);
        $LogPos = '';
        if(!empty($model->log))
            $LogPos = json_decode($model->log);
        $posModel = PosInformation::model()->findByPk($model->pos_info_id);
        if(!empty($posModel->device_num)) {
            $MemberInfo =  Yii::app()->db->createCommand()
                ->select('gai_number,username')
                ->from(Member::model()->tableName())
                ->where("id=:id",array(':id'=>$posModel->member_id))
                ->queryRow();
            $agentName = PosAudit::getMachineName($posModel->device_num,PosAudit::AGENT_TYPE);
            $machineName = PosAudit::getMachineName($posModel->device_num,PosAudit::MACHINE_TYPE);
        }
        $this->render('detail', array(
            'model'=>$model,
            'posModel' => isset($posModel)?$posModel:$posModel,
            'callbackData' => isset($callbackData)?$callbackData:$callbackData,
            'agentName' => isset($agentName)?$agentName:'',
            'MemberInfo' => isset($MemberInfo)?$MemberInfo:'',
            'machineName' => isset($machineName)?$machineName:'',
            'LogPos'=> !empty($LogPos)?$LogPos[0]:'',
        ));
    }
    /*
 * 修改处理状态
 * */
    public function actionUpdateStatus(){
        $id = $this->getPost('id');
        $model = PosAudit::model()->findByPk($id);
        if($model->status != PosAudit::PROCESS_TYPE_END && $model->status >= PosAudit::PROCESS_TYPE_YET_NO) {
            $model->status = $model->status + 1;
        }else{
            exit(json_encode(array('error' => '不能修改')));
        }
        if ($model->save(false)) {
            SystemLog::record($this->getUser()->name . "修改处理状态：" . $model->status);
            exit(json_encode(array('success' => '修改成功')));
        } else
            exit(json_encode(array('error' => '修改失败')));
    }
    /*
     * 更新数据
     * */
    public function actionUpdateData(){
        $model = new PosAudit();
        if (isset($_GET['PosAudit'])) {
            $ParamData = $this->getParam('PosAudit');
            $posStartTime = strtotime($ParamData['posStartTime']);
            $posEndTime = strtotime($ParamData['posEndTime']);
            if ($posStartTime > $posEndTime) {
                throw new CHttpException(400, '结束时间不能比开始时间小');
            } else {
                $model->posStartTime = strtotime($ParamData['posStartTime']);
                $model->posEndTime = strtotime($ParamData['posEndTime']);
            }
        }
        if(empty($posStartTime) && !empty($posEndTime)){
            $posStartTime = $posEndTime;
        }
        if(!empty($posStartTime) && empty($posEndTime)){
            $posEndTime = $posStartTime;
        }
        if(!empty($posEndTime) && !empty($posStartTime)) {
            self::actionReadeFile($posStartTime, $posEndTime);
        }else{
            throw new CHttpException(400, '请选择时间');
        }
        $this->render('admin', array(
            'model' => $model,
        ));
    }
    /*
     * 遍历文件
     * */
    public function get_files1($dir) {
        $files = array();
        if(!is_dir($dir)) {
            return $files;
        }
        $handle = opendir($dir);
        if($handle) {
            while(false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..') {
                    $filename = $dir . "/"  . $file;
                    if(is_file($filename)) {
                        $files[] = $file;
                    }
                }
            }
            closedir($handle);
        }
        return $files;
    }   //  end function
    /*
     * 读取cvs文件数据类
     * */
    public static function importCvs($dir,$arrayData){
        if(!empty($arrayData)) {
            $counSum = count($arrayData);
        }else{
            $counSum = 0;
        }
        $objPHPExcel = '';
        $exceData = '';
        //引入phpExcel
        require_once Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel/Shared/String.php';
        require_once Yii::getPathOfAlias('comext') . '/PHPExcel/PHPExcel.php';
        Yii::registerAutoloader(array('PHPExcel_Autoloader', 'Register'), true);
        $objPHPExcel = PHPExcel_IOFactory::load ( $dir );
        $exceData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $exceData[1] = array('A'=>'发卡行代号|收单行代号|交易账号|系统参考号|交易发生日|交易时间|POS交易流水号|交易金额|清算日|终端号|商户号|商户帐号|交易币别|清算金额|交易类型标识|原中心跟踪码|商户手续费|卡类型');
        $keyData = array();
        $valData = array();
        $num = 0;
        if(!empty($exceData)){
            foreach($exceData as $key=>$val){
                if($key == 1){
                    $keyData = explode('|',$val['A']);
                }else{
                    $valData[$num++] = explode('|',$val['A']);
                }
            }
            foreach($valData as $key=>$val){
                foreach($keyData as $k=>$value){
                    $arrayData[$counSum+$key][$value] = $val[$k];
                }
            }
        }
        return !empty($arrayData)?$arrayData:'';
    }
    public function actionSupplementTransactions(){
        $id = $this->getParam('id');
        $posInfo = PosAudit::model()->findByPk($id);
        if (isset($_POST['PosAudit'])) {
            if(!empty($posInfo->callback_data)) {
                $postArr = $_POST['PosAudit'];
                $posApiData = array();
                $posData =  json_decode($posInfo->callback_data,true);
                $posArr = PosAudit::getCVSkv();
                foreach($posArr as $key=>$val){
                    if(!empty($val)) {
                        $posArr[$key] = $posData[$val];
                    }
                }
                foreach($postArr as $key=>$val){
                    if(!empty($val)) {
                        $posArr[$key] = $postArr[$key];
                    }
                }
                $posArr['isSupply'] = 1;
                $posArr['TransactionTime'] = substr($posArr['TransactionTime'],0,6);
                if ($this->actionConsumebypos($posArr,$id) === true) {
                   /* $postArr['userId'] = Yii::app()->user->id;
                    $postArr['username'] = Yii::app()->user->name;
                    $postArr['time'] = time();
                    $logArr = array();
                    $logJson = '';
                    if(!empty($posInfo->log)) {
                        $logArr1 = json_decode($posInfo->log,true);
                        foreach($logArr1 as $key => $val){
                            $logArr[$key] = $val;
                        }
                        $num = count($logArr1);
                        $logArr[$num] = $postArr;
                        $logJson = json_encode($logArr);
                    }
                    else
                    $logJson = json_encode(array($postArr));
                    $posInfo->log = $logJson;
                    $posInfo->admin_id = Yii::app()->user->id;
                    $posInfo->status = PosAudit::PROCESS_TYPE_END;
                    $posInfo->update_time = time();
                    if($posInfo->save(false)){*/
                        $this->setFlash('success', Yii::t('appTopicHouse', '补录成功'));
                        $this->redirect(array('accountPosRecord/admin'));
                   // }
                }else{
                    //$this->setFlash('success', Yii::t('appTopicHouse', '补录失败'));
                }
            }
        }
        $model = new PosAudit();
        $this->render('supplementTransactions', array(
            'model' => $model,
            'posJson' => !empty($posInfo->callback_data)?json_decode($posInfo->callback_data):'',
            'postArr'=>!empty($postArr)?$posArr:'',
        ));
    }
    public function actionConsumebypos($post,$Posid)
    {
        try {
            //由于太长 所以分拆几行
            if(empty($post)){
                 return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '数据没有数据'));
            }
            if(empty($post['CardNum'])) {
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '卡号不能为空'));
            }
                if(empty($post['UserPhone'])){
                    return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '手机号不能为空'));
                }
            if(empty($post['Name'])){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '盖网账号不能为空'));
            }
            if(!PosInformation::checkCardNum($post['CardNum'])){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '不是合法的卡号'));
            }
            $LastCar4Sys = substr($post['CardNum'],-4);
            $FirstCar6Sys = substr($post['CardNum'],0,6);
            $LastCar4 = substr($post['CardNumPos'],-4);
            $FirstCar6 = substr($post['CardNumPos'],0,6);
            if($LastCar4Sys != $LastCar4 || $FirstCar6Sys != $FirstCar6){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '卡号不正确'));
            }
            if(!is_numeric($post['Amount']) || $post['Amount']<=0){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '输入金额请大于0的数字'));
            }

            $amount = $post['Amount'];
            $amountPos = $post['Money'];
            if(bccomp($amount,$amountPos,4) != 0){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '输入金额不正确'));
            }

            $machine = Yii::app()->gt->createCommand()->from('{{machine}}')->where('machine_code =:machine_code', array(':machine_code' => $post['ShopID']))->queryRow();
            $symbol = $machine['symbol'];
            if (empty($machine)){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '盖机不存在'));
            }
            if($machine['pos_code'] != $post['DeviceNum']){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '盖机终端号不一致'));
            }
            // 消费金额转换成人民币
            if ($symbol == Symbol::RENMINBI || $symbol == Symbol::EN_DOLLAR) {
                $basePrice = 100;
                $symbol = Symbol::RENMINBI;
            } elseif ($symbol == Symbol::HONG_KONG_DOLLAR && $hkRate = $this->getConfig('rate', 'hkRate')) {
                $basePrice = $hkRate;
            } else {
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '币种错误'));
            }
            // 转换为人民币(100*0.75)
            $moneyRMB = bcmul($amount, bcdiv($basePrice, 100, 5), 2);

            $gaiNumber = $post['Name'];

            if ($gaiNumber != false) {
                $member = PosAudit::getMemberByGainumber($gaiNumber);
                if (empty($member)){
                    return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '账号不存在'));
                }
                $userPhone = $member['mobile'];
                if($userPhone != $post['UserPhone']){
                    return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '手机与盖网号不匹配'));
                }
            }
            $pay_time = strtotime($post['TransactionDate'].$post['TransactionTime']);

            $accountFlowTable = PosAudit::monthTable($pay_time);

            // 获取加盟商信息
            $franchisee = PosAudit::getFranchisee($machine['biz_info_id']);
            if (empty($franchisee)) {
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '不存在该商家'));
            }

            //盖网通接口加入了折扣设定验证，这里也加入，为了防止截取url直接访问这边。
            if ($franchisee['member_discount'] == 0 || $franchisee['gai_discount'] == 0) {
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '盖机参数设定异常，无法消费'));
            } else if($franchisee['gai_discount'] > $franchisee['member_discount']){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '盖机参数设定异常，无法消费'));
            }
            //加盟商对应的信息
            $franchiseeMember = Yii::app()->db->createCommand()
                ->select('id,gai_number,status')
                ->from('{{member}}')
                ->where('id=:id',array(':id'=>$franchisee['member_id']))
                ->queryRow();
            if(empty($franchiseeMember)){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '商家的账号不存在'));
            }
            if($franchiseeMember['status'] > Member::STATUS_NORMAL){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '商家的账号已被禁用或删除!'));
            }
            if($franchisee['member_id'] == $member['id']){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '您作为商家，不能在本店消费'));
            }

            // 人民币转换为积分
            $score = Common::convertSingle($moneyRMB, $member['type_id']);
            $recordId = "";
            $order_id = 'SNt'.Tool::buildOrderNo();

            //针对post消费，二次补录订单号，追加"-BL"后缀
            // ----------- modify by xuegang.liu@gmail.com   2016-04-11 15:28:32 -----------------------
            $order_id = (isset($post['isSupply']) && !empty($post['isSupply']) ) ? $order_id."-BL" : $order_id;
            //--------------------------------------- modify end --------------------------------------

            $data = array(
                // ''=>
                'moneyRMB' => $moneyRMB,
                'basePrice' => $basePrice,
                'symbol' => $symbol,
                'machineSN' => $post['TransactionSerialNum'],//原本是TransactionSerialNum
                'accountFlowTable' => $accountFlowTable,
                'money' => $amount,
                'serial_number'=>$order_id,
                'pay_type'=>FranchiseeConsumptionRecord::RECORD_TYPE_POS,
                'record_type'=>FranchiseeConsumptionRecord::RECORD_TYPE_POINT,
            );


            if(empty($member)){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '盖网号没有对应的该盖网会员'));
            }

            $pos_info = Yii::app()->db->createCommand()
                ->select("id")
                ->from('{{pos_information}}')
                ->where("serial_num = :serial_num  and transaction_time = :transaction_time",
                    // ->where("machine_id = ':mid' and serial_num = ':serial_num' and doc_num = ':doc_num' and batch_num = ':batch_num'",
                    array(
                        ':serial_num'=>(string)$post['TransactionSerialNum'],
                        ':transaction_time'=>$pay_time,
                    )
                )
                ->queryRow();
            if(!empty($pos_info)){
                $posInfo = PosAudit::model()->findByPk($Posid);
                $posInfo->pos_info_id = $pos_info['id'];
                $posInfo->status = PosAudit::PROCESS_TYPE_NO;
                $posInfo->save(false);
                Yii::app()->user->setFlash('success', Yii::t('articleCategory', '无需补录'));
                return $this->redirect(array('accountPosRecord/admin'));
            }
            // 当月的流水表 在开启事务之前创建
            $monthTable = PosAudit::monthTable($pay_time);
            //开启事务
            $transaction = Yii::app()->db->beginTransaction();
            $time = time();
            $posInformation_mod = new PosInformation();
            $posInformation_mod->is_supply = (isset($post['isSupply']) && !empty($post['isSupply'])) ? $post['isSupply'] : 0;
            $posInformation_mod->machine_id = $machine['id'];
            $posInformation_mod->machine_serial_num = $order_id;
            $posInformation_mod->member_id = $member['id'];
            $posInformation_mod->phone = $post['UserPhone'];
            $posInformation_mod->card_num = $post['CardNum'];
            $posInformation_mod->amount = $amount;
            $posInformation_mod->serial_num = $post['TransactionSerialNum'];
            $posInformation_mod->transaction_time = $pay_time;
            $posInformation_mod->business_num = $post['BusinessNum'];
            $posInformation_mod->device_num = $post['DeviceNum'];
            $posInformation_mod->shopname = isset($post['ShopName'])?$post['ShopName']:'';
            $posInformation_mod->operator = isset($post['Operator'])?$post['Operator']:'';
            $posInformation_mod->doc_num = isset($post['DocNum'])?$post['DocNum']:'';
            $posInformation_mod->batch_num = isset($post['BatchNum'])?$post['BatchNum']:'';
            $posInformation_mod->card_valid_date = isset($post['CardValidDate'])?strtotime($post['CardValidDate']):'';
            $posInformation_mod->transaction_type = $post['TransactionType'];
            $posInformation_mod->send_card_bank = isset($post['SendCardBank'])?$post['SendCardBank']:'';
            $posInformation_mod->receive_bank = isset($post['ReceiveBank'])?$post['ReceiveBank']:'';
            $posInformation_mod->clear_account_date = isset($post['ClearAccountDate'])?strtotime($post['ClearAccountDate']):'';

            if(!$posInformation_mod->save()){
                return Yii::app()->user->setFlash('success', Yii::t('articleCategory', '保存流水失败'));
            }else{
                //[{"ShopID":"201512140301","Name":"GW91316950","Amount":"1","UserPhone":"18814099798","CardNum":"62284833334515","userId":"167","username":"admin","time":1470646839}]
                $postArr = array();
                $postArr['ShopID'] = $post['ShopID'];
                $postArr['Name'] = $gaiNumber;
                $postArr['Amount'] = $amount;
                $postArr['UserPhone'] = $userPhone;
                $postArr['CardNum'] = $post['CardNum'];
                $postArr['userId'] = Yii::app()->user->id;
                $postArr['username'] = Yii::app()->user->name;
                $postArr['time'] = time();
                $posAuide = PosAudit::model()->findByPk($Posid);
                $posAuide->pos_info_id = $posInformation_mod->id;
                $logJson = json_encode(array($postArr));
                $posAuide->log = $logJson;
                $posAuide->admin_id = Yii::app()->user->id;
                $posAuide->status = PosAudit::PROCESS_TYPE_END;
                $posAuide->update_time = time();
                $posAuide->save(false);
            }
            $ratio = Yii::app()->db->createCommand()
                ->select("ratio")
                ->from("{{member_type}}")
                ->where("id = {$member['type_id']}")
                ->queryScalar();

            $score = bcdiv($amount,$ratio,2);
            //插入recharge 因为冲突不能用save
            Yii::app()->db->createCommand()->insert(Recharge::model()->tableName(),
                array(
                    'member_id' => $member['id'],
                    'code' =>$order_id,
                    'ratio' => $ratio,
                    'score'=>$score,
                    'money' =>  $amount,
                    'create_time' =>  $time,
                    'pay_time' =>$pay_time,
                    'status' => Recharge::STATUS_SUCCESS,
                    'description' => '通过盖网通'.$post['ShopID'].'pos刷卡充值消费',
                    'pay_type' => Recharge::PAY_TYPE_POS,
                    'pay_mode' => 1,
                    'by_gai_number' =>$member['gai_number'],
                    'ip' => Tool::getIP(),
                ));
            $recarge_id = Yii::app()->db->getLastInsertID();

            // 会员余额表记录创建
            $arr = array(
                'account_id'=>$member['id'],
                'type'=>AccountBalance::TYPE_CONSUME,
                'gai_number'=>$member['gai_number']
            );
            $memberAccountBalance = AccountBalance::findRecord($arr,false,$pay_time);

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
            // 会员账户余额表更新
            AccountBalance::calculate(array('today_amount' => $amount), $memberAccountBalance['id']);
            // 借贷流水1.按月
            Yii::app()->db->createCommand()->insert($monthTable,
                AccountFlow::mergeField($MemberCredit,$pay_time));
            $transaction->commit();
            $resule = IntegralOfflineNew::offlineConsumePos($franchisee, $machine, $member, $data, $recordId,array(),$pay_time);
            if ($resule !== true) {
                //return Yii::app()->user->setFlash('success', Yii::t('articleCategory', $resule));
            }
            $totalMoney = AccountBalance::getAccountAllBalance($member['gai_number'], AccountBalance::TYPE_CONSUME);
            // 发送短信
            $this->sendSms_gtDeduct($member, $franchisee['name'], $amount, $score, $userPhone, $symbol, $totalMoney, $recordId, 1,$pay_time);
            return true;
        }catch (Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
    /**
     * 盖网通消费积分后发送短信
     * @param array $member
     * @param string $franchiseeName
     * @param float $money
     * @param float $score
     * @param float $moneyRMB
     * @param int $userPhone
     */
    public function sendSms_gtDeduct($member, $franchiseeName, $money, $score, $userPhone, $symbol, $totalMoney, $recordId, $smsType = 0,$pay_time) {
        $smsConfig = $this->getConfig('smsmodel');
        if (isset($smsConfig['offScoreConsume']) && $smsConfig['offScoreConsume'] != false) {
            $smsContent = $smsConfig['offScoreConsume'];
            $money = $symbol == 'HKD' ? "HK$" . $money : "￥" . $money;
            $now = $pay_time;
            $smsContent = str_replace(array('{0}', '{1}', '{2}', '{3}', '{4}', '{5}'), array($member['gai_number'], date('Y-m-d H:i', $now), $franchiseeName, $money, $score,
                Common::convertSingle($totalMoney, $member['type_id'])), $smsContent);
            $datas =  array($member['gai_number'], date('Y-m-d H:i', $now), $franchiseeName, $money, $score,
                Common::convertSingle($totalMoney, $member['type_id']));
            $tmpId = $smsConfig['offScoreConsumeId'] ;
            SmsLog::addSmsLog($userPhone, $smsContent, $recordId, SmsLog::TYPE_OFFLINE_ORDER,null,true, $datas,  $tmpId);
        }
    }
}