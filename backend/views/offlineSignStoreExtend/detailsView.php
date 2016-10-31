<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.jqzoom.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/pdf.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>


<?php  if($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_NEW_FRANCHIESE) :?>
<?php $this->renderPartial('qualificationDetailsNew', array('storeData'=>$storeData,'enterprise_model' => $enterpriseModel, 'contract_model' => $contractModel,'extendModel'=>$extendModel,'auditLogging_model'=>$auditLogging_model,'id'=>$id,'data'=>$data)); ?>
<?php elseif($extendModel->apply_type == OfflineSignStoreExtend::APPLY_TYPE_OLD_FRANCHIESE) :?>
<?php $this->renderPartial('qualificationDetailsOld',  array('storeData'=>$storeData,'enterprise_model' => isset($enterpriseModel)?$enterpriseModel:'', 'contract_model' => isset($contractModel)?$contractModel:'','extendModel'=>$extendModel,'auditLogging_model'=>$auditLogging_model,'id'=>$id,'data'=>$data)); ?>
<?php endif;?>
<script>
	//图片放大镜效果
	$(function(){
		$(".jqzoom").jqueryzoom({xzoom:380,yzoom:410});
		$(".party-prcList ul li img").click(function(){
			var url=$(this).attr("src");
			$(this).parent().parent().parent().parent().parent().find("#preview img").attr("src",url);
		})
	});
</script>