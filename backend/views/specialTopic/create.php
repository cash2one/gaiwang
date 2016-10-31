<?php

/* @var $this SpecialTopicController */
/* @var $model SpecialTopic */

$this->breadcrumbs = array(
    Yii::t('specialTopic', '专题管理') => array('admin'),
    Yii::t('specialTopic', '创建专题'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>