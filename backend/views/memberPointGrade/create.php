<?php
/* @var $this MemberGradeController */
/* @var $model MemberGrade */

$this->breadcrumbs = array(
    Yii::t('memberGrade','会员积分额度级别管理 ')=> array('admin'),
    Yii::t('memberGrade','添加积分额度级别'), 
);
?>

<?php $this->renderPartial('_form', array('model' => $model)); ?>