<?php
/**
 * 
 * 优势联动(U无线网页支付)
 * @param array $param 
 */
$param['service']='pay_req';
$resArr=OnlineWapPay::getTradeNo($param);
$rescode=$resArr['ret_code'];
$tradeno=$resArr['trade_no'];
?>
<?php if($rescode!=0000 || empty($tradeno)):
      echo $resArr['ret_msg']."<br />";
 ?>
<?php else:?>
<form  method="get" name="SendOrderForm"  action="<?php echo UM_HTMLPAY_URL ?>" >
    <input type="hidden" name="tradeNo" value="<?php echo $tradeno ?>"/>
</form>
<?php endif;?>