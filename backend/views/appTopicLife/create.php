<?php
/* @var $this AppTopicLifeController */
/* @var $model AppTopicLife */

$this->breadcrumbs=array(
	'App Topic Lives'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AppTopicLife', 'url'=>array('index')),
	array('label'=>'Manage AppTopicLife', 'url'=>array('admin')),
);
?>

<h1>Create AppTopicLife</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>