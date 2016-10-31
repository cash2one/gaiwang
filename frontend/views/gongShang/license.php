<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="盖象,网上购物,网上商城,积分兑换,积分消费,手机,笔记本,电脑,数码,服装,手表,化妆品,保健品,盖象商城" />
    <meta name="Description" content="盖象,盖象商城-中国最大的网上购物及积分兑换消费商城，便捷，诚信的服务,为您提供愉悦的网上商城购物体验!" />
    <title><?php echo $this->pageTitle ?></title>
	<link href="../css/global.css" rel="stylesheet" type="text/css" />
    <link href="../css/module.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="main w1200">
        <div class="licenceCon">
            <div class="shopLogo">
                <a href="<?php echo Yii::app()->createAbsoluteUrl('/') ?>"><img class="left" alt="盖网" src="../images/bgs/logo.png" width="215" height="85"></a>
                <h1><?php echo Yii::t('gongShang','盖象商城') ?></h1>
                <p><?php echo Yii::t('gongShang','经营资质信息公示如下：') ?></p>
            </div>
            <div class="licenseImg"><img src="../images/temp/licenseImg.jpg" alt="<?php echo Yii::t('gongShang','工商执照') ?>" width="1050" height="740"/></div>
            <p class="txtC"><?php echo Yii::t('gongShang','注：经营者信息以资质原件为准。') ?></p>
        </div>
    </div>
</body>