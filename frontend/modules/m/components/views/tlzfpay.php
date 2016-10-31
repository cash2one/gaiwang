<?php
/** @var $model Recharge */
/** @var $this TlzfWapPayController */
/**
 * 通联支付
 *
 * @var string $code 订单编号
 * @var float $money 订单金额
 * @var string $backUrl 支付结果接收URL
 * @var string $parentCode 母订单串,交易流水
 * @var int $orderDate 订单日期
 * @var string $orderDesc 订单描述
 * @var string $orderType 订单类型
 */
$money=$param['money']*100;
$attach = implode('XXX',array($param['orderType'],$param['code'],Yii::app()->user->gw));
$receiveUrl=Tool::getConfig('payapi','ip').'tlzfWappay';
$map=array(
        'inputCharset'=>'1',
        'pickupUrl'=>$param['backUrl'],
        'receiveUrl'=>$receiveUrl,
        'version'=>'v1.0',
        'signType'=>'1',
        'merchantId'=>TLZF_MERCHANT_WAPID,
        'orderNo'=>$param['parentCode'],
        'orderAmount'=>$money,
        'orderDatetime'=>$param['orderDate'],
        'ext1'=>$attach,
        'payType'=>'0',
        'tradeNature'=>'GOODS',
        'key'=>TLZF_MD5KEY,
);
$plain=urldecode(http_build_query($map));
$signMsg=strtoupper(md5($plain));
?>
<form  method="post" name="SendOrderForm"  action="<?php echo TLZF_PAY_URL;?>">
   <?php foreach($map as $k => $v): ?>
      <input type="hidden" name="<?php echo $k;?>" value="<?php echo $v;?>"/> 
   <?php endforeach;?> 
    <input type="hidden" name="signMsg" value="<?php echo $signMsg;?>"/> 
</form>