<?php
/** @var $this StoreController */
$title = Yii::t('cityShow', '添加商家');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆列表')=>array('/seller/cityshow/list'),
    $title,
);
?>
<?php $res=Cityshow::getInfoById($this->csid,'title');?>
<div class="toolbar">
    <b><?php echo $res->title;?>-〉<?php echo Yii::t('cityShow', '添加商家'); ?></b>
</div>
<?php $this->renderPartial('_storeform', array('model' => $model)) ?>