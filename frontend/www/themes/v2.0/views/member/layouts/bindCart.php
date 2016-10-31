<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="盖网,网上购物,网上商城,积分兑换,积分消费,手机,笔记本,电脑,数码,服装,手表,化妆品,保健品,盖象商城" />
    <meta name="Description" content="盖网,盖象商城-中国最大的网上购物及积分兑换消费商城，便捷，诚信的服务,为您提供愉悦的网上商城购物体验!" />
    <title><?php echo $this->pageTitle;?></title>
        <?php 
            Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/styles/module.css');
            Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/styles/global.css');
            Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl.'/styles/cart.css');
            //Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery-1.9.1.js',CClientScript::POS_HEAD);
            Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/jquery.gate.common.js',CClientScript::POS_END);
        ?>
  </head>
  <body>
        <!--头部 start-->
        <?php $this->renderPartial('/layouts/_bindTop')?>
        <!--头部 end-->
  	<!--主体start-->
        <?php echo $content?>
        <!-- 主体end -->
  	<!-- 底部start -->
	<?php $this->renderPartial('/layouts/_footer_reg'); ?>
    <!-- 底部end -->
  </body>
</html>