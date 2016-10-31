<?php

/**
 * 历史金额的使用
 * @author zhenjun_xu <412530435@qq.com>
 */
class HistoryBalanceUse {

    /**
     * @var bool 是否经过 HistoryBalanceUse::pay 处理
     */
    private static $_process = false;

    /** @var array 代扣失败记录 */
    private static $_errorLog = array();

    /**
     * @var array 后台代扣配置
     */
    private static $_config = array();

    /** gw_deduct_log  platform 支付平台 */

    const PLATFORM_UNION = 1;
    const PLATFORM_BEST = 2;
    const PLATFORM_IPS = 3;

    public static function showPlatform() {
        return array(
//            self::PLATFORM_UNION => '广州银联',
            self::PLATFORM_BEST => '翼支付',
//            self::PLATFORM_IPS => '环迅',
        );
    }

    /** 代扣结果 */

    const STATUS_YES = 1;
    const STATUS_NO = 2;
    /**
     * 翼支付代扣
     */
    const WEBSVRNAME = '签约实时代收付接口';
    const WEBSVRCODE = 'INF05001';
    /** @var int 渠道号，标识渠道类型，定值80 */
    const CHANNELCODE = 80;

    private static $_successCode = '000000';

    /**
     * 翼支付代扣，拼接 xml PayPlatRequestParameter
     * @param string $code 订单号
     * @param float $money 金额
     * @param string $gai_number
     * @param string $mainCode
     * @return string  xml
     */
    private static function _preparePayFlatParameter($code, $money, $gai_number, $mainCode) {
        //随机生成的流水，用于维持请求响应对:终端号+yyyyMMddhhmmss+4位流水号
        $keep = BEST_TMNNUM . date('Ymdhis') . '' . rand(0, 10000);
        //请求此服务的客户端标识编码:省份-应用系统名称-版本号-IP
        $appFrom = '440000-PAYMENT-001-' . Yii::app()->request->userHostAddress;
        //标明本次请求控制信息。属于消息头
        $ctrlInfo = '<CTRL-INFO WEBSVRNAME="' . self::WEBSVRNAME . '" WEBSVRCODE="' . self::WEBSVRCODE . '"  APPFROM="' . $appFrom . '"  KEEP="' . $keep . '" REQUESTTIME="' . date('Ymdhis') . '" />';
        //代扣信息
        return '<PayPlatRequestParameter>' . $ctrlInfo .
                '<PARAMETERS>' .
                '<ORDERSEQ>' . $mainCode . '</ORDERSEQ>' . //订单号
                '<BUSITYPE>BT001</BUSITYPE>' . //代收付类型
                '<TRANSCONTRACTID>' . BEST_TRANSCONTRACTID . '</TRANSCONTRACTID>' . //签约ID
                '<BANKACCT>' . self::$_config['bestCardNumbers'][0] . '</BANKACCT>' . //银行账号
                '<TXNAMOUNT>' . ($money * 100) . '</TXNAMOUNT>' . //交易金额,单位：分
                '<MEMO>' . $gai_number . '</MEMO>' .
                '<REMARK1>' . $code . '</REMARK1>' . //保留1
                '<REMARK2> </REMARK2>' . //保留2
                '</PARAMETERS>' .
                '</PayPlatRequestParameter>';
    }

    /**
     * 翼支付代扣，拼接 xml VerifyParameter
     * @param $channelCode
     * @param $merId
     * @param $sign
     * @param $tmnNum
     * @param $arr2
     * @return string
     */
    private static function _prepareVerifyParameter($channelCode, $merId, $sign, $tmnNum, $arr2) {
        return '<VerifyParameter>' .
                '<MERID>' . $merId . '</MERID>' .
                '<CHANNELCODE>' . $channelCode . '</CHANNELCODE>' .
                '<TMNNUM>' . $tmnNum . '</TMNNUM>' .
                '<SIGN>' . $sign . '</SIGN>' .
                '<CER>' . $arr2 . '</CER>' .
                '</VerifyParameter>';
    }

    /**
     * 翼支付代扣
     * @param $code
     * @param $money
     * @param array $member
     * @param string $mainCode
     * @throws Exception
     * @return true
     */
    private static function _bestPay($code, $money, $member, $mainCode) {
        $payPlatRequestParam = self::_preparePayFlatParameter($code, $money, $member['gai_number'], $mainCode);
        $rsaPath = Yii::getPathOfAlias('common') . '/rsaFile/';
        $fp = fopen($rsaPath . BEST_RSA_FILE . '.key', "r");
        $private_key = fread($fp, 8192);
        fclose($fp);
        openssl_sign($payPlatRequestParam, $binary_signature, $private_key, 'sha1WithRSAEncryption');
        $sign = (base64_encode($binary_signature) . "\n"); //获取Sign值
        //获取cert值
        $cert = file_get_contents($rsaPath . BEST_RSA_FILE . '.pem');
        $arr = explode("-----", $cert);
        $arr2 = explode("\n", $arr[2]);
        $cert = implode($arr2);

        $request = self::_prepareVerifyParameter(self::CHANNELCODE, BEST_MER_ID, $sign, BEST_TMNNUM, $cert) . $payPlatRequestParam;
        $xmlParameter = '<?xml version="1.0" encoding="UTF-8"?><Request>' . $request . '</Request>';
//        echo $xmlParameter;exit;
        $infClient = new SoapClient(BEST_SERVICE_URL);
        $result = $infClient->dispatchCommand(self::WEBSVRCODE . "|" . $_SERVER['REMOTE_ADDR'], $xmlParameter);
        if ($result) {
            $xmlObj = simplexml_load_string($result);
//            Tool::pr($xmlObj);
            $responseCode = $xmlObj->PayPlatResponseParameter->RESPONSECODE;
            if ($responseCode == self::$_successCode) {
                Yii::app()->db->createCommand()->insert('{{deduct_log}}', array(
                    'card_number' => self::$_config['bestCardNumbers'][0],
                    'platform' => self::PLATFORM_BEST,
                    'money' => $money,
                    'order_code' => $code,
                    'status' => self::STATUS_YES,
                    'create_time' => time(),
                    'member_id' => $member['id'],
                ));
                return true;
            } else {
                self::$_errorLog[] = array(
                    'card_number' => self::$_config['bestCardNumbers'][0],
                    'platform' => self::PLATFORM_BEST,
                    'money' => $money,
                    'order_code' => $code,
                    'status' => self::STATUS_NO,
                    'create_time' => time(),
                    'member_id' => $member['id'],
                    'text' => $result,
                );
            }
        } else {
            self::$_errorLog[] = array(
                'card_number' => self::$_config['bestCardNumbers'][0],
                'platform' => self::PLATFORM_BEST,
                'money' => $money,
                'order_code' => $code,
                'status' => self::STATUS_NO,
                'create_time' => time(),
                'member_id' => $member['id'],
                'text' => $xmlParameter,
            );
        }
        //代扣失败，将当前银行卡号放到最后
        $firstCartN = self::$_config['bestCardNumbers'][0];
        array_shift(self::$_config['bestCardNumbers']);
        array_push(self::$_config['bestCardNumbers'], $firstCartN);
        //更新配置文件
        $config = self::$_config;
        $config['bestCardNumbers'] = implode(',', $config['bestCardNumbers']);
        $name = 'historybalance';
        $value = WebConfig::model()->findByAttributes(array('name' => $name));
        if ($value) {
            $webConfig = WebConfig::model();
            $webConfig->id = $value->id;
        } else {
            $webConfig = new WebConfig();
        }
        $webConfig->name = $name;
        $webConfig->value = serialize($config);
        if ($webConfig->save()) {
            if (Tool::cache($name . 'config')->get($name)) {
                Tool::cache($name . 'config')->set($name, $string);
            } else {
                Tool::cache($name . 'config')->add($name, $string);
            }
        }
//        $file = Yii::getPathOfAlias('common') . DS . 'webConfig' . DS . 'historybalance.config.inc';
//        file_put_contents($file, base64_encode(serialize($config)));
        return false;
    }

    /**
     * 获取代扣处理方法
     * @return string
     */
    private static function _getPlatform() {
        /*
         * 随机方式
          $platform = array_keys(self::showPlatform());
          shuffle($platform);
          switch($platform[0]){
          case self::PLATFORM_BEST:
          $methodName = '_bestPay';
          break;
          case self::PLATFORM_UNION:
          $methodName = '_unionPay';
          break;
          case self::PLATFORM_IPS;
          $methodName = '_ipsPay';
          break;
          }
         */
        /**
         * 后台指定方式
         */
        $config = Tool::getConfig('historybalance');
        $config['bestCardNumbers'] = explode(',', $config['bestCardNumbers']);
        self::$_config = $config;
        if ($config['currentPay'] == self::PLATFORM_BEST) {
            $methodName = '_bestPay';
        }
        return $methodName;
    }

    private static function _unionPay($code, $money, $member, $mainCode) {
        echo __FUNCTION__;
        return false;
    }

    private static function _ipsPay($code, $money, $member, $mainCode) {
        echo __FUNCTION__;
        return false;
    }

    /**
     * 代扣方法,不加入事务处理，因为无论成功、失败都需要记录log
     * @param string $code 订单编号
     * @param float $money
     * @param array $member 会员信息
     * @param string $mainCode
     * @return bool
     * @throws Exception
     */
    public static function pay($code, $money, Array $member, $mainCode) {
        return true;
        if (!self::$_process)
            return true;
//        header("Content-Type: text/xml; charset=UTF-8");
        $methodName = self::_getPlatform();
        /**
         * 如果失败，尝试执行3次
         */
        $i = 1;
        while (!$result = self::$methodName($code, $money, $member, $mainCode)) {
            $i++;
            $methodName = self::_getPlatform();
            if ($i > 3)
                break;
        }
        return $result;
    }

    /**
     * 记录错误的代扣
     */
    public static function errorLog() {
        if (!empty(self::$_errorLog)) {
            foreach (self::$_errorLog as $v) {
                Yii::app()->db->createCommand()->insert('{{deduct_log}}', $v);
            }
        }
    }

    /**
     * 处理代扣
     * @param string $newMonthTable gw_account_flow 流水表表名
     * @param string $oldMonthTable gw_account_flow_history 流水表表名
     * @param array $balance 用户余额表
     * @param array $historyBalance 历史余额表
     * @param float $money 金额
     * @param string $code 订单号
     * @param int $orderId 订单id
     * @param string $remark 备注
     * @return bool
     * @throws Exception
     */
    public static function process($newMonthTable, $oldMonthTable, Array $balance, Array $historyBalance, $money, $code, $orderId, $remark = '网银订单充值,支付订单') {
        if (bccomp($historyBalance['today_amount'], $money, 3) == -1) {
            return false;
        }
        //借方(会员)
        $creditOld = array(
            'account_id' => $balance['account_id'],
            'gai_number' => $balance['gai_number'],
            'card_no' => $balance['card_no'],
            'type' => AccountFlow::TYPE_CONSUME,
            'debit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_ASSIGN_ONE,
            'order_id' => $orderId,
            'order_code' => $code,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_ASSIGN_ONE,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_ASSIGN,
            'flag' => AccountFlow::FLAG_SPECIAL,
        );

        //贷方(会员)
        $creditNew = array(
            'account_id' => $balance['account_id'],
            'gai_number' => $balance['gai_number'],
            'card_no' => $balance['card_no'],
            'type' => AccountFlow::TYPE_CONSUME,
            'credit_amount' => $money,
            'operate_type' => AccountFlow::OPERATE_TYPE_ASSIGN_TWO,
            'order_id' => $orderId,
            'order_code' => $code,
            'remark' => $remark,
            'node' => AccountFlow::BUSINESS_NODE_ASSIGN_TWO,
            'transaction_type' => AccountFlow::TRANSACTION_TYPE_ASSIGN,
            'flag' => AccountFlow::FLAG_SPECIAL,
        );
        $db = Yii::app()->db;
        //转移金额
        //$sql = 'update ' . ACCOUNT . '.gw_account_balance_history set today_amount=today_amount-' . $money . ' where id=' . $historyBalance['id'];
        AccountBalanceHistory::calculate(array('today_amount'=>-$money),$historyBalance['id']);
        AccountBalance::calculate(array('today_amount'=>$money),$balance['id']);
        //$sql .= ';update ' . ACCOUNT . '.gw_account_balance set today_amount=today_amount+' . $money . ' where id=' . $balance['id'];
        //$db->createCommand($sql)->execute();

        // 借贷流水1.按月
        $db->createCommand()->insert($newMonthTable, AccountFlow::mergeField($creditNew));
        $db->createCommand()->insert($oldMonthTable, AccountFlow::mergeField($creditOld));

        self::$_process = true;
        return true;
    }

}
