<?php
/* @var $this AppTopicProblemController */
/* @var $model AppTopicProblem */

$this->breadcrumbs=array(
	'App Topic Problems'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AppTopicProblem', 'url'=>array('index')),
	array('label'=>'Manage AppTopicProblem', 'url'=>array('admin')),
);
?>

<h1>Create AppTopicProblem</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>