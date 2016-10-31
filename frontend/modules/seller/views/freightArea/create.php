<?php
/** @var $typeModel FreightType */
$title = Yii::t('freightType', '运费详情');
$this->pageTitle = $title . '-' . $this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('freightType', '交易管理 '),
    Yii::t('freightType', '运费模版 '),
    $title,
    Yii::t('freightType', '指定地区运费设置'),
);
?>
<div class="toolbar">
    <h3><?php echo $typeModel->freightTemplate->name ?> - <?php echo $typeModel::mode($typeModel->mode) ?>
        - <?php echo Yii::t('freightType', '指定地区运费设置') ?></h3>
</div>
<?php $this->renderPartial('_form',array('model'=>$model,'typeModel'=>$typeModel)) ?>