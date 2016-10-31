<?php
/* @var $this AppTopicLifeController */
/* @var $model AppTopicLife */

$this->breadcrumbs=array(
	'App Topic Lives'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AppTopicLife', 'url'=>array('index')),
	array('label'=>'Create AppTopicLife', 'url'=>array('create')),
	array('label'=>'View AppTopicLife', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AppTopicLife', 'url'=>array('admin')),
);
?>

<h1>Update AppTopicLife <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>