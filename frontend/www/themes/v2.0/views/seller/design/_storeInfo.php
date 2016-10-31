<?php
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo Yii::t('sellerDesign','实体店介绍编辑'); ?></title>

    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/Site.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css">

    <?php Yii::app()->clientScript->registerCoreScript('jquery') ?>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.js" type="text/javascript"></script>
    <script src="<?php echo DOMAIN ?>/js/swf/js/artDialog.iframeTools.js" 
            type="text/javascript"></script>
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
    </script>
</head>
<body>
    <?php echo CHtml::form() ?>
    <div class="arbox">
        <?php $info = isset($tmpData['synopsis']) ? $tmpData['synopsis'] : '' ?>
        <textarea cols="75" id="synopsis" name="synopsis" rows="8"><?php echo $info ?></textarea>
        <div class="editor">
            <input type="submit" value="<?php echo Yii::t('sellerDesign','保存'); ?>" class="button_red1"/>
            <input type="button" value="<?php echo Yii::t('sellerDesign','取消'); ?>" class="button_red1s" onclick="Cancel()"/>
        </div>
    </div>
    <?php echo CHtml::endForm() ?>

</body>
</html>
