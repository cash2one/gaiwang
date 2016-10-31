<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */

$this->breadcrumbs=array(
    Yii::t('sellerFranchisee','加盟商管理')=> array('/seller/franchisee/'),
    Yii::t('sellerFranchisee','加盟商文章编辑'), 
);
?>

<div class="toolbar">
	<h3><?php echo Yii::t('sellerFranchisee','编辑文章'); ?></h3>
</div>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerFranchisee','文章信息'); ?></h3>

<?php $this->renderPartial('_artile_form', array('model'=>$model)); ?>