<?php
$this->breadcrumbs=array(
		Yii::t('AppBrands', '专题列表')=>array('AppBrands/Admin'),
		Yii::t('AppBrands', '添加'));
$this->renderPartial('_form',array('model'=>$model));
?>