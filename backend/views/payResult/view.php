<?php
/* @var $this PayResultController */
/* @var $model PayResult */

$this->breadcrumbs=array(
	'Pay Results'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PayResult', 'url'=>array('index')),
	array('label'=>'Create PayResult', 'url'=>array('create')),
	array('label'=>'Update PayResult', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PayResult', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PayResult', 'url'=>array('admin')),
);
?>

<h1>View PayResult #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'pay_result',
		'pay_type',
		'update_time',
		'create_time',
		'times',
		'order_type',
	),
)); ?>
