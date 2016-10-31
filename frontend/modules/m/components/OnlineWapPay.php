<?php

/**
 *  微商城翼支付 挂件
 * OnlineWapPay 修改  common/components/OnlinePay.php
 * @author wyee <yanjie.wang@g-emall.com>
 */
class OnlineWapPay extends CWidget
{
    /**
     * @var string 订单编号
     */
    public $code;
    /**
     * @var float 订单金额
     */
    public $money;
    /**
     * @var string 支付结果接收URL
     */
    public $backUrl;
    /** @var  int 支付方法 */
    public $payType;
    /** @var int 订单时间 yyyyMMddhhmmss 翼支付 */
    public $orderDate;
    /** @var string 订单说明 */
    public $orderDesc = "订单支付";
    public $parentCode; //同时支付两个订单的时候生成的母订单号,对应环迅和银联的payer
    const PAY_BEST = 2; //翼支付
    const PAY_UM = 4; //联动优势 (U支付)
    const PAY_UM_QUICK  = 5;  //OR 联动优势(U一键支付)
    const PAY_TLZF  = 7;  //通联支付
    const PAY_WAP_INTEGRAL = 100; // 积分支付方式
    const PAY_WAP_UNION = 99; //银联支付
    const PAY_GHT_QUICK = 9; //高汇通快捷支付
    
    public $auth;

    /**
     * 订单类型
     */
    public $orderType;
    const ORDER_TYPE_RECHARGE = 0; //积分充值
    const ORDER_TYPE_GOODS = 1; //商品订单支付

    public function run()
    {
        if ($this->payType == self::PAY_WAP_UNION) {
            $this->render('unionpay', array(
                    'code' => $this->code,
                    'money' => $this->money,
                    'backUrl' => $this->backUrl,
                    'parentCode' => $this->parentCode,
                    'orderDate' => $this->orderDate,
                    'orderType' => $this->orderType,
            ));
        }
        
        if ($this->payType == self::PAY_BEST) {
            $this->render('bestpay', array(
                'code' => $this->code,
                'money' => $this->money,
                'backUrl' => $this->backUrl,
                'parentCode' => $this->parentCode,
                'orderDate' => $this->orderDate,
                'orderDesc' => $this->orderDesc,
                'orderType' => $this->orderType,
            ));
        }
        
        if ($this->payType == self::PAY_UM) {
            $this->render('umpay',array(
              'param'=>array(
                    'code' => $this->code,
                    'money' => $this->money,
                    'backUrl' => $this->backUrl,
                    'parentCode' => $this->parentCode,
                    'orderDate' => $this->orderDate,
                    'orderDesc' => $this->orderDesc,
                    'orderType' => $this->orderType,
            )));
        }      
        if ($this->payType == self::PAY_UM_QUICK ) {
            $this->render('umQuickPay', array(
               'param'=>array(
                    'code' => $this->code,
                    'money' => $this->money,
                    'backUrl' => $this->backUrl,
                    'parentCode' => $this->parentCode,
                    'orderDate' => $this->orderDate,
                    'orderDesc' => $this->orderDesc,
                    'orderType' => $this->orderType,
            ))); 
        }    
        if ($this->payType == self::PAY_TLZF ) {
            $this->render('tlzfpay', array(
               'param'=>array(
                    'code' => $this->code,
                    'money' => $this->money,
                    'backUrl' => $this->backUrl,
                    'parentCode' => $this->parentCode,
                    'orderDate' => $this->orderDate,
                    'orderType' => $this->orderType,
                    )));
        }
    }
    
    /**
     * 银联支付 结果检查
     * @return array
     */
    public static function unionPayCheck()
    {
        //接受银联在线返回数据
        $result = array();
        if(empty($_POST['signature'])){
            $result['errorMsg'] = '签名为空！';
        }else{
            $result=isset($_POST['respCode']) ? $_POST : $_GET;
            $res=RsaPay::unionVerify($result);
            if($res){
            $signMsg = $result['signature'];
            $orderNo = $result['parentCode'] = Yii::app()->request->getPost('orderId'); //商户订单号
            $payNo = $result['payNo'] = Yii::app()->request->getPost('queryId'); //支付单号
            $result['payTranNo'] = $payNo;
            $respCode = $result['respCode'] = Yii::app()->request->getPost('respCode'); //响应码
            $reserved = Yii::app()->request->getPost('reqReserved'); //保留域
            $attach = explode('XXX', $reserved);
            $result['orderType'] = $attach[0];
            $result['code'] = isset($attach[1]) ? $attach[1] : null;
            $result['ip'] = isset($attach[2]) ? $attach[2] : null;
            $result['gw'] = isset($attach[3]) ? $attach[3] : null;
            $result['money'] = sprintf('%0.2f', Yii::app()->request->getPost('txnAmt') / 100);
          if ($respCode != '00') {
            $result['errorMsg'] = '支付失败，银联支付返回的信息：' . self::unionError($respCode);
           }
        }else{
            $result['errorMsg'] = '验签失败！';
          }
        }
        return $result;
    
    }
    
    /**
     * 银联支付前台返回结果检查
     * @return array
     */
    public static function unionFrontPayCheck()
    {
        //接受银联在线返回数据
        $result = array();  
        if(empty($_POST['signature'])){
            $result['errorMsg'] = '签名为空！';
        }else{
            $result=isset($_POST['respCode']) ? $_POST : $_GET;
            $res=RsaPay::unionVerify($result);
            if($res){
                $signMsg = Yii::app()->request->getPost('signature');
                $respCode=Yii::app()->request->getPost('respCode');
                $orderNo = $result['parentCode'] = Yii::app()->request->getPost('orderId'); //商户订单号
                $payNo = $result['payNo'] = Yii::app()->request->getPost('queryId'); //支付单号
                $result['payTranNo'] = $payNo;
                $reserved = Yii::app()->request->getPost('reqReserved'); //保留域
                $attach = explode('XXX', $reserved);
                $result['orderType'] = $attach[0];
                $result['code'] = isset($attach[1]) ? $attach[1] : null;
                $result['ip'] = isset($attach[2]) ? $attach[2] : null;
                $result['gw'] = isset($attach[3]) ? $attach[3] : null;
                $result['money']=sprintf('%0.2f', Yii::app()->request->getPost('txnAmt') / 100);
                if ($respCode != '00') {
                    $result['errorMsg'] = '支付失败，银联支付返回的信息：' . self::unionError($respCode);
                }
            }else{
                $result['errorMsg'] = '验签失败！';
            }
        }
        return $result;
    
    }
    
    
    /**
     * 翼支付 结果检查
     * @return array
     */
    public static function bestPayCheck()
    {
        $result = array();
        $result['uptranseq'] = Yii::app()->request->getPost('UPTRANSEQ'); //网关平台交易流水号
        $result['payTranNo'] = $result['uptranseq'];
        $result['payDate'] = Yii::app()->request->getPost('TRANDATE'); //支付时间
        $result['returnCode'] = Yii::app()->request->getPost('RETNCODE'); //处理结果码
        $result['returnInfo'] = Yii::app()->request->getPost('RETNINFO'); //处理结果解释码
        $result['parentCode'] = Yii::app()->request->getPost('ORDERREQTRANSEQ');
        $result['code'] = Yii::app()->request->getPost('ORDERSEQ'); //订单号
        $result['money'] = Yii::app()->request->getPost('ORDERAMOUNT'); //订单金额
        $attach = explode('XXX', Yii::app()->request->getPost('ATTACH'));   
        $sign = Yii::app()->request->getPost('SIGN');
        $result['orderType'] = $attach[0];
        $result['gw'] = isset($attach[2]) ? $attach[2] : null;
        $mac = 'UPTRANSEQ=' . $result['uptranseq'] . '&MERCHANTID=' . BEST_MER_CODE . '&ORDERSEQ=' . $result['code'] .
            '&ORDERAMOUNT=' . $result['money'] . '&RETNCODE=' . $result['returnCode'] . '&RETNINFO=' . $result['returnInfo'] .
            '&TRANDATE=' . $result['payDate'] . '&KEY=' . BEST_KEY;
        if (strtolower($sign) != md5($mac)) {
            $result['errorMsg'] = '验签失败！';
        }
        if ($result['returnCode'] != '0000') {
            $result['errorMsg'] = '支付失败';
        }
        return $result;
    }
    
    /**
     * 联动优势（U支付）结果返回数据检测
     */  
   public static function umPayCheck(){
        /**
         * @var CHttpRequest $request
         */
        $request = Yii::app()->request;
        $signMsg = $request->getParam('sign');
        $result = array(); //订单数据
        $statusCode = $request->getParam('error_code');
        if($statusCode && $statusCode!='0000'){
            $result['errorMsg'] = '交易错误码：'.$statusCode;
        }else if($signMsg){
            $data = isset($_POST['order_id']) ? $_POST : $_GET;
            ksort($data);
            unset($data['sign']);
            unset($data['sign_type']);
            //明文
            $plain = RsaPay::plain($data);
            if(!RsaPay::verify($plain,$signMsg,Yii::getPathOfAlias('common') . '/rsaFile/um.cert.pem')){
                $result['errorMsg'] = '验签失败';
            }else{
                $result = $data;
                $attach = explode('XXX', $request->getParam('mer_priv'));
                $result['parentCode'] = $request->getParam('order_id');
                $result['payTranNo'] = $result['trade_no'];
                $result['orderType'] = $attach[0];
                $result['ip'] = isset($attach[2]) ? $attach[2] : null;
                $result['gw'] = isset($attach[3]) ? $attach[3] : null;
                $result['code'] = isset($attach[1]) ? $attach[1] : null;
                $result['money'] = sprintf('%0.2f', $request->getParam('amount') / 100);
            }
        }else{
            $result['errorMsg'] = '接收到的数据格式错误';
        }
        //U首次支付签订协议处理（数据入库操作）
        if(isset($result['usr_pay_agreement_id']) && !empty($result['usr_pay_agreement_id'])){
            $result['saveFlag']=Process::umUserAgreeId($result);
        }
        
        return $result;
    }

    /**
     * 通联支付 结果返回数据检测
     * 验签时注意数据组装的顺序
     */
    public static function tlzfPayCheck(){
        /**
         * @var CHttpRequest $request
         */
            $result = array(); //订单数据
            $data=array();
            $data = isset($_POST['orderNo']) ? $_POST : $_GET;
            $signArr = array('merchantId','version','language','signType','payType','issuerId','paymentOrderId','orderNo','orderDatetime','orderAmount','payDatetime','payAmount','ext1','ext2','payResult','errorCode','returnDatetime');
            $canEmptyParams = array('language','payType','issuerId','ext1','ext2','errorCode');
            $verify_result=RsaPay::verifyRequest($data, $signArr,$canEmptyParams);
            if(!$verify_result){
                throw new Exception('验签失败');
            }else{ 
               if($data['payResult']==1){
                $result = $data;
                $attach = explode('XXX', $_POST['ext1']);
                $result['parentCode'] = $_POST['orderNo'];
                $result['orderType'] = $attach[0];
                $result['code'] = isset($attach[1]) ? $attach[1] : null;
                $result['gw'] = isset($attach[2]) ? $attach[2] : null;
                $result['money'] = sprintf('%0.2f', $data['orderAmount']/100);
                 }else{
                     $result['errorMsg'] = '支付失败';
                 }
            }
        return $result;
    }
    
    
    /**
     * 联动优势（U支付 签约绑定银行卡结果返回数据检测
     */
    public static function umPayCheckSDKBind()
    {
        /**
         * @var CHttpRequest $request
         */
        $result = array(); //返回的经过处理的数据
        $request = Yii::app()->request;
        $signMsg = $request->getParam('sign');
        $statusCode = $request->getParam('error_code');
        if(!empty($signMsg)){
           if ($statusCode && $statusCode != '0000') {
                $result['errorMsg'] = '交易错误码：' . $statusCode;
           }else{ 
                $data = !empty($_POST) ? $_POST : $_GET;
                $result['maincode'] = $data['code'];
                unset($data['sign']);
                unset($data['sign_type']);
                unset($data['code']);
                $plain = RsaPay::plain($data);
                $plain=iconv("UTF-8", "GBK", $plain);
                if(!RsaPay::verify($plain,$signMsg,Yii::getPathOfAlias('common') . '/rsaFile/um.cert.pem')){
                  $result['errorMsg'] = '验签失败';
             }else {
                $result['data'] = $data;
                $result['gw'] = $data['mer_cust_id'];
                $result['pay_type'] = $data['bank_card_type'];
            }
         } 
        }else{
            $result['errorNonMsg']='没有接收到返回结果';
        }
        return $result;
    }

    /**
     * 联动优势（U支付）商户API下单 取得返回信息 trade_no
     * @param array $param
     * @var string $param['code'] 订单编号
     * @var float  $param['money'] 订单金额
     * @var string $param['backUrl'] 支付结果接收URL
     * @var string $param['parentCode'] 母订单串,交易流水
     * @var int    $param['orderDate'] 订单日期  联动优势YYYYMMDD
     * @var string $param['orderType'] 订单类型
     * @return array
     */
    public static function getTradeNo($param){
        $attach = implode('XXX',array($param['orderType'],$param['code'],Tool::ip2int(Yii::app()->request->userHostAddress),Yii::app()->user->gw));
        $serverUrl = Tool::getConfig('payapi','ip').'umWappay';
        $map=array(
                'service' =>$param['service'],
                'charset' =>'UTF-8',
                'mer_id' => UM_MEMBER_ID,
                'ret_url' => $param['backUrl'],
                'notify_url' => $serverUrl,
                'res_format' =>'HTML',
                'version' => '4.0',
                'order_id' => $param['parentCode'],
                'mer_date' => $param['orderDate'],
                'amount' => $param['money']*100,
                'amt_type' => 'RMB',
                'mer_priv' =>$attach,
                'expire_time' => ''
        );
       $resArr=self::toUm($map);
        return $resArr;   
    }
    
    /**
     * 联动优势（U支付）协议支付取得手机验证码
     * @param array $param
     * @return vericode
     */
    public static function getVericode($param){
         $map=array(
                'service' =>'req_smsverify_shortcut',
                'mer_id' => UM_MEMBER_ID,
                'version' =>'4.0', 
                'trade_no' => $param['tradeNo'],
                'mer_cust_id' => $param['paygw'],
                'usr_busi_agreement_id' =>$param['payBusi'],
                'usr_pay_agreement_id' => $param['payAgr'],
          );
        $resArr=self::toUm($map);
        return $resArr;
    }
    
    /**
     * 联动优势（U支付）协议支付确认支付
     * @param array $param
     * @return vericode
     */
    public static function bankConfirm($param){
        $map=array(
                'service' =>'agreement_pay_confirm_shortcut',
                'mer_id' => UM_MEMBER_ID,
                'charset'=>'UTF-8',
                'res_format'=>'HTML',
                'version' =>'4.0',
                'trade_no' => $param['tradeNo'],
                'verify_code'=>$param['vericode'],
                'mer_cust_id' => $param['paygw'],
                'usr_busi_agreement_id' =>$param['payBusi'],
                'usr_pay_agreement_id' => $param['payAgr'],
        );
        $resArr=self::toUm($map);
        return $resArr;
    }
    
   /**
     * 联动优势（U支付）解绑快捷支付
     * @param array $param
     * @return bool
     */
    public static function unbindUm($param){
        $map=array(
            'service' =>'unbind_mercust_protocol_shortcut',
            'mer_id' => UM_MEMBER_ID,
            'version' =>'4.0',
            'charset' =>'UTF-8',
            'mer_cust_id' => $param['gw'],
            'usr_busi_agreement_id' => $param['busi_agreement_id'],
            'usr_pay_agreement_id' => $param['pay_agreement_id'],
        );
        $resArr=self::toUm($map);
        if(isset($resArr['ret_code']) && $resArr['ret_code']=='0000') return true;
        return false;
    }
    
    /**
     * 联动优势（U支付）签约绑定快捷支付
     * @param array $param
     * @return bool
     */
    public static function bindUm($param){
        $map=array(
                'merId' => UM_MEMBER_ID,
                'merCustId' =>$param['gw'],
        );
        $plain='merId='.UM_MEMBER_ID.'&merCustId='.$map['merCustId'];
        $sign=RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $map['retUrl'] =$param['retUrl'];
        $map['signType'] ='RSA';
        $map['sign'] =$sign;
        $url=UM_BINDCARD_URL.'?'.http_build_query($map);
        return  $url;
    }
    
    /**
     * 联动优势对数据进行加密并且请求Api接口取得返回结果
     * @param array $map
     */
    public static function toUm($map){
        $plain=RsaPay::plain($map);
        $sign=RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $map['sign'] = $sign;
        $map['sign_type'] = 'RSA';
        $resArr=array();
        $html=get_meta_tags(UM_PAY_URL.'?'.http_build_query($map));
        $html=$html['mobilepayplatform'];
         parse_str($html,$resArr);
        return $resArr;
    }
   
    /**
     * 支付接口检查
     * @param int $payType
     * @return  string
     */
    public static function checkInterface($payType)
    {
        //检查支付接口
        $payConfig = Tool::getConfig('payapi', '');
        $msg = '';
        if (!is_numeric($payType)) $msg = Yii::t('orderFlow', '支付接口参数错误');
        switch ($payType) {
            case self::PAY_WAP_UNION:
                if ($payConfig['gneteEnable'] === 'false') {
                    $msg = Yii::t('orderFlow', '银联支付接口已经关闭,请用其它支付方式支付');
                }
                break;
            case self::PAY_BEST:
                if ($payConfig['bestEnable'] === 'false') {
                    $msg = Yii::t('orderFlow', '翼支付接口已经关闭,请用其它支付方式支付');
                }
                break;
           case self::PAY_UM:
                    if ($payConfig['umEnable'] === 'false') {
                        $msg = Yii::t('orderFlow', 'U支付接口已经关闭,请用其它支付方式支付');
                    }
                    break;
           case self::PAY_UM_QUICK :
                        if ($payConfig['umQuickEnable'] === 'false') {
                            $msg = Yii::t('orderFlow', 'U一键支付接口已经关闭,请用其它支付方式支付');
                        }
                        break;
           case self::PAY_TLZF :
                            if ($payConfig['tlzfEnable'] === 'false') {
                                $msg = Yii::t('orderFlow', 'U一键支付接口已经关闭,请用其它支付方式支付');
                            }
                            break;
            case self::PAY_GHT_QUICK:
                if($payConfig['ghtQuickEnable'] === 'false'){
                    $msg = Yii::t('orderFlow', '高汇通快捷支付接口已经关闭,请用其它支付方式支付');
                }
                break;
            default:
                $msg = Yii::t('orderFlow', '未知的支付接口参数' . $payType);
                break;
        }
        return $msg;
    }

    /**
     * 跳转到支付确认页面
     * @param string $action 控制器 orderFlow/payShow
     * @param int $payType 支付接口
     * @param string $mainCode 订单编号
     * @param float $money 支付金额
     * @param string $parentCode 订单流水编号
     */
    public static function redirectToPayShow($action,$payType,$mainCode,$money,$parentCode){
        $auth = Tool::authcode($money.$parentCode,'ENCODE',false,3600); //校验码，一个小时内有效
        $controller = Yii::app()->controller;
        if ($payType == OnlineWapPay::PAY_WAP_UNION) {
            //银联支付
            $controller->redirect(array(
                    $action,
                    'code' => $mainCode,
                    'money' => $money,
                    'payType' => OnlineWapPay::PAY_WAP_UNION,
                    'orderDate' => substr($parentCode, 1,14),//支付对账时有用
                    'auth'=>$auth,
                    'parentCode' => $parentCode));
        }
        if ($payType == OnlineWapPay::PAY_BEST) {
            //翼支付
            $controller->redirect(array(
                $action,
                'code' => $mainCode,
                'money' => $money,
                'payType' => OnlineWapPay::PAY_BEST,
                'orderDate' => date('YmdHis'),
                'auth'=>$auth,
                'parentCode' => $parentCode));
        }  
       if ($payType == OnlineWapPay::PAY_UM) {
            //U支付
            $controller->redirect(array(
                    $action,
                    'code' => $mainCode,
                    'money' => $money,
                    'payType' => OnlineWapPay::PAY_UM,
                    'orderDate' => date('Ymd'),
                    'auth'=>$auth,
                    'parentCode' => $parentCode));
        }
      if ($payType == OnlineWapPay::PAY_UM_QUICK ) {
            //U一键支付
            $controller->redirect(array(
                    $action,
                    'code' => $mainCode,
                    'money' => $money,
                    'payType' => OnlineWapPay::PAY_UM_QUICK ,
                    'orderDate' => date('Ymd'),
                    'auth'=>$auth,
                    'parentCode' => $parentCode));
        }
     if ($payType == OnlineWapPay::PAY_TLZF ) {
            //通联支付
            $controller->redirect(array(
                    $action,
                    'code' => $mainCode,
                    'money' => $money,
                    'payType' => OnlineWapPay::PAY_TLZF ,
                    'orderDate' => substr($parentCode, 1,14),
                    'auth'=>$auth,
                    'parentCode' => $parentCode));
        }
    }
    
    /**
     * 银联 网关响应码
     * @param null $key
     * @return null
     */
    public static function unionError($key = null)
    {
        $arr = array(
                '00' => '交易成功',
                '01' => '交易失败。详情请咨询95516',
                '02' => '系统未开放或暂时关闭，请稍后再试',
                '03' => '交易通讯超时，请发起查询交易',
                '04' => '交易状态未明，请查询对账结果',
                '05' => '交易已受理，请稍后查询交易结果',
                '10' => '报文格式错误',
                '11' => '验证签名失败',
                '12' => '重复交易',
                '13' => '报文交易要素缺失',
                '14' => '批量文件格式错误',
                '30' => '交易未通过，请尝试使用其他银联卡支付或联系95516',
                '31' => '商户状态不正确',
                '32' => '无此交易权限',
                '33' => '交易金额超限',
                '34' => '查无此交易',
                '35' => '原交易不存在或状态不正确',
                '36' => '与原交易信息不符',
                '37' => '已超过最大查询次数或操作过于频繁',
                '38' => '银联风险受限',
                '39' => '交易不在受理时间范围内',
                '40' => '绑定关系检查失败',
                '41' => '批量状态不正确，无法下载',
                '42' => '扣款成功但交易超过规定支付时间',
                '60' => '交易失败，详情请咨询您的发卡行',
                '61' => '输入的卡号无效，请确认后输入',
                '62' => '交易失败，发卡银行不支持该商户，请更换其他银行卡',
                '63' => '卡状态不正确',
                '64' => '卡上的余额不足',
                '65' => '输入的密码、有效期或CVN2有误，交易失败',
                '66' => '持卡人身份信息或手机号输入不正确，验证失败',
                '67' => '密码输入次数超限',
                '68' => '您的银行卡暂不支持该业务，请向您的银行或95516咨询',
                '69' => '您的输入超时，交易失败',
                '70' => '交易已跳转，等待持卡人输入',
                '71' => '动态口令或短信验证码校验失败',
                '72' => '您尚未在银行网点柜面或个人网银签约加办银联无卡支付业务，请去柜面或网银开通或拨打95516咨询',
                '73' => '支付卡已超过有效期',
                '74' => '扣款成功，销账未知',
                '75' => '扣款成功，销账失败',
                '76' => '需要验密开通',
                '77' => '银行卡未开通认证支付',
                '78' => '发卡行交易权限受限，详情请咨询您的发卡行',
                '79' => '此卡可用，但发卡行暂不支持短信验证',
                '80' => '交易失败，Token 已过期',
                '98' => '文件不存在',
                '99' => '通用错误',
                'A6' => '有缺陷的成功',
               
        );
        return isset($arr[$key]) ? $arr[$key] : '未知错误';
    }
} 