<?php
/**
 * 
 * 优势联动(U快捷支付)
 *@param array $param
 */
$param['service']='pay_req_shortcut';
$resArr=OnlineWapPay::getTradeNo($param);
$rescode=$resArr['ret_code'];
$tradeno=$resArr['trade_no'];
?>
<?php 
      //协议支付
$payAgreen=PayAgreement::model()->find(array(
      'condition' => 'gw = :gw',
      'params' => array(':gw' => Yii::app()->user->gw),
    ));
?>

<?php if($rescode!=0000 || empty($tradeno)):
      echo $resArr['ret_msg']."<br />";
?>
<?php else:?>
   <?php if(!empty($payAgreen)):?>
         <form  method="post" name="SendOrderForm"  action=<?php echo Yii::app()->createAbsoluteUrl('/m/orderConfirm/umQuickPay');?> >
             <input type="hidden" name="tradeNo" value="<?php echo $tradeno ?>"/>
             <input type="hidden" name="gw" value="<?php echo Yii::app()->user->gw ?>"/>
             <input type="hidden" name="money" value="<?php echo $param['money'] ?> "/>
             <input type="hidden" name="code" value="<?php echo $param['code']; ?>"/>
             <input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken;?>"/>
         </form>  
     <?php else:?>
        <form  method="post" target="_blank" name="SendOrderForm"  action=<?php echo UM_YIHTMLPAY_URL;?> >
            <input type="hidden" name="tradeNo" value="<?php echo $tradeno ?>"/> 
            <input type="hidden" name="merCustId" value="<?php echo Yii::app()->user->gw; ?>"/>
        </form>
   <?php endif;?>
<?php endif;?>
