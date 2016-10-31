<?php
/* @var $this SpecController */
/* @var $model Spec */

$this->breadcrumbs=array(
    Yii::t('spec','商品规格管理 ')=> array('admin'),
    Yii::t('spec','编辑商品规格'), 
);

?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>