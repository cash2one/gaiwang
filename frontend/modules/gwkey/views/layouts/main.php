<?php
// app布局文件
/* @var $this Controller */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="<?php echo empty($this->keywords) ? '盖网,网上购物,网上商城,积分兑换,积分消费,手机,笔记本,电脑,数码,服装,手表,化妆品,保健品,盖象商城' : $this->keywords ?>" />
        <meta name="Description" content="<?php echo empty($this->description) ? '盖网,盖象商城-中国最大的网上购物及积分兑换消费商城，便捷，诚信的服务,为您提供愉悦的网上商城购物体验!' : $this->description ?>" />
        <title>盖网通</title>
        <link rel="shortcut icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
        <link rel="icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
        <link href="<?php echo CSS_DOMAIN; ?>global.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_DOMAIN; ?>module.css" rel="stylesheet" type="text/css" />
        <script>
            document.domain = "<?php echo substr(DOMAIN, 11) ?>";
        </script>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script src="<?php echo DOMAIN; ?>/js/jquery-gate.js" type="text/javascript"></script>
    </head>
    <body class="appdownload">
        <div class="wrap nobg">
            <!--header begin-->
            <div class="header">
                <?php $this->renderPartial('//layouts/_top'); ?>
                <!--<div class="appHead clearfix">-->
                    <!--<div class="left">
                        <?php /*echo CHtml::link(CHtml::image(DOMAIN . '/images/bg/APP_logo.gif'), DOMAIN); */?>
                    </div>-->
                    <!--<div class="appNav clearfix">
                        <?php /*echo CHtml::link(Yii::t('appMain','首页'), $this->createAbsoluteUrl('/')); */?>
                        <?php /*echo CHtml::link(Yii::t('appMain','盖象商城'), $this->createAbsoluteUrl('/jf')); */?>
                        <?php /*echo CHtml::link(Yii::t('appMain','联系我们'), $this->createAbsoluteUrl('/contact')); */?>
                    </div>-->
                <!--</div>-->
            </div>
            <?php echo $content; ?>
            <?php $this->renderPartial('//layouts/_footer'); ?>
        </div>
    </body>
</html>
