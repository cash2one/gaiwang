<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.jqzoom.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/pdf.js" type="text/javascript"></script>

<?php
/* @var $this OfflineSignEnterpriseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'电子化签约申请'=>array('OfflineSignStoreExtend/admin'),
	'新商户生成信息录入 > 查看',
);

$this->menu=array(
	array('label'=>'Create OfflineSignEnterprise', 'url'=>array('create')),
	array('label'=>'Manage OfflineSignEnterprise', 'url'=>array('admin')),
);
?>
<?php if($model->apply_type == OfflineSignStore::APPLY_TYPE_NEW_FRANCHIESE) :?>
<?php $this->renderPartial('qualificationDetailsNew', array('model'=>$model,'enterpriModel' => $enterpriModel, 'contractModel' => $contractModel,)); ?>
<?php elseif($model->apply_type == OfflineSignStore::APPLY_TYPE_OLD_FRANCHIESE) :?>
<?php $this->renderPartial('qualificationDetailsOld', array('model'=>$model,'data'=>$data)); ?>
<?php endif;?>

<script>
	$(document).ready(function(){
		<?php if(isset($model) && $model->error_field):?>
		<?php $modelError = json_decode($model->error_field,true);?>
		<?php foreach($modelError as $value):?>
		$("li[id='<?php echo $value?>']").addClass('red');
		<?php endforeach;?>
		<?php endif;?>

		<?php if(isset($enterpriModel) && $enterpriModel->error_field):?>
		<?php $modelError = json_decode($enterpriModel->error_field,true);?>
		<?php foreach($modelError as $value):?>
		$("li[id='<?php echo $value?>']").addClass('red');
		<?php endforeach;?>
		<?php endif;?>

		<?php if(isset($contractModel) && $contractModel->error_field):?>
		<?php $modelError = json_decode($contractModel->error_field,true);?>
		<?php foreach($modelError as $value):?>
		$("li[id='<?php echo $value?>']").addClass('red');
		<?php endforeach;?>
		<?php endif;?>
	});
</script>
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