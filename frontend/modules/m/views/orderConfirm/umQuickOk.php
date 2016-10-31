<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $this->pageTitle?>_付款成功</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/global.css" type="text/css"></link>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/comm.css" type="text/css"></link>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/member.css" type="text/css"></link>
</head>
  
  <body>
  <div class="wrap">
 	<div class="header" id="js-header">
		<div class="mainNav">
			<div class="topNav clearfix">
				<a class="icoBlack fl" href="javascript:history.go(-1);"></a>
				<?php if (!isset($result['errorMsg'])): ?>
				<a class="TxtTitle fl" href="javascript:void(0);">结算成功</a>
				<?php else: ?>
				<a class="TxtTitle fl" href="javascript:void(0);">结算失败</a>
				<?php endif;?>
			</div>
		</div>
	</div>
	<?php if (!isset($result['errorMsg'])): ?>
    <div class="main">
    	<div class="rsTag"><img src="<?php echo DOMAIN ?>/images/bg/seller_iconSuccess.gif" width="71" height="70"><?php echo Yii::t('memberRecharge','您已经付款成功'); ?></div>
    	<div class="rsinfo">金额：<span><?php echo HtmlHelper::formatPrice($result['money']);?></span></div>
    	<input type="button" value="返回订单" class="loginSub" onclick="location.href='/order/index'"/>
    </div>
   <?php else: ?>
   <div class="main">
    	<div class="rsTag"><img src="<?php echo DOMAIN ?>/images/bg/rateimg02.png" width="71" height="70">
    	<?php echo Yii::t('memberRecharge',$result['errorMsg']);?>
    	</div>
    	<input type="button" value="返回订单" class="loginSub" onclick="location.href='/order/index'"/>
    </div>
  <?php endif;?>
   </div>
  </body>
</html>
