<?php
/* @var $this HotelLevelController */
/* @var $model HotelLevel */

$this->breadcrumbs=array(
	Yii::t('hotelBrand','酒店品牌')=>array('admin'),
	Yii::t('hotelBrand','创建'),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>