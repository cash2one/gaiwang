<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo Yii::t('sellerDesign','店铺装修引导'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->module->assetsUrl ?>/css/commom.css" />
    <?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
    <script type="text/javascript" src="<?php echo $this->module->assetsUrl ?>/js/slides.min.jquery.js"></script>
    <?php echo $this->renderPartial('_shopJs') ?>
    <script type="text/javascript" src="<?php echo $this->module->assetsUrl ?>/js/jquery.easing.1.3.js"></script>
    <style type="text/css">
        /* 店铺页面--店铺大图广告 */
        .scroll_shop
        {
            width: 800px;
            height: 450px;
            overflow: hidden;
            position: relative;
        }
        /*.scroll_shop ul{z-index:400px;}*/
        .shopmue ul.pagination
        {
            z-index: 9999;
            bottom: 10px;
            right: 280px;
            width: 200px;
            position: absolute;
        }
        .shopmue ul.pagination li
        {
            width: 24px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            float: left;
            margin-left: 5px;
            font-family: "微软雅黑";
            margin-bottom: 5px;
        }
        .shopmue ul.pagination li a
        {
            background: #000;
            border: 1px solid #8691a1;
            color: #FFF;
            display: block;
            filter: alpha(opacity=50);
            -moz-opacity: 0.5;
            -khtml-opacity: 0.5;
            opacity: 0.5;
            text-indent: -9999em;
        }
        .shopmue ul.pagination li.current a
        {
            background-color: #eb8a8a;
            border: 1px solid #c23636;
            font-size: 14px;
            filter: alpha(opacity=80);
            -moz-opacity: 0.8;
            -khtml-opacity: 0.8;
            opacity: 0.8;
        }
        .slides_container
        {
            height: 450px;
        }
    </style>
</head>
<body>
<!-- 大图广告 -->
<div class="scroll_shop shopmue">
    <div class="scroll_shop activ_pson">
        <div id="shop">
            <ul class="slides_container">
                <li><a href="javascript:void(0)" title="">
                        <img alt="<?php echo Yii::t('sellerDesign','商铺装修流程'); ?>" src="<?php echo $this->module->assetsUrl ?>/images/temp/ShopProcess.jpg" width="800" height="450" /></a>
                </li>
                <li><a href="javascript:void(0)" title="">
                        <img alt="<?php echo Yii::t('sellerDesign','商铺功能按钮介绍'); ?>" src="<?php echo $this->module->assetsUrl ?>/images/temp/ShopButton.jpg" width="800" height="450" /></a>
                </li>
                <li><a href="javascript:void(0)" title="">
                        <img alt="<?php echo Yii::t('sellerDesign','更多模块功能体验'); ?>" src="<?php echo $this->module->assetsUrl ?>/images/temp/ShopMore.jpg" width="800" height="450" /></a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- 大图广告 -->
</body>
</html>
