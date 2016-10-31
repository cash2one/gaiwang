<?php
/* @var $this AttributeValueController */
/* @var $model AttributeValue */
$type_id=$model->attrName->type_id;
$this->breadcrumbs=array(
	Yii::t('type', '商品类型') => array('type/admin'),
     Yii::t('attribute', '商品属性') => array("attribute/admin&type_id=$type_id"),
	Yii::t('attributeValue', '商品属性值')=>array("attribute-value/admin&attr_id=$model->attribute_id"),
	Yii::t('attributeValue', '更新'),
);

?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>