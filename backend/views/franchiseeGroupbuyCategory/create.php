<?php

/* @var $this FranchiseeGroupbuyCategoryController */
/* @var $model FranchiseeGroupbuyCategory */

$this->breadcrumbs = array(
    Yii::t('franchiseeGroupbuyCategory', '类目') => array('admin'),
    Yii::t('franchiseeGroupbuyCategory', '添加'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>