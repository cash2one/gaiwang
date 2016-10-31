<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */

$this->breadcrumbs=array(
    Yii::t('sellerFranchisee','加盟商管理')=> array('/seller/franchisee/'),
    Yii::t('sellerFranchisee','售货机商品入库'), 
);
?>

<div class="toolbar">
	<h3><?php echo Yii::t('sellerFranchisee','售货机商品入库'); ?></h3>
</div>
<h3 class="mt15 tableTitle"><?php echo $model->name; ?></h3>

<?php $this->renderPartial('_vending_machine_goods_stock_form', array('model'=>$model)); ?>