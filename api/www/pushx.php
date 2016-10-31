<?php
set_time_limit(600);
$time = time();
//接收到设备发来的token,这里我手动填上。
$deviceToken = "277b8e8f8717f3da0fcd19a1e76701b7ff6f6421c8116338a04ab67461c897c0";
//构造消息体
$messege= '测试推送信息'.date('Y-m-d H:i:s');
$body = array("aps" => array("alert" => $messege, "badge" => 1, "sound" => 'received5.caf'));
$ctx = stream_context_create();
stream_context_set_option($ctx, "ssl", "local_cert", "dpush.pem");
//stream_context_set_option($ctx, "ssl", "local_cert", 'C:\wamp\www\svn-gatewang\gatewang\api\config\key\dpush.pem');
//stream_context_set_option($ctx, "ssl", "local_cert", "C:/wamp/www/svn-gatewang/gatewang/api/config/key/dpush.pem");
stream_context_set_option($ctx, 'ssl', 'passphrase', '123456');
//建立socket连接
$err = $errstr = '';
$fp = stream_socket_client("ssl://gateway.sandbox.push.apple.com:2195", $err, $errstr, 360, STREAM_CLIENT_CONNECT, $ctx);
if (!$fp) { print "Failed to connect $err $errstr"; return; }
print "Connection OK<br/>";
$payload = json_encode($body);
$msg = chr(0) . pack("n",32) . pack("H*", $deviceToken) . pack("n",strlen($payload)) . $payload;
print "sending message :" . $payload;
fwrite($fp, $msg);
fclose($fp);
echo '<br/>'.(time()-$time);