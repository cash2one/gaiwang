<?php
/**
 * 汇卡支付
 * @author zhenjun_xu <412530435@qq.com>
 *
 * @var string $code 订单编号
 * @var float $money 订单金额
 * @var string $backUrl  支付结果接收URL
 * @var string $parentCode 母订单串
 * @var int $orderType 订单类型
 */
$money=$money;
$params = array('orderType'=>$orderType,'parentCode'=>$parentCode,'gw'=>Yii::app()->user->gw,'code'=>$code);
$orderArray = array(
    'merId'=>HI_MERCHANT_ID,
    'settleNo'=>HI_SETTLE_NO,
    'organNo'=>HI_MEMBER_ID,
    'pwd'=>HI_PWD,
    'orderNo'=>$parentCode,
    'transType'=>0,
    'currCode'=>'CNY',
    'charge'=>1,
    'orderAmount'=>sprintf('%0.2f',$money),
    'gateType'=>'B',
    'gateId'=>'03',
    'callBackUrl'=>$backUrl.'?'.http_build_query($params), //交易结果后台接收URL
    'bgRetUrl'=>Yii::app()->createAbsoluteUrl('/result/hipay',$params),
    'resultMode'=>0,//支付结果返回方式,0=成功和失败支付结果均返回
);
$orderString = '';
foreach($orderArray as $k=>$v){
    $orderString .= $k.'='.$v.'&';
}
$orderString = rtrim($orderString,'&');
//var_dump($orderString);exit;
//对原始信息进行加密
if(OnlinePay::encryptMsg($orderString)){
    $encryptedMsg = OnlinePay::$LastResult;
}else{
    echo 'EncryptMsg() Return:' . OnlinePay::$LastErrMsg . '<br>';
    echo '<script>var flag = false; </script>';
}
//对原始信息进行签名
if(OnlinePay::signMsg($orderString)){
    $signedMsg = OnlinePay::$LastResult;
}else{
    echo 'SignMsg() Return:' . OnlinePay::$LastErrMsg . '<br>';
    echo '<script>var flag = false; </script>';
}
?>
<form method="post" name="SendOrderForm"  action="<?php echo HI_PAY_URL ?>" target="_blank">
    <input type="hidden" name="msg" value="<?php echo $encryptedMsg; ?>">
    <input type="hidden" name="signMsg" value="<?php echo $signedMsg; ?>">
</form>