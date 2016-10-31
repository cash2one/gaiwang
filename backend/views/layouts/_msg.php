<?php
$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerScriptFile($baseUrl . "/js/swf/js/artDialog.js?skin=blue");
?>
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <script>
        //成功样式的dialog弹窗提示
        art.dialog({
            icon: 'succeed',
            content: '<?php echo Yii::app()->user->getFlash('success'); ?>',
            ok: true,
            drag:false
        });
    </script>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
    <script>
        //错误样式的dialog弹窗提示
        art.dialog({
            icon: 'error',
            content: <?php echo json_encode(Yii::app()->user->getFlash('error')); ?>,
            ok: true,
            drag:false
        });
    </script>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('warning')): ?>
    <script>
        //警告样式的dialog弹窗提示
        art.dialog({
            icon: 'warning',
            content: '<?php echo Yii::app()->user->getFlash('warning'); ?>',
            ok: true,
            drag:false
        });
    </script>
<?php endif; ?>