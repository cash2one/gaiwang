<?php
/**
 * 积分申请兑现
 * 操作(申请,兑现记录)
 *  @author zhenjun_xu <412530435@qq.com>
 */
class ApplyCashController extends MController{

    public $layout = 'member';

    public function init()
    {
        $this->pageTitle = '_'.Yii::t('memberApplyCash', '用户中心').'_' . Yii::app()->name;
    }

    /**
     * ajax 获取手机验证码
     */
    public function actionGetMobileVerifyCode() {
        if (Yii::app()->request->isAjaxRequest) {
            $member = Member::model()->findByPk($this->getUser()->id);
            $verifyCodeCheck = $this->getSession($member->mobile);
            if($verifyCodeCheck){
                $verifyArr = unserialize( Tool::authcode($verifyCodeCheck,'DECODE'));
                if($verifyArr && (time() - $verifyArr['time'] < 60) ){
                    echo Yii::t('memberHome', '验证码正在发送，请等待{time}秒后重试',array('{time}'=>'60'));
                    Yii::app()->end();
                }
            }
            $tmpId = $this->getConfig('smsmodel','phoneVerifyContentId');
            $verifyCode = mt_rand(10000, 99999);
//            $msg = Yii::t('memberApplyCash', $smsConfig['phoneVerifyContent'],array('{0}'=>$verifyCode));
            $msg = str_replace('{0}', $verifyCode, Yii::t('memberApplyCash', $smsConfig['phoneVerifyContent']));
            $data = array('time' => time(), 'verifyCode' => $verifyCode);
            //验证码同时写cookie\session 防止丢失
            $this->setCookie($member->mobile, Tool::authcode(serialize($data),'ENCODE','',60*5),60*5);
            $this->setSession($member->mobile,Tool::authcode(serialize($data),'ENCODE','',60*5));
            
            if(Yii::app()->request->cookies[$member->mobile]){
                SmsLog::addSmsLog($member->mobile, $msg, 0,SmsLog::TYPE_CAPTCHA,null,true,array($verifyCode),  $tmpId);
                echo 'success';
            }else{
                echo "发送失败,请重试";
            }
            Yii::app()->end();
        }
    }

    /**
     * 兑现完成
     */
    public function actionComplete(){
        $this->pageTitle = Yii::t('memberApplyCash', '兑现完成') . $this->pageTitle;
        $this->render('complete');
    }

    /**
     * 提现、兑现 统一界面
     */
    public function actionList(){
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
                        $this->redirect(array('applyCash/complete'));
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

        $this->render('list', array(
            'businessAccount' => $businessAccount,
            'agentAccount' => $agentAccount,
//            'freezeMoney' => $freezeMoney,
            'enterprise' => $enterprise,
            'model' => $model,
            'cashSetting' => $cashSetting,
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
     * 提现列表
     */
    public function actionLog()
    {
        $this->pageTitle = Yii::t('memberApplyCash', '提现列表') . $this->pageTitle;
        $model = new CashHistory('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['CashHistory']))
            $model->attributes = $this->getQuery('CashHistory');
        $c = $model->searchEnterpriseCash($this->getUser()->id);
        $count = CashHistory::model()->count($c);
        $pages = new CPagination($count);
        $pages->applyLimit($c);

        $log = CashHistory::model()->findAll($c);
        $this->render('log', array('model' => $model, 'pages' => $pages, 'log' => $log));
    }

} 