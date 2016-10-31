<!--<script src="/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>-->
<?php if (Yii::app()->user->hasFlash('success')): ?>
    <script>
        //成功样式的dialog弹窗提示
		layer.alert('<?php echo Yii::app()->user->getFlash('success'); ?>');
    </script>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('error')): ?>
    <script>
        //错误样式的dialog弹窗提示
		layer.alert('<?php echo Yii::app()->user->getFlash('error'); ?>');
    </script>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('warning')): ?>
    <script>
        //警告样式的dialog弹窗提示
		layer.alert('<?php echo Yii::app()->user->getFlash('warning'); ?>');
    </script>
<?php endif; ?>