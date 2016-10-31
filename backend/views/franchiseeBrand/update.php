<?php
/* @var $this FranchiseeBrandController */
/* @var $model FranchiseeBrand */
$this->breadcrumbs=array(
    Yii::t('brand','加盟商管理 ')=> array('admin'),
    Yii::t('brand','加盟商品牌编辑'), 
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>