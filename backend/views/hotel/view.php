<?php
/* @var $this HotelController */
/* @var $model Hotel */

$this->breadcrumbs=array(
	'Hotels'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Hotel', 'url'=>array('index')),
	array('label'=>'Create Hotel', 'url'=>array('create')),
	array('label'=>'Update Hotel', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Hotel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Hotel', 'url'=>array('admin')),
);
?>

<h1>View Hotel #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'keywords',
		'description',
		'name',
		'level_id',
		'brand_id',
		'province_id',
		'city_id',
		'district_id',
		'street',
		'content',
		'address_id',
		'lng',
		'lat',
		'sort',
		'thumbnail',
		'status',
		'create_time',
		'update_time',
		'checkout_time',
		'parking_lot',
		'meeting_room',
		'pickup_service',
	),
)); ?>
