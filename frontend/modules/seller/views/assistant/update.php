<?php
/* @var $this AssistantController */
/* @var $model Assistant */

$this->breadcrumbs=array(
    Yii::t('sellerAssistant','店小二管理'),
    Yii::t('sellerAssistant','修改店小二'),
);
?>
<div class="toolbar">
    <h3><?php echo Yii::t('sellerAssistant','修改店小二'); ?></h3>
</div>

<?php $this->renderPartial('_form', array('model'=>$model,'permissions'=>$permissions,'franchisee'=>$franchisee,)); ?>