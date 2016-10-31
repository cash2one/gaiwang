<?php
/** @var $this StoreController */
$title = Yii::t('cityShow', '城市馆主题添加');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('cityShow', '城市馆主题')=>array('/seller/cityshowTheme/list','csid'=>$this->csid),
    $title,
);
?>
<?php $res=Cityshow::getInfoById($this->csid,'title');?>
<div class="toolbar">
    <b><?php echo $res->title;?>-〉<?php echo Yii::t('cityShow', '添加主题'); ?></b>
</div>
<?php $this->renderPartial('_form', array('model' => $model)) ?>