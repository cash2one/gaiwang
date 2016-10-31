<?php

/**
 * api控制器父类
 * @author wanyun.liu <wanyun_liu@163.com>
 */
class Controller extends CController {

    public $actionType;
    protected $username;
    protected $password;
    protected $member;

    const CODE_CACHE = 'apiCode'; //验证码缓存目录

    public $rules; //比率
    public $memberTypeRate;
    public $encrypt_field;

    public function __construct($id, $module = null) {
        $this->rules = $this->getConfig('allocation');
        $this->memberTypeRate = MemberType::fileCache();
        $this->setLanguage();
        parent::__construct($id, $module);
    }

    /**
     * 设置语言
     */
    public function setLanguage() {
        $postConfig = (int) $this->getPost('Language', 0);
        $config = (int) $this->getSession('language', 1);
        if ($postConfig != false && $config != $postConfig && in_array($postConfig, array(1, 2, 3))) {
            $this->setSession('language', $postConfig);
            $config = $postConfig;
        }
        //语言,1简体；2繁体；3英语
        switch ($config) {
            case 1: Yii::app()->language = 'zh_cn';
                break;
            case 2: Yii::app()->language = 'zh_tw';
                break;
            case 3: Yii::app()->language = 'en';
                break;
            default :Yii::app()->language = 'zh_cn';
        }
    }

    /**
     * 设置session值
     * @param string $key
     * @param string|array $value 如果$value为null表示注销session
     */
    public function setSession($key, $value = null) {
        Yii::app()->user->setState($key, $value, null);
    }

    /**
     * 获取session值
     * @param string $key
     * @param string|array $defaultValue
     * @return string|array
     */
    public function getSession($key, $defaultValue = null) {
        return Yii::app()->user->getState($key, $defaultValue);
    }

    public function getMember() {
        $member = $this->getSession('member');
        if (!$this->getSession('isLogin') || !$member) {
            $this->errorEndXml('请登录');
            return false;
        } else {
            return $member;
        }
    }

    /**
     * 获取post提交参数
     * @param string $name
     * @param string $defaultValue
     * @param boolean $filter
     * @return string|array
     */
    public function getPost($name, $defaultValue = null, $filter = true) {
        if (!$filter)
            return Yii::app()->request->getPost($name, $defaultValue);
        $rs = Yii::app()->request->getPost($name, $defaultValue);
        return $this->magicQuotes($rs);
    }

    /**
     * 获取get提交参数
     * @param string $name
     * @param string $defaultValue
     * @param boolean $filter
     * @return string|array
     */
    public function getQuery($name, $defaultValue = null, $filter = true) {
        if (!$filter)
            return Yii::app()->request->getQuery($name, $defaultValue);
        return $this->magicQuotes(Yii::app()->request->getQuery($name, $defaultValue));
    }

    /**
     * 获取post,get提交参数
     * @param string $name
     * @param string $defaultValue
     * @param boolea  $filter
     * @return string|array
     */
    public function getParam($name, $defaultValue = null, $filter = true) {
        if (!$filter)
            return Yii::app()->request->getParam($name, $defaultValue);
        return $this->magicQuotes(Yii::app()->request->getParam($name, $defaultValue));
    }

    /**
     * 转义数据
     * @param string|array $var
     * @return string|array
     */
    public function magicQuotes(&$var) {
        if (!get_magic_quotes_gpc()) {
            if (is_array($var)) {
                foreach ($var as $k => $v)
                    $var[$k] = $this->magicQuotes($v);
            }
            else
                $var = addslashes($var);
        }
        return $var;
    }

    /**
     * 判断是否post请求
     * @return boolean
     */
    public function isPost() {
        return Yii::app()->request->isPostRequest;
    }

    /**
     * 获取应用用户实例
     * @return CWebUser
     */
    public function getUser() {
        return Yii::app()->user;
    }

    /**
     * 获取配置文件下的参数
     * @param string $field1
     * @param string $field2
     * @return string|array
     */
    public function params($field1, $field2 = null) {
        return $field2 ? Yii::app()->params[$field1][$field2] : Yii::app()->params[$field1];
    }

    /**
     * 验证当前是否POST请求
     * 若不是: die
     */
    public function checkRequest() {
        if (!$this->isPost())
            exit('Access Invalid!');
    }

    /**
     * 
     */
    public function checkParam($param) {
        if (!trim($this->getPost($param)))
            exit('Access Invalid P!');
        return trim($this->getPost($param));
    }

    public function checkMultipleMember($username) {
        $mult = ApiMember::getMultipleMember($username);
        if (count($mult) > 1) {
            $xml = '<Multiple>1</Multiple><UserInfo><GaiNumberList>';
            foreach ($mult as $val) {
                $xml .= '<GaiNumber>' . $val['gai_number'] . '</GaiNumber>';
            }
            $xml .= '</GaiNumberList></UserInfo><ResultDesc>请选择一个账号登陆</ResultDesc>';
            echo $this->exportXml($xml);
            Yii::app()->end();
        }
    }

    /**
     * 客户端 用户验证,同时获取用户信息
     */
    public function checkIdentity() {
        if (!$this->username && !$this->password) {
            $username = $this->checkParam('UserName');    //用户名(RSA加密)
            $password = $this->checkParam('Pwd');    //密码(RSA加密)
            // 解密
            $rsa = new RSA();
            $this->username = $rsa->decrypt($username);
            $this->password = $rsa->decrypt($password);
        }
        $this->username = trim($this->username);
        $this->password = trim($this->password);
        if (!$this->username || !$this->password) {
            $this->errorEndXml('请输入用户名和密码');
        }
        $this->checkMultipleMember($this->username);
        $user = new UserIdentity($this->username, $this->password);
        if (!$user->authenticate()) {
            if (empty($user->errorMessage)) {
                $this->errorEndXml('用户名或密码错误');
            } else {
                $this->errorEndXml($user->errorMessage);
            }
        }
        if ($user->errorCode === UserIdentity::ERROR_NONE) {
            Yii::app()->user->login($user);
        }
        $userData = $user->getMemberData();  //获取用户信息
        $this->member = $userData;  //获取用户信息
        if (!$this->getSession('isLogin') || !$this->getSession('member')) {
            $this->setSession('member', $userData);
            Yii::app()->user->id = $userData['id'];
            Yii::app()->user->name = $userData['username'];
            Yii::app()->user->setState('typeId', $userData['type_id']);
        }
    }

    /**
     * 登录后更新相关数据
     */
    public function afterLoginUpdate($member) {
        /** @var Member $member */
        $member['logins'] = $member['logins'] + 1;
        $member['last_login_time'] = $member['current_login_time'];
        $member['current_login_time'] = time();
        Yii::app()->db->createCommand()->update('{{member}}', $member, 'id=:id', array(':id' => $member['id']));

        $this->setSession('member', $member);
        $this->member = $member;  //获取用户信息

        Yii::app()->user->id = $member['id'];
        Yii::app()->user->name = $member['username'];
        Yii::app()->user->setState('typeId', $member['type_id']);

        //设置企业店铺相关session,店铺是store表，由会员在卖出中心申请
        if ($member['enterprise_id']) {
            /** @var Store $store */
            $store = Store::model()->find('member_id=:member_id', array(':member_id' => $member['id']));
            if ($store) {
                Yii::app()->user->setState('storeId', $member['id']);
                Yii::app()->user->setState('storeStatus', $store->status);
            }

            /**
             * 企业会员相关信息，只有是企业会员才能登陆卖家平台
             */
            /** @var Enterprise $infoModel */
            $infoModel = Enterprise::model()->findByPk($member['enterprise_id']);
            if ($infoModel) {
                Yii::app()->user->setState('enterpriseId', $infoModel->id);
                Yii::app()->user->setState('enterpriseAuditing', $infoModel->auditing);
            }
        }
    }

    /**
     * 客户端 验证操作验证码
     * @param string $encodes 加密的验证码
     * @return boolean 是否通过
     */
    public function verifyOperateCode($encodes) {
        $rsa = new RSA();
        $decodes = $rsa->decrypt($encodes);
        if (strpos($decodes, ',') !== false) {
            $ary = explode(',', $decodes);
            $this->addLog('apiLog', "\r\n operateCode", $ary);
            if (count($ary) == '3' && $ary[2]) {
                if ($this->checkVerifyCode($ary[2])) {
                    $this->username = $ary[0];
                    $this->password = $ary[1];
                    $this->checkIdentity();
                    return $this->member;
                }
            }
        }
        $this->errorEndXml('操作验证码错误');
    }

    /**
     * 生成验证码缓存
     * @param string $content 内容
     * @param string|int $expire 有效时间
     * @return string 随机码
     */
//    public function createValifyCode($content='gw',$expire='1800') {
//        $code = $this->makeCode();
//        $stat = Tool::cache(self::CODE_CACHE)->add($code, $content, $expire);//15min
//        $this->addLog('apiLog',"code: ".$code.", content: ".$content.", seconds: ".$expire."\r\nstatus: ".$stat);
//        return $code;
//    }
    public function createValifyCode($content = 'gw', $expire = '1800') {
        $code = $this->makeCode($content, $expire);
        $this->addLog('apiLog', "code: " . $code . ", content: " . $content . ", seconds: " . $expire);
        return $code;
    }

    /**
     * 递归产生唯一随机码
     * @return string
     */
//    public function makeCode(){
//        $code = (time() - strtotime(date('Y-m-d'))) . sprintf("%05d", mt_rand(1, 99999));//前5位 + 后5位
//        if(Tool::cache(self::CODE_CACHE)->offsetExists($code)){
//            $code = $this->makeCode();
//        }
//        return $code;
//    }
    public function makeCode($content, $expire) {
        $stat = false;
        $code = (time() - strtotime(date('Y-m-d'))) . sprintf("%05d", mt_rand(1, 99999)); //前5位 + 后5位
        $res = Yii::app()->db->createCommand()->from('{{checkcode}}')->where("phone='{$code}'")->queryRow();
        if (!empty($res)) {
            if ($res['overtime'] < time()) {
                // update
                $stat = Yii::app()->db->createCommand()->update('{{checkcode}}', array('checkcode' => $content, 'overtime' => time() + $expire), "phone='{$code}'");
            }
        } else {
            //insert
            $stat = Yii::app()->db->createCommand()->insert('{{checkcode}}', array('phone' => $code, 'checkcode' => $content, 'overtime' => time() + $expire));
        }
        if ($stat == false)
            $code = $this->makeCode($expire);
        return $code;
    }

    /**
     * 生成验证码缓存
     * @param string $content 内容
     * @param string|int $expire 有效时间
     * @return string 随机码
     */
//    public function createPhoneValifyCode($phone,$expire='60') {
//        if(Tool::cache(self::CODE_CACHE)->offsetExists($phone)){
//            $this->errorEndXml('验证码已经生效,请不要重复生成');
//        }
//        $code = substr(microtime(),3,2) . sprintf("%04d", mt_rand(1, 9999));//前5位 + 后5位
//        $stat = Tool::cache(self::CODE_CACHE)->add($phone, $code, $expire);//15min
//        $this->addLog('apiLog',"phonecode: ".$phone.", content: ".$code.", seconds: ".$expire."\r\nstatus: ".$stat);
//        return $code;
//    }
    public function createPhoneValifyCode($phone, $expire = '300') {
        $code = substr(microtime(), 3, 2) . sprintf("%04d", mt_rand(1, 9999)); //前5位 + 后5位
        $sql = "replace into {{checkcode}} (phone,checkcode,overtime) values('{$phone}','{$code}'," . (time() + $expire) . ")";
        if (Yii::app()->db->createCommand($sql)->execute()) {
            return $code;
        }
//        $res = Yii::app()->db->createCommand()->from('{{checkcode}}')->where("phone='{$phone}'")->queryRow();
//        if(!empty($res)){
//            if($res['overtime'] > time()){
//                // update
//                $stat = Yii::app()->db->createCommand()->update('{{checkcode}}', 
//                        array('checkcode'=>$code,'overtime'=>time() + $expire),"phone='{$phone}'");
//            }else{
//                $this->errorEndXml('验证码已经生效,请不要重复生成');
//            }
//        }else{
//            //insert
//            $stat = Yii::app()->db->createCommand()->insert('{{checkcode}}', 
//                    array('phone'=>$phone,'checkcode'=>$code,'overtime'=>time() + $expire));
//        }
//        return $code;
    }

    /**
     * 检验验证码是否正确
     * @param string $encode 密文验证码
     * @param string $content 内容
     * @return bool 是否正确
     */
//    public function checkVerifyCode($code,$content='gw') {return true;
////        usleep(200000);//1000 000
//        if (Tool::cache(self::CODE_CACHE)->offsetExists($code)) {
//            $value = Tool::cache(self::CODE_CACHE)->get($code);
//            if($content == $value){
//                Tool::cache(self::CODE_CACHE)->delete($code);
//                $this->addLog('apiLog',"func: " . __FUNCTION__ . "\r\ncode: ".$code.", content: ".$content.", ckecked");
//                return true;
//            }else{
//                $this->addLog('apiLog',"func: " . __FUNCTION__ . "\r\ncode: ".$code.", content: ".$content.", is wrong");
//                $this->errorEndXml('验证码错误');
//            }
//        }else{
//            $this->addLog('apiLog',"func: " . __FUNCTION__ . "\r\ncode: ".$code.", content: ".$content.", not exists ".Tool::cache(self::CODE_CACHE)->get($code));
//            $this->errorEndXml('验证码不存在');
//        }
//    }
    public function checkVerifyCode($code, $content = 'gw') {
        $res = Yii::app()->db->createCommand()->from('{{checkcode}}')->where("phone='{$code}'")->queryRow();
        if (!empty($res)) {
            if ($res['overtime'] < time()) {
                // del
                Yii::app()->db->createCommand()->delete('{{checkcode}}', "phone='{$code}'");
                $this->errorEndXml('验证码超时');
            } else {
                if ($content == $res['checkcode']) {
                    Yii::app()->db->createCommand()->delete('{{checkcode}}', "phone='{$code}'");
                    $this->addLog('apiLog', "func: " . __FUNCTION__ . "\r\ncode: " . $code . ", content: " . $content . ", ckecked");
                    return true;
                } else {
                    $this->addLog('apiLog', "func: " . __FUNCTION__ . "\r\ncode: " . $code . ", content: " . $content . ", is wrong");
                    $this->errorEndXml('验证码错误');
                }
            }
        } else {
            $this->addLog('apiLog', "func: " . __FUNCTION__ . "\r\ncode: " . $code . ", content: " . $content . ", not exists ");
            $this->errorEndXml('验证码不存在');
        }
    }

    /**
     * 价格转换积分
     * @param float $price
     * @return float
     */
    public function convertPrice($price) {
        $member = $this->getSession('member');
        if ($member) {
            Yii::app()->user->setState('typeId', $member['type_id']);
        }
        return Common::convert($price);
    }

    /**
     * 接口输出正确的xml数据
     * @param string $actionType
     * @param string $data
     * @return xml
     */
    public function exportXml($data) {
        header("Content-type:text/xml;charset=utf-8");
        $xmlString = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<Response ActionType="$this->actionType">
$data
<ResultCode>1</ResultCode>
</Response>
XML;
        return $xmlString;
    }

    /**
     * 接口输出错误的xml数据
     * @param string $actionType
     * @param string $message
     * @return xml
     */
    public function errorXml($message, $node = '') {
        header("Content-type:text/xml;charset=utf-8");
        $xmlString = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<Response ActionType="$this->actionType">
<ResultCode>0</ResultCode>
<ResultDesc>$message</ResultDesc>$node
</Response>
XML;
        return $xmlString;
    }

    public function errorEndXml($message, $node = '') {
        $message = str_replace("<", "&lt;", str_replace("&", "&amp;", $message));   //处理xml非法字符
        $message = Yii::t('appApi', $message);
        echo $this->errorXml($message, $node);
        Yii::app()->end();
    }

    /**
     * 灵活输出xml数据
     * @param string $actionType
     * @param string $data
     * @return xml
     */
    public function exportXmlEx($data = '', $ResultCode = 0, $message = '', $end = true) {
        header("Content-type:text/xml;charset=utf-8");
        $message = $message ? "<ResultDesc>{$message}</ResultDesc>" : '';
        $xmlString = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<Response ActionType="$this->actionType">
$data
$message
<ResultCode>$ResultCode</ResultCode>
</Response>
XML;
        echo $xmlString;
        if ($end)
            Yii::app()->end();
    }

    /**
     * @return CFormatter  数据格式化
     */
    public function format() {
        return Yii::app()->format;
    }

    /**
     * @param int time 时间戳
     * @return CFormatter  时间式化
     */
    public function formatDatetime($time = 0) {
        return $time ? Yii::app()->format->formatDatetime($time) : 0;
    }

    /**
     * 获取后台配置的常用参数数据
     * @param string $name  文件名称，例如site.config.inc,$name = 'site'
     * @param string $key 该配置项的键名
     * @return string
     */
    public function getConfig($name, $key = null) {
        return Tool::getConfig($name, $key);
    }

    public function checkUserNameBySession($username, $member) {
        if (strtolower($username) == strtolower($member['username']) || strtolower($username) == strtolower($member['gai_number']) || $username == $member['mobile']) {
            return true;
        }
        return false;
    }

    public function addLog($fileName, $content = '', $array = array()) {
        $root = Yii::getPathOfAlias('root');
        $path = $root . DS . 'backend' . DS . 'runtime' . DS . $fileName;
        $str = "\r\n------------------------------------------\r\n" .
                "ctr: " . $this->getId() . ", act: " . $this->getAction()->getId() . ", time: " . date("m-d H:i:s") .
                "\r\n" . $content;
        if (!empty($array)) {
            $str .= "\r\n";
            if (is_array($array))
                $str .= $this->makeLogArray2Str($array);
            else
                $str .= $array;
        }
        $str .= "\r\n";
        @file_put_contents($path, $str, FILE_APPEND);
    }

    public function makeLogArray2Str($array) {
        $str = "array => (";
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $str .= "   " . $this->makeLogArray2Str($val) . ",";
            } else {
                $str .= " $key => $val,";
            }
        }
        $str .= ")";
        return $str;
    }

    public function updateMemberSession($memberId, $item = array()) {
        $receiveData = $hotelCount = $orderCount = $memberNew = array();
        // 更新session
        if (empty($item) || in_array('member', $item)) {
            $memberNew = Yii::app()->db->createCommand()
                    ->from('{{member}}')->where('id=:id', array(':id' => $memberId))
                    ->queryRow();
            $this->setSession('member', $memberNew);
        }
        // 订单数
        if (empty($item) || in_array('goodsOrderCount', $item)) {
            $orderCount = Yii::app()->db->createCommand()
                    ->select(array('count(1) as num'))->from('{{order}}')
                    ->where('member_id=:mid AND `status`<:status', array(':mid' => $memberId, ':status' => Order::STATUS_COMPLETE))
                    ->queryScalar();
            $this->setSession('goodsOrderCount', $orderCount);
        }
        // 酒店数
        if (empty($item) || in_array('hotelOrderCount', $item)) {
            $hotelCount = Yii::app()->db->createCommand()
                    ->select(array('count(1) as num'))->from('{{hotel_order}}')
                    ->where('member_id=:mid AND `status`<:status', array(':mid' => $memberId, ':status' => HotelOrder::STATUS_SUCCEED))
                    ->queryScalar();
            $this->setSession('hotelOrderCount', $hotelCount);
        }
        // 收货地址
        if (empty($item) || in_array('receiveMessage', $item)) {
            $receiveData = Yii::app()->db->createCommand()
                    ->select(array('id', 'real_name', 'mobile', 'province_id', 'city_id', 'district_id', 'street'))
                    ->from('{{address}}')
                    ->where('member_id=:member_id', array(':member_id' => $memberId))
                    ->queryAll();
            $this->setSession('receiveMessage', $receiveData);
        }
    }

    /**
     * 获取用户(盖网通用)
     * @param int $userPhone
     * @return array $result 会员信息
     */
    public function findMemberByPhone($userPhone) {
        $result = ApiMember::getMemberByPhone($userPhone);
        if (!is_array($result) && is_string($result)) {
            $this->errorEndXml($result);
        }
        return $result;
    }

    /**
     * 格式化金额
     * @param float $price 人民币
     * @return string 金额
     */
    public function formatPrice($price) {
        if (!is_numeric($price))
            return $price;
        $outPrice = '';
        $rate = 1;
        if (Yii::app()->language == 'zh_tw' || Yii::app()->language == 'en') {
            if (!$rate = Tool::cache('common')->get('hk_rate')) {
                $from = 'CNY';  // 人民币
                $to = 'HKD';    // 香港币
                // WebService   实时汇率
                $url = "http://www.webservicex.net/CurrencyConvertor.asmx/ConversionRate?FromCurrency=$from&ToCurrency=$to";
                $doc = new DOMDocument();
                $doc->load($url);
                $ele = $doc->getElementsByTagName("double");
                $rate = $ele->item(0)->nodeValue;   // 获取汇率
                Tool::cache('common')->set('hk_rate', $rate, 86400); // 缓存保留一天
            }
            $outPrice = sprintf("%.2f", $price * $rate);
        } else {
            $outPrice = $price;
        }
        return $outPrice;
    }

    public function formatScore($float, $save = 2) {
        $n = pow(10, $save);
        return floor($float * $n) / $n;
    }

    /**
     * @param $deviceToken 设备Token值
     * @param $message 信息内容
     */
    public function pushApple($deviceToken, $message) {
        set_time_limit(600);
        $certPath = Yii::getPathOfAlias('keyPath') . DS . 'dpush.pem'; //证书
        $passphrase = '123456'; //证书密码
        // 内容
        $body = array("aps" => array("alert" => $message, "badge" => 1, "sound" => 'received5.caf'));
        // 推送
        $ctx = stream_context_create();
        stream_context_set_option($ctx, "ssl", "local_cert", $certPath);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        $err = $errstr = '';
        $fp = stream_socket_client("ssl://gateway.sandbox.push.apple.com:2195", $err, $errstr, 260, STREAM_CLIENT_CONNECT, $ctx);
        if (!$fp) {
            $this->errorEndXml("Failed to connect {$err}");
//            $this->errorEndXml("Failed to connect {$err} {$errstr}");
        }
        $payload = json_encode($body);
        $msg = chr(0) . pack("n", 32) . pack("H*", $deviceToken) . pack("n", strlen($payload)) . $payload;
        fwrite($fp, $msg);
        fclose($fp);
        return $body;
    }

    /**
     * 盖网通发过来解密
     * @param array|string $post
     * @param unknown_type $is_public
     * @return Ambigous <string, multitype:, string|array>|boolean
     */
    protected function _decrypt($post) {
        if (is_array($post)) {
            $data = array();   //保存解密后的数组
            $rsa = new RSA();
            foreach ($post as $key => $value) {
                if (in_array($key, $this->encrypt_field)) {  //对需要解密的非盖机编码的字段使用新的私钥解密
                    $data[$key] = $rsa->decrypt($value);
                } else {
                    $data[$key] = $value;
                }
            }
            return $this->magicQuotes($data);
        } else if (is_string($post)) {   //单个解密
            $rsa = new RSA();
            return $this->magicQuotes($rsa->decrypt($post));
        }
    }

}
