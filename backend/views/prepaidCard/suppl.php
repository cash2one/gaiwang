<?php $this->breadcrumbs = array('充值兑换管理', '补充充值短信'); ?>
<?php echo CHtml::form(Yii::app()->createAbsoluteUrl('PrepaidCard/Suppl')) ?>
<?php echo '短信发送：'?>
<?php echo CHtml::submitButton('点击发送', array('class' => 'regm-sub')) ?>
<?php echo CHtml::endForm() ?>