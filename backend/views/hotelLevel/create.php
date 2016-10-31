<?php
/* @var $this HotelLevelController */
/* @var $model HotelLevel */

$this->breadcrumbs=array(
	Yii::t('hotelLevel','酒店等级')=>array('admin'),
	Yii::t('hotelLevel','创建'),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>