<?php
/* @var $this NationalityController */
/* @var $model Nationality */

$this->breadcrumbs = array(
    Yii::t('nationality', '国籍') => array('admin'),
    Yii::t('nationality', '更新'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>