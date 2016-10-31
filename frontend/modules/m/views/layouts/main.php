<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="盖象商城" />
        <meta name="description" content="全国包邮,货到付款,提供最完美的购物体验！" />
        <link rel="icon" href="<?php echo DOMAIN; ?>/images/mfavicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/mfavicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/mfavicon.ico" type="image/x-icon" />
        <meta content="width=device-width, minimum-scale=1,initial-scale=1, maximum-scale=1, user-scalable=1;" id="viewport" name="viewport" /><!--离线应用的另一个技巧-->
        <meta content="yes" name="apple-mobile-web-app-capable" /><!--指定的iphone中safari顶端的状态条的样式-->
        <meta content="black" name="apple-mobile-web-app-status-bar-style" /><!--告诉设备忽略将页面中的数字识别为电话号码-->
        <meta content="telephone=no" name="format-detection" /><!--设置开始页面图片-->
		<link rel="icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
        <link rel="bookmark" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo DOMAIN; ?>/images/m/favicon.ico" type="image/x-icon" />
        <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/global.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/comm.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/module.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/member.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo DOMAIN; ?>/css/m/alertStyle.css" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    <body>
        <?php $this->renderPartial('/layouts/_top'); ?>
        <?php echo $content; ?>
        <?php $this->renderPartial('/layouts/_footer');?>
    </body>
</html>