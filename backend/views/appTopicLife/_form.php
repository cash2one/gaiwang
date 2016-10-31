<?php
/* @var $this AppTopicLifeController */
/* @var $model AppTopicLife */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'app-topic-life-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rele_status'); ?>
		<?php echo $form->textField($model,'rele_status'); ?>
		<?php echo $form->error($model,'rele_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'audit_status'); ?>
		<?php echo $form->textField($model,'audit_status'); ?>
		<?php echo $form->error($model,'audit_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sequence'); ?>
		<?php echo $form->textField($model,'sequence'); ?>
		<?php echo $form->error($model,'sequence'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comHeadUrl'); ?>
		<?php echo $form->textField($model,'comHeadUrl',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comHeadUrl'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'profess_proof'); ?>
		<?php echo $form->textArea($model,'profess_proof',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'profess_proof'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'topic_img'); ?>
		<?php echo $form->textField($model,'topic_img',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'topic_img'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'goods_list'); ?>
		<?php echo $form->textArea($model,'goods_list',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'goods_list'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'error_field'); ?>
		<?php echo $form->textArea($model,'error_field',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'error_field'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time'); ?>
		<?php echo $form->error($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rele_time'); ?>
		<?php echo $form->textField($model,'rele_time'); ?>
		<?php echo $form->error($model,'rele_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->