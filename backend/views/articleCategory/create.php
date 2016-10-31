<?php

/* @var $this ArticleCategoryController */
/* @var $model ArticleCategory */

$this->breadcrumbs = array(
    Yii::t('articleCategory', '文章分类') => array('admin'),
    Yii::t('articleCategory', '添加'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>