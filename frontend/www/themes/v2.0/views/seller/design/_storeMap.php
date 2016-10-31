<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title><?php echo Yii::t('sellerDesign','实体店地图编辑'); ?></title>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/Site.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css">
    <link rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/styles/blue.css">
    <?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.iframeTools.js" type="text/javascript"></script>
    <script type="text/javascript">
        if (typeof success != 'undefined') {
            parent.location.reload();
            art.dialog.close();
        }
        var Cancel = function () {
            var p = art.dialog.opener;
            if (p && p.doClose)
                p.doClose();
        };
        var mark_click = function () {
            var url = '<?php echo $this->createAbsoluteUrl('/seller/design/mapSelect',array('id'=>$model->id)) ?>';
            dialog = art.dialog.open(url, {
                'title': '<?php echo Yii::t('sellerDesign','设定经纬度'); ?>',
                'lock': true,
                'window': 'top',
                'width': 740,
                'height': 600,
                'border': true
            });
        };
        var onSelected = function (lat, lng) {
            $('#POS_X').val(lng);
            $('#POS_Y').val(lat);
        };
        var dialog = null;
        var doClose = function () {
            if (null != dialog) {
                dialog.close();
            }
        };
    </script>
</head>

<body>

    <?php echo CHtml::form(); ?>
    <?php
        $label = isset($tmpData['Label']) ? $tmpData['Label'] : '';
        $x = isset($tmpData['POS_X']) ? $tmpData['POS_X'] : '';
        $y = isset($tmpData['POS_Y']) ? $tmpData['POS_Y'] : '';
    ?>
    <div class="arbox">
        <table class="tb-blue tb-t2b2" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <th style="width: 100px;"><?php echo Yii::t('sellerDesign','标注名称'); ?></th>
                <td><input id="Label" class="text-input-bj small" type="text" value="<?php echo $label ?>" name="Label"></td>
            </tr>
            <tr>
                <th style="width: 100px;"><?php echo Yii::t('sellerDesign','经度'); ?></th>
                <td><input id="POS_X" class="text-input-bj small" type="text" value="<?php echo $x ?>" name="POS_X"></td>
            </tr>
            <tr>
                <th style="width: 100px;"><?php echo Yii::t('sellerDesign','纬度'); ?></th>
                <td>
                    <input id="POS_Y" class="text-input-bj small" type="text" value="<?php echo $y ?>" name="POS_Y">
                    <input class="regm-sub" type="button" onclick="mark_click()" value="<?php echo Yii::t('sellerDesign','选择经纬度'); ?>">
                </td>
            </tr>
            </tbody>
        </table>
        <div class="editor">
            <input class="button_red1" type="submit" value="<?php echo Yii::t('sellerDesign','保存'); ?>">
            <input class="button_red1s" type="button" onclick="Cancel()" value="<?php echo Yii::t('sellerDesign','取消'); ?>">
        </div>
    </div>
    <?php echo CHtml::endForm(); ?>

<div
    style="display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%; cursor: move; opacity: 0; background: none repeat scroll 0% 0% rgb(255, 255, 255);"></div>
</body>
</html>
