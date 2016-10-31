<?php
/** @var $this StoreController */
$title = Yii::t('cityShow', '添加城市馆');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆列表')=>array('/seller/cityshow/list'),
    $title,
);
?>
<div class="toolbar">
    <b><?php echo Yii::t('cityShow', '城市馆基本信息'); ?></b>
</div>
<?php $this->renderPartial('_form', array('model' => $model,'imgArr'=>$imgArr)) ?>