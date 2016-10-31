<?php
/** @var $this StoreController */
/** @var $store Store */
$title = Yii::t('sellerStore', '店铺基本设置');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerStore', '店铺管理') => array('index'),
    $title,
);
?>
<?php if ($store): ?>
    <?php if ($store->status == $store::STATUS_APPLYING): ?>
        <div class="toolbar">
            <b><?php echo Yii::t('sellerStore', '编辑店铺'); ?></b>
            <span><?php echo Yii::t('sellerStore', '店铺在申请中，请等待管理员审核！'); ?></span>
        </div>
    <?php else: ?>
    <?php endif; ?>
<?php else: ?>
    <div class="toolbar">
        <b><?php echo Yii::t('sellerStore', '编辑店铺'); ?></b>
        <span><?php echo Yii::t('sellerStore', '您还没有申请店铺，请填写店铺基本信息进行申请。'); ?></span>
    </div>
    <?php $this->renderPartial('_form', array('model' => $model)) ?>
<?php endif; ?>