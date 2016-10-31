<?php
/* @var $this MemberGradeController */
/* @var $model MemberGrade */

$this->breadcrumbs = array(
    Yii::t('memberGrade','会员级别管理 ')=> array('admin'),
    Yii::t('memberGrade','添加会员级别'), 
);
?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>