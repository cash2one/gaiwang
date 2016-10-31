<?php 

/**
 * 企业管理控制器
 * @author wyee<yanjie.wang@g-emall.com>
 *
 */
class EnterpriseController extends MController {
     
    public $layout = 'member'; 
    public function beforeAction($action){
        $enterpriseId = $this->getSession('enterpriseId');
        if(!$enterpriseId){
            throw new CHttpException(404, '请求的页面不存在');
        }
        return parent::beforeAction($action);
    }
    
    
    public function ActionIndex(){
        $enterpriseId = $this->getSession('enterpriseId');
        $model = Enterprise::model()->findByPk($enterpriseId);
        $bindMobile=Member::model()->findByPk($this->getUser()->id,array('select'=>'mobile'));
        if(isset($_POST['Enterprise'])){
            unset($model->attributes);
            $model->attributes = $this->getPost('Enterprise');
           if ($model->save(false)){
               $this->setFlash('success', Yii::t('store', '操作成功'));
           }else{
               $this->setFlash('error', Yii::t('store', '操作失败'));
           }
        }
        $this->render('index',array(
                'model'=>$model,
                'bindMobile'=>$bindMobile->mobile
          ));
    } 
    
    /**
     * 提现列表
     */
    public function ActionCashList(){
        $this->pageTitle = Yii::t('memberApplyCash', '提现列表') . $this->pageTitle;
        $model = new CashHistory('search');
        $model->unsetAttributes(); // clear any default values
        $model->status='';
        if (isset($_GET['CashHistory']))
            $model->attributes = $this->getQuery('CashHistory');
        $c = $model->searchEnterpriseCash($this->getUser()->id);
        $count = CashHistory::model()->count($c);
        $pages = new CPagination($count);
        $pages->applyLimit($c);
        
        $log = CashHistory::model()->findAll($c);
        $this->render('cashList', array('model' => $model, 'pages' => $pages, 'log' => $log));
    }
    
    /**
     * 申请提现
     */
    public function ActionApplyCash(){
       $this->pageTitle = Yii::t('memberApplyCash', '申请提现') . $this->pageTitle;
        $memberId = $this->getUser()->id;
        /** @var Member $member */
        $member = Member::model()->findByPk($memberId);
        // 商家余额
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_MERCHANT,
            'gai_number' => $member['gai_number'],
        );
        $enterpriseAccountAry = AccountBalance::findRecord($array);
        $businessAccount = $enterpriseAccountAry['today_amount'];
        // 代理余额
        $array = array(
            'account_id' => $member['id'],
            'type' => AccountBalance::TYPE_AGENT,
            'gai_number' => $member['gai_number'],
        );
        $agentAccountAry = AccountBalance::findRecord($array);
        $agentAccount = $agentAccountAry['today_amount'];
        
        /** @var $enterprise Enterprise 商家信息 */
        $enterprise = Enterprise::model()->findByPk($member->enterprise_id);
        if (!$enterprise) throw new CHttpException(403,'can not find enterprise');
        
        // 提现历史
        /** @var  CashHistory $model */
        $model = new CashHistory('enterpriseCash');
        //银行账户
        /** @var  BankAccount $bank */
        $bank = BankAccount::model()->findByAttributes(array('member_id' => $memberId));
        if($bank){
            $model->account = $bank->account;
            $model->account_name = $bank->account_name;
            $model->bank_name = $bank->bank_name;
            $model->bank_address = Region::getName($bank->province_id,$bank->city_id,$bank->district_id);
        }
        $this->performAjaxValidation($model);
        
        //提现的冻结金额[禁止提现的]
//        $freezeMoney = Freeze::sumFreeze($enterprise->id);
        
        $cashSetting = $this->getConfig('shopcash');
        // 字段中有最小提现金额，则用字段中的最小提现金额，否则用配置文件的
        if (!empty($enterprise->min_apply)) {
            $cashSetting['applyCashUnit'] = $enterprise->min_apply;
        }
        
        if(isset($_POST['CashHistory'])){
            $findLastOne = $model->findByAttributes(array('member_id'=>$memberId),array('order'=>'apply_time DESC'));
            if($findLastOne && ($findLastOne->apply_time+300) > time()){
                $this->setFlash('error','亲爱的会员，系统五分钟内只能操作一次提现，请五分钟后再操作');
                throw new CHttpException(403);
            }
            //防止重复提交
            $this->checkPostRequest();
			if($enterprise->apply_cash_limit==Enterprise::APPLY_CASH_LIMIT_YES){
				$this->setFlash('error','亲爱的会员，因你目前处于财务纠纷阶段，你的提现申请已被禁止，若有疑问请咨询盖网客服');
                $this->refresh();
			}
            if(!$bank){
                $this->setFlash('error',Yii::t('applyCash','请向盖网提交您的银行账号信息'));
                $this->refresh();
            }
            $model->attributes = $this->getPost('CashHistory');
            $model->agentMoney = $_POST['CashHistory']['agentMoney'];
            //如果是繁体，则输入是港币，转成人民币
            if(Yii::app()->language!='zh_cn'){
                $model->money = Common::rateConvert($model->money,Common::CURRENCY_RMB);
                $model->agentMoney = Common::rateConvert($model->agentMoney,Common::CURRENCY_RMB);
            }
            if($model->money<=$businessAccount && $model->agentMoney <= $agentAccount){
                //逐个提现金额检查
                $this->_checkMoney($model->money,$businessAccount,$cashSetting['applyCashFactorage']);
                $this->_checkMoney($model->agentMoney,$agentAccount,$cashSetting['applyCashFactorage']);

                $totalMoney = $model->money + $model->agentMoney; //总提现金额
                $maxTotalMoney = $businessAccount + $agentAccount; //最大提现金额
                $maxFee = sprintf('%0.2f', $maxTotalMoney * $cashSetting['applyCashFactorage'] / 100); //手续费
                //总金额检查
                if($totalMoney > ($maxTotalMoney-$maxFee) ){
                    $this->setFlash('error',Yii::t('memberApplyCash','提现失败,金额校验失败 001'));
                    throw new CHttpException(403);
                }else{
                    $model->score = 0;
                    $model->factorage = $cashSetting['applyCashFactorage'];
                    $model->applyer = $enterprise->name;
                    $model->ratio = 0;
                    $model->apply_time = time();
                    $model->ip = Tool::ip2int($_SERVER['REMOTE_ADDR']);
                    $model->status = $model::STATUS_APPLYING;
                    $model->type = $model::TYPE_COMPANY_CASH;
                    $model->member_id = (int)$member->id;
                    $model->reason = ' ';
                    $model->symbol = ' ';
                    $model->base_price = 0;
                    $model->update_time = 0;
                    $model->code = Tool::buildOrderNo(20,3);
                    //
                    $flag = false;
                    //商家提现
                    if($model->money>0){
                        $flag = CashHistoryProcess::enterpriseCash($model->attributes, $member->attributes);
                    }
                    //代理提现
                    if($model->agentMoney > 0){
                        $model->code = Tool::buildOrderNo(20,3);
                        $model->money = $model->agentMoney;
                        $model->member_id = (int)$member->id;
                        $model->score = Common::convertSingle($model->money);
                        $model->ratio = $member->memberType->ratio;
                        $model->type = $model::TYPE_CASH;
                        $flag = CashHistoryProcess::memberCash($model->attributes, $member->attributes);
                    }
                    if ($flag) {
                        $this->setFlash('success', Yii::t('memberApplyCash', '申请提现成功!'));
                        $this->redirect(array('cashList'));
                    } else {
                        $this->setFlash('error', Yii::t('memberApplyCash', '抱歉，您的提现申请递交失败!'));
                    }
                }

            }else{
                $this->setFlash('error',Yii::t('memberApplyCash','提现失败,金额校验失败'));
                throw new CHttpException(403);
            }
        }
        
        //多货币显示
        $businessAccount = Common::rateConvert($businessAccount);
        $agentAccount = Common::rateConvert($agentAccount);
//        $freezeMoney = Common::rateConvert($freezeMoney);
        $cashSetting['applyCashUnit'] = Common::rateConvert($cashSetting['applyCashUnit']);

        $this->render('applyCash', array(
            'businessAccount' => $businessAccount,
            'agentAccount' => $agentAccount,
//            'freezeMoney' => $freezeMoney,
            'enterprise' => $enterprise,
            'model' => $model,
            'cashSetting' => $cashSetting,
            'gai_number'=>$member['gai_number']
        ));
    }
    
    /**
     * 检查提现金额+手续费 是否大于 账户余额
     * @param float $money 提现金额
     * @param float $cash 账户余额
     * @param float $factorage 手续费率
     * @throws CHttpException
     */
    private function _checkMoney($money, $cash, $factorage)
    {
        $fee = $money * $factorage / 100;
        if (($money + $fee) > $cash) {
            $this->setFlash('error',Yii::t('memberApplyCash', '抱歉，金额校验失败! ') . $money);
            throw new CHttpException(403);
        }
    }
    
    /**
     * 线下交易明细
     */
    public function ActionOffline(){
        $this->pageTitle = Yii::t('memberWealth', '线下交易详情') . $this->pageTitle;
        CActiveRecord::$db = Yii::app()->db1; //线下明细所有查询都使用从库
        $model = new FranchiseeConsumptionRecord();
        $model->unsetAttributes();
        $model->status='';
        if (isset($_GET['FranchiseeConsumptionRecord']))
            $model->attributes = $this->getParam('FranchiseeConsumptionRecord');  
        //查询该会员对应的加盟商id
        $sql = "select id from gw_franchisee where member_id=" . $this->getUser()->getId();
        $franchiseeIds = Yii::app()->db->createCommand($sql)->queryAll();
        $franchiseeIdsArr = array();
        foreach ($franchiseeIds as $franchisee_id) {
            $franchiseeIdsArr[] = $franchisee_id['id'];
        }
        $model->franchisee_id = $franchiseeIdsArr;
        $wealths = $model->searchListOffline();
        $this->render('offline', array(
                'wealths' => $wealths,
                'model' => $model
        ));
    }
    
    
    /**
     * 账户明细
     */
    public function ActionEnterpriseCashDetail(){
        $this->pageTitle = Yii::t('memberWealth', '账户明细') . $this->pageTitle;
        $model = new AccountFlow();
        $model->unsetAttributes();
        if (isset($_GET['AccountFlow']))
            $model->attributes = $this->getParam('AccountFlow');
        $this->render('enterprisecashdetail', array('model' => $model));
    }



    /*
     * 线下交易明细导出
    */
    
    public function actionExportExcel() {
        Yii::import('comext.PHPExcel.*');
        $objPHPExcel = new PHPExcel();
        CActiveRecord::$db = Yii::app()->db1; //切换从库
        $model = new FranchiseeConsumptionRecord();
        $model->unsetAttributes();
        $this->getQuery('franchiseeName') ? $model->remark = $this->getQuery('franchiseeName') : "";
        $this->getQuery('starTime') ? $model->start_time = $this->getQuery('starTime') : "";
        $this->getQuery('endTime') ? $model->end_time = $this->getQuery('endTime') : "";
        $this->getQuery('status') != "" ? $model->status = $this->getQuery('status') : "";
        $page = $this->getQuery('page') ?  $this->getQuery('page') : 1;

        //查询该会员对应的加盟商id
        $sql = "select a.id from gw_franchisee a LEFT JOIN gw_member m on a.member_id=m.id
        where m.id=" . $this->getUser()->getId();
        $franchiseeIds = Yii::app()->db->createCommand($sql)->queryAll();
        $franchiseeIdsArr = array();
        foreach ($franchiseeIds as $franchisee_id) {
            $franchiseeIdsArr[] = $franchisee_id['id'];
        }
        //输出表头
        $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', '加盟商名称')
        ->setCellValue('B1', '加盟商编号')
        ->setCellValue('C1', '对账状态')
        ->setCellValue('D1', '盖网折扣(百分比)')
        ->setCellValue('E1', '会员折扣(百分比)')
        ->setCellValue('F1', '账单时间')
        ->setCellValue('G1', '消费金额')
        ->setCellValue('H1', '分配金额')
        ->setCellValue('I1', '应付金额')
        ->setCellValue('J1', 'GW号')
        ->setCellValue('K1', '手机号');
        
        $franChiseeTb = Franchisee::model()->tableName(); 
        $criteria = new CDbCriteria;
        $criteria->addInCondition('t.franchisee_id', $franchiseeIdsArr);
        $criteria->join = "LEFT JOIN " . $franChiseeTb . " f ON f.id = t.franchisee_id";
        $criteria->compare('t.status', $model->status);
        if ($model->start_time) {
            $criteria->compare('t.create_time', ' >=' . strtotime($model->start_time));
        }
        if ($model->end_time) {
            $criteria->compare('t.create_time', ' <' . (strtotime($model->end_time) + 86400));
        }
        $criteria->compare('f.name', $model->remark, true);
        $criteria->order = 't.create_time desc';
        //$criteria->limit = CPagination::DEFAULT_PAGE_SIZE;
        //$criteria->offset = ($page - 1) * CPagination::DEFAULT_PAGE_SIZE ;
        $weathsData = FranchiseeConsumptionRecord::model()->findAll($criteria);
        if ($weathsData){
            $num = 1;
            foreach ($weathsData as $key => $wealth) {
                $num++;
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $num, $wealth->franchisee->name)
                ->setCellValue('B' . $num, $wealth->franchisee->code)
                ->setCellValue('C' . $num, FranchiseeConsumptionRecord::getCheckStatus($wealth->status))
                ->setCellValue('D' . $num, $wealth->gai_discount)
                ->setCellValue('E' . $num, $wealth->member_discount)
                ->setCellValue('F' . $num, date('Y-m-d H:i:s', $wealth->create_time))
                ->setCellValue('G' . $num, $wealth->spend_money)
                ->setCellValue('H' . $num, $wealth->distribute_money)
                ->setCellValue('I' . $num, IntegralOfflineNew::formatPrice($wealth->spend_money - $wealth->distribute_money))
                ->setCellValue('J' . $num, $wealth->member->gai_number)
                ->setCellValue('K' . $num, $wealth->member->mobile);
            }
         }
        $objPHPExcel->getActiveSheet()->setTitle("线下交易明细");
        $name = "线下交易明细";
        $name = iconv('UTF-8', 'GB2312', $name);
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $name . '.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        unset($weathsData, $objPHPExcel, $objWriter);
        Yii::app()->end();
    }
    






}
?>