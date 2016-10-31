<?php

/* @var $this FranchiseeGroupbuyController */
/* @var $model FranchiseeGroupbuy */
$this->breadcrumbs = array(
    Yii::t('lineGroupbuy', '线下团购') => array('admin'),
    Yii::t('lineGroupbuy', '发布'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model,'imgModel'=>$imgModel)); ?>



