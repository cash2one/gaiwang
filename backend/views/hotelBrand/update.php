<?php
$this->breadcrumbs=array(
	Yii::t('hotelBrand','酒店品牌')=>array('admin'),Yii::t('hotelBrand','更新'),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>