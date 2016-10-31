<?php

/* @var $this FranchiseeGroupbuyCategoryController */
/* @var $model FranchiseeGroupbuyCategory */

$this->breadcrumbs = array(
    Yii::t('groupbuyCategory', '类目') => array('admin'),
    Yii::t('groupbuyCategory', '重命名'),
);
?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>