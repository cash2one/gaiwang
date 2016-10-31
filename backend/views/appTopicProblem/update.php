<?php
/* @var $this AppTopicProblemController */
/* @var $model AppTopicProblem */

$this->breadcrumbs=array(
	'App Topic Problems'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AppTopicProblem', 'url'=>array('index')),
	array('label'=>'Create AppTopicProblem', 'url'=>array('create')),
	array('label'=>'View AppTopicProblem', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AppTopicProblem', 'url'=>array('admin')),
);
?>



<?php $this->renderPartial('_form', array('model'=>$model)); ?>