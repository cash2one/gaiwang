<?php
/* @var $this AppTopicCarCommentController */
/* @var $model AppTopicCarComment */

$this->breadcrumbs = array(
    Yii::t('AppTopicCarComment','评论列表')=>array('admin'),
    Yii::t('AppTopicCarComment','编辑'),
);

?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>