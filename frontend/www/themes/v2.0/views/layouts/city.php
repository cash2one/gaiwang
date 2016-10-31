<?php
/**
 * 城市馆公共布局
 * @author zhenjun_xu <412530435@qq.com>
 * Date: 2016/4/15
 * Time: 11:36
 */
/* @var $this Controller */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Author" content="<?php echo empty($this->author) ? '' : $this->author; ?>" />
    <meta name="Keywords" content="<?php echo empty($this->keywords) ? '' : $this->keywords; ?>" />
    <meta name="Description" content="<?php echo empty($this->description) ? '' : $this->description; ?>" />
    <title><?php echo empty($this->title) ? '' : $this->title; ?></title>
    <?php $lang = Yii::app()->user->getState('selectLanguage'); ?>
    <?php if ($lang == HtmlHelper::LANG_EN): ?>
        <link href="<?php echo DOMAIN; ?>/styles/encss/global.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo DOMAIN; ?>/styles/encss/module.css" rel="stylesheet" type="text/css" />
    <?php else: ?>
        <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/styles/global.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/styles/module.css" rel="stylesheet" type="text/css" />
    <?php endif; ?>
    <script>
        document.domain = "<?php echo substr(DOMAIN, 11) ?>";
    </script>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <script src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/js/jquery.gate.common.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/js/jquery.flexslider-min.js" type="text/javascript"></script>
    <!--处理IE6中透明图片兼容问题-->
    <!--[if IE 6]>
    <script type="text/javascript" src="../js/DD_belatedPNG.js" ></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('.icon_v,.icon_v_h,.adbg,.gwHelp dl dd,.column .category li');
    </script>
    <![endif]-->
</head>
<body>
<!--<div class="icon_v browserSug" style="display: none">温馨提示：您当前使用的浏览器版本过低，兼容性和安全性较差，盖象商城建议您升级: <a class="red" href="http://windows.microsoft.com/zh-cn/windows/upgrade-your-browser">IE8浏览器</a></div>-->
<div class="wrap">

        <?php $this->renderPartial('//layouts/_top_v20'); ?>
        <?php $this->renderPartial('//layouts/_top2_v20'); ?>
        <?php //  $this->renderPartial('//layouts/_nav'); ?>
    <?php echo $content; ?>

    <?php $this->renderPartial('//layouts/_footer_v20'); ?>
</div>
</body>
</html>
