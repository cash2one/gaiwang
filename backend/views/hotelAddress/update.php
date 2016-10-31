<?php
$this->breadcrumbs=array(
	Yii::t('hotelAddress','酒店热门地址列表')=>array('admin'),
	Yii::t('hotelAddress','更新'),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>