<?php

/* @var $this SpecialTopicCategoryController */
/* @var $model SpecialTopicCategory */

$this->breadcrumbs = array(
    '专题管理' => array('/specialTopic/admin'),
    '专题分类' => array('admin', 'specialId' => $this->specialId),
    '编辑分类'
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>