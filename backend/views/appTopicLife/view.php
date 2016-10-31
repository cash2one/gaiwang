<?php
/* @var $this AppTopicLifeController */
/* @var $model AppTopicLife */

$this->breadcrumbs=array(
	'App Topic Lives'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List AppTopicLife', 'url'=>array('index')),
	array('label'=>'Create AppTopicLife', 'url'=>array('create')),
	array('label'=>'Update AppTopicLife', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AppTopicLife', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AppTopicLife', 'url'=>array('admin')),
);
?>

<h1>View AppTopicLife #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'rele_status',
		'audit_status',
		'sequence',
		'comHeadUrl',
		'profess_proof',
		'author',
		'topic_img',
		'goods_list',
		'error_field',
		'create_time',
		'rele_time',
	),
)); ?>
