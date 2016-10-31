<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */

$this->breadcrumbs=array(
    Yii::t('sellerFranchiseeGoods','加盟商管理')=> array('/seller/franchiseeGoods/'),
    Yii::t('sellerFranchiseeGoods','添加加盟商线下商品'), 
);
?>

<div class="toolbar">
	<h3><?php echo Yii::t('sellerFranchiseeGoods','添加线下商品'); ?></h3>
</div>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerFranchiseeGoods','新增线下商品信息'); ?></h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>