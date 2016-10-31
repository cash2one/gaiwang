<?php
/* @var $this SlideController */
/* @var $model Slide */

$this->breadcrumbs = array(Yii::t('sellerSlide', '商家广告') => array('admin'), Yii::t('sellerSlide', '更新广告'));
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>