<?php
/** @var $model Recharge */
/** @var $this GhtPayController */
/**
 * 高汇通支付
 *
 * @var string $code 订单编号
 * @var float $money 订单金额
 * @var string $backUrl 支付结果接收URL
 * @var string $parentCode 母订单串,交易流水
 * @var int $orderDate 订单日期
 * @var string $orderDesc 订单描述
 * @var string $orderType 订单类型
 */
$money=$money;
$attach = implode('XXX',array($orderType,$code,Tool::ip2int(Yii::app()->request->userHostAddress),Yii::app()->user->gw,$zfType));
$receiveUrl= Tool::getConfig('payapi','ip').'ghtpay';
$key=$zfType==OnlinePay::PAY_GHT ? GHT_MD5KEY :GHTKJ_MD5KEY;
$memno=$zfType==OnlinePay::PAY_GHT ? GHT_MERCHANT_ID :GHTKJ_MERCHANT_ID;
$terno=$zfType==OnlinePay::PAY_GHT ? GHT_TERMINAL_ID :GHTKJ_TERMINAL_ID;
$postUrl=GHT_WEBPAY_URL;
$map=array(
        'busi_code'=>'PAY',
        'merchant_no'=>$memno,
        'terminal_no'=>$terno,
        'order_no'=>$parentCode,
        'amount'=>$money,
        'currency_type'=>'CNY',
        'sett_currency_type'=>'CNY',
        'product_name'=>'盖象商城-'.Yii::app()->user->gw,
        'return_url'=>$backUrl,
        'notify_url'=>$receiveUrl,
        'base64_memo'=>base64_encode($attach),
        'sign_type'=>'SHA256',
);
$signOrigStr='';
$plain=RsaPay::plain($map);
$signOrigStr=$plain."&"."key=".$key;
$signMsg=strtolower(hash("sha256",$signOrigStr));
$map['sign']=$signMsg;
ksort($map);
?>
<form  method="get" target="_blank" name="SendOrderForm"  action="<?php echo GHT_WEBPAY_URL;?>">
   <?php foreach($map as $k => $v): ?>
      <input type="hidden" name="<?php echo $k;?>" value="<?php echo $v;?>"/> 
   <?php endforeach;?> 
</form>