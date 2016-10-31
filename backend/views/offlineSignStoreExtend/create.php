<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */

$this->breadcrumbs=array(
	'Offline Sign Store Extends'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OfflineSignStoreExtend', 'url'=>array('index')),
	array('label'=>'Manage OfflineSignStoreExtend', 'url'=>array('admin')),
);
?>

<h1>Create OfflineSignStoreExtend</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>