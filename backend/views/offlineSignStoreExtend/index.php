<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Offline Sign Store Extends',
);

$this->menu=array(
	array('label'=>'Create OfflineSignStoreExtend', 'url'=>array('create')),
	array('label'=>'Manage OfflineSignStoreExtend', 'url'=>array('admin')),
);
?>

<h1>Offline Sign Store Extends</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
