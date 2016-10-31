<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="shortcut icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
    <link rel="icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
    <link href="<?php echo CSS_DOMAIN; ?>global.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_DOMAIN; ?>module.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_DOMAIN; ?>member.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_DOMAIN; ?>custom.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo DOMAIN; ?>/styles/member.css" rel="stylesheet" type="text/css"/>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <script src="<?php echo DOMAIN; ?>/js/jquery-gate.js" type="text/javascript"></script>
    <script>
        document.domain = "<?php echo substr(DOMAIN, 11) ?>";
    </script>
</head>
<body>
<div class="wrap">
    <div class="header">
        <!--top  start-->
        <?php $this->renderPartial('application.views.layouts._top'); ?>
        <!--top end-->
        <div class="regHeader">
            <div class="w1200 clearfix">
                <a href="<?php echo DOMAIN ?>" class="logo fl" id="log_"><img src="<?php echo DOMAIN ?>/images/bgs/logo.png" alt="<?php echo Yii::app()->name; ?>"/></a>
                <h1><?php echo $this->showTitle; ?></h1>
            </div>
        </div>
    </div>

    <!--header end -->
    <div class="main clearfix">
        <div class="register">
            <!--content start -->
            <?php echo $content; ?>
            <!--content end -->
        </div>
    </div>
    <div class="footer clearfix">
        <div class="footLink">
            <div class="gwLinks w1200">
				<?php echo CHtml::link(Yii::t('site', '关于盖网'), $this->createAbsoluteUrl('/about'), array('target' => '_blank')); ?>
				|
				<?php echo CHtml::link(Yii::t('site', '帮助中心'), $this->createAbsoluteUrl('/help'), array('target' => '_blank')); ?>
				|
				<?php echo CHtml::link(Yii::t('site', '网站地图'), $this->createAbsoluteUrl('/sitemap'), array('target' => '_blank')); ?>
				|
				<?php echo CHtml::link(Yii::t('site', '诚聘英才'), $this->createAbsoluteUrl('/job'), array('target' => '_blank')); ?>
				|
				<?php echo CHtml::link(Yii::t('site', '联系客服'), $this->createAbsoluteUrl('/contact'), array('target' => '_blank')); ?>
				|
				<?php echo CHtml::link(Yii::t('site', '免责声明'), $this->createAbsoluteUrl('/statement'), array('target' => '_blank')); ?>
				|
				<?php echo CHtml::link(Yii::t('site', '隐私保护'), $this->createAbsoluteUrl('/privacy'), array('target' => '_blank')); ?>

				<div class="copyRight w1200"><?php echo Tool::getConfig('site', 'copyright'); ?></div>

                <!--p class="ico_j">
                    <span class="ico_f1"> </span>
                    <span class="ico_f2"> </span>
                    <span class="ico_f3"> </span>
                    <span class="ico_f4"> </span>
                </p>-->
            </div>
        </div>
        <!--footer end -->
    </div>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-51285352-1', 'gatewang.com');
        ga('send', 'pageview');

    </script>
</div>
<?php $this->renderPartial('/layouts/_msg'); ?>
</body>
</html>