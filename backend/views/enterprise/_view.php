<?php
/* @var $this EnterpriseController */
/* @var $data Enterprise */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('short_name')); ?>:</b>
	<?php echo CHtml::encode($data->short_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('license')); ?>:</b>
	<?php echo CHtml::encode($data->license); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('license_photo')); ?>:</b>
	<?php echo CHtml::encode($data->license_photo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('province_id')); ?>:</b>
	<?php echo CHtml::encode($data->province_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city_id')); ?>:</b>
	<?php echo CHtml::encode($data->city_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('district_id')); ?>:</b>
	<?php echo CHtml::encode($data->district_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street')); ?>:</b>
	<?php echo CHtml::encode($data->street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_man')); ?>:</b>
	<?php echo CHtml::encode($data->link_man); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link_phone')); ?>:</b>
	<?php echo CHtml::encode($data->link_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mobile')); ?>:</b>
	<?php echo CHtml::encode($data->mobile); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('department')); ?>:</b>
	<?php echo CHtml::encode($data->department); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_start_time')); ?>:</b>
	<?php echo CHtml::encode($data->service_start_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_end_time')); ?>:</b>
	<?php echo CHtml::encode($data->service_end_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('auditing')); ?>:</b>
	<?php echo CHtml::encode($data->auditing); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('signing_type')); ?>:</b>
	<?php echo CHtml::encode($data->signing_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kingdee_id')); ?>:</b>
	<?php echo CHtml::encode($data->kingdee_id); ?>
	<br />

	*/ ?>

</div>