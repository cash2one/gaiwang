<?php
$attr_id=isset($_GET['attr_id'])?$_GET['attr_id']:'';
$type_id=Attribute::model()->findByPk($attr_id)->type_id;
$this->breadcrumbs=array(
	Yii::t('type', '商品类型') => array('type/admin'),
     Yii::t('attribute', '商品属性') => array("attribute/admin&type_id=$type_id"),
	Yii::t('attributeValue', '商品属性值')=>array("attribute-value/admin&attr_id=$attr_id"),
	Yii::t('attributeValue', '创建'),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>