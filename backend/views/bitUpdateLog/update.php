<?php
/* @var $this BitUpdateLogController */
/* @var $model BitUpdateLog */

$this->breadcrumbs=array(
	'Bit Update Logs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update BitUpdateLog <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>