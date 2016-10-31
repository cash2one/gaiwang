<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $this->pageTitle?>_付款确认</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/global.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/comm.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo CSS_DOMAIN; ?>m/member.css" type="text/css"/>
    <script src="<?php echo DOMAIN ?>/js/m/jquery-2.1.1.min.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN ?>/js/artDialog/jquery.artDialog.js?skin=aero" type="text/javascript"></script>
	</head>
  <body>
  <div class="wrap">
 	<div class="header" id="js-header">
		<div class="mainNav">
			<div class="topNav clearfix">
				<a class="icoBlack fl" href="javascript:history.go(-1);"></a>
				<a class="TxtTitle fl" href="javascript:void(0);">银行付款确认</a>
			</div>
		</div>
	</div>
	<?php 
	       $bankImgArr=array(
                             '99'=>DOMAIN.'/images/m/bg/m_paymentSel3.png',
                             '2'=>DOMAIN.'/images/m/bg/m_paymentSel5.png',
                             '4'=>DOMAIN.'/images/m/bg/m_paymentSel6.png',
                             '5'=>DOMAIN.'/images/m/bg/m_paymentSel6.png',
                             '7'=>DOMAIN.'/images/m/bg/tlzf.gif'
                            );
	?>
    <div class="main">
    	<div class="rsTag"><img width="100" height="50" src="<?php echo $bankImgArr[$this->getParam('payType')]?>"></img></div>
    	<div class="rsinfo"><?php echo Yii::t('orderFlow','支付订单号'); ?>：<span><?php echo $this->getParam('code') ?></span></div>
    	<div class="rsinfo"><?php echo Yii::t('orderFlow','应付款金额'); ?>：<span><?php echo HtmlHelper::formatPrice($this->getParam('money')) ?></span></div>
    	<div class="rsinfo"> 
    	            <?php
                        if ($this->getParam('payType') == onlineWapPay::PAY_WAP_UNION):
                            $this->widget('onlineWapPay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => onlineWapPay::PAY_WAP_UNION,
                                'orderType' => $orderType,
                                'orderDesc'=>$orderDesc,
                            ));
                            endif;
                              
                        if ($this->getParam('payType') == onlineWapPay::PAY_BEST):
                            $this->widget('onlineWapPay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => onlineWapPay::PAY_BEST,
                                'orderType' => $orderType,
                                'orderDesc'=>$orderDesc,
                            ));
                            endif;
                        if ($this->getParam('payType') == onlineWapPay::PAY_UM):
                        $this->widget('onlineWapPay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => onlineWapPay::PAY_UM,
                                'orderType' => $orderType,
                                'orderDesc'=>$orderDesc,
                        ));
                        endif;     
                        if ($this->getParam('payType') == onlineWapPay::PAY_UM_QUICK):
                        $this->widget('onlineWapPay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => onlineWapPay::PAY_UM_QUICK,
                                'orderType' => $orderType,
                                'orderDesc'=>$orderDesc,
                        )); 
                        endif;   
                        if ($this->getParam('payType') == onlineWapPay::PAY_TLZF):
                        $this->widget('onlineWapPay', array(
                                'code' => $this->getParam('code'),
                                'money' => $this->getParam('money'),
                                'backUrl' => $this->createAbsoluteUrl($backUrl),
                                'orderDate' => $this->getParam('orderDate'),
                                'parentCode' => $this->getParam('parentCode'),
                                'payType' => onlineWapPay::PAY_TLZF,
                                'orderType' => $orderType,
                        ));
                        endif; 
                        ?>
    	</div>
    	<input type="button" value="确认付款" class="loginSub" onclick='paySubmit()'/>
    </div>
   </div>
  </body>
  <script>
    function paySubmit(){
        var checkUrl = "<?php echo $this->createAbsoluteUrl($checkUrl,
                    array(
                    'code'=>$this->getParam('code'),
                    'money'=>$this->getParam('money'),
                        ))
                ?>";
        art.dialog({
            lock:true,
            icon:"warning",
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>',
            content:'<?php echo Yii::t('orderFlow','请您在新打开的网上银行页面进行支付，支付完成前请不要关闭该窗口。也不要关闭本窗口，否则可能导致支付失败。') ?>',
            button:[{
                name: '<?php echo Yii::t('orderFlow','已完成支付') ?>',
                callback: function () {
                    document.location.href = checkUrl;
                },
                focus: true
            }]
        });
        document.SendOrderForm.submit();
        //循环对账
        window.countTime = 0;
        setTimeout(function () {
            window.si = setInterval(function () {
                countTime++;
                if(countTime>360) clearInterval(si); //大约半个小时后不再对账
                $.ajax({
                    url: checkUrl,
                    dataType:'json',
                    success: function (rs) {
                        if (typeof rs.errorMsg == 'undefined') {
                            document.location.href = checkUrl;
                        }
                    }
                });
            }, 5000); //每隔5秒对账一次
        }, 1000 * 10);//10秒之后去对账
    }
</script>
</html>
