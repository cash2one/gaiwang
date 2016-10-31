<?php
/* @var $this FranchiseeBrandController */
/* @var $model FranchiseeBrand */

$this->breadcrumbs=array(
	Yii::t('franchisee','加盟商管理')=>array('admin'),
	Yii::t('franchisee','添加加盟品牌'),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>