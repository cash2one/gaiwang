<?php

/**
 * 短信接口
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class SmsController extends Controller {

    /**
     * 注册时发送新验证码到用户手机
     * 
     */
    public function actionSend(){
        $this->actionType = 'sendCheckCode';
        $this->addLog('apiLog',"\r\n\r\n1.post: ",$_POST);
        $this->checkRequest();
        $rsa = new RSA();
        $userPhone = $rsa->decrypt($this->checkParam('UserPhone'));    //用户手机号
//        $code = $this->createValifyCode($userPhone);//验证码
        $code = $this->createPhoneValifyCode('app'.$userPhone);//验证码
        if($code == false){
            $this->errorEndXml('获取验证码失败');
        }
        $smsConfig = $this->getConfig('smsmodel');
        $tmpId = $smsConfig['gaiVerifyContentId'];
        $content = $code . ' ('.Yii::t('appApi', '验证码').')';
        $datas = array($code);
        $this->addLog('apiLog',"\r\n2.code: ",$content);
        $smsRes = SmsLog::addSmsLog($userPhone, $content,  0, SmsLog::TYPE_CAPTCHA,null,true,$datas, $tmpId);
        $this->addLog('apiLog',"\r\n3.status: ",$smsRes);
        if($smsRes == false){
            $this->errorEndXml('发送失败');
        }
        echo $this->exportXml('');
    }
    
}