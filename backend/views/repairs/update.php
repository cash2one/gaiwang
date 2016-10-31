<?php
/* @var $this RepairsController */
/* @var $model Repairs */

$this->breadcrumbs=array(
	'Repairs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Repairs', 'url'=>array('index')),
	array('label'=>'Create Repairs', 'url'=>array('create')),
	array('label'=>'View Repairs', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Repairs', 'url'=>array('admin')),
);
?>

<h1>Update Repairs <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>