<?php
/** @var $model Recharge */
/** @var $this GhtPayController */
/**
 * EBC钱包支付
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
$sendData='ot='.$orderType.'&code='.$code.'&mem='.Yii::app()->user->gw;
//$receiveUrl= Tool::getConfig('payapi','ip').'ebcpay?'.$sendData;
$receiveUrl='http://www.gnet-mall.net/reslog/log?'.$sendData;
$key=EBC_CARD_KEY;
$merName=RsaPay::ebc_iconv_str(EBC_MERCHANT_NAME);
$proName=RsaPay::ebc_iconv_str('盖象商品_'.Yii::app()->user->gw);
$map=array(
        'merchno'=>EBC_MERCHANT_ID,
        'merchname'=>$merName,
        'dsorderid'=>$parentCode,
        'product'=>$proName,
        'userno'=>EBC_USER_ID,
        'mediumno'=>EBC_MONEY_ID,
        'cardno'=>EBC_CARDNO,
        'currency'=>'CNY',
        'transcurrency'=>'CNY',
        'amount'=>$money,
        'cardtype'=>'01',//储蓄卡
        'usertype'=>'0',
        'banktburl'=>$backUrl,
        'dsyburl'=>$receiveUrl,
);
$plain = '';
foreach($map as $k=>$v){
    $plain .= $k.'='.$v.'&';
}
$plain=substr($plain,0,-1);
$dataSign=RsaPay::ebcEncrypt($plain,$key);
/* $map['dstbdatasign']=$dataSign;
Tool::pr($map);exit; */
?>
<form  method="post" target="_blank" name="SendOrderForm"  action="<?php echo EBC_WEBPAY_URL;?>">
   <?php foreach($map as $k => $v): ?>
      <input type="hidden" name="<?php echo $k;?>" value="<?php echo $v;?>"/> 
   <?php endforeach;?> 
     <input type="hidden" name="dstbdatasign" value="<?php echo $dataSign;?>"/> 
</form>