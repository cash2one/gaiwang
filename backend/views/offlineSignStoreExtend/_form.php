<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'offline-sign-store-extend-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'role_1_audit_status'); ?>
		<?php echo $form->textField($model,'role_1_audit_status'); ?>
		<?php echo $form->error($model,'role_1_audit_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_2_audit_status'); ?>
		<?php echo $form->textField($model,'role_2_audit_status'); ?>
		<?php echo $form->error($model,'role_2_audit_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_3_audit_status'); ?>
		<?php echo $form->textField($model,'role_3_audit_status'); ?>
		<?php echo $form->error($model,'role_3_audit_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_4_audit_status'); ?>
		<?php echo $form->textField($model,'role_4_audit_status'); ?>
		<?php echo $form->error($model,'role_4_audit_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_5_audit_status'); ?>
		<?php echo $form->textField($model,'role_5_audit_status'); ?>
		<?php echo $form->error($model,'role_5_audit_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_6_audit_status'); ?>
		<?php echo $form->textField($model,'role_6_audit_status'); ?>
		<?php echo $form->error($model,'role_6_audit_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_7_audit_status'); ?>
		<?php echo $form->textField($model,'role_7_audit_status'); ?>
		<?php echo $form->error($model,'role_7_audit_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'agent_id'); ?>
		<?php echo $form->textField($model,'agent_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'agent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apply_type'); ?>
		<?php echo $form->textField($model,'apply_type'); ?>
		<?php echo $form->error($model,'apply_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_import'); ?>
		<?php echo $form->textField($model,'is_import'); ?>
		<?php echo $form->error($model,'is_import'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'old_member_franchisee_id'); ?>
		<?php echo $form->textField($model,'old_member_franchisee_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'old_member_franchisee_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'audit_status'); ?>
		<?php echo $form->textField($model,'audit_status'); ?>
		<?php echo $form->error($model,'audit_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'repeat_audit'); ?>
		<?php echo $form->textField($model,'repeat_audit'); ?>
		<?php echo $form->error($model,'repeat_audit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'repeat_application'); ?>
		<?php echo $form->textField($model,'repeat_application'); ?>
		<?php echo $form->error($model,'repeat_application'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_time'); ?>
		<?php echo $form->textField($model,'create_time',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'create_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_time'); ?>
		<?php echo $form->textField($model,'update_time',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'update_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->