<?php
/* @var $this AppTopicCarCommentControllerController */
/* @var $model AppTopicCarComment */

$this->breadcrumbs=array(
	'App Topic Car Comments'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AppTopicCarComment', 'url'=>array('index')),
	array('label'=>'Create AppTopicCarComment', 'url'=>array('create')),
	array('label'=>'Update AppTopicCarComment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AppTopicCarComment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AppTopicCarComment', 'url'=>array('admin')),
);
?>
<h1>View AppTopicCarComment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'topic_id',
		'parent_id',
		'member_id',
		'name',
		'content',
		'likes',
		'status',
		'create_time',
		'passed_time',
		'admin_id',
	),
)); ?>
