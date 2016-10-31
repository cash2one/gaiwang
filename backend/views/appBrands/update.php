<?php
$this->breadcrumbs=array(
		Yii::t('AppBrands', '专题列表')=>array('AppBrands/admin'),
		Yii::t('AppBrands', '修改'));
$this->renderPartial('_form',array('model'=>$model));
