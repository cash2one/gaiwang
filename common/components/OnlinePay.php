<?php

/**
 *  在线支付 小物件
 *
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 14-3-8
 * Time: 下午1:52
 */
class OnlinePay extends CWidget
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
    public $auth;//金额校验字段

    const PAY_IPS = 0; //环迅支付
    const PAY_UNION = 1; //银联支付
    const PAY_BEST = 2; //翼支付
    const PAY_HI = 3; //汇卡支付
    const PAY_UM = 4; //联动优势
    const PAY_UM_QUICK = 5; //联动优势:快捷支付
    const PAY_TLZF  = 7;  //通联支付
    const PAY_TLZFKJ  = 12;  //通联支付
    const PAY_GHT  = 8;  //高汇通支付
    const PAY_GHTKJ  = 11; //高汇通积分限制支付
    const PAY_GHT_QUICK  = 9;  //高汇通快捷支付
    const PAY_EBC  = 10;  //ebc钱包支付
    const PAY_WAP_INTEGRAL = 100; // 积分支付方式
    const PAY_WAP_WEIXIN = 101; // 微信支付方式
    /**
     * 订单类型
     */
    public $orderType;
    const ORDER_TYPE_RECHARGE = 0; //积分充值
    const ORDER_TYPE_GOODS = 1; //商品订单支付
    const ORDER_TYPE_HOTEL = 2; //酒店订单

    public function run()
    {
        if ($this->payType == self::PAY_UNION) {
            $this->render('unionpay', array(
                'code' => $this->code,
                'money' => $this->money,
                'backUrl' => $this->backUrl,
                'parentCode' => $this->parentCode,
                'orderType' => $this->orderType,
            ));
        }
        if ($this->payType == self::PAY_IPS) {
            $this->render('ipspay', array(
                'code' => $this->code,
                'money' => $this->money,
                'backUrl' => $this->backUrl,
                'parentCode' => $this->parentCode,
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
        if ($this->payType == self::PAY_HI) {
            $this->render('hipay', array(
                'code' => $this->code,
                'money' => $this->money,
                'backUrl' => $this->backUrl,
                'parentCode' => $this->parentCode,
                'orderType' => $this->orderType,
            ));
        }
        if ($this->payType == self::PAY_UM) {
            $this->render('umpay', array(
                'code' => $this->code,
                'money' => $this->money,
                'backUrl' => $this->backUrl,
                'parentCode' => $this->parentCode,
                'orderDate' => $this->orderDate,
                'orderType' => $this->orderType,
            ));
        }
        if ($this->payType == self::PAY_UM_QUICK) {
            $this->render('umQuickPay', array(
                'code' => $this->code,
                'money' => $this->money,
                'backUrl' => $this->backUrl,
                'parentCode' => $this->parentCode,
                'orderDate' => $this->orderDate,
                'orderType' => $this->orderType,
            ));
        }
        
        if ($this->payType == self::PAY_TLZF || $this->payType == self::PAY_TLZFKJ) {
            $this->render('tlzfpay', array(
                    'code' => $this->code,
                    'money' => $this->money,
                    'backUrl' => $this->backUrl,
                    'parentCode' => $this->parentCode,
                    'orderDate' => $this->orderDate,
                    'orderType' => $this->orderType,
                    'zfType' =>$this->payType,
            ));
        }     
        if ($this->payType == self::PAY_GHT || $this->payType == self::PAY_GHTKJ) {
            $this->render('ghtpay', array(
                    'code' => $this->code,
                    'money' => $this->money,
                    'backUrl' => $this->backUrl,
                    'parentCode' => $this->parentCode,
                    'orderDate' => $this->orderDate,
                    'orderType' => $this->orderType,
                    'zfType' =>$this->payType,
            ));
        }
        
        if ($this->payType == self::PAY_EBC) {
            $this->render('ebcpay', array(
                    'code' => $this->code,
                    'money' => $this->money,
                    'backUrl' => $this->backUrl,
                    'parentCode' => $this->parentCode,
                    'orderDate' => $this->orderDate,
                    'orderType' => $this->orderType,
            ));
        }
    }

    /**
     * 获取支付方式列表
     * @return array
     * @author jianlin.lin
     */
    public static function getPayWayList($k=null)
    {
        $array = array(
            OnlinePay::PAY_WAP_INTEGRAL => Yii::t('onlinePay', '积分支付'),
            OnlinePay::PAY_IPS => Yii::t('onlinePay', '环迅支付'),
            OnlinePay::PAY_UNION => Yii::t('onlinePay', '银联支付'),
            OnlinePay::PAY_BEST => Yii::t('onlinePay', '翼支付'),
            OnlinePay::PAY_HI => Yii::t('onlinePay', '汇卡支付'),
            OnlinePay::PAY_UM => Yii::t('onlinePay', '联动优势'),
            OnlinePay::PAY_UM_QUICK => Yii::t('onlinePay', '联动优势(快捷支付)'),
            OnlinePay::PAY_TLZF => Yii::t('onlinePay', '通联支付'),
            OnlinePay::PAY_TLZFKJ => Yii::t('onlinePay', '通联支付KJ'),
            OnlinePay::PAY_GHT => Yii::t('onlinePay', '高汇通支付'),
            OnlinePay::PAY_GHTKJ => Yii::t('onlinePay', '高汇通支付'),
            OnlinePay::PAY_GHT_QUICK => Yii::t('onlinePay', '高汇通快捷支付'),
            OnlinePay::PAY_EBC => Yii::t('onlinePay', 'EBC钱包支付'),
        	OnlinePay::PAY_WAP_WEIXIN => Yii::t('onlinePay', '微信支付'),
        );
        if(is_numeric($k)){
            return isset($array[$k]) ? $array[$k] : null;
        }else{
            return $array;
        }
    }

    /**
     * 获取支付方式描述
     * @param $key
     * @return string
     * @author jianlin.lin
     */
    public static function getPayWay($key)
    {
        $array = self::getPayWayList();
        return isset($array[$key]) ? $array[$key] : Yii::t('orderPayForm', '未知');
    }

    /**
     * 银联支付 结果检查
     * @return array
     */
    public static function unionPayCheck()
    {
        //接受银联在线返回数据
        $result = array();
        if (isset($_POST['EncodeMsg'])) {
            $SignMsg = $_POST['SignMsg'];
            parse_str($_POST['EncodeMsg'], $arr);
            $_POST = $arr;
            $_POST['SignMsg'] = $SignMsg;
        }
        $orderNo = $result['parentCode'] = Yii::app()->request->getPost('OrderNo'); //商户订单号
        $payNo = $result['payNo'] = Yii::app()->request->getPost('PayNo'); //支付单号
        $result['payTranNo'] = $payNo;
        $payAmount = $result['money'] = Yii::app()->request->getPost('PayAmount'); //支付金额，格式：元.角分
        $currCode = $result['currCode'] = Yii::app()->request->getPost('CurrCode'); //货币代码
        $systemSSN = $result['systemSSN'] = Yii::app()->request->getPost('SystemSSN'); //系统参考号
        $respCode = $result['respCode'] = Yii::app()->request->getPost('RespCode'); //响应码
        $settDate = $result['settDate'] = Yii::app()->request->getPost('SettDate'); //清算日期，格式：月月日日
        $reserved01 = Yii::app()->request->getPost('Reserved01'); //保留域1
        $reserved02 = Yii::app()->request->getPost('Reserved02'); //保留域2
        $signMsg = $result['signMsg'] = Yii::app()->request->getPost('SignMsg'); //时间戳签名
        $attach = explode('XXX', $reserved01);
        $result['orderType'] = $attach[0];
        $result['code'] = isset($attach[1]) ? $attach[1] : null;
        $result['ip'] = isset($attach[2]) ? $attach[2] : null;
        $result['gw'] = isset($attach[3]) ? $attach[3] : null;
        $sourceMsg = $orderNo . $payNo . $payAmount . $currCode . $systemSSN . $respCode . $settDate . $reserved01 . $reserved02;
        //校验签名是否一致
        $locSignMsg = md5($sourceMsg . md5(UNION_MER_KEY));
        if ($locSignMsg != $signMsg) {
            $result['errorMsg'] = '验签失败！';
        }
        if ($respCode != '00') {
            $result['errorMsg'] = '支付失败，银联支付返回的信息：' . self::unionError($respCode);
        }
        return $result;

    }


    /**
     * 环迅支付结果检查
     * @return array
     */
    public static function ipsPayCheck()
    {
        $result = array();
        $errorCode = Yii::app()->request->getParam('errCode');
        if ($errorCode) {
            $result['errorMsg'] = OnlinePay::ipsError($errorCode);
        }
        $attach = explode('XXX', Yii::app()->request->getParam('attach'));
        $result['parentCode'] = Yii::app()->request->getParam('billno');
        $result['money'] = Yii::app()->request->getParam('amount');
        $result['mydate'] = Yii::app()->request->getParam('date');
        $result['succ'] = Yii::app()->request->getParam('succ');
        $result['msg'] = Yii::app()->request->getParam('msg');
        $result['ipsbillno'] = Yii::app()->request->getParam('ipsbillno');
        $result['payTranNo'] = $result['ipsbillno'];
        $result['retEncodeType'] = Yii::app()->request->getParam('retencodetype');
        $result['currency_type'] = Yii::app()->request->getParam('Currency_type');
        $signature = $result['signature'] = Yii::app()->request->getParam('signature');
        $result['orderType'] = $attach[0];
        $result['code'] = isset($attach[1]) ? $attach[1] : null;
        $result['ip'] = isset($attach[2]) ? $attach[2] : null;
        $result['gw'] = isset($attach[3]) ? $attach[3] : null;
        //返回参数的次序为：
        //billno + mercode + amount + date + succ + msg + ipsbillno + Currecny_type + retencodetype + attach + signature + bankbillno
        //注2：当RetEncodeType=17时，摘要内容已全转成小写字符，请在验证的时将您生成的Md5摘要先转成小写后再做比较
        $content = 'billno' . $result['parentCode'] . 'currencytype' . $result['currency_type'] . 'amount' . $result['money'] .
            'date' . $result['mydate'] . 'succ' . $result['succ'] . 'ipsbillno' . $result['ipsbillno'] .
            'retencodetype' . $result['retEncodeType'];
        $signature_2 = md5($content . IPS_MER_KEY);
        if ($signature_2 != $signature) {
            $result['errorMsg'] = '验签失败！';
        }
        if ($result['succ'] != 'Y') {
            $result['errorMsg'] = '支付失败';
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
        $result['code'] = Yii::app()->request->getPost('ORDERSEQ'); //订单号
        $result['money'] = Yii::app()->request->getPost('ORDERAMOUNT'); //订单金额
        $result['returnCode'] = Yii::app()->request->getPost('RETNCODE'); //处理结果码
        $result['returnInfo'] = Yii::app()->request->getPost('RETNINFO'); //处理结果解释码
        $result['payDate'] = Yii::app()->request->getPost('TRANDATE'); //支付时间
        $attach = explode('XXX', Yii::app()->request->getPost('ATTACH'));
        $result['parentCode'] = Yii::app()->request->getPost('ORDERREQTRANSEQ');
        $sign = Yii::app()->request->getPost('SIGN');
        $result['orderType'] = $attach[0];
        $result['ip'] = isset($attach[2]) ? $attach[2] : null;
        $result['gw'] = isset($attach[3]) ? $attach[3] : null;
        $mac = 'UPTRANSEQ=' . $result['uptranseq'] . '&MERCHANTID=' . BEST_MER_CODE . '&ORDERID=' . $result['code'] .
            '&PAYMENT=' . $result['money'] . '&RETNCODE=' . $result['returnCode'] . '&RETNINFO=' . $result['returnInfo'] .
            '&PAYDATE=' . $result['payDate'] . '&KEY=' . BEST_KEY;
        if (strtolower($sign) != md5($mac)) {
            $result['errorMsg'] = '验签失败！';
        }
        if ($result['returnCode'] != '0000') {
            $result['errorMsg'] = '支付失败';
        }
        $result['money'] = $result['money'] ? sprintf('%0.2f', $result['money'] / 100) : '';
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
                $result['zfType'] = isset($attach[3]) ? $attach[3] : null;
                $result['money'] = sprintf('%0.2f', $data['orderAmount']/100);
            }else{
                $result['errorMsg'] = '支付失败';
            }
        }
        return $result;
    }


    /**
     * 联动优势支付结果检查
     * @return array
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
            $plain = '';
            foreach($data as $k=>$v){
                $plain .= $k.'='.$v.'&';
            }
            $plain = substr($plain,0,-1);
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
        //联动优势首次支付绑定协议号入库操作处理
        if(isset($result['usr_pay_agreement_id']) && !empty($result['usr_pay_agreement_id'])){
            Yii::app()->user->isGuest && Process::umUserAgreeId($result); //前台无法调用此类,只有对账接口可用
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
     * @return int
     */
    public static function getUmTradeNo($param){

        $attach = implode('XXX',array($param['orderType'],$param['code'],Tool::ip2int(Yii::app()->request->userHostAddress),Yii::app()->user->gw));
        $map=array(
            'service' =>'pay_req_shortcut',
            'charset' =>'UTF-8',
            'mer_id' => UM_MEMBER_ID,
            'ret_url' => $param['backUrl'],
            'notify_url' => Tool::getConfig('payApi','ip').'umpay',
            'res_format' =>'HTML',
            'version' => '4.0',
            'order_id' => $param['parentCode'],
            'mer_date' => $param['orderDate'],
            'amount' => $param['money']*100,
            'amt_type' => 'RMB',
            'mer_priv' =>$attach,
            'expire_time' => ''
        );
        $plain=RsaPay::plain($map);
        $sign=RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $map['sign'] = $sign;
        $map['sign_type'] = 'RSA';
        $html=get_meta_tags(UM_PAY_URL.'?'.http_build_query($map));
        $html=$html['mobilepayplatform'];
        parse_str($html,$array);
        if(isset($array['trade_no'])) return $array['trade_no'];
        return 0;
    }

    /**
     * 联动优势（U支付）协议支付取得手机验证码
     * @param array $param
     * @return bool
     */
    public static function getUmVerifyCode($param){
        $map=array(
            'service' =>'req_smsverify_shortcut',
            'mer_id' => UM_MEMBER_ID,
            'version' =>'4.0',
            'trade_no' => $param['tradeNo'],
            'mer_cust_id' => $param['gw'],
            'usr_pay_agreement_id' => $param['pay_agreement_id'],
            'usr_busi_agreement_id' => $param['busi_agreement_id'],
        );
        $plain=RsaPay::plain($map);
        $sign=RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $map['sign'] = $sign;
        $map['sign_type'] = 'RSA';
        $html=get_meta_tags(UM_PAY_URL.'?'.http_build_query($map));
        $html=$html['mobilepayplatform'];
        parse_str($html,$array);
        if(isset($array['ret_code']) && $array['ret_code']=='0000') return true;
        return false;
    }
    /**
     * 联动优势（U支付）协议支付取得手机验证码
     * @param array $param
     * @return bool
     */
    public static function checkUmVerifyCode($param){
        $map=array(
            'service' =>'agreement_pay_confirm_shortcut',
            'mer_id' => UM_MEMBER_ID,
            'version' =>'4.0',
            'charset' =>'UTF-8',
            'trade_no' => $param['tradeNo'],
            'verify_code' => $param['verify_code'],
            'mer_cust_id' => $param['gw'],
            'usr_busi_agreement_id' => $param['busi_agreement_id'],
            'usr_pay_agreement_id' => $param['pay_agreement_id'],
        );
        $plain=RsaPay::plain($map);
        $sign=RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $map['sign'] = $sign;
        $map['sign_type'] = 'RSA';
        $html=get_meta_tags(UM_PAY_URL.'?'.http_build_query($map));
        $html=$html['mobilepayplatform'];
        parse_str($html,$array);
        if(isset($array['ret_code']) && $array['ret_code']=='0000') return true;
        return $array['ret_msg'];
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
                unset($data['sign']);
                unset($data['sign_type']);
                $plain = RsaPay::plain($data);
                $plain=iconv("UTF-8", "GBK", $plain);
                if(!RsaPay::verify($plain,$signMsg,Yii::getPathOfAlias('common') . '/rsaFile/um.cert.pem')){
                  $result['errorMsg'] = '验签失败';
             }else {
                $result = $data;
                $result['gw'] = $data['mer_cust_id'];
                $result['pay_type'] = $data['bank_card_type'];
            }
         }
         if(isset($result['usr_pay_agreement_id']) && !empty($result['usr_pay_agreement_id'])){
             Yii::import('application.modules.result.components.Process');
             Process::umUserAgreeId($result);
         }
        }else{
            $result['errorNonMsg']='没有接收到返回结果';
        }
        return $result;
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
        $plain=RsaPay::plain($map);
        $sign=RsaPay::sign($plain,Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $map['sign'] = $sign;
        $map['sign_type'] = 'RSA';
        $html=get_meta_tags(UM_PAY_URL.'?'.http_build_query($map));
        $html=$html['mobilepayplatform'];
        parse_str($html,$array);
        if(isset($array['ret_code']) && $array['ret_code']=='0000') return true;
        return false;
    }

    public static function ghtPaySign($params){
//        var_dump($params);exit;
        $ghtPay=new GhtPay();

        $key=substr(Tool::buildOrderNo(19), 0,16);
        $xmlData=$ghtPay->set_data($params,'pay');
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
        //exit; //高汇通暂时没有异步信息
        $httpsUrl = new HttpClient('http', '8081');
        return $httpsUrl->quickPost(GHT_QUICK_PAY_URL, $postData);
//        return array('key'=>$key,'signData'=>$encryptData);
    }


    
    /**
     * ips 网关响应码
     * @param null $k
     * @return array
     */
    public static function ipsError($k = null)
    {
        $arr = array(
            'P0001' => '商户号为空 或者 用户名为空 ',
            'P0002' => '商户号长度大于6位  ',
            'P0003' => '商户订单号为空  ',
            'P0005' => '商户订单号太长  ',
            'P0006' => '商户金额为空  ',
            'P0007' => '商户金额不合法  ',
            'P0009' => '商户日期为空或者长度不对  ',
            'P0010' => '商户日期不合法  ',
            'P0011' => '商户订单签名不能为空  ',
            'P0012' => '商户订单签名错  ',
            'P0015 ' => '币种未激活  ',
            'P0016' => '支付方式未开通  ',
            'P0017' => '商户未开通(配置文件不存在)  ',
            'P0106' => '商户禁止访问  ',
            'P0107' => '未从正确的入口进入 ',
            '%23E008 ' => '未从绑定的域名下提交交易  ',
        );
        return isset($arr[$k]) ? $arr[$k] : $arr;
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
            '01' => '交易失败，请联系发卡行',
            '02' => '交易失败，请联系发卡行',
            '03' => '交易失败，请联系发卡行',
            '04' => '交易失败，请联系发卡行',
            '05' => '交易失败，请联系发卡行',
            '06' => '交易失败，请联系发卡行',
            '07' => '交易失败，请联系发卡行',
            '09' => '交易失败，请重试',
            '12' => '交易失败，请联系发卡行',
            '13' => '金额有误，请重试',
            '14' => '无效卡号，请换卡重试',
            '15' => '此卡不能受理',
            '17' => '交易失败，请联系发卡行',
            '19' => '交易失败，请重试',
            '20' => '交易失败，请联系发卡行',
            '21' => '交易失败，请联系发卡行',
            '22' => '操作有误，请重试',
            '23' => '交易失败，请联系发卡行',
            '25' => '交易失败，请联系发卡行',
            '30' => '交易失败，请联系发卡行',
            '31' => '此卡不能受理',
            '33' => '卡片过期，请联系发卡行',
            '34' => '交易失败，请联系发卡行',
            '35' => '交易失败，请联系发卡行',
            '36' => '此卡有误，请换卡重试',
            '37' => '交易失败，请联系发卡行',
            '38' => '密码错误次数超限',
            '39' => '交易失败，请联系发卡行',
            '40' => '交易失败，请联系发卡行',
            '41' => '交易失败，请联系发卡行',
            '42' => '交易失败，请联系发卡行',
            '43' => '交易失败，请联系发卡行',
            '44' => '交易失败，请联系发卡行',
            '51' => '余额不足，请查询',
            '52' => '交易失败，请联系发卡行',
            '53' => '交易失败，请联系发卡行',
            '54' => '卡片过期，请联系发卡行',
            '55' => '密码错，请重试',
            '56' => '交易失败，请联系发卡行',
            '57' => '该卡不支持此项服务，请联系发卡行',
            '58' => '交易失败，请联系发卡行',
            '59' => '交易失败，请联系发卡行',
            '60' => '交易失败，请联系发卡行',
            '61' => '金额超限',
            '62' => '交易失败，请联系发卡行',
            '63' => '交易失败，请联系发卡行',
            '64' => '交易失败，请联系发卡行',
            '65' => '交易失败，请联系发卡行',
            '66' => '交易失败，请联系发卡行',
            '67' => '交易失败，请联系发卡行',
            '68' => '交易超时，请稍后重试',
            '75' => '密码错误次数超限',
            '76' => '交易失败，请联系发卡行',
            '77' => '交易失败，请联系发卡行',
            '78' => '交易失败，请联系发卡行',
            '90' => '交易失败，请稍后重试',
            '91' => '交易失败，请稍后重试',
            '92' => '交易失败，请稍后重试',
            '93' => '交易失败，请联系发卡行',
            '94' => '交易失败，请稍后重试',
            '95' => '交易失败，请稍后重试',
            '96' => '交易失败，请稍后重试',
            '97' => '交易失败，请稍后重试',
            '98' => '交易超时，请稍后重试',
            '99' => '交易失败，请稍后重试',
            'A0' => '交易失败，请稍后重试',
            'A2' => '交易结果请查询发卡行',
            'BF' => '交易失败，请联系发卡行',
            'XX' => '交易失败，请稍后重试',
        );
        return isset($arr[$key]) ? $arr[$key] : '未知错误';
    }

    /**
     * 汇卡支付错误码
     * @param $k
     * @return null
     */
    public static function hiError($k){
        $arr = array(
            '01'=>'交易重复,交易失败',
            '02'=>'卡状态不正常,交易失败',
            '03'=>'无效商户,交易失败',
            '04'=>'卡已过有效期,交易失败',
            '05'=>'卡上余额不足,交易失败',
            '06'=>'卡不存在,交易失败',
            '07'=>'商户不存在,交易失败',
            '08'=>'交易无效,交易失败',
            '09'=>'不能在该商户内消费,交易失败',
            '10'=>'商户不允许消费或商圈无效,交易失败',
            '11'=>'订单号相同,交易失败',
            '12'=>'商户无效（商户号或密码错误）,交易失败',
            '13'=>'交易无效,交易失败',
            '14'=>'验证商户签名失败,交易失败',
            '15'=>'金额超限（>=1.00）,交易失败',
            '16'=>'订单号不存在或不属于该商户,交易失败',
            '51'=>'账户内余额不足,余额不足，请查询',
            '52'=>'无此支票账户,交易失败',
            '53'=>'无此储蓄卡账户,交易失败',
            '54'=>'过期的卡,过期卡，请联系发卡行',
            '55'=>'密码输错,密码错，请重试',
        );
        return isset($arr[$k]) ? $arr[$k] : '未知错误';
    }


    // 取出上次调用加密、解密、签名函数成功后的输出结果
    public static $LastResult;
    //取出上次调用任何函数失败后的失败原因
    public static $LastErrMsg;

    /**
     * 对字符串进行加密
     * @param string $TobeEncrypted 待加密的字符串
     * @param string $CertFile 解密者公钥证书路径
     * @return bool 加密成功返回true(从LastResult属性获取结果)，失败返回false(从LastErrMsg属性获取失败原因)
     */
    public static function encryptMsg($TobeEncrypted = '')
    {
        $socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP ) or die ( 'could not create socket' );
        socket_connect ( $socket, HI_RSA_IP, HI_RSA_PORT );
        //向服务端发送数据

        if(!socket_write ( $socket, '0'.$TobeEncrypted."\n")){
            self::$LastErrMsg = 'could not write socket';
        }
        //接受服务端返回数据
        $str = trim(socket_read ( $socket, 2048, PHP_NORMAL_READ ));
        //关闭
        if ($str) {
            self::$LastResult = $str;
            return true;
        } else {
            self::$LastErrMsg = "Error Number:-10022, Error Description: ER_ENCRYPT_ERROR（加密失败）" ;
            return false;
        }
    }


    /**
     * 对加密后的密文进行解密
     * TobeDecrypted    需要解密的密文
     * KeyFile PFX证书文件路径
     * PassWord 私钥保护密码
     * 解密成功返回true(从LastResult属性获取结果)，失败返回false(从LastErrMsg属性获取失败原因)
     */
    public static function decryptMsg($TobeDecrypted)
    {

        $socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP ) or die ( 'could not create socket' );
        socket_connect ( $socket, HI_RSA_IP, HI_RSA_PORT );
        //向服务端发送数据
        if(!socket_write ( $socket, '2'.base64_encode($TobeDecrypted)."\n")){
            self::$LastErrMsg = 'could not write socket';
        }
        //接受服务端返回数据
        $str = trim(socket_read ( $socket, 2048, PHP_NORMAL_READ ));
        if ($str) {
            self::$LastResult = $str;
            return true;
        } else {
            self::$LastErrMsg = "Error Number:-10023, Error Description: ER_DECRYPT_ERROR（解密失败）|";
            return false;
        }
    }

    /**
     * 对字符串进行签名
     * TobeSigned 需要进行签名的字符串
     * KeyFile PFX证书文件路径
     * PassWord 私钥保护密码
     * return 签名成功返回true(从LastResult属性获取结果)，失败返回false(从LastErrMsg属性获取失败原因)
     */
    public static function signMsg($TobeSigned = '')
    {
        $socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP ) or die ( 'could not create socket' );
        socket_connect ( $socket, HI_RSA_IP, HI_RSA_PORT );
        //向服务端发送数据

        if(!socket_write ( $socket, '1'.$TobeSigned."\n")){
            self::$LastErrMsg = 'could not write socket';
        }
        //接受服务端返回数据
        $str = trim(socket_read ( $socket, 2048, PHP_NORMAL_READ ));
        if ($str) {
            self::$LastResult = $str;
            return true;

        } else {
            self::$LastErrMsg = "Error Number:-10020, Error Description: ER_SIGN_ERROR（签名失败）";
            return false;
        }
    }

    /**
     * 验证签名
     * TobeVerified 待验证签名的密文
     * PlainText 待验证签名的明文
     * CertFile 签名者公钥证书
     * return 验证成功返回true，失败返回false(从LastErrMsg属性获取失败原因)
     */
    public static function verifyMsg($TobeVerified, $PlainText)
    {
        $socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP ) or die ( 'could not create socket' );
        socket_connect ( $socket, HI_RSA_IP, HI_RSA_PORT );
        //向服务端发送数据

        if(!socket_write ( $socket, '3'.base64_encode($TobeVerified."java_rsa_division".$PlainText)."\n")){
            self::$LastErrMsg = 'could not write socket';
        }
        //接受服务端返回数据
        $str = trim(socket_read ( $socket, 2048, PHP_NORMAL_READ ));
        if (!empty($str)) {
            return true;
        } else {
            self::$LastErrMsg = "Error Number:-10021, Error Description: ER_VERIFY_ERROR（验签失败）" ;
            return false;
        }

    }

    /**
     * 检验支付返回数据，返回检验结果
     * @return array
     */
    public static function hiPayCheck()
    {
        /**
         * @var CHttpRequest $request
         */
        $request = Yii::app()->request;
        $encodeMsg = $request->getPost('encryStr');
        $signMsg = $request->getPost('signStr');
        $result = array(); //订单数据
        $statusCode = $request->getPost('resp');
        if($statusCode != '00'){
            $result['errorMsg'] = self::hiError($statusCode);
        }else{
            //解密数据
            if (!self::decryptMsg($encodeMsg)) {
                //解密失败
                $result['errorMsg'] = self::$LastErrMsg;
            } else {
                $decryptedMsg = self::$LastResult;
                $ret = self::verifyMsg($signMsg, $decryptedMsg);
                if ($ret == false) {
                    $result['errorMsg'] = self::$LastErrMsg;
                }
                parse_str(mb_convert_encoding($decryptedMsg, 'UTF-8', 'GBK'), $payResult);
                $result['currCode'] = $payResult['currCode'];
                $result['resp'] = $payResult['resp'];
                $result['money'] = $payResult['payAmount'];
                $result['parentCode'] = $payResult['orderNo'];
                $result['orderType'] = $request->getParam('orderType');
                $result['gw'] = $request->getParam('gw');
                $result['code'] = $request->getParam('code');
            }
        }
        return $result;
    }
    
    /**
     * 高汇通快捷支付检查
     */
    public static function ghtQuickCeck(){   
        $result = array();
        $request = Yii::app()->request;
        $encryptKeyData = $request->getParam('encryptKey');
        $encryptData= $request->getParam('encryptData');
        $signData = $request->getParam('signData');
        $key=GhtPay::rsaDecrypt($encryptKeyData);
        $xmlData=GhtPay::aseDecrypt($encryptData,$key);
        $signIstrue=GhtPay::verify_sign($xmlData, base64_decode($signData));
        if(!$signIstrue){
            $result['errorMsg'] = '验签失败';
        }else{
            $xmlToArray=@simplexml_load_string($xmlData);
            $head=$xmlToArray->head;
            $body=$xmlToArray->body;
            $resCode=$xmlToArray->head->respCode;
          if(!empty($head) && !empty($body)){
            if($resCode=='000000'){
                $result['parentCode'] = $head->reqMsgId;
                $result['payTranNo'] =$head->payMsgId;
                $result['orderType'] = $request->getParam('ot');//需要加载异步地址里
                $result['gw'] = $body->userId;
                $result['code'] = $request->getParam('code');//需要加载异步地址里
                $result['money'] = $body->amount;
                $result['info']=$xmlToArray;
            }else{
                $result['errorMsg'] = '支付失败';
            } 
           }else{
                $result['errorMsg'] = '异步信息错误';
           }
        }
        
        return $result;
    }

    /**
     * 高汇通支付结果检查
     * @return array
     */
    public static function ghtPayCheck(){
        /**
         * @var CHttpRequest $request
         */
        $request = Yii::app()->request;
        $signMsg = $request->getParam('sign');
        $signMsg=strtolower($signMsg);
        $result = array(); //订单数据
        $signPars ='';
        $signData=isset($_POST['order_no']) ? $_POST : $_GET;
        ksort($signData);
        foreach($signData as $k => $v) {
            if('sign' != $k && "" != $v) {
                $signPars .= $k . "=" . $v . "&";
            }
        }
        $base64_memo=$request->getParam('base64_memo');
        $memo=!empty($base64_memo) ? base64_decode($base64_memo):null;
        $attach = explode('XXX',$memo);
        $zfType=isset($attach[4]) ? $attach[4] : null;
        $key=$zfType==OnlinePay::PAY_GHT ? GHT_MD5KEY : GHTKJ_MD5KEY;
        $signPars .= "key=" . $key;
        $sign = strtolower(hash("sha256",$signPars));
          if($sign!=$signMsg){
                $result['errorMsg'] = '验签失败';
            }else{
              if($request->getParam('pay_result')==1){
                $result = $signData;
                $result['parentCode'] = $request->getParam('order_no');
                $result['payTranNo'] = $result['pay_no'];
                $result['orderType'] = $attach[0];
                $result['ip'] = isset($attach[2]) ? $attach[2] : null;
                $result['gw'] = isset($attach[3]) ? $attach[3] : null;
                $result['code'] = isset($attach[1]) ? $attach[1] : null;
                $result['zfType'] = $zfType;
                $result['money'] = $request->getParam('amount');
            }else{
                $result['errorMsg'] = '支付失败';
            }
       }
       
        return $result;
    }
    
    /**
     * EBC钱包支付结果检查
     * @return array
     */
    public static function ebcPayCheck(){
        /**
         * @var CHttpRequest $request
         */
         $result=array();
         $request = Yii::app()->request;
         $dstbdata=$request->getParam('dstbdata');
         $dstbdatasign=$request->getParam('dstbdatasign');
         $design=RsaPay::ebcDecrypt($dstbdatasign, EBC_CARD_KEY);
         if($dstbdata==$design){
             parse_str($dstbdata,$data);
             if(isset($data['returncode']) && $data['returncode']=='00'){
                 //$result=$data;
                 $result['orderType'] = $request->getParam('ot');
                 $result['gw'] = $request->getParam('mem');
                 $result['code'] = $request->getParam('code');
                 $result['parentCode'] = $data['dsorderid'];
                 $result['payTranNo'] = $data['orderid'];
                 $result['money'] = $data['amount'];
             }else{
                 $result['errorMsg'] = '支付失败';
             }
         }else{
             $result['errorMsg'] = '验签失败';
         }
         return $result;
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
            case self::PAY_BEST:
                if ($payConfig['bestEnable'] === 'false') {
                    $msg = Yii::t('orderFlow', '翼支付接口已经关闭,请用其它支付方式支付');
                }
                break;
            case self::PAY_UNION:
                if ($payConfig['gneteEnable'] === 'false') {
                    $msg = Yii::t('orderFlow', '银联支付接口已经关闭,请用其它支付方式支付');
                }
                break;
            case self::PAY_IPS:
                if ($payConfig['ipsEnable'] === 'false') {
                    $msg = Yii::t('orderFlow', '环迅支付接口已经关闭,请用其它支付方式支付');
                }
                break;
            case self::PAY_HI:
                if ($payConfig['hiEnable'] === 'false') {
                    $msg = Yii::t('orderFlow', '汇卡支付接口已经关闭,请用其它支付方式支付');
                }
                break;
            case self::PAY_UM:
                if ($payConfig['umEnable'] === 'false') {
                    $msg = Yii::t('orderFlow', '联动优势支付接口已经关闭,请用其它支付方式支付');
                }
                break;
            case self::PAY_UM_QUICK:
                if ($payConfig['umQuickEnable'] === 'false') {
                    $msg = Yii::t('orderFlow', '联动优势（快捷支付）接口已经关闭,请用其它支付方式支付');
                }
                break;
            case self::PAY_TLZF:
                if ($payConfig['tlzfEnable'] === 'false') {
                    $msg = Yii::t('orderFlow', '通联支付接口已经关闭,请用其它支付方式支付');
                }
                break;
            case self::PAY_TLZFKJ:
                    if ($payConfig['tlzfKjEnable'] === 'false') {
                        $msg = Yii::t('orderFlow', '通联支付KJ接口已经关闭,请用其它支付方式支付');
                    }
                    break;
           case self::PAY_GHT:
               if ($payConfig['ghtEnable'] === 'false') {
                    $msg = Yii::t('orderFlow', '高汇通接口已经关闭,请用其它支付方式支付');
                }
               break;
           case self::PAY_GHTKJ:
               if ($payConfig['ghtKjEnable'] === 'false') {
                   $msg = Yii::t('orderFlow', '高汇通积分接口已经关闭,请用其它支付方式支付');
               }
           break;
          case self::PAY_EBC:
                   if ($payConfig['ebcEnable'] === 'false') {
                       $msg = Yii::t('orderFlow', '高汇通接口已经关闭,请用其它支付方式支付');
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
        if ($payType == OnlinePay::PAY_IPS) {
            $controller->redirect(array(
                $action,
                'code' => $mainCode,
                'money' => $money,
                'payType' => OnlinePay::PAY_IPS,
                'auth' => $auth,
                'parentCode' => $parentCode));
        }

        if ($payType == OnlinePay::PAY_UNION) {
            //银联支付
            $controller->redirect(array(
                $action,
                'code' => $mainCode,
                'money' => $money,
                'payType' => OnlinePay::PAY_UNION,
                'auth' => $auth,
                'parentCode' => $parentCode));

        }
        if ($payType == OnlinePay::PAY_BEST) {
            //翼支付
            $controller->redirect(array(
                $action,
                'code' => $mainCode,
                'money' => $money,
                'payType' => OnlinePay::PAY_BEST,
                'orderDate' => date('YmdHis'),
                'auth' => $auth,
                'parentCode' => $parentCode));
        }
        if ($payType == OnlinePay::PAY_HI) {
            //汇卡支付
            $controller->redirect(array(
                $action,
                'code' => $mainCode,
                'money' => $money,
                'payType' => OnlinePay::PAY_HI,
                'auth' => $auth,
                'parentCode' => $parentCode));
        }
        
        if ($payType == OnlinePay::PAY_UM) {
            //联动优势支付
            $controller->redirect(array(
                $action,
                'code' => $mainCode,
                'money' => $money,
                'orderDate' => date('Ymd'),
                'payType' => OnlinePay::PAY_UM,
                'auth' => $auth,
                'parentCode' => $parentCode));
        }

        if ($payType == OnlinePay::PAY_UM_QUICK) {
            //联动优势（快捷支付）
            $controller->redirect(array(
                $action,
                'code' => $mainCode,
                'money' => $money,
                'orderDate' => date('Ymd'),
                'payType' => OnlinePay::PAY_UM_QUICK,
                'auth' => $auth,
                'parentCode' => $parentCode));
        }
        
        if ($payType == OnlinePay::PAY_TLZF || $payType == OnlinePay::PAY_TLZFKJ) {
            //通联支付
            $controller->redirect(array(
                    $action,
                    'code' => $mainCode,
                    'money' => $money,
                    'orderDate' => $mainCode == $parentCode ? substr($parentCode, 0,14) : substr($parentCode, 1,14),//查询订单时需要传送支付时间
                    'payType' => $payType,
                    'auth' => $auth,
                    'parentCode' => $parentCode));
        }
        
        if ($payType == OnlinePay::PAY_GHT || $payType == OnlinePay::PAY_GHTKJ) {
            //高汇通支付
            $controller->redirect(array(
                    $action,
                    'code' => $mainCode,
                    'money' => $money,
                    'orderDate' => date('YmdHis'),
                    'payType' => $payType,
                    'auth' => $auth,
                    'parentCode' => $parentCode));
        }  

        if ($payType == OnlinePay::PAY_EBC) {
            //EBC钱包支付
            $controller->redirect(array(
                    $action,
                    'code' => $mainCode,
                    'money' => $money,
                    'orderDate' => date('YmdHis'),
                    'payType' => OnlinePay::PAY_EBC,
                    'auth' => $auth,
                    'parentCode' => $parentCode));
        }
    
    }

    /**
     * 支付金额校验
     * @throws CHttpException
     */
    public static function checkMoney(){
        $auth=Yii::app()->request->getParam('auth');
        $money=Yii::app()->request->getParam('money');
        $parentCode=Yii::app()->request->getParam('parentCode');
        $auth=Tool::authcode($auth,'DECODE');
        if(!$auth){
            throw new CHttpException(503,'订单支付链接存在风险，请重新打开支付！');
        }else{
            if($money.$parentCode!==$auth){
                throw new CHttpException(403,'订单支付链接存在风险，请重新打开支付！');
            }
        }
    }
} 