<?php
$success = Yii::app()->user->hasFlash('success');
$error = Yii::app()->user->hasFlash('error');
$warning = Yii::app()->user->hasFlash('warning');
Yii::app()->clientScript->registerScriptFile(DOMAIN.'/js/artDialog/jquery.artDialog.js?skin=aero');
?>
<?php if ($success): ?>
    <script>
        //成功样式的dialog弹窗提示
        art.dialog({
            icon: 'succeed',
            content: '<?php echo Yii::app()->user->getFlash('success'); ?>',
            ok: true,
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>'
        });
    </script>
<?php endif; ?>
<?php if ($error): ?>
    <script>
        //错误样式的dialog弹窗提示
        art.dialog({
            icon: 'error',
            content: '<?php echo json_encode(Yii::app()->user->getFlash('error')); ?>',
            ok: true,
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>'
        });
    </script>
<?php endif; ?>
<?php if ($warning): ?>
    <script>
        //警告样式的dialog弹窗提示
        art.dialog({
            icon: 'warning',
            content: '<?php echo Yii::app()->user->getFlash('warning'); ?>',
            ok: true,
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息') ?>'
        });
    </script>
<?php endif; ?>

<?php if(Yii::app()->user->hasFlash('activation')): ?>
    <script>
        art.dialog({
            icon: 'warning',
            content: '<?php echo Yii::app()->user->getFlash('activation') ?>',
            ok: function(){
                document.location.href = "<?php echo $this->createAbsoluteUrl('/member/home/activation')?>";
            },
            okVal:'<?php echo Yii::t('member','确定') ?>',
            title:'<?php echo Yii::t('member','消息提示') ?>',
            lock:true,
            esc:false,
            cancel:function(){
                document.location.href = "<?php echo $this->createAbsoluteUrl('/member/home/logout')?>";
            },
            cancelVal:"<?php echo Yii::t('member','取消') ?>",
            width:420,
            height:210
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