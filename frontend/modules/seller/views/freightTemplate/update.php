<?php
/* @var $this FreightTemplateController */
/* @var $model FreightTemplate */

$title = Yii::t('sellerFreightTemplate', '修改运费模版');
$this->pageTitle = $title.'-'.$this->pageTitle;
$this->breadcrumbs = array(
    Yii::t('sellerFreightTemplate', '交易管理 '),
    Yii::t('sellerFreightTemplate', '运费模版 '),
    $title,
);
?>

<?php $this->renderPartial('_form', array('model'=>$model,'modeArray'=>$modeArray)); ?>