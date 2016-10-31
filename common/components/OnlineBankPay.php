<?php

/**
 * 网银直付
 * @author wyee <yanjie.wang@g-emall.com>
 */
class OnlineBankPay
{

    const PAY_BANK_NONE = 1;//不指定银行
    const PAY_BANK_DEBITCARD = 2;//借记卡
    const PAY_BANK_CREDITCARD = 3;//信用卡
    
    const STATUS_YES=1;//显示
    const STATUS_NO=0;//不显示

    /**
     * 获取共有的银行卡
     * @return array
     */
    public static function getCommonBank()
    {
        $sql = "SELECT
                    `code`,
                    `name`,
                    count(NAME) AS c
                FROM
                    gw_bank
                GROUP BY
                    `name`
                HAVING
                    c = (SELECT COUNT(DISTINCT type) from gw_bank)
                ORDER BY
                    c DESC,
                    sort DESC";
        $data = Yii::app()->db->createCommand($sql)->queryAll();
        $payConfig = Tool::getConfig('payapi');
        if($payConfig['ghtEnable']){
            $sql = 'select code,name from gw_bank where (code="ALIPAY" or code="WECHAT") AND `status`='.OnlineBankPay::STATUS_YES.'  order BY  sort desc';
            $ext = Yii::app()->db->createCommand($sql)->queryAll();
            $data = array_merge($ext,$data);
        } 
        return $data;
    }

    /**
     * 直连银行卡类别
     * @param int $cardType
     * @return or array
     */
    public static function getCardType($cardType = null)
    {
        $arr = array(
            self::PAY_BANK_NONE => Yii::t('goods', '不指定'),
            self::PAY_BANK_DEBITCARD => Yii::t('goods', '借记卡'),
            self::PAY_BANK_CREDITCARD => Yii::t('goods', '信用卡'),
        );
        if (is_numeric($cardType)) {
            return isset($arr[$cardType]) ? $arr[$cardType] : null;
        } else {
            return $arr;
        }
    }


    /**
     * 根据不同的第三方走不同的通道
     * @param int $thirdType 第三方类型
     * @param array $payArr 待支付订单数据
     */
    public static function ThirdTypeCheck($payType, $payArr)
    {
        switch ($payType) {
            case OnlinePay::PAY_BEST:
                self::bestBankPay($payArr);
                break;
             /*case OnlinePay::PAY_UM:
                self::umBankPay($payArr);
                break;
            case OnlinePay::PAY_TLZF:
                self::tlzfBankPay($payArr);
                break; */
            case OnlinePay::PAY_GHT:
                self::ghtBankPay($payType, $payArr);
                break;
            case OnlinePay::PAY_GHTKJ:
                self::ghtBankPay($payType, $payArr);
                break;
            default:
                self::ghtBankPay(OnlinePay::PAY_GHT,$payArr);
                break;
        }
    }


    /**
     * 翼支付银行直连支付
     * @param array $payArr 支付数据组成的数组
     */
    private static function bestBankPay($payArr)
    {
        $money = $payArr['money'] * 100;
        $ip = $_SERVER['REMOTE_ADDR'];
        $orderDate = date('YmdHis');
        $mac = 'MERCHANTID=' . BEST_MER_CODE . '&ORDERSEQ=' . $payArr['code'] . '&ORDERDATE=' . $orderDate . '&ORDERAMOUNT=' . $money . '&CLIENTIP=' . $ip . '&KEY=' . BEST_KEY;
        $mac = md5($mac);
        $attach = implode('XXX', array($payArr['orderType'], $payArr['code'], Tool::ip2int(Yii::app()->request->userHostAddress), Yii::app()->user->gw));
        $map = array(
            'MERCHANTID' => BEST_MER_CODE, 'ORDERSEQ' => $payArr['code'],
            'ORDERREQTRANSEQ' => $payArr['parentCode'], 'ORDERDATE' => $orderDate,
            'PRODUCTAMOUNT' => $money, 'ATTACHAMOUNT' => '0',
            'ORDERAMOUNT' => $money, 'CURTYPE' => 'RMB',
            'ENCODETYPE' => '1', 'MERCHANTURL' => $payArr['backUrl'],
            'BACKMERCHANTURL' => Tool::getConfig('payapi', 'ip') . 'bestpay',
            'BANKID' => $payArr['bankCode'],
            'ATTACH' => $attach,
            'BUSICODE' => '0001', 'PRODUCTID' => '08',
            'TMNUM' => '', 'CUSTOMERID' => Yii::app()->user->gw,
            'PRODUCTDESC' => '', 'CLIENTIP' => $ip,
            'MAC' => $mac,
        );
        $goUrl = 'https://webpaywg.bestpay.com.cn/payWebDirect.do';
        self::HttpSendUrlData($goUrl, $map);
    }

    /**
     * 联动优势 网银直连
     * @param array $payArr 支付数据组成的数组
     */
    private static function umBankPay($payArr)
    {
        $cardType = array(self::PAY_BANK_DEBITCARD => 'DEBITCARD', self::PAY_BANK_CREDITCARD => 'CREDITCARD');
        $money = $payArr['money'] * 100;
        $attach = implode('XXX', array($payArr['orderType'], $payArr['code'], Tool::ip2int(Yii::app()->request->userHostAddress), Yii::app()->user->gw));
        $map = array(
            'service' => 'req_front_page_pay',
            'charset' => 'UTF-8',
            'mer_id' => UM_MEMBER_ID,
            'ret_url' => $payArr['backUrl'],
            'notify_url' => Tool::getConfig('payapi', 'ip') . 'umpay',
            'version' => '4.0',
            'order_id' => $payArr['parentCode'],
            'mer_date' => date('Ymd'),
            'amount' => $money,
            'amt_type' => 'RMB',
            'pay_type' => $cardType[$payArr['bankType']],
            'gate_id' => $payArr['bankCode'],
            'mer_priv' => $attach,
            'interface_type' => '01',
            'goods_inf' => Yii::app()->user->gw,
        );
        $plain = RsaPay::plain($map);
        $sign = RsaPay::sign($plain, Yii::getPathOfAlias('common') . '/rsaFile/um.key.pem');
        $map['sign_type'] = 'RSA';
        $map['sign'] = $sign;
        self::HttpSendUrlData(UM_PAY_URL, $map);
    }

    /**
     * 通联支付 网银直连
     * @param array $payArr 支付数据组成的数组
     */
    private static function tlzfBankPay($payArr)
    {
        $money = $payArr['money'] * 100;
        $attach = implode('XXX', array($payArr['orderType'], $payArr['code'], Tool::ip2int(Yii::app()->request->userHostAddress), Yii::app()->user->gw));
        $map = array(
            'inputCharset' => '1',
            'pickupUrl' => $payArr['backUrl'],
            'receiveUrl' => Tool::getConfig('payapi', 'ip') . 'tlzfpay',
            'version' => 'v1.0',
            'signType' => '1',
            'merchantId' => TLZF_MERCHANT_ID,
            'orderNo' => $payArr['parentCode'],
            'orderAmount' => $money,
            'orderDatetime' => substr($payArr['parentCode'], 1, 14),
            'ext1' => $attach,
            'payType' => '1',//直连是1，间连是0
            'issuerId' => strtolower($payArr['bankCode']),
            'tradeNature' => 'GOODS',
            'key' => TLZF_MD5KEY,
        );
        $plain = urldecode(http_build_query($map));
        $signMsg = strtoupper(md5($plain));
        $map['signMsg'] = $signMsg;
        self::HttpSendUrlData(TLZF_WEBPAY_URL, $map);
    }


    /**
     * 高汇通银行直连支付
     * @param int $source 银行类别，用于判别所用的高汇通商户号
     * @param array $payArr 支付数据组成的数组
     */
    private static function ghtBankPay($payType, $payArr)
    {
        $ghtType = $payType;
        $key = $ghtType == OnlinePay::PAY_GHTKJ ? GHTKJ_MD5KEY : GHT_MD5KEY;
        $memno = $ghtType == OnlinePay::PAY_GHTKJ ? GHTKJ_MERCHANT_ID : GHT_MERCHANT_ID;
        $terno = $ghtType == OnlinePay::PAY_GHTKJ ? GHTKJ_TERMINAL_ID : GHT_TERMINAL_ID;
        $attach = implode('XXX', array($payArr['orderType'], $payArr['code'], Tool::ip2int(Yii::app()->request->userHostAddress), Yii::app()->user->gw, $ghtType));
        $receiveUrl = Tool::getConfig('payapi', 'ip') . 'ghtpay';
        $map = array(
            'busi_code' => 'PAY',
            'merchant_no' => $memno,
            'terminal_no' => $terno,
            'order_no' => $payArr['parentCode'],
            'amount' => $payArr['money'],
            'currency_type' => 'CNY',
            'sett_currency_type' => 'CNY',
            'product_name' => '盖象商城-' . Yii::app()->user->gw,
            'return_url' => $payArr['backUrl'],
            'notify_url' => $receiveUrl,
            'bank_code' => $payArr['bankCode'],
            'base64_memo' => base64_encode($attach),
            'sign_type' => 'SHA256',
        );
        $signOrigStr = '';
        $plain = RsaPay::plain($map);
        $signOrigStr = $plain . "&" . "key=" . $key;
        $signMsg = strtolower(hash("sha256", $signOrigStr));
        $map['sign'] = $signMsg;
        ksort($map);
        self::HttpSendUrlData(GHT_WEBPAY_URL, $map);
    }

    /**
     * header()提交数据
     * @param  $url 提交数据网关网址
     * @param  $map 提交数据
     */
    private static function HttpSendUrlData($url, $map)
    {
        $uri = http_build_query($map);
        $SendUrl = $url . '?' . $uri;
        header("Location:$SendUrl");
    }

    /**
     *检测支付方式是否关闭
     * @param array $payTypes 支付类别
     */

    public static function checkPayType($payTypes)
    {
        $payConfig = Tool::getConfig('payapi');
        $payConfigArr = array(
            OnlinePay::PAY_BEST => 'bestEnable',
            OnlinePay::PAY_GHT => 'ghtEnable',
            OnlinePay::PAY_TLZF => 'tlzfEnable',
            OnlinePay::PAY_UM => 'umEnable',
        );
        $result = array();
        if (!empty($payTypes)) {
            foreach ($payTypes as $v) {
                $key = $payConfigArr[$v['type']];
                if ($payConfig[$key] === 'true') {
                    $result[] = $v;
                }
            }
        }
        return $result;
    }


}