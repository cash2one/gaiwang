<?php //Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero') ?>
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <script>
        //成功样式的dialog弹窗提示
        layer.open({
            icon:1,
            content: '<?php echo Yii::app()->user->getFlash('success'); ?>',
            title:'<?php echo Yii::t('member','成功信息') ?>'
        });
    </script>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
    <script>
        //错误样式的dialog弹窗提示
        layer.open({
            icon:2,
            content: '<?php echo trim(json_encode(Yii::app()->user->getFlash('error')),'"'); ?>',
            title:'<?php echo Yii::t('member','错误提示') ?>'
        });
    </script>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('warning')): ?>
    <script>
        //警告样式的dialog弹窗提示
        layer.open({
            icon:7,
            content: '<?php echo Yii::app()->user->getFlash('warning'); ?>',
            title:'<?php echo Yii::t('member','警告信息') ?>'
        });
    </script>
<?php endif; ?>