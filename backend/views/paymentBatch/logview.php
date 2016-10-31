<?php
/* @var $this PayResultController */
/* @var $model PayResult */

$this->breadcrumbs=array(
	'Pay Results'=>array('index'),
	$model->id,
);
?>

<h1>View PaymentLog #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'value',
		'create_time',
	),
)); ?>
