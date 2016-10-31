<?php
$this->breadcrumbs=array(
		Yii::t('AppHomePicture', '欢迎页列表')=>array('AppHomePicture/Admin'),
		Yii::t('AppHomePicture', '添加'));
$this->renderPartial('_form',array('model'=>$model));
?>