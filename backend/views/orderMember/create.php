<?php
/* @var $this AppTopicCarController */
/* @var $model AppTopicCar */

$this->breadcrumbs=array(
	Yii::t('AppTopicCar','订单用户管理')=>array('orderMember/admin'),
	Yii::t('AppTopicCar','添加订单用户'),
);

?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>