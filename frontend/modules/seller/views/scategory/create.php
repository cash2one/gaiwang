<?php

/* @var $this ScategoryController */
/* @var $model Scategory */
$this->breadcrumbs = array(
        Yii::t('sellerScategory', '宝贝分类管理') => array('admin'),
        Yii::t('sellerScategory', '新增宝贝分类'),
);
?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>