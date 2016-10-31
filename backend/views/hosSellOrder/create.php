<?php
$this->breadcrumbs=array(
		Yii::t('HosSellOrder', '热卖管理')=>array('HosSellOrder/index'),
		Yii::t('HosSellOrder', '添加'));
$this->renderPartial('_form',array('model'=>$model));
?>
