<?php

/**
 * 处理 优势联动SDK绑定银行卡 推送的消息
 * Class UmBindController
 * @author qinghaoye <qinghao.ye@g-emall.com>
 */
class UmBindController extends Controller {

    public function actionIndex() {
        $result = OnlineWapPay::umPayCheckSDKBind();
        //U首次支付签订协议处理（数据入库操作）
        if(isset($result['usr_pay_agreement_id'])){
            $result['saveFlag']=Process::umUserAgreeId($result);
        }
        
        if (!isset($result['errorMsg'])) {
            $response = $this->_getResponse($result);
            echo $response;
        } else {
            echo $result['errorMsg'];
        }
    }

    /**
     * 组装相应数据
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
            'mer_id'=>$result['mer_id'],
            'version'=>'4.0',
            'ret_msg'=>'',
            'ret_code'=>'0000',
        );
        $plain = RsaPay::plain($params);
        $sign = RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $params['sign'] = $sign;
        $params['sign_type'] = 'RSA';
        return str_replace('{data}',RsaPay::plain($params),$html);
    }

}
