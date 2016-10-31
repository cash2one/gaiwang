<?php
$this->breadcrumbs=array(
		Yii::t('AppHomePicture', '欢迎页列表')=>array('AppHomePicture/admin'),
		Yii::t('AppHomePicture', '修改'));
$this->renderPartial('_form',array('model'=>$model));
