<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $this->pageTitle?>_付款</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/global.css" type="text/css"></link>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/comm.css" type="text/css"></link>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/member.css" type="text/css"></link>
	<script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/member.js"></script>
</head>
  <body>
    <div class="wrap ODWrap">
	 	<div class="header" id="js-header">
			<div class="mainNav">
				<div class="topNav clearfix">
				   <?php 
				       $code=$this->getParam('code');
				       $codeArr=explode(",", $code);
				       $num=count($codeArr);
				       $url='';
				       if($num==1){
				           $url=$this->createAbsoluteUrl('order/detail',array('code'=>$code));
				       }else{
				           $url=$this->createAbsoluteUrl('order/index'); 
				       }
				      ?>
					<a class="icoBlack fl" href="<?php echo $url;?>"></a>
					<a class="TxtTitle fl" href="javascript:void(0);">付款</a>
				</div>
			</div>
		</div>
		
		<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'order-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
        'validateOnSubmit' => true,
        ),
    ));
    ?>
    
            <?php 
                    $flag=true;
                    $memberInfo=MemberPoint::getMemberPoint($member->id, $accountMoney);
                    //Tool::pr($totalPrice);
                  if(!empty($memberInfo)){
	                    $limitMoney=$memberInfo['dayLimitMoney'];
	                    $exFlag=bcsub($limitMoney,$totalPrice,2);
	                    $flag= $exFlag >= 0 ? true : false;  
                   }
                ?>     
                 
                 
	    <div class="main">
	    	<div class="OSlistTitle payTitleInfo">
   				<div class="OSlistTitleLeft2 fl">需要支付</div>
   				<div class="OSlistTitleRight fr"><?php echo HtmlHelper::formatPrice($totalPrice);?></div>
   				<div class="clear"></div>
   			</div>
   			<?php 
   			  if($isMoneyPay || !$flag ):
   			    $paty='';
   			 ?>
	    	<?php  $this->renderPartial('_payType',array(
	    	        'totalPrice'=>$totalPrice,
	    	        'accountMoney'=>$accountMoney
	    	)); ?> 
   			<?php elseif($totalPrice-$accountMoney <= 0  && ($sourceType == Order::SOURCE_TYPE_DEFAULT || $totalPrice==0)):?>
   			       <?php $paty='JF';?>   
   			<div class="ODItem ODItem2 OCList">
	    		<ul>
	    			<li>
		    			<span class="OSProducts fl cartProducts paymentTotal">
		    				<img width="100" class="fl" src="<?php echo DOMAIN; ?>/images/m/bg/m_paymentSel1.png"></img>
		    				<span class="OSProductsRight cartProductsRight fl">
		    					<span class="payTitle">盖网余额支付</span><br/>
		    					盖网余额支付便捷，安全
		    				</span>
		    				<span class="cartSel cartQSelTotal fl cartThisSel" num="1" paytype="JF" <?php if($paty=='JF'):?>style="background: url(<?php echo DOMAIN; ?>/images/m/bg/m_ioc13.png<?php endif;?>)  no-repeat;background-size:100% 100%"></span>
		    				<span class="clear"></span>
		    			</span>
		    			<span class="clear"></span>
	    			</li>
	    			<li>
    					<span class="menberLeft fl"><span style="color: #f23f36;white-space: nowrap">本日可用余额：<?php echo HtmlHelper::formatPrice($limitMoney);?></span></span>
    					<span class="menberRight payRight fr">余额：<?php echo HtmlHelper::formatPrice($accountMoney);?></span>
    					<span class="clear"></span>
	    			</li>
	    			<li>
    					<span class="menberLeft fl">盖网余额支付</span>
    					<span class="clear"></span>
	    			</li>
	    			<li class="payY">
	    				<?php echo $form->textField($model,'mobileVerifyCode', array('Placeholder'=>'请输入验证码','class' => 'fl')) ?>
	    				<div class="rBtn fr" style="cursor: pointer" id="sendOrderCode" >
	    				<span data-status="1">发送验证码</span>
	    				</div>
	    				  <?php echo $form->error($model,'mobileVerifyCode'); ?>
	    				<div  class="clear"></div>
	    			</li>
	    			
	    		</ul>
	    	</div>
	    	 <?php else:?>
	    	<!-- 当积分不够支付时或者是红包商品时，要选择其他的支付方式 -->
	    	<?php $paty='';?>
	    	<?php  $this->renderPartial('_payType',array(
	    	        'totalPrice'=>$totalPrice,
	    	        'accountMoney'=>$accountMoney
	    	)); ?> 
	    	 <?php endif;?>
	    </div>
	     <!-- 底部固定按钮 -->
	    <div class="ODFooter">
	    	<div class="OSListBtn">
	    	     <?php echo $form->hiddenField($model, 'mobile'); ?> 
   				 <?php echo $form->hiddenField($model, 'totalPrice'); ?>
                 <?php echo $form->hiddenField($model, 'payType',array('value'=>$paty)); ?>
                 <?php echo $form->error($model,'payType'); ?>
                 <?php echo $form->hiddenField($model, 'code', array('value' => $this->getParam('code'))); ?>
                 <?php echo CHtml::submitButton('确认支付', array('class' => 'OSListOnfirmBtn OCBtn')); ?>	
   			</div>
	    </div>
	    <?php $this->endWidget(); ?>
   </div>
   <?php $this->renderPartial('/home/_sendMobileCodeJs'); ?>
   <script type="text/javascript">
    $(function(){//会员注册短信发送
        sendMobileCode('#sendOrderCode','#OrderForm_mobile');
    });
</script>
  </body>
</html>
