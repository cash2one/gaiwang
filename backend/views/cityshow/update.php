<?php
/* @var $this CityshowController */
/* @var $model Cityshow */

$this->breadcrumbs=array(
	'城市馆'=>array('admin'),
	$model->title,
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>