<?php
//店铺首页布局文件
/**
 * @var $this DesignController
 */
$design = new DesignFormat($this->currentDesign->data);
?>
<!--[if lt IE 8]><script>window.location.href="http://seller.<?php echo SHORT_DOMAIN ?>/home/notSupported"</script><![endif]-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo CHtml::encode($this->pageTitle) ?></title>
    <link rel="shortcut icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
    <link rel="icon" href="<?php echo DOMAIN ?>/favicon.ico" type="mage/x-icon">
    <link href="<?php echo $this->theme->baseUrl; ?>/styles/global.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->theme->baseUrl; ?>/styles/module.css" rel="stylesheet" type="text/css" />  
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery-1.9.1.js" type="text/javascript"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.gate.common.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/jquery.flexslider-min.js"></script>
    <script src="<?php echo $this->theme->baseUrl; ?>/js/shop-v2.0.js"></script>
    <script type="text/javascript" src="<?php echo $this->theme->baseUrl; ?>/js/jquery.jqzoom.js"></script><!-- 图片放大 -->
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/lazyLoad.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo DOMAIN; ?>/js/raty/lib/jquery.raty.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsUrl ?>/css/template.css"/>
    <?php Yii::app()->clientScript->registerCoreScript('artDialog') ?>
    <?php echo $this->renderPartial('_shopJs') ?>
    <?php if ($this->currentDesign->status == Design::STATUS_EDITING) $this->renderPartial('_designJs'); ?>
    <!--处理IE6中透明图片兼容问题-->
    <!--[if IE 6]>
    <script type="text/javascript" src="<?php echo DOMAIN ?>/js/DD_belatedPNG.js"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('.icon_v,.icon_v_h,.adbg,.gwHelp dl dd,.column .category li');
    </script>
    <![endif]-->
    <!--店铺装修背景设置-->
    <?php if ($this->id == 'shop' && isset($this->design)): ?>
        <style type="text/css">
            body {
            <?php if($this->design->DisplayBgImage): ?> background-image: url('<?php echo IMG_DOMAIN.'/'.$this->design->BGImg ?>');
                background-repeat: <?php echo $this->design->BGRepeat ?>;
                background-position: <?php echo $this->design->BGPosition ?>;
            <?php else: ?> background-color: <?php echo $this->design->BGColor ?>;
            <?php endif; ?>
            }
        </style>
    <?php endif; ?>
    <?php if ($this->action->id == 'preview' || $this->action->id == 'storePreview'): ?>
        <style type="text/css">
            .headWrap {
                position: relative;
            }
            .previewImg {
                position: absolute;
                background: url("<?php echo DOMAIN.'/images/bg/yulan.png' ?>") no-repeat;
                width: 149px;
                height: 85px;
                top: 80px;
                left: 100px;
            }
        </style>
    <?php endif; ?>
</head>
<body>
<div id="dRemarks" style="display: none"></div>
<div class="top_bj"></div>

<?php echo $this->renderPartial('/layouts/_designTop') ?>
<div class="wrap">
    <div class="header">
  <?php $this->renderPartial('//layouts/_top_v20'); ?>
  <?php $this->renderPartial('//layouts/_top3_v20'); ?>
  <?php $this->renderPartial('//layouts/_nav4_v20',array('design'=>$design)); ?>
  <?php $this->renderPartial('//layouts/scateoryNav_v20',array('design'=>$design));?>
    </div>

    <div class="main" style="width: 100%">
        <?php echo $content; ?>
    </div>
</div>
</body>
</html>