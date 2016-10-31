<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>付款</title>
	<link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>member.css" type="text/css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/member.css" />
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>global.css" type="text/css"/>
	<script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/jquery-2.1.1.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
  <body>
	<div class="main">
		<div class="payMethodList">
			<p class="pMTitle"><b>您已经开通的快捷支付银行卡：</b></p>
			<p class="pSTitle">已开通：<b class="red"><?php echo count($agr);?></b>张银行卡</p>
			<ul  class="couponList clearfix">
			  <?php foreach($agr as $k => $v):
				$code=$this->getParam('code');
				$getData=array(
					'id'=>$v->id,
					'parentCode'=>$code,
					'trade'=>$tradeNo,
					'money'=>$money,
					'auth'=>Tool::authcode($money.$code,'ENCODE',false,3600),
					);
				$url=UM_YIHTMLPAY_URL.'?tradeNo='.$tradeNo.'&merCustId='.$this->getUser()->gw;
			?>
				<li class="umQBitem clearfix">
				   <a href="<?php echo $this->createAbsoluteUrl('orderConfirm/agreementPay',$getData);?>">
						<div class="<?php echo $v->bank;?> PMImg"></div>
						<div class="PMNum">****<?php echo $v->bank_num;?></div>
						<div class="clear"></div>
						<div class="PMType"><?php echo PayAgreement::getCardType($v->card_type)?></div>
						<div class="clear"></div>
						<div class="PMInfo">预留手机号码<span><?php echo substr_replace($v->mobile, '****', 3, 6); ?></span></div>
				   </a>	
				</li>
				<?php endforeach;?>	
				<li class="clear"></li>
				<li style="height:50px;">
				   <a class="plusBankCard plusOtherCard" href="<?php echo $url;?>"></a>	
				</li>
				<li class="clear"></li>
			</ul>
		</div>
	</div>
            
  </body>
</html>