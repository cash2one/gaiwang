

<!DOCTYPE html>
<html>
<head>
    <title><?php echo Yii::t('sellerDesign','diy编辑'); ?></title>
    <meta charset="utf-8"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl ?>/css/tablestyle.css">
    <?php Yii::app()->clientScript->registerCoreScript('artDialog') ?>
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
        var dialog = null;
        var doClose = function () {
            if (null != dialog) {
                dialog.close();
            }
        };
    </script>
</head>
<body>
<?php echo CHtml::form() ?>
<?php
//自定义区域
$this->widget('ext.editor.WDueditor', array(
    'model' => null,
    'base_url' => 'http://seller.'.SHORT_DOMAIN,
    'attribute' => 'content',
    'value'=>$data,
    'save_path' => 'uploads/files', //默认是'attachments/UE_uploads'
    'url' => IMG_DOMAIN . '/files', //默认是ATTR_DOMAIN.'/UE_uploads',
    'height'=>'400',
));
?>
<div class="editor">
    <input class="button_red1" type="submit" value="<?php echo Yii::t('sellerDesign','保存'); ?>">
    <input class="button_red1s" type="button" onclick="Cancel()" value="<?php echo Yii::t('sellerDesign','取消'); ?>">
</div>

<?php echo CHtml::endForm() ?>

</body>
</html>
