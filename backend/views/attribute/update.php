<?php
$this->breadcrumbs=array(
	Yii::t('type', '商品类型') => array('type/admin'),
    Yii::t('attribute', '商品属性') => array("attribute/admin&type_id=$model->type_id"),	
	Yii::t('attribute', '更新'),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>