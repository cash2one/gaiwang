<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/pdf.js" type="text/javascript"></script>
<script >
var traceChange = function() {
    console.log('eee');
    var reKey = 1;
    var val = $('#OfflineSignStore_upload_contract').val();
    var pdfName = $('#pdfName').html();
    <?php if($storeNum > 1):?>
    <?php for($i=1;$i <= $storeNum;$i+=10):?>
    var imgName<?php echo intval($i/10)+1;?> = $("#imgName<?php echo intval($i/10)+1;?>").html();
    if (imgName<?php echo intval($i/10)+1;?> == '') {
        reKey = 0;
    }
    <?php endfor;?>
    if (pdfName != '' && reKey == 1) {
        sbmit_btn();
    }
    <?php endif;?>
    <?php if($storeNum == 1):?>
    if (pdfName != '') {
        sbmit_btn();
    }
    <?php endif;?>
    $('#returnButton').click(function(){
        $('#returnButton').attr('href','#');
        art.dialog({
            okVal: '确定',
            content: '返回后，当前已上传的文件会消失，下次需重新进行上传。确定要返回？',
            lock: true,
            cancel: true,
            ok:function(){
                location.href = '<?php echo $this->createURL('offlineSignAuditLogging/seeAudit',array('storeExtendId'=>$model->id));?>';
            }
        });
    });
}
    function sbmit_btn(){
    $('#sbumit-btn').removeAttr('disabled');
    $('#sbumit-btn').attr({
        'class':'btn-sign'
    });
}
</script>
<div class="toolbar img08"><?php echo CHtml::link(Yii::t('Public','返回'), $this->createURL('offlineSignAuditLogging/seeAudit',array('storeExtendId'=>$model->id)), array('id'=>'returnButton','class' => 'button_05 floatRight')); ?></div>
<div class="audit-type clearfix">
    <p><span class="sign-title" style=" padding-right: 15px;">新增类型</span><?php echo OfflineSignStoreExtend::getApplyType($model->apply_type)?></p>
    <p><span class="sign-title" style=" padding-right: 15px;">企业名称</span><?php echo $model->enTerName?></p>
</div>
<?php if($model->apply_type == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE):?>
    <?php $this->renderPartial('uploadNewContract', array('model'=>$model,'storeNum'=>$storeNum)); ?>
<?php elseif($model->apply_type == OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE):?>
    <?php $this->renderPartial('uploadOldContract', array('model'=>$model,'storeNum'=>$storeNum)); ?>
<?php endif;?>

