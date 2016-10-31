<?php

/**
 * 积分充值
 *
 * 操作(积分充值，积分充值记录)
 * @author zhenjun_xu <412530435@qq.com>
 */
class RechargeController extends MController
{
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CaptchaAction',
                'height' => '30',
                'width' => '70',
                'minLength' => 4,
                'maxLength' => 4,
                'offset' => 3,
                'testLimit'=>10,
            ),
        );
    }

    public function init()
    {
//        throw new CHttpException(404,'暂不支持网银充值');
        $this->pageTitle = Yii::t('memberRecharge', '_用户中心_') . Yii::app()->name;
    }
    
    
    /**
     * 积分充值
     */
    public function actionIndex()
    {
        throw new CHttpException(403,'第三方充值已关闭');

        // 检测借贷平衡
        $this->pageTitle = Yii::t('memberRecharge', '积分充值') . $this->pageTitle;
        $payConfig = Tool::getConfig('payapi');
        /** @var $model Recharge */
        //从充值记录跳转过来的
        if ($this->getParam('code')) {
            $model = Recharge::model()->findByAttributes(array('code' => $this->getParam('code')));
        } else {
            //本页的
            $model = new Recharge('insert');
            $this->performAjaxValidation($model);
            $model->code = Tool::buildOrderNo();
        }

        if (isset($_POST['Recharge'])) {
            $model->attributes = $this->getPost('Recharge');
            if($model->gai_number) {
                $recharge_member = Yii::app()->db->createCommand()->select('id')->from('{{member}}')->where('gai_number=:gai_number', array(':gai_number' => $model->gai_number))->queryRow();
                if (empty($recharge_member)) {
                    $this->setFlash('error', Yii::t('memberRecharge', '充值失败！用户GW号不存在！'));
                    $this->redirect(array('index'));
                    exit();
                }
                $model->member_id = $recharge_member['id'];
            }else
                $model->member_id = Yii::app()->user->id;

            $model->by_gai_number = Yii::app()->user->gw;
            if(!$model->save(false)){
                throw new CHttpException(403,'充值异常');
            }
        }

        if (!empty($model->money) && !empty($model->id)) {
            //快捷支付 
            if (isset($_POST['quickPay'])) {
                $model->pay_type = $this->getPost('quickPay');
            }
            
            //在线支付
            $msg = OnlinePay::checkInterface($model->pay_type);
            if ($msg) throw new CHttpException(503, $msg);

            //快捷支付
            if(isset($_POST['quickPay'])){
                //获取getTradeNo
                $param = array(
                    'orderType'=>OnlinePay::ORDER_TYPE_RECHARGE,
                    'code'=>$model->code,
                    'parentCode'=>$model->code,
                    'money'=>$model->money,
                    'goods_inf'=>$this->getUser()->gw,
                    'orderDate'=>date('Ymd'),
                    'backUrl'=>$this->createAbsoluteUrl('/member/recharge/payResult'),
                );
                $tradeNo = OnlinePay::getUmTradeNo($param);

                $this->redirect(array('/member/recharge/quickPayShow',
                    'pay_type'=>$model->pay_type,
                    'code'=>$model->code,
                    'money'=>$model->money,
                    'tradeNo'=>$tradeNo,
                    'quickPay'=>$_POST['Recharge']['pay_type'],
                    'parentCode'=>$model->code,
                    'auth'=>Tool::authcode($model->money.$model->code,'ENCODE',false,3600), //校验码，一个小时内有效
                ));
            }
             $creatTime=$model->create_time;
            //跳转到支付确认页面
            OnlinePay::redirectToPayShow('/member/recharge/payShow', $model->pay_type, $model->code, $model->money, $model->code,$creatTime);

        }
        $this->render('index', array('model' => $model, 'payConfig' => $payConfig));
    }

    /**
     * 快捷支付验证页面
     * @throws CHttpException
     */
    public function actionQuickPayShow(){
        $this->pageTitle = Yii::t('memberRecharge','快捷支付验证_') . $this->pageTitle;
        /** @var PayAgreement $model */
        $model = PayAgreement::model()->findByPk($this->getParam('quickPay'));
        if(!$model || $model->gw!=$this->getUser()->gw){
            throw new CHttpException(403,'快捷支付数据有误');
        }
        if(isset($_POST['verifyCode'])){
            $param = array(
                'gw'=>$this->getUser()->gw,
                'tradeNo'=>$this->getParam('tradeNo'),
                'verify_code'=>$this->getPost('verifyCode'),
                'busi_agreement_id'=>$model->busi_agreement_id,
                'pay_agreement_id'=>$model->pay_agreement_id,
            );
            $result = OnlinePay::checkUmVerifyCode($param);
            if($result===true){
                $this->redirect($this->createAbsoluteUrl('/member/recharge/payResult'));
            }else{
                $this->setFlash('error',Yii::t('memberRecharge','支付失败:').$result);
            }


        }
        $this->render('quickPayShow',array('model'=>$model));
    }

    /**
     * 确认支付平台
     */
    public function actionPayShow()
    {
        $this->pageTitle = Yii::t('memberRecharge','确认支付平台_') . $this->pageTitle;
        $this->render('payshow');
    }

    /**
     * 积分充值结果
     */
    public function actionPayResult(){
        $this->pageTitle = Yii::t('memberRecharge', '积分充值结果') . $this->pageTitle;
        $result = array();//支付结果
        if (isset($_POST['SystemSSN'])) {
            //银联
            $result = OnlinePay::unionPayCheck();
        } else if (isset($_GET['ipsbillno'])) {
            //环迅支付
            $result = OnlinePay::ipsPayCheck();
        } else if (isset($_POST['UPTRANSEQ'])) {
            //翼支付
            $result = OnlinePay::bestPayCheck();
        } else if (isset($_POST['encryStr'])) {
            //汇卡支付
            $result = OnlinePay::hiPayCheck();
        }else if (isset($_POST['mer_priv']) || isset($_GET['mer_priv'])) {
            //联动优势支付
            $result = OnlinePay::umPayCheck();
        } else if (isset($_POST['payResult']) && $_POST['payResult'] == 1) {
            //通联支付    
            $result = OnlinePay::tlzfPayCheck();
        } else if (isset($_GET['pay_result']) && $_GET['pay_result'] == 1) {
            //高汇通支付    
            $result = OnlinePay::ghtPayCheck();
        } else if (isset($_GET['returncode']) && $_GET['returncode'] == '00') {
            //EBC钱包支付  
            $result = OnlinePay::ebcPayCheck();
        }
        
        $this->render('payresult', array('result' => $result));
    }

    /**
     * 对账
     * @param $code
     * @param $SignMsg
     * @param int $payType 支付平台
     */
    public function actionCheck($code, $SignMsg, $payType)
    {
        $result = array();
        /** @var $model Recharge */
        $model = Recharge::model()->findByAttributes(array('code' => $code));
        if (!$model) {
            $result['errorMsg'] = Yii::t('memberRecharge', '您支付的订单不存在');
        }
        if ($model && $model->status != Recharge::STATUS_SUCCESS) {
            if(in_array($payType,array_keys(OnlinePay::getPayWayList()))){
                $result['errorMsg'] = Yii::t('recharge','您还未支付订单');
            }else{
                $result['errorMsg'] = Yii::t('memberRecharge', '未知的支付方式');
            }
        }
        if ($this->isAjax()) {
            echo json_encode($result);
        } else {
            $this->pageTitle = Yii::t('memberRecharge', '积分充值结果') . $this->pageTitle;
            $this->render('payresult', array('result' => $result));
        }
    }

    /**
     * 积分充值记录
     */
    public function actionList()
    {
        $this->pageTitle = Yii::t('memberRecharge', '积分充值记录') . $this->pageTitle;
        $model = new Recharge('search');
        $model->unsetAttributes();
        if (isset($_GET['Recharge'])) {
            $model->attributes = $this->getQuery('Recharge');
        }
        $this->render('list', array('model' => $model));
    }

    /**
     * 获取快捷支付验证码
     */
    public function actionGetQuickPayCode(){
        if($this->isAjax()){
            $param = array(
                'tradeNo'=>$this->getPost('tradeNo'),
                'gw'=>$this->getUser()->gw,
                'busi_agreement_id'=>$this->getPost('usr_busi_agreement_id'),
                'pay_agreement_id'=>$this->getPost('usr_pay_agreement_id'),
            );
            if(OnlinePay::getUmVerifyCode($param)){
                echo 'success';
            }
        }
    }

}

