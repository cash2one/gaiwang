<?php
class PushTool{

    public $tableName = '{{app_push}}';
    public $primaryKey = 'id';

    const RECEIVER_TYPE_OFFICIAL = 0;
    const RECEIVER_TYPE_IMEI = 1;
    const RECEIVER_TYPE_TAG = 2;
    const RECEIVER_TYPE_ALIAS = 3;
    const RECEIVER_TYPE_APPKEY = 4;

    const SYSTEM_TYPE_ALL = 0;
    const SYSTEM_TYPE_APPLE = 1;
    const SYSTEM_TYPE_ANDROID = 2;

    const PLATFORM_OFFICIAL  = 0;
    const PLATFORM_OTHER = 1;

    const STATUS_NEW = 0;
    const STATUS_SEND = 1;
    const STATUS_FAIL = 2;
    const STATUS_READ = 3;

    public function appleJPush($targetId,$message,$title=''){
        $master_secret = 'c8735fa689bfd23eb6257e45';
        $app_key='a529cd21e3f759451dad93c8';
        /**
         *  @param $master_secret
         *  @param $app_key
         *  @param $targetId
         * @param $message
         * @param $title
         */
        $jpushPath = Yii::getPathOfAlias('application') . DS . 'extensions' . DS . 'jpush' . DS;
        $output = include $jpushPath.'applePush.php';
        $this->addPush($title,$message,$targetId,self::RECEIVER_TYPE_ALIAS,self::SYSTEM_TYPE_APPLE,self::PLATFORM_OTHER,$output['status'],$output['code'],$output['message']);
        var_dump($output);
    }

    /**
     * @param $deviceToken 设备Token值
     * @param $message 信息内容
     */
    public function pushApple($deviceToken,$message){
        set_time_limit(600);
        $certPath = Yii::getPathOfAlias('keyPath').DS.'dpush.pem';//证书
        $passphrase = '123456';//证书密码
        // 内容
        $body = array("aps" => array("alert" => $message, "badge" => 1, "sound" => 'received5.caf'));
        // 推送
        $ctx = stream_context_create();
        stream_context_set_option($ctx, "ssl", "local_cert", $certPath);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
        $err = $errstr = '';
        $fp = stream_socket_client("ssl://gateway.sandbox.push.apple.com:2195", $err, $errstr, 260, STREAM_CLIENT_CONNECT, $ctx);
        if (!$fp) {
            $status = self::STATUS_FAIL;
        }else{
            $payload = json_encode($body);
            $msg = chr(0) . pack("n",32) . pack("H*", $deviceToken) . pack("n",strlen($payload)) . $payload;
            fwrite($fp, $msg);
            $status = self::STATUS_SEND;
        }
        fclose($fp);
        $this->addPush('',$message,$deviceToken,self::RECEIVER_TYPE_OFFICIAL,self::SYSTEM_TYPE_APPLE,self::PLATFORM_OFFICIAL,$status,$err,$errstr);
        if(!$fp) $this->errorEndXml("Failed to connect {$err}");
        return $body;
    }
    /**
     *
     * @param string $content 内容
     * @param string $receiverId 设备id
     * @param int $receiverType 接收者类型token,别名
     * @param int $systemType 客户端系统类型
     * @param int $platform 推送平台
     * @param int $errcode
     * @param int $status
     * @param string $title
     * @param string $errmsg
     */
    public function addPush($title='',$content,$receiverId,$receiverType,$systemType,$platform,$status,$errcode,$errmsg=''){
        $data = array(
            'title' => $title,
            'content' => $content,
            'errcode' => $errcode,
            'errmsg' => $errmsg,
            'receiver_id' => $receiverId,
            'receiver_type' => $receiverType,
            'sys_type' => $systemType,
            'platform' => $platform,
            'create_time' => time(),
            'status' => $status,
        );
        Yii::app()->dbl->createCommand()->insert('{{app_push}}',$data);
    }
}

?>