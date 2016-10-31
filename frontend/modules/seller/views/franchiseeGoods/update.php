<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */

$this->breadcrumbs=array(
    Yii::t('sellerFranchiseeGoods','加盟商管理')=> array('/seller/franchiseeGoods/'),
    Yii::t('sellerFranchiseeGoods','更新加盟商线下商品信息'), 
);
?>

<div class="toolbar">
	<h3><?php echo Yii::t('sellerFranchiseeGoods','修改线下商品'); ?></h3>
</div>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerFranchiseeGoods','更新线下商品信息'); ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>