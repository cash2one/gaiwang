<?php
/* @var $this TypeController */
/* @var $model Type */
?>
<?php
$this->breadcrumbs=array(
	Yii::t('type', '商品类型')=>array('admin'),
	Yii::t('type', '创建'),
);

?>
<?php $this->renderPartial('_form', array('model'=>$model,'specData'=>$specData,'brand'=>$brand,'specCheck'=>$specCheck,'brandCheck'=>$brandCheck)); ?>