<?php
/* @var $this AppTopicProblemController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'App Topic Problems',
);

$this->menu=array(
	array('label'=>'Create AppTopicProblem', 'url'=>array('create')),
	array('label'=>'Manage AppTopicProblem', 'url'=>array('admin')),
);
?>

<h1>App Topic Problems</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
