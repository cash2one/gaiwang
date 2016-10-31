<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */

$this->breadcrumbs=array(
    Yii::t('sellerFranchisee','加盟商管理')=> array('/seller/franchisee/'),
    Yii::t('sellerFranchisee','添加加盟商客服'), 
);
?>

<div class="toolbar">
	<h3><?php echo Yii::t('sellerFranchisee','添加客服');?></h3>
</div>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerFranchisee','添加客服');?></h3>

<?php $this->renderPartial('_customer_form', array('model'=>$model)); ?>