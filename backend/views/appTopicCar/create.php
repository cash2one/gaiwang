<?php
/* @var $this AppTopicCarController */
/* @var $model AppTopicCar */

$this->breadcrumbs=array(
	Yii::t('AppTopicCar','新动')=>array('AppTopicCar/admin'),
	Yii::t('AppTopicCar','添加主题'),
);

?>
<?php $this->renderPartial('_form', array('model'=>$model,'subcontent'=>$subcontent)); ?>