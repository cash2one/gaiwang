<?php
// 会员中心布局文件
/* @var $this Controller */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="Keywords" content="盖网,网上购物,网上商城,积分兑换,积分消费,手机,笔记本,电脑,数码,服装,手表,化妆品,保健品,盖象商城"/>
        <meta name="Description" content="盖网,盖象商城-中国最大的网上购物及积分兑换消费商城，便捷，诚信的服务,为您提供愉悦的网上商城购物体验!"/>
        <meta name="renderer" content="webkit">
        <title><?php echo CHtml::encode($this->pageTitle) ?></title>
        <link rel="shortcut icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
        <link rel="icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
        <link href="<?php echo CSS_DOMAIN; ?>global.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo CSS_DOMAIN; ?>member.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo CSS_DOMAIN; ?>custom.css" rel="stylesheet" type="text/css"/>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script type="text/javascript" src="<?php echo DOMAIN ?>/js/jquery.tips.js"></script>
        <script src="<?php echo DOMAIN; ?>/js/jquery-gate.js" type="text/javascript"></script>
        <script src="<?php echo DOMAIN; ?>/js/jquery.gate.common.js" type="text/javascript"></script>
        <!--进度条-->
        <script type="text/javascript">
            $(document).ready(function() {
                var percent = $('.progress_bar').attr('title');
                $(".progress_bar").animate({width: percent}, 1000);
                $(".tip").tipsy({gravity: 's', fade: true});
            });
        </script>
        <!--进度条-->
    </head>
    <body>
        <?php $this->renderPartial('/layouts/_top'); ?>
        <div class="mbPostion">
            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'homeLink' => CHtml::link(Yii::t('member','用户中心'), '/site'),
                    'links' => $this->breadcrumbs,
                ));
                ?>
            <?php endif ?>
        </div>
        <div class="mbConter">
            <?php $this->renderPartial('/layouts/_left'); ?>
            <?php echo $content; ?>
        </div>
        <?php $this->renderPartial('/layouts/_footer'); ?>
        <?php $this->renderPartial('/layouts/_msg'); ?>
        <?php //if(!$this->isMobile) $this->renderPartial('/layouts/_bindMobile',array('member'=>$this->model)); //去掉强制绑定手机号 ?>
    </body>
</html>
