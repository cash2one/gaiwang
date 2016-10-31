<?php
$type_id=isset($_GET['type_id'])?$_GET['type_id']:'';
$this->breadcrumbs=array(
	Yii::t('type', '商品类型') => array('type/admin'),
    Yii::t('attribute', '商品属性') => array("attribute/admin&type_id=$type_id"),	
	Yii::t('attribute', '创建'),
);

?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>