<?php

/**
 * 快捷支付
 *
 * @author zhenjun.xu
 * Class QuickPayController
 *
 */
class QuickPayController extends MController {

    /**
     * 已开通快捷支付
     */
    public function actionList() {
        $this->pageTitle = '我的快捷支付_'.$this->pageTitle;
        $this->render('list');
    }

    /**
     * 签约绑定银行卡
     */
    public function actionBindCards(){
        $this->layout = 'bindCart';
        if(isset($_POST['usr_pay_agreement_id'])){
            $result = OnlinePay::umPayCheckSDKBind();
            if ((!isset($result['errorNonMsg'])) && (!isset($result['errorMsg']))) {
                $this->setFlash('success','绑定银行卡成功');
            } else {
                $this->setFlash('success','绑定银行卡失败：'.$result['errorMsg']);
            }
            $code = $this->getParam('code');
            $fopStr=strpos($code, 'H');
            if ($code != '' && $code != '1') {
                if ((!isset($result['errorNonMsg'])) && (!isset($result['errorMsg']))) {
                    if($fopStr===false){
                        $this->redirect(array('/order/pay', 'code' => $code));//跳转到商品确认订单页面
                    }else{
                        $this->redirect(array('/hotel/order/pay', 'code' => $code));//跳转到酒店确认订单页面
                    }
                } else {
                    echo $result['errorMsg'];
                }
            }else{
                $this->redirect(array('/member/quickPay/list'));
            }
        }
        $this->render('bindCards');
    }


    /**
     * 签约绑定银行卡
     */
    public function actionBindCard()
    {
        if(isset($_POST['usr_pay_agreement_id'])){
            $result = OnlinePay::umPayCheckSDKBind();
            if ((!isset($result['errorNonMsg'])) && (!isset($result['errorMsg']))) {
                $this->setFlash('success','绑定银行卡成功');
            } else {
                $this->setFlash('success','绑定银行卡失败：'.$result['errorMsg']);
            }
            $code = $this->getParam('code');
            $fopStr=strpos($code, 'H');
            if ($code != '' && $code != '1') {
                if ((!isset($result['errorNonMsg'])) && (!isset($result['errorMsg']))) {
                   if($fopStr===false){
                    $this->redirect(array('/order/pay', 'code' => $code));//跳转到商品确认订单页面
                   }else{
                    $this->redirect(array('/hotel/order/pay', 'code' => $code));//跳转到酒店确认订单页面
                   }
                } else {
                    echo $result['errorMsg'];
                }
            }else{
                $this->redirect(array('/member/quickPay/list'));
            }
        }
        $this->render('bindcard');
    }

    /**
     * 跳转到签约页面
     */  
    public function actionSigngo(){
      if($this->isAjax()){
        $param=array(
                'service'=>'bind_req_shortcut_front',
                'charset'=>'UTF-8',
                'mer_id'=>UM_MEMBER_ID,
                'ret_url'=>$this->createAbsoluteUrl('quickPay/bindCard',array('code'=>$_POST['code'])),
                'version'=>'4.0',
                'mer_cust_id'=>$this->model->gai_number,
                'pay_type'=>$_POST['payTypes'],
                'gate_id'=>$_POST['gateId'],
        );
        $plain=RsaPay::plain($param);
        $sign=RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
          echo $sign;
          exit;
       }
    }
    
    
    
    /**
     * 解绑
     */
    public function actionClose(){
        if($this->isAjax()){
            /** @var  PayAgreement $model */
            $model = PayAgreement::model()->findByPk($this->getPost('id'));
            $param = array(
                'gw'=>$this->getUser()->gw,
                'busi_agreement_id'=>$model->busi_agreement_id,
                'pay_agreement_id'=>$model->pay_agreement_id,
            );
            if($model->delete()){
                OnlinePay::unbindUm($param);
                $this->setFlash('success','解绑成功') ;
            }else{
                $this->setFlash('error','解绑失败') ;
            }
        }
    }
    
 /**
     * 联动优势 组装相应数据
     * @param $result
     * @return mixed
     */
    private function _getResponse($result){
        $html = <<<EOF
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <META NAME="MobilePayPlatform" CONTENT="{data}" />
</head>
EOF;
        $params = array(
                'mer_id'=>$result['data']['mer_id'],
                'version'=>'4.0',
                'ret_code'=>'0000',
        );
        $plain = RsaPay::plain($params);
        $sign = RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $params['sign'] = $sign;
        $params['sign_type'] = 'RSA';
        return str_replace('{data}',RsaPay::plain($params),$html);
    }
    
    /**
     * 高汇通绑卡 
     */
    public function actionBindGht(){
//        exit('暂时关闭关闭绑卡');
        $this->layout = 'bindCart';
        $this->pageTitle = '快捷支付方式_绑定银行卡';
        $post = Yii::app()->request->getPost('PayAgreement');
        $model = new PayAgreement();
        if($post){ //避免重复提交表单
            $payModel = PayAgreement::hasCard($post['bank_num']);
            if($payModel && $payModel instanceof PayAgreement) $model = $payModel;
            if(isset($post['card_type'])){
                $model->card_type = $post['card_type'];
            } else {
                $this->setFlash('error','请选择卡类型');
                $this->redirect('/member/quickPay/bindCards');
            }
            $scenario = $model->card_type == '01' ? 'bindCard' : 'bindcredit';
            $model->setScenario($scenario); //设置当前验证场景
            $model->attributes = $post;
            if($model->validate()){
               $model->attributes = $post;
               $model->reqMsgId = $model->pay_agreement_id = Tool::buildOrderNo(19,'G'); //流水号 由于唯一性索引限制
               $model->gw = Yii::app()->getUser()->gw;
               $model->create_time = time();
               $model->messageCode = $post['messageCode'];
               $model->messageId = $post['messageId'];
               $model->pay_type = PayAgreement::PAY_TYPE_GHT;
//                           var_dump($model->attributes); exit;
            $ghtPay=new GhtPay();
            $info = $model->attributes;
//            var_dump($info);
            $info['messageId'] = $model->messageId;
            $info['messageCode'] = $model->messageCode;
            $key=substr(Tool::buildOrderNo(19), 0,16);
            $xmlData=$ghtPay->set_data($info);
//            print_r($xmlData);exit;
            $encryptData=GhtPay::encrypt($xmlData,$key);
            $encryptKey=GhtPay::rsaEncrypt($key);
            $signData= GhtPay::create_sign($xmlData);
            $postData=array(
                    'encryptData'=>$encryptData,
                    'encryptKey'=>$encryptKey,
                    'merchantId'=> GHT_QUICK_PAY_MERCHANTID,
                    'signData'=>$signData,
                    'tranCode'=> $ghtPay->payType['bind'],
                    'callBack'=>'http://www.gnet-mall.net/reslog/log');
//              $model->pay_agreement_id=$key;
            if($model->save()){
                $result = $this->_sendHttp($postData);
            } else {
//                var_dump($model->getErrors());exit;
                $this->redirect('/member/quickPay/bindCards');
            }
            exit;
            }
//            var_dump($model->getErrors());exit;
        }
        
        //收集上个页面传过来的参数
        $card_type = Yii::app()->request->getPost('card_type');
        $bank = Yii::app()->request->getPost('bank');
        if(empty($card_type) || empty($bank)) $this->redirect('/quickPay/bindCards');
        $model->card_type = $card_type;
        $model->bank = $bank;
        $scenario = $card_type == '01' ? 'bindCard' : 'bindcredit';
        $model->setScenario($scenario); //设置当前验证场景
//        echo $model->getScenario();
        $this->render('bindGht',array('model'=>$model));
    }
    
    /**
     * 解绑银行卡
     */
    public function actionUnbind(){
        
    }
    
    public function actionPay(){
        $info = array(
            'reqMsgId' => Tool::buildOrderNo(19,'G'),
            'userId' =>  Yii::app()->getUser()->gw,
            'bindId' => 'I00010030801622588698800052395',
            'amount' => '4',
            'productName' => 'test product',
            'productDesc' => '中文秒速',
        );
        $ghtPay=new GhtPay();

        $key=substr(Tool::buildOrderNo(19), 0,16);
        $xmlData=$ghtPay->set_data($info,'pay');
        print_r($xmlData);
        $encryptData=GhtPay::encrypt($xmlData,$key);
        $encryptKey=GhtPay::rsaEncrypt($key);
        $signData= GhtPay::create_sign($xmlData);
        $postData=array(
                'encryptData'=>$encryptData,
                'encryptKey'=>$encryptKey,
                'merchantId'=> GHT_QUICK_PAY_MERCHANTID,
                'signData'=>$signData,
                'tranCode'=> $ghtPay->payType['pay'],
                'callBack'=>'http://www.gnet-mall.net/reslog/log');
        $this->_sendHttp($postData);
    }
            
    
    /**
     * 发送短信验证码
     */
    public function actionSendMsg(){
        $info = array();
//        $post = Yii::app()->request->getPost('payAgreement');
        $info['mobilePhone'] = '13751527605';
        $info['userId'] = Yii::app()->getUser()->gw;
        $info['reqMsgId'] = substr(Tool::buildOrderNo(19),0,16); //生成一个16位的流水号
        $ghtPay = new GhtPay;
        $xmlData = $ghtPay->set_data($info,'mobile');
//        print_r($xmlData);
        $key=substr(Tool::buildOrderNo(19), 0,16);
        $encryptData=GhtPay::encrypt($xmlData,$key);
        $encryptKey=GhtPay::rsaEncrypt($key);
        $signData= GhtPay::create_sign($xmlData);
            $postData=array(
                    'encryptData'=>$encryptData,
                    'encryptKey'=>$encryptKey,
                    'merchantId'=> GHT_QUICK_PAY_MERCHANTID,
                    'signData'=>$signData,
                    'tranCode'=> $ghtPay->payType['mobile'],
                    'callBack'=>'http://www.gnet-mall.net/reslog/log');
//              $model->pay_agreement_id=$key;
//            $model->save();
//        var_dump($postData);exit;
       // $result = $this->_sendHttp($postData);
//        var_dump($result);
        $result = true;
        exit(CJSON::encode(array('xml'=>$result,'reqMsgId'=>$info['reqMsgId'])));
    }
    /**
     * 统一发送http请求
     * @param array $postData 要发送的数据
     */
    private function _sendHttp($postData){
        $httpsUrl = new HttpClient('http', '8081');
        return $httpsUrl->quickPost(GHT_QUICK_PAY_URL, $postData);
    }

}
