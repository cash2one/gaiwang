<?php
/* @var $this AppTopicCarCommentControllerController */
/* @var $model AppTopicCarComment */

$this->breadcrumbs=array(
	'App Topic Car Comments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AppTopicCarComment', 'url'=>array('index')),
	array('label'=>'Manage AppTopicCarComment', 'url'=>array('admin')),
);
?>
<h1>Create AppTopicCarComment</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>