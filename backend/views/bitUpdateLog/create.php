<?php
/* @var $this BitUpdateLogController */
/* @var $model BitUpdateLog */

$this->breadcrumbs=array(
	'Bit create Logs'=>array('index'),
	'Update',
);
?>

<h1>Create BitUpdateLog <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>