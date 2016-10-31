<?php
/** @var $this StoreController */
$title = Yii::t('cityShow', '编辑城市');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆列表')=>array('/seller/cityShow/list'),
    $title,
);
?>
<div class="toolbar">
    <b><?php echo Yii::t('cityShow', '编辑城市'); ?></b>
</div>
<?php $this->renderPartial('_form', array('model' => $model,'imgArr'=>$imgArr)) ?>