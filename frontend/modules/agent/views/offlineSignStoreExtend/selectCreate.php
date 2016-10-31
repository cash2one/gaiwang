<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<?php
/* @var $this OfflineSignStoreController */
/* @var $model OfflineSignStore */

$this->breadcrumbs=array(
    '电子化签约申请'=>array('OfflineSignStoreExtend/admin'),
    '选择签约新建类型',
);

$this->menu=array(
    array('label'=>'List OfflineSignStore', 'url'=>array('index')),
    array('label'=>'Create OfflineSignStore', 'url'=>array('create')),
);
?>
<div class="toolbar img08"><?php echo CHtml::link(Yii::t('Public','返回'), $this->createURL('offlineSignStoreExtend/admin'), array('class' => 'button_05 floatRight')); ?></div>
<div class="com-box">
    <div class="sign-build">
        <p class="sign-title">请选择签约新增类型：</p>
        <p><a href="<?php echo $this->createUrl('offlineSignContract/newFranchisee')?>">+ 添加新商户</a></p>
        <p><a href="<?php echo $this->createUrl('offlineSignStoreExtend/oldFranchisee')?>">+ 原有会员新增加盟商</a></p>
    </div>
</div>
