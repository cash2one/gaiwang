<?php

/**
 * 工具接口
 * @author qinghao.ye <qinghaoye@sina.com>
 */
class ToolController extends Controller {

    /**
     * 获取验证码接口
     * 返回密文验证码
     */
    public function actionCreateCode() {
        $this->actionType = 'tool/createcode';
        $code = $this->createValifyCode();
        echo $this->exportXml('<Code>' . $code . '</Code>');
    }
    
    /**
     * 安卓客户端更新
     */
    public function actionUpdate() {
        $this->actionType = 'machine/update';
        $this->checkRequest();
        $system = $this->getPost('Token') ? 4 : 1;
        $apk = Yii::app()->db->createCommand()
                ->from('{{app}}')->where('system='.$system.' and is_published=1')
                ->order('version DESC')
                ->limit('1', '0')
                ->queryRow();
        if (empty($apk)) {
            $this->errorEndXml('已是最新版本');
        }
        $xml = '<Version>' . $apk['version'] . '</Version><Detail>' . $apk['mobile_log'] . '</Detail><NeedFlag>' . $apk['is_auto_download'] . '</NeedFlag><Url>' . $apk['url'] . '</Url>';
        echo $this->exportXml($xml);
    }

    /**
     * 苹果客户端更新
     */
    public function actionUpdateIOS() {
        $this->actionType = 'machine/update';
        $this->checkRequest();
        $apk = Yii::app()->db->createCommand()
                ->from('{{app}}')->where('system=2 and is_published=1')
                ->order('version DESC')
                ->limit('1', '0')
                ->queryRow();
        if (empty($apk)) {
            $this->errorEndXml('已是最新版本');
        }
        $xml = '<Version>' . $apk['version'] . '</Version><Detail>' . $apk['mobile_log'] . '</Detail><NeedFlag>' . $apk['is_auto_download'] . '</NeedFlag><Url>' . $apk['url'] . '</Url>';
        echo $this->exportXml($xml);
    }

    /**
     * 供广西app更新
     */
    public function actionOldAppUpdate() {
        $apk = Yii::app()->db->createCommand()
                ->from('{{app}}')->where('is_published=1')
                ->order('version DESC')
                ->limit('1', '0')
                ->queryRow();
        if (!empty($apk)) {
            $data = array(
                'Code' => 0,
                'Msg' => '',
                'CacheTimeOut' => 0,
                'Data' => array(
                    'ApkVersion' => $apk['version'],
                    'ApkSize' => $apk['size'],
                    'ApkCode' => 1,
                    'ApkName' => $apk['name'],
                    'ApkDownloadUrl' => $apk['url'],
                    'ApkLog' => $apk['mobile_log']
                )
            );
            echo json_encode($data);
        }
    }

    public function actionDecodeIOS() {
        $this->addLog('apiIos', "\r\n<hr><hr>1.POST", $_POST);
        $this->addLog('apiIos', "\r\n<hr>2.GET", $_GET);
        $code = $this->getPost('Code') ? $this->getPost('Code') : ($this->getQuery('Code') ? $this->getQuery('Code') : '');
        if ($code == false) {
            $this->errorEndXml('请提交测试密文');
        }
        $this->addLog('apiIos', "\r\n<hr>3.CODE", $code);
        $rsa = new RSA();
        $str = $rsa->decrypt($code);
        $this->addLog('apiIos', "\r\n<hr>4.DECODE", $str);
        echo $this->exportXml('<Code>' . $str . '</Code>');
    }

    public function actionLlog() {
        if ($this->getParam('n') == 'n') {
            $fileName = $this->getParam('f', 'application.log');
            $dirName = $this->getParam('d', 'api');
            if ($dirName != 'api' && $dirName != 'backend') {
                die('error.');
            }
            $root = Yii::getPathOfAlias('root');
            $path = $root . DS . $dirName . DS . 'runtime' . DS . $fileName;
            if (file_exists($path)) {
                $content = file_get_contents($path);
                $content = str_replace("\r\n", "<br/>", $content);
                $content = str_replace("\r", "<br/>", $content);
                $content = str_replace("\n", "<br/>", $content);
                $content = str_replace("<br/>2", "<hr><hr>2", $content);
                echo $path . '<hr>' . $content;
            } else {
                die($path . ' is not exists.');
            }
        }
    }

    public function actionDlog() {
        if ($this->getParam('n') == 'n') {
            $fileName = $this->getParam('f', 'application.log');
            $root = Yii::getPathOfAlias('root');
            $path = $root . DS . 'api' . DS . 'runtime' . DS . $fileName;
            @unlink($path);
            echo "success";
        }
    }

    /**
     * 苹果手机令牌版本
     */
    public function actionTokenVersionIOS() {
        $this->actionType = 'machine/update';
        $this->checkRequest();
        $apk = Yii::app()->db->createCommand()
                ->from('{{app}}')->where('system=3 and is_published=1')
                ->order('version DESC')
                ->limit('1', '0')
                ->queryRow();
        if (empty($apk)) {
            $this->errorEndXml('已是最新版本');
        }
        $xml = '<Version>' . $apk['version'] . '</Version><Detail>' . $apk['mobile_log'] . '</Detail><NeedFlag>' . $apk['is_auto_download'] . '</NeedFlag><Url>' . $apk['url'] . '</Url>';
        echo $this->exportXml($xml);
    }

    /**
     * 盖网通发送短信
     */
    public function actionSendContent() {
        $this->checkRequest();
        $this->addLog('apiLog',"\r\n\r\n1.post: ",$_POST);
        $rsa = new RSA();
        $this->checkVerifyCode($rsa->decrypt($this->checkParam('CheckCode')));    //验证码(已加密)
        $phone = $rsa->decrypt($this->checkParam('UserPhone'));
        $content = $this->checkParam('Content');
        $type = $this->getPost('Type');
        $this->addLog('apiLog', "\r\n\2.code: ", $content);
        $sendType = $this->getPost('sendType');
        $rs = false;
        if(!Api::validateMobile($phone))$this->errorEndXml('非手机号码');
        if($sendType == 1)
        {
           $code = $rsa->decrypt($this->checkParam('code'));
           if(empty($code))return false;
           Sms::voiceVerify($code, $phone);
           echo true;
        }else{
            $code = $rsa->decrypt($this->checkParam('code'));
            $datas = array($code);
            $smsConfig = $this->getConfig('smsmodel');
            $tmpId = $smsConfig['gaiVerifyContentId'];
            if($type){
                
                $rs = SmsLog::addSmsLog($phone, $content,0, $type,null,true, $datas, $tmpId);
            }  else {
                $rs = SmsLog::addSmsLog($phone, $content,0, SmsLog::TYPE_CAPTCHA,null,true, $datas, $tmpId);
            }
            echo $rs;
        }	
    }
    public function actionError() {
        $error = Yii::app()->errorHandler->error;
        if (!empty($error)) {
            if($error['message']){
                $this->errorEndXml($error['message']);
            }else{
                $this->errorEndXml('程序意外终止');
            }
        }
    }
    /**
     * 测试验证码
     */
    public function actionTestCode() {
        if($_POST['cc'] == 'cc'){
            $stat = $this->checkVerifyCode($_POST['code']);
            var_dump($stat);
        }
    }

    public function actionAjaxGetCode(){
        $code = $this->createValifyCode();
        if($code){
            $rsa = new RSA();
            echo $rsa->encrypt($code);
        }

    }
    public function actionAjaxGetPhoneCode(){
        $userPhone = $_POST['phone'];
        $code = $this->createPhoneValifyCode('app'.$userPhone);//验证码
        if($userPhone && $code){
            echo $code;
        }

    }
    public function actionAjaxGetMCode(){
        if($_POST['code'] != false){
            $ary = explode(',',$_POST['code']);
            $code = $this->createValifyCode();
            if($code){
                $rsa = new RSA();
                echo $rsa->encrypt($ary[0].','.$ary[1].','.$code);
            }
        }

    }
    public function actionAjaxEncode(){
        if($_POST['code'] != false){
            $rsa = new RSA();
            echo $rsa->encrypt($_POST['code']);
        }
    }
//    盖网通短信发送接口
    public function actionSendMessage(){
        $phone = $this->checkParam('UserPhone');
        $content = $this->checkParam('Content');
        $type = $this->checkParam('type');
        $orderId = $this->checkParam('orderId');
        $rong = isset($_POST['rong']) && $_POST['rong'] ? json_decode($_POST['rong']) : null;
        $tmpId = $this->getParam('tmpId',null);
//        Yii::log($phone.'post'.PHP_EOL.var_export($rong,true));
        $rs = SmsLog::addSmsLog($phone,$content, $orderId, $type,null,true,$rong,$tmpId);
//        echo $rs;
    }
}

?>