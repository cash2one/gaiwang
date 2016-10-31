<?php

/* @var $this ScategoryController */
/* @var $model Scategory */
$this->breadcrumbs = array(
        Yii::t('sellerScategory', '线下商品分类管理') => array('admin'),
        Yii::t('sellerScategory', '新增线下商品分类'),
);
?>

<?php $this->renderPartial('_form', array('model' => $model,'franchisee_id'=>$franchisee_id)); ?>