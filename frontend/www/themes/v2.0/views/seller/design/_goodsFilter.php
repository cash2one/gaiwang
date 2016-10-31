<?php
/** @var $this DesignController */
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo Yii::t('sellerDesign','商铺装修编辑'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/Site.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css">
    <link rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/blue.css">
    <script type="text/javascript" src="<?php echo $this->theme->baseUrl; ?>/js/jquery-1.9.1.js" ></script>
    <script type="text/javascript" src="<?php echo $this->module->assetsUrl ?>/js/jquery/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->module->assetsUrl ?>/js/jquery/jquery.validate.unobtrusive.min.js"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.iframeTools.js" type="text/javascript"></script>
    
    <script type="text/javascript">
            var dialog = null;
            if (typeof success != 'undefined') {
            parent.location.reload();
            art.dialog.close();
        }
           var cancel = function () {
                var p = art.dialog.opener;
                if (p && p.doClose) p.doClose(); 
            };
    </script>
    <style type="text/css">
        body {
            font-size: 12px;
        }
    </style>
</head>
<body style="background: #fff">
<div class="arbox">
    <?php echo CHtml::form() ?>
    <h1 class="h1title"><?php echo Yii::t('sellerDesign','显示方式'); ?></h1>
    <div class="c10">
    </div>
    <table width="100%" cellpadding="0" cellspacing="0" class="tb-blue tb-t2b2">
        <tr>
            <th style="width: 100px;">
                <?php echo Yii::t('sellerDesign','宝贝数量'); ?>：
            </th>
            <td>
                <?php echo CHtml::textField('ProCount',$tmpData['ProCount'],array(
                    'class'=>'text-input-bj small',
                    'data-val'=>'true',
                    'data-val-number'=>Yii::t('sellerDesign','宝贝数量 必须是数字'),
                    'data-val-range'=>Yii::t('sellerDesign','宝贝数量必须在1--50之内'),
                    'data-val-range-max'=>'50',
                    'data-val-range-min'=>'1',
                    'data-val-regex'=>Yii::t('sellerDesign','宝贝数量必须为正整数'),
                    'data-val-regex-pattern'=>'^[0-9]*[1-9][0-9]*$',
                    'data-val-required'=>Yii::t('sellerDesign','宝贝数量 必填'),
                    'id'=>'ProCount',
                )) ?>
                <span class="field-validation-valid" data-valmsg-for="ProCount"  data-valmsg-replace="true"></span>
            </td>
        </tr>
        <tr>
            <th style="width: 100px;">
                <?php echo Yii::t('sellerDesign','排序方式'); ?>：
            </th>
            <td>
                <?php echo CHtml::dropDownList('OrderMode',$tmpData['OrderMode'],
                    Design::orderMode(),array('id'=>'OrderMode','class'=>'text-input-bj')) ?>
            </td>
        </tr>
    </table>
    <div class="editor">
        <input id="shopSubmit" type="submit" value="<?php echo Yii::t('sellerDesign','保存'); ?>" class="button_red1"/>
        <input type="button" onClick="cancel()" value="<?php echo Yii::t('sellerDesign','取消'); ?>" class="button_red1s"/>
    </div>
    <?php echo CHtml::endForm() ?>
</div>
</body>
</html>
