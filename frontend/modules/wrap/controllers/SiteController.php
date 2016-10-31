<?php
/**
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class SiteController extends Controller {

    public $totalTime = 60;//有效时间秒
    public $codeLen = 5;//验证码长度
    public function actionIndex() {
        $this->render('index');
    }

    public function actionRegister() {
        $this->render('register');
    }
    
    /**
     * WIFI热点连接跳转注册
     */
    public function actionCheck(){
        $this->title = Yii::t('wrapCheck','登陆验证');
        $error = $model = '';
        $data = $this->getParam('check');
        if (!empty($data)) {
            if($data['mobile'] != false){
                $pattern = "/(^\d{11}$)|(^852\d{8}$)/";
                if (preg_match($pattern, $data['mobile'])){
                    if($data['code'] != false && is_numeric($data['code']) && strlen($data['code'])>=$this->codeLen){
                        $verifyCodeCheck = $this->getSession($data['mobile']);
                        if ($verifyCodeCheck) {
                            $verifyArr = unserialize(Tool::authcode($verifyCodeCheck, 'DECODE'));
                            if ($verifyArr && $verifyArr['verifyCode'] == $data['code'] && (time() - $verifyArr['time'] < $this->totalTime)) {
                                $this->setSession($data['mobile']);//删除
                                $member = WrapModule::addMember($data['mobile']);//添加会员
                                if(!empty($member)){
                                    $smsContent = $this->getConfig('smsmodel','registerPhoneSucc');
                                    $tmpId = $this->getConfig('smsmodel','registerPhoneSuccId');
                                    if($smsContent){
                                        $smsContent = str_replace('{0}', $member['password'],$smsContent);
                                        SmsLog::addSmsLog($data['mobile'], $smsContent,$member->id,SmsLog::TYPE_OTHER,null,true,array($member['password']),$tmpId);
                                    }
                                    //注册成功
                                }
                                //验证成功
                                header("Content-type:text/html;charset=utf-8");
                                echo Yii::t('wrapCheck', '验证成功!');
                                Yii::app()->end();
                            }
                        }
                    }
                    $error = '请填写正确验证码!';
                }else{
                    $error = '请填写正确的手机号';
                }
            }else{
                $error = '请填写手机号!';
            }
        }
        $this->render('check', array('totalTime'=>$this->totalTime, 'data' => $data, 'error'=>$error));
    }
    /**
     * 获取验证码
     */
    public function actionGetCode(){
        if (Yii::app()->request->isAjaxRequest) {
            $mobile = $this->getParam('mobile');//手机号
            if ($mobile != false) {
                if (preg_match("/(^\d{11}$)|(^852\d{8}$)/", $mobile)) {
                    // 检查session
                    $verifyCodeCheck = $this->getSession($mobile);
                    if ($verifyCodeCheck) {
                        $verifyArr = unserialize(Tool::authcode($verifyCodeCheck, 'DECODE'));
                        if ($verifyArr && (time() - $verifyArr['time'] < $this->totalTime)) {
                            echo Yii::t('wrapCheck', '验证码正在发送，请等待{t}秒后重试',array('{t}'=>$this->totalTime));
                            Yii::app()->end();
                        }
                    }
                    $tmpId = $this->getConfig('smsmodel','phoneVerifyContentId');
                    // 验证码100-999
                    $verifyCode = mt_rand(str_pad(1, $this->codeLen, 0, STR_PAD_RIGHT), str_pad(9, $this->codeLen, 9, STR_PAD_RIGHT));
                    //验证码同时写cookie\session 防止丢失
                    $data = array('time' => time(), 'verifyCode' => $verifyCode);
                    $this->setCookie($mobile, Tool::authcode(serialize($data),'ENCODE','',$this->totalTime*5),$this->totalTime*5);
                    $this->setSession($mobile,Tool::authcode(serialize($data),'ENCODE','',$this->totalTime*5));
                    $content = Yii::t('wrapCheck','验证码').':'.$verifyCode;
                    echo $content.'|';
                    if(Yii::app()->request->cookies[$mobile]){
                        if (SmsLog::addSmsLog($mobile,$content,0,SmsLog::TYPE_CAPTCHA,null,true,array($verifyCode),$tmpId)) {
                            echo 'success';
                            Yii::app()->end();
                        }
                    }
                }
            }
        }
        echo Yii::t('wrapCheck',"发送失败,请重试");
        Yii::app()->end();
    }
}
