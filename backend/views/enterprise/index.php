<?php
/* @var $this EnterpriseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Enterprises',
);

$this->menu=array(
	array('label'=>'Create Enterprise', 'url'=>array('create')),
	array('label'=>'Manage Enterprise', 'url'=>array('admin')),
);
?>

<h1>Enterprises</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
