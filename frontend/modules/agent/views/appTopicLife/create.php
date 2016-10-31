<?php
/* @var $this AppTopicCarController */
/* @var $model AppTopicCar */

$this->breadcrumbs=array(
	Yii::t('AppTopicLife','臻致生活')=>array('AppTopicLife/admin'),
	Yii::t('AppTopicLife','添加专题'),
);

?>
<?php $this->renderPartial('_form', array('model'=>$model,'subcontent'=>'')); ?>