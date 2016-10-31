<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/uploadImg.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>

<?php
/* @var $this OfflineSignEnterpriseController */
/* @var $model OfflineSignEnterprise */

$this->breadcrumbs=array(
	'电子化签约申请'=>array('OfflineSignStoreExtend/admin'),
	'新商户生成信息录入 > 企业与帐号信息 > 编辑',
);

$this->menu=array(
	array('label'=>'List OfflineSignEnterprise', 'url'=>array('index')),
	array('label'=>'Manage OfflineSignEnterprise', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model,'demoImgs' => $demoImgs)); ?>