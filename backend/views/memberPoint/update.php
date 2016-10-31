<?php
/* @var $this MemberGradeController */
/* @var $model MemberGrade */

$this->breadcrumbs=array(
    Yii::t('memberGrade','会员积分额度 ')=> array('admin'),
    Yii::t('memberGrade','编辑积分额度'), 
);

?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>