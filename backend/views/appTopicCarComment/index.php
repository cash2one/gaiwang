<?php
/* @var $this AppTopicCarCommentControllerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'App Topic Car Comments',
);

$this->menu=array(
	array('label'=>'Create AppTopicCarComment', 'url'=>array('create')),
	array('label'=>'Manage AppTopicCarComment', 'url'=>array('admin')),
);
?>

<h1>App Topic Car Comments</h1>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
