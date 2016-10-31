<?php
/* @var $this AppTopicProblemController */
/* @var $model AppTopicProblem */

$this->breadcrumbs=array(
	'App Topic Problems'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AppTopicProblem', 'url'=>array('index')),
	array('label'=>'Create AppTopicProblem', 'url'=>array('create')),
	array('label'=>'Update AppTopicProblem', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AppTopicProblem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AppTopicProblem', 'url'=>array('admin')),
);
?>

<h1>View AppTopicProblem #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'life_topic_id',
		'member_id',
		'name',
		'content',
		'status',
		'create_time',
		'passed_time',
		'admin_id',
		'problem',
	),
)); ?>
