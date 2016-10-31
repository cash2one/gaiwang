<?php

/**
 *会员中心 （会员基本信息）
 * @author wyee <yanjie@gatewang.com>
 */
class MemberController extends WController {
  
    public $account;
   
    
    /**
     * 验证码参数配置
     */
    public function actions()
    {
        /**
         * model里添加此规则
         * array('verifyCode','captcha','allowEmpty'=>!CCaptcha::checkRequirements()),
         */
        return array(
                'captcha' => array(
                        'class' => 'CaptchaAction',
                        'height' => '30',
                        'width' => '70',
                        'minLength' => 4,
                        'maxLength' => 4,
                        'testLimit'=>999,
                ),
        );
    }
    
    /**
     * 用户中心
     */
    public function actionIndex()
    {
        $this->top=true;
        $this->showTitle =Yii::t('member', '用户中心');
        $this->account = Member::account($this->model);
        $this->render('index', array('model' => $this->model));
    }

    /**
     * 我的钱包
     */
    public function actionWallet(){
        $codeModel = new ExchangeCodeForm();
        $this->showTitle =Yii::t('member', '我的钱包');
        $this->account = Member::account($this->model);
        $this->render('wallet',array('codeModel' => $codeModel));
    }
    
    //使用兑换码为红包充值
    public function actionRechargeCodes() {
        if (isset($_POST['ExchangeCodeForm'])) {
            $member_id = $this->model->id;
            $data = $this->getParam('ExchangeCodeForm');
            $name = $data['name'];
            $exchangeInfo = ExchangeCode::model()->findByAttributes(array('name' => $name));
            if ($exchangeInfo) {
                $exchangeInfo->type = Activity::TYPE_RECHARGE;
                $status = $exchangeInfo['status'];
                if ($status == ExchangeCode::RECHARGE_NO) {
                    $transaction = Yii::app()->db->beginTransaction();
                    try {
                        $data = $exchangeInfo;
                        RedEnvelopeTool::createRedisActivity($member_id, Coupon::SOURCE_GAIWANG, Activity::TYPE_RECHARGE, Coupon::COMPENSATE_NO, $sms_content = NULL, $data);
                        $exchangeInfo->status = ExchangeCode::RECHARGE_YES;
                        $exchangeInfo->account = $this->model->gai_number;
                        $exchangeInfo->time = time();
                        $exchangeInfo->save(FALSE);
                        $transaction->commit();
                        $this->setFlash('msg', Yii::t('Activity', "兑换成功，谢谢您的支持！"));
                    } catch (Exception $e) {
                        $transaction->rollback();
                        $this->setFlash('msg', Yii::t('Activity', "红包充值失败！") . $e->getMessage());
                    }
                    $this->redirect(array('wallet'));
                } else {
                    $this->setFlash('msg', '兑换失败，请认真核对后再输入！');
                    $this->redirect(array('wallet'));
                }
            } else {
                $this->setFlash('msg', '兑换失败，请认真核对后再输入！');
                $this->redirect(array('wallet'));
            }
        }
    }

    /**
     * 红包充值
     * @author binbin.liao
     * @param $id 红包id
     */
    public function actionGetRed() {
        $msg = array(); //提示信息
        if ($this->isAjax()) {
            $id = $this->getPost('id'); //红包id
            if ($this->model->mobile) {
                //判断红包是否是未使用和未过期的
                $redData = RedEnvelope::checkRed($id, $this->memberId);
                if (!empty($redData)) {
                    $red = RedEnvelopeTool::getInstance();
                    $status = $red->rechargeRed($this->model, $redData);
                    $msg['tip'] = $status['tip'];
                    $msg['status'] = true;
                } else {
                    $msg['tip'] = '该红包已经充值过了';
                    $msg['status'] = false;
                }
            } else {
                $msg['tip'] = '请先完善您的资料';
                $msg['status'] = false;
            }
            exit(CJSON::encode($msg));
        }
    }

    
    /**
     * 我的银行卡
     */
    public function actionBankCard(){     
            $this->showTitle =Yii::t('member', '我的银行卡');
            $model=PayAgreement::getCardList($this->model->gai_number,  PayAgreement::PAY_TYPE_GHT);
            $this->render('bankCard',array('model'=>$model));
    }
    
    /**
     * 绑定银行卡
     */
    public function actionBindCard(){
        $result=OnlineWapPay::umPayCheckSDKBind();
        $InRet=array();
        $InRet=$result['data'];
        $InRet['gw']=$result['gw'];
        $InRet['pay_type']=$result['pay_type'];
        if ((!isset($result['errorNonMsg'])) && (!isset($result['errorMsg']))){ 
            //U签约绑定银行卡 签订协议处理（数据入库操作）
            if(isset($InRet['usr_pay_agreement_id']) && !empty($InRet['usr_pay_agreement_id'])){
                $result['saveFlag']=Process::umUserAgreeId($InRet);
                $this->setFlash('tips','银行卡绑定成功');
            }
         }else {
                $this->setFlash('tips','银行卡绑定失败');
        }
        if($result['maincode']!='1' && $result['maincode']!=''){
            $this->redirect(array('orderConfirm/pay','code'=>$result['maincode']));//跳转到确认订单页面
        }else{
            $this->redirect(array('bankCard'));
        }
    }
    
    
    /**
     * 银行卡解除绑定
     */    
    public function actionRemoveBank(){
       if($this->isAjax()){
            /** @var  PayAgreement $model */
            $model = PayAgreement::model()->findByPk($this->getPost('id'));
            $param = array(
                'gw'=>$this->getUser()->gw,
                'busi_agreement_id'=>$model->busi_agreement_id,
                'pay_agreement_id'=>$model->pay_agreement_id,
            );
            if($model->deleteAll("pay_agreement_id=:pay_agreement_id",array(":pay_agreement_id"=>$model->pay_agreement_id))){
                 OnlineWapPay::unbindUm($param);
                 $this->setFlash('msg','解绑成功');
            }else{
                $this->setFlash('msg','解绑失败');
            }

        }
    }
        
    /**
     * 我的红包领取记录列表
     */
    public function actionRed()
    {
        $this->showTitle =Yii::t('member', '红包领取记录');
        $criteria=new CDbCriteria;
        $criteria->select='money,id,member_id,`type`,create_time';
        $criteria->compare('member_id',$this->model->id);
        $criteria->compare('mode',Activity::ACTIVITY_MODE_RED);
        $CouponCount = Coupon::model()->count($criteria);
        $pager = new CPagination($CouponCount);
        $pager->pageSize = 10;
        $pager->applyLimit($criteria);
        $data = Coupon::model()->findAll($criteria);
        $this->render('red', array('model' => $data,'pages'=>$pager));
    }

    public function actionShare(){
        $this->layout = false;
        $this->showTitle = Yii::t('member', '分享领取红包');
        $this->render('shareRedBag');
    }
    
    /**
     * 高汇通 解绑卡 数据库数据删除
     */
    public function actionUnbind(){
      if($this->isAjax()){  
            $id = $this->getParam('id');
            $model = PayAgreement::model()->findByPk($this->getPost('id'));
            $info['sendReqMsgId'] = $this->getParam('reqMsgId');
            $info['validateCode'] = $this->getParam('code');
            $info['userId'] = Yii::app()->getUser()->gw;
            $info['bindId'] = $model->pay_agreement_id;
            $info['reqMsgId'] = substr(Tool::buildOrderNo(19), 0,16);
            $ghtPay = new GhtPay();
            $result=$ghtPay->getHttpData($info,'unbind');
            if($result['status']){
             if($model->updateByPk($id,array('status'=>PayAgreement::STATUS_FALSE))){
               exit(CJSON::encode(array('tips'=>'银行卡解绑成功')));
             }else{
               exit(CJSON::encode(array('tips'=>'银行卡解绑失败')));
             }
          }else{
            exit(CJSON::encode(array('tips'=>'银行卡解绑失败,请确认验证码是否正确')));
        }
       } 
    }  
    
    /**
     * 高汇通卡绑定动作 同时添加到数据库
     */
    public function actionBindGht(){
        $ghtModel=new GhtForm();
        $ghtPay = new GhtPay();
        $ghtModel->bankCardType=$this->getParam('cardType');
        if (isset($_POST['GhtForm'])){
            $postData=$this->getParam('GhtForm');
            $info=array();
            $info['reqMsgId']=Tool::buildOrderNo(19,'G');
            $info['bank_num']=$postData['bankCardNo'];
            $info['card_type']=$postData['bankCardType'];
            $info['mobile']=$postData['mobilePhone'];
            $info['gw']=$this->model->gai_number;
            $info['messageId']=$postData['validateCode'];
            $info['messageCode']=$postData['sendReqMsgId'];
            $info['accountName']=$postData['accountName'];
            $info['certificateType']=$postData['certificateType'];
            $info['certificateNo']=$postData['certificateNo'];
            $info['valid']=isset($postData['valid']) ? $postData['valid']:'';
            $info['cvn2']=isset($postData['cvn2']) ? $postData['cvn2']:'';
            $result=$ghtPay->getHttpData($info,'bind');
            if($result['status']){
                $res=$result['info'];
                $bank['pay_type']=PayAgreement::PAY_TYPE_GHT;
                $bank['status']=PayAgreement::STATUS_TRUE;
                $bank['gw']=$this->model->gai_number;
                $bank['bank']=$res->body->bankCode;
                $bank['card_type']=$postData['bankCardType']=='01' ? 'DEBITCARD':'CREDITCARD' ;
                $bank['mobile']=$postData['mobilePhone'];
                $bank['pay_agreement_id']=$res->body->bindId;
                $bank['bank_num']=substr($postData['bankCardNo'], -4,4);
                $bank['create_time']=time();
                $model=new PayAgreement;
                $payAgr=PayAgreement::model()->exists(array(
                        'condition'=>'pay_agreement_id=:pay_agreement_id AND pay_type=:pty',
                        'params'=>array(':pay_agreement_id'=>$res->body->bindId,':pty'=>PayAgreement::PAY_TYPE_GHT),
                ));
                if(empty($payAgr)){
                    $model->attributes=$bank;
                    $model->save();
                }else{
                   PayAgreement::model()->update(array('status'=>PayAgreement::STATUS_TRUE),'pay_agreement_id=:pay_agreement_id AND pay_type=:pty',array(':pay_agreement_id'=>$res->body->bindId,':pty'=>PayAgreement::PAY_TYPE_GHT));
                }
               $this->setFlash('tips','银行卡绑定成功');
            }else{
               $this->setFlash('tips','银行卡绑定失败');
            }
            $this->redirect(array('bankCard'));
        }
        $this->render('bindBCard',array('model'=>$ghtModel));
    }
    
    /**
     * 高汇通银行卡类别及银行选择
     */
    public function actionBindList(){
        $this->render('bindList');
    }
    /**
     * 检查 解绑卡 信息
     */
    public function actionCheck(){
        exit(CJSON::encode(array('false'=>true)));
    }
    
    
}
