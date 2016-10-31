<?php
$this->breadcrumbs=array(
	Yii::t('type', '商品类型')=>array('admin'),
	Yii::t('type', '更新'),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'specData'=>$specData,'specCheck'=>$specCheck,'brand'=>$brand,'brandCheck'=>$brandCheck)); ?>