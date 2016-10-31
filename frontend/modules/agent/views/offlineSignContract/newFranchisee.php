<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>
<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */
$this->breadcrumbs=array(
    '电子化签约申请'=>array('OfflineSignStoreExtend/admin'),
    '新商户生成信息录入 > 新建' ,
);

$this->menu=array(
    array('label'=>'List OfflineSignStore', 'url'=>array('index')),
    array('label'=>'Create OfflineSignStore', 'url'=>array('create')),
);
?>
<?php $this->renderPartial('_form',array('model'=>$model));?>
