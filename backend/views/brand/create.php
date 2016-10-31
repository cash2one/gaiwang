<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs = array(Yii::t('brand', '品牌 ') => array('admin'), Yii::t('brand', '创建'));
$this->renderPartial('_form', array('model' => $model));
?>