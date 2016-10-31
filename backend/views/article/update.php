<?php
/* @var $this ArticleController */
/* @var $model Article */
$this->breadcrumbs = array(
    Yii::t('article', '文章') => array('admin'),
    Yii::t('article', '编辑'),
);
?>
<?php $this->renderPartial('_form', array('model' => $model)); ?>