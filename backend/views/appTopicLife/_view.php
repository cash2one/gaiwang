<?php
/* @var $this AppTopicLifeController */
/* @var $data AppTopicLife */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rele_status')); ?>:</b>
	<?php echo CHtml::encode($data->rele_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('audit_status')); ?>:</b>
	<?php echo CHtml::encode($data->audit_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sequence')); ?>:</b>
	<?php echo CHtml::encode($data->sequence); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comHeadUrl')); ?>:</b>
	<?php echo CHtml::encode($data->comHeadUrl); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('profess_proof')); ?>:</b>
	<?php echo CHtml::encode($data->profess_proof); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('author')); ?>:</b>
	<?php echo CHtml::encode($data->author); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('topic_img')); ?>:</b>
	<?php echo CHtml::encode($data->topic_img); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('goods_list')); ?>:</b>
	<?php echo CHtml::encode($data->goods_list); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('error_field')); ?>:</b>
	<?php echo CHtml::encode($data->error_field); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rele_time')); ?>:</b>
	<?php echo CHtml::encode($data->rele_time); ?>
	<br />

	*/ ?>

</div>