<?php

/* @var $this NationalityController */
/* @var $model Nationality */

$this->breadcrumbs = array(
    Yii::t('nationality', '国籍') => array('admin'),
    Yii::t('nationality', '创建'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>