<?php
/* @var $this SlideController */
/* @var $model Slide */

$this->breadcrumbs = array(Yii::t('sellerSlide', '商家广告') => array('admin'), Yii::t('sellerSlide', '添加广告'));
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>