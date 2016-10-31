<?php
$this->breadcrumbs=array(
	Yii::t('hotelAddress','酒店供应商列表')=>array('admin'),
	Yii::t('hotelAddress','创建'),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>