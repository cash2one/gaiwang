<?php 
$cs = Yii::app()->clientScript;
$cs->registerCssFile($this->theme->baseUrl . '/styles/global.css');
$cs->registerCssFile($this->theme->baseUrl . '/styles/module.css');
$cs->registerCssFile($this->theme->baseUrl.'/styles/register.css');
$cs->registerScriptFile($this->theme->baseUrl.'/js/jquery-1.9.1.js');
$cs->registerScriptFile($this->theme->baseUrl.'/js/jquery.gate.common.js');

$cName=$this->action->id;
?>
<div class="coverTenpay-top" id="coverTenpay-top">
    <div class="w1200 clearfix">
        <div class="left">
            <a href="<?php echo DOMAIN ?>"><img src="<?php echo $this->theme->baseUrl ?>/images/temp/register_logo.jpg" width="213" height="86" /></a>
        </div>
        <div class="right">
            <a <?php if($cName=='index'):?> class=on <?php endif;?> href="<?php echo $this->createAbsoluteUrl('/gwkey') ?>">盖象优选</a>
            <a <?php if($cName=='pay'):?> class=on <?php endif;?> href="<?php echo $this->createAbsoluteUrl('/gwkey/site/pay') ?>">盖付通</a>
            <a <?php if($cName=='shopkeeper'):?> class=on <?php endif;?> href="<?php echo $this->createAbsoluteUrl('/gwkey/site/shopkeeper') ?>">盖掌柜</a>
            <a <?php if($cName=='uwpPay'):?> class=on <?php endif;?> href="<?php echo $this->createAbsoluteUrl('/gwkey/site/uwpPay') ?>">UWP盖付通</a>
            <a <?php if($cName=='uwpShopkeeper'):?> class=on <?php endif;?> href="<?php echo $this->createAbsoluteUrl('/gwkey/site/uwpShopkeeper') ?>">UWP盖掌柜</a>
            <a <?php if($cName=='gxt'):?> class=on <?php endif;?> href="<?php echo $this->createAbsoluteUrl('/gwkey/site/gxt') ?>">盖讯通</a>
            <a href="<?php echo $this->createAbsoluteUrl('/contact') ?>">联系我们</a>
        </div>
    </div>
</div>