<?php
/* @var $this SpecValueController */
/* @var $model SpecValue */

$this->breadcrumbs=array(
    Yii::t('specValue','商品规格管理 ')=> array('spec/admin'),
    Yii::t('specValue','编辑商品规格值'), 
);

?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>