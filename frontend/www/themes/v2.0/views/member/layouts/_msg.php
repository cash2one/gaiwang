<?php
$success = Yii::app()->user->hasFlash('success');
$error = Yii::app()->user->hasFlash('error');
$warning = Yii::app()->user->hasFlash('warning');
?>
<?php if ($success): ?>
    <script>
        layer.open({
            icon:1,
            content: "<?php echo trim(Yii::app()->user->getFlash('success'),'"'); ?>",
            title:'<?php echo Yii::t('member','成功信息') ?>'
        });
    </script>
<?php endif; ?>
<?php if ($error): ?>
    <script>
        //错误样式的dialog弹窗提示
		layer.alert('<?php echo trim(json_encode(Yii::app()->user->getFlash('error')),'"'); ?>',{icon:2});
    </script>
<?php endif; ?>
<?php if ($warning): ?>
    <script>
        //警告样式的dialog弹窗提示
		layer.alert('<?php echo trim(Yii::app()->user->getFlash('warning'),'"'); ?>', {icon:7});
    </script>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('activation')): ?>
    <script>
		layer.confirm('<?php echo Yii::app()->user->getFlash('activation') ?>', {
			btn: ['<?php echo Yii::t('member','确定') ?>','<?php echo Yii::t('member','取消') ?>'] //按钮
		}, function(){
			document.location.href = "<?php echo $this->createAbsoluteUrl('/member/home/activation')?>";
		}, function(){
			document.location.href = "<?php echo $this->createAbsoluteUrl('/member/home/logout')?>";
		});
    </script>

<?php endif; ?>
<script type="text/javascript">
    $(function(){
        var lang = "<?php echo Yii::app()->user->getState('selectLanguage');?>";
        var domain = "<?php echo DOMAIN?>";
        var href = "";
        if(lang == 2){
            href = domain+"/"+"index_tw.html";
        }else if(lang == 3){
            href = domain+"/"+"index_en.html";
        }else{
            href = domain;
        }
        $("#log_").attr("href",href);
    })

</script>