<?php
/** @var $this StoreController */
$title = Yii::t('sellerStore', '店铺基本设置');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerStore', '店铺管理') => array('view'),
    $title,
);
?>
<div class="toolbar">
    <b><?php echo Yii::t('sellerStore', '编辑店铺'); ?></b>
</div>
<?php $this->renderPartial('_form', array('model' => $model)) ?>