<?php
/* @var $this CharityController */
/* @var $model Charity */

$this->breadcrumbs=array(
	'Charities'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Charity', 'url'=>array('index')),
	array('label'=>'Manage Charity', 'url'=>array('admin')),
);
?>

<h1>Create Charity</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>