<?php
/* @var $this AppTopicProblemController */
/* @var $model AppTopicProblem */

$this->breadcrumbs = array(
    Yii::t('AppTopicProblem','评论列表')=>array('admin'),
    Yii::t('AppTopicProblem','编辑'),
);

?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>