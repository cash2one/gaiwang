<?php
/* @var $this AppTopicLifeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'App Topic Lives',
);

$this->menu=array(
	array('label'=>'Create AppTopicLife', 'url'=>array('create')),
	array('label'=>'Manage AppTopicLife', 'url'=>array('admin')),
);
?>

<h1>App Topic Lives</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
