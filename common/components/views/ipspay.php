<?php
/** @var $model Recharge */
/**
 * 银联支付 v36 接口提交订单支付
 * 需要传三个参数过来
 * @var string $code 订单编号
 * @var float $money 订单金额
 * @var string $backUrl  支付结果接收URL
 * @var string $parentCode 母订单串
 * @var int $orderType 订单类型
 */
?>
<?php
$money=$money;
$callBackUrl = $backUrl; //支付结果接收URL
//商户号
$merCode = IPS_MER_CODE;
//商户证书：登陆http://merchant.ips.com.cn/商户后台下载的商户证书内容
$merKey = IPS_MER_KEY;
//商户订单编号
$billno = $parentCode;
//订单金额(保留2位小数)
$amount = number_format($money, 2, '.', '');
//订单日期
$date = date('Ymd');
//币种
$currencyType = 'RMB';
//支付卡种
$gatewayType = '01';
//语言
$lang = 'GB';
//支付结果成功返回的商户URL
$merchanturl = $callBackUrl;
//支付结果失败返回的商户URL
$failUrl = $callBackUrl;
//支付结果错误返回的商户URL
$errorUrl = $callBackUrl;
//商户数据包 //多个订单同时用在线支付额外的母订单串
$attach = implode('XXX',array($orderType,$code,Tool::ip2int(Yii::app()->request->userHostAddress),Yii::app()->user->gw));
//订单支付接口加密方式 md5
$orderEncodeType = 5;
//交易返回接口加密方式 md5
$retEncodeType = 17;
//返回方式 1返回
$retType = 1;

//Server to Server 返回页面URL
$serverUrl = Tool::getConfig('payapi','ip').'ipspay';
//OrderEncodeType设置为5，且在订单支付接口的Signmd5字段中存放MD5摘要认证信息。
//交易提交接口MD5摘要认证的明文按照指定参数名与值的内容连接起来，将证书同时拼接到参数字符串尾部进行md5加密之后再转换成小写，明文信息如下：
//billno+【订单编号】+ currencytype +【币种】+ amount +【订单金额】+ date +【订单日期】+ orderencodetype +【订单支付接口加密方式】+【商户内部证书字符串】
//例:(billno000001000123currencytypeRMBamount13.45date20031205orderencodetype5GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ)
//订单支付接口的Md5摘要，原文=订单号+金额+日期+支付币种+商户证书
$orge = 'billno'.$billno.'currencytype'.$currencyType.'amount'.$amount.'date'.$date.'orderencodetype'.$orderEncodeType.$merKey ;
//echo '明文:'.$orge ;
//$SignMD5 = md5('billno'.$Billno.'currencytype'.$Currency_Type.'amount'.$Amount.'date'.$Date.'orderencodetype'.$OrderEncodeType.$Mer_key);
$signMD5 = md5($orge) ;
//echo '密文:'.$signMD5 ;
?>
<form action="<?php echo IPS_PAY_URL ?>" method="post" id="frm1" target="_blank" name="SendOrderForm">
    <input type="hidden" name="Mer_code" value="<?php echo $merCode ?>">
    <input type="hidden" name="Billno" value="<?php echo $billno ?>">
    <input type="hidden" name="Amount" value="<?php echo $amount ?>" >
    <input type="hidden" name="Date" value="<?php echo $date ?>">
    <input type="hidden" name="Currency_Type" value="<?php echo $currencyType ?>">
    <input type="hidden" name="Gateway_Type" value="<?php echo $gatewayType ?>">
    <input type="hidden" name="Lang" value="<?php echo $lang ?>">
    <input type="hidden" name="Merchanturl" value="<?php echo $merchanturl ?>">
    <input type="hidden" name="FailUrl" value="<?php echo $failUrl ?>">
    <input type="hidden" name="ErrorUrl" value="<?php echo $errorUrl ?>">
    <input type="hidden" name="Attach" value="<?php echo $attach ?>">
    <input type="hidden" name="OrderEncodeType" value="<?php echo $orderEncodeType ?>">
    <input type="hidden" name="RetEncodeType" value="<?php echo $retEncodeType ?>">
    <input type="hidden" name="Rettype" value="<?php echo $retType ?>">
    <input type="hidden" name="ServerUrl" value="<?php echo $serverUrl ?>">
    <input type="hidden" name="SignMD5" value="<?php echo $signMD5 ?>">
</form>