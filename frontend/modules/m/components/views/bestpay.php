<?php
/** @var $model Recharge */
/** @var $this BestPayController */
/**
 * 翼支付
 *
 * 需要传三个参数过来
 * @var string $code 订单编号
 * @var float $money 订单金额
 * @var string $backUrl 支付结果接收URL
 * @var string $parentCode 母订单串,交易流水
 * @var int $orderDate 订单日期
 * @var string $orderDesc 订单描述
 * @var string $orderType 订单类型
 */
$money=sprintf('%0.2f', $money);
$mac = 'MERCHANTID='.BEST_MER_CODE.'&ORDERSEQ='.$code.'&ORDERDATE='.$orderDate.'&ORDERAMOUNT='.$money.'&KEY='.BEST_KEY;
$mac = md5($mac);
$attach = implode('XXX',array($orderType,$code,Yii::app()->user->gw));
?>
<form  method="post" name="SendOrderForm"  action="<?php echo BEST_WAPPAY_URL ?>">
    <input type="hidden" name="MERCHANTID" value="<?php echo BEST_MER_CODE ?>"/>
    <input type="hidden" name="ORDERSEQ" value="<?php echo $code ?>" />
    <input type="hidden" name="ORDERREQTRANSEQ" value="<?php echo $parentCode ?>"/>
    <input type="hidden" name="ORDERDATE" value="<?php echo $orderDate ?>"/>
    <input type="hidden" name="PRODUCTAMOUNT" value='<?php echo $money ?>'/>
    <input type="hidden" name="ATTACHAMOUNT" value='0.00'/>
    <input type="hidden" name="ORDERAMOUNT" value='<?php echo $money ?>'/>
    <input type="hidden" name="CURTYPE" value="RMB"/>
    <input type="hidden" name="ENCODETYPE" value="1"/>
    <input type="hidden" name="MERCHANTURL" value="<?php echo $backUrl ?>"/>
    <input type="hidden" name="BACKMERCHANTURL" value="<?php echo Tool::getConfig('payapi','ip') ?>bestWappay"/>
    <input type="hidden" name="ATTACH" value='<?php echo $attach ?>'/>
    <input type="hidden" name="BUSICODE" value="0001"/>
    <input type="hidden" name="PRODUCTID" value="08"/>
    <input type="hidden" name="TMNUM" value=""/>
    <input type="hidden" name="CUSTOMERID" value="<?php echo Yii::app()->user->gw;?>"/>
    <input type="hidden" name="PRODUCTDESC" value="<?php echo $orderDesc ?>"/>
    <input type="hidden" name="MAC" value="<?php echo $mac; ?>"/>
</form>