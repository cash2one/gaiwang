<?php
/** @var $this DesignController */

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo Yii::t('sellerDesign','店铺通版 - 盖网'); ?></title>
    <?php Yii::app()->clientScript->registerCoreScript('jquery') ?>

    <script type="text/javascript" src="<?php echo $this->module->assetsUrl ?>/js/iframe.js"></script>
    <link href="<?php echo $this->module->assetsUrl ?>/css/commom.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $this->module->assetsUrl ?>/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
<span class="btnzx" title="<?php echo Yii::t('sellerDesign','展开工具栏'); ?>"></span>
<!-- 左栏 -->
<div class="banr" >
    <div class="title">
        <span><?php echo Yii::t('sellerDesign','页面管理'); ?></span></div>
    <div class="con" id="navcon">
            <span class="name hover">
                <h4>
                    <?php echo Yii::t('sellerDesign','基础页面'); ?></h4>
            </span>
        <ul>
            <li class="hover"><a href="javascript:app.openUrl('<?php echo $this->createAbsoluteUrl("index"); ?>')">▪ <?php echo Yii::t('sellerDesign','管理首页'); ?></a></li>
            <li><a href="javascript:app.openUrl('<?php echo $this->createAbsoluteUrl("store"); ?>')">▪ <?php echo Yii::t('sellerDesign','实体店管理'); ?></a></li>
        </ul>
    </div>
    <i title="<?php echo Yii::t('sellerDesign','隐藏工具栏'); ?>"></i>
</div>
<!-- 左栏end -->
<div id="dBody">
    <iframe id="dCtxFrame" name="dCtxFrame" src="<?php echo $this->createAbsoluteUrl('index') ?>" frameborder="0" scrolling="yes" class="adminFrame" style="overflow: visible;">
    </iframe>
</div>
</body>
</html>
