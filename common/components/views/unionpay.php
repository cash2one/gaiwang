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
$EntryMode = '';
$strPKey = UNION_MER_KEY;
$MerId = UNION_MEMBER_ID; //商户ID参数
$OrderNo = $parentCode; //每次提交的订单号要不一样，否则会提示订单号重复
$OrderAmount = $money; //订单金额，格式：元.角分
$CurrCode = "CNY"; //货币代码，值为：CNY
$CallBackUrl = $backUrl; //支付结果接收URL，要根据自己的接收URL填写
$ResultMode = "0";
$BankCode = "";
// $parentCode 多个订单同时用在线支付额外的母订单串
$Reserved01 = implode('XXX',array($orderType,$code,Tool::ip2int(Yii::app()->request->userHostAddress),Yii::app()->user->gw));
$Reserved02 = '';
$type = "B2C";
$SourceText = $MerId . $OrderNo . $OrderAmount . $CurrCode . $type . $CallBackUrl . $ResultMode . $BankCode . $EntryMode . $Reserved01 . $Reserved02;
//对原始信息进行加密
$SignedMsg = md5($SourceText . md5($strPKey));
?>
<form method="post" name="SendOrderForm"  action="<?php echo UNION_PAY_URL ?>" target="_blank">
    <input type="hidden" name="SignMsg" value="<?php echo $SignedMsg; ?>">
    <input type='hidden' name="MerId" value="<?php echo $MerId; ?>">
    <input type='hidden' name="OrderNo" value="<?php echo $OrderNo; ?>">
    <input type='hidden' name="OrderAmount" value="<?php echo $OrderAmount; ?>">
    <input type='hidden' name="CurrCode" value="<?php echo $CurrCode; ?>">
    <input type='hidden' name="CallBackUrl" value="<?php echo $CallBackUrl; ?>">
    <input type='hidden' name="ResultMode" value="<?php echo $ResultMode; ?>">
    <input type='hidden' name="OrderType" value="<?php echo $type; ?>">
    <input type='hidden' name="BankCode" value="<?php echo $BankCode; ?>">
    <input type='hidden' name="EntryMode" value="<?php echo $EntryMode; ?>">
    <input type='hidden' name="Reserved01" value="<?php echo $Reserved01; ?>">
    <input type='hidden' name="Reserved02" value="<?php echo $Reserved02; ?>">
</form>