<?php

/* @var $this SpecialTopicController */
/* @var $model SpecialTopic */

$this->breadcrumbs = array(
    Yii::t('specialTopic', '专题管理') => array('admin'),
    Yii::t('specialTopic', '编辑专题'),
    $model->name,
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>