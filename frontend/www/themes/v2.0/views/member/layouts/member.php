<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content="盖网,网上购物,网上商城,积分兑换,积分消费,手机,笔记本,电脑,数码,服装,手表,化妆品,保健品,盖象商城"/>
    <meta name="Description" content="盖网,盖象商城-中国最大的网上购物及积分兑换消费商城，便捷，诚信的服务,为您提供愉悦的网上商城购物体验!"/>
    <title><?php echo CHtml::encode($this->pageTitle) ?></title>
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/styles/global.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/styles/module.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/styles/member.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/styles/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <script src="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/js/jquery.gate.common.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo DOMAIN.Yii::app()->theme->baseUrl;?>/js/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN ?>/js/jquery.tips.js"></script>
    <script src="<?php echo Yii::app()->theme->baseUrl; ?>/js/layer/layer.js"></script>
</head>
<body>
<!-- 头部start -->
<?php $this->renderPartial('//layouts/_top_v20'); ?>
<?php $this->renderPartial('//member/layouts/_top2'); ?>
<!-- 头部end -->

<!--主体start-->
<div class="member-contain clearfix address-receiving">
    <?php 
    if($this->id=="goodsCollect" || $this->id=="storeCollect"||$this->id=="goodscollect" || $this->id=="storecollect"){
        echo $content;
    }elseif($this->id=="enterprise" || $this->id=="enterpriseLog"){
        $this->renderPartial('//member/layouts/_enterpriseLeft');
         echo $content;
    }else{
        $this->renderPartial('//member/layouts/_left');
        echo $content;
    }      
    ?>      
</div>
<!-- 主体end -->
<!-- 底部start -->
<?php $this->renderPartial('//layouts/_footer_v20'); ?>
<!-- 底部end -->
<?php $this->renderPartial('//member/layouts/_msg'); ?>
<script>
	$(function () {
		//提醒卖家发货
		$(".myorder-list .remind-btn").click(function () {
			$(".remind-box").show();
		});
		
		$(".remind-box .confirm-btn").click(function () {
			$(".remind-box").hide();
		});
		//判断是否有符合的商品
		if ($(".myorder-list .list-item").size() == 0) {
			$(".no-product").show();
		} else {
			$(".no-product").hide();
		}
		
		$.ajax({
			type: "GET",
			dataType: "json",
			url: "<?php echo $this->createAbsoluteUrl('/member/site/getNewMessage') ?>",
			data: {},
			success: function(data) {
				$('#message_num').html(data.count);
			}
		});
	});
</script>
<!--<script src="<?php //echo $this->theme->baseUrl; ?>/js/ShoppingCart.js"></script>-->
</body>
</html>