<?php
// 公共布局文件
/* @var $this Controller */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="Keywords" content="<?php echo empty($this->keywords) ? '盖网,网上购物,网上商城,积分兑换,积分消费,手机,笔记本,电脑,数码,服装,手表,化妆品,保健品,盖象商城' : $this->keywords; ?>" />
        <meta name="Description" content="<?php echo empty($this->description) ? '盖网,盖象商城-中国最大的网上购物及积分兑换消费商城，便捷，诚信的服务,为您提供愉悦的网上商城购物体验!' : $this->description; ?>" />
        <title><?php echo empty($this->pageTitle) ? '盖网科技列表更多推荐' : $this->pageTitle; ?></title>
        <link rel="shortcut icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
        <link rel="icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">

        <link href="<?php echo CSS_DOMAIN; ?>global.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo CSS_DOMAIN; ?>module.css" rel="stylesheet" type="text/css" />
        <script>
            document.domain = "<?php echo substr(DOMAIN, 11) ?>";
        </script>
        <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
        <script src="<?php echo DOMAIN; ?>/js/jquery-gate.js" type="text/javascript"></script>
        <script src="<?php echo DOMAIN; ?>/js/productList.js" type="text/javascript" ></script>
        <script src="<?php echo DOMAIN; ?>/js/slides.min.jquery.js" type="text/javascript"></script>
        <script src="<?php echo DOMAIN; ?>/js/dialog.js" type="text/javascript"></script>
        <!--处理IE6中透明图片兼容问题-->
        <!--[if IE 6]>
        <script type="text/javascript" src="<?php echo DOMAIN ?>/js/DD_belatedPNG.js" ></script>
        <script type="text/javascript">
        DD_belatedPNG.fix('.logo img,.menu span.name,.menu,.menuList,.ico_lct,span.ico_hot,.storey,.titleItem a,span#star img,.loginBox01,.loginBox02,.loginBox01 .loginForm .loginbutton,.loginbgPic');
        </script>
        <![endif]-->
    </head>
    <body>
        <div class="wrap">
            <div class="header">
                <?php $this->renderPartial('//layouts/_top'); ?>
                <?php $this->renderPartial('//layouts/_top2'); ?>
                <?php $this->renderPartial('//layouts/_nav2'); ?>
            </div>
            <?php echo $content; ?>
            <div class="clear"></div>
            <?php $this->renderPartial('//layouts/_footer'); ?>
        </div>
        <?php $this->renderPartial('//layouts/_gotop'); ?>

    </body>
</html>
