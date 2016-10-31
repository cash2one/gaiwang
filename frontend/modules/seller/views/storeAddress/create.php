<?php
/* @var $this StoreAddressController */
/* @var $model StoreAddress */

$title = Yii::t('storeAddress', '添加店铺地址');
$this->pageTitle = $title.'-'.$this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('storeAddress', '交易管理 '),
    $title,
);

?>
<div class="toolbar">
    <h3><?php echo Yii::t('storeAddress','添加店铺地址'); ?></h3>
</div>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>