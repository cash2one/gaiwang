<?php
/* @var $this MemberGradeController */
/* @var $model MemberGrade */

$this->breadcrumbs = array(
    Yii::t('memberGrade', '会员积分额度级别管理 ') => array('admin'),
    Yii::t('memberGrade', '级别管理'),
);
?>

<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
<?php if (Yii::app()->user->checkAccess('MemberPointGrade.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/memberPointGrade/create') ?>">添加会员级别</a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'member-point-grade-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
        'grade_name',
        'grade_point',
        'day_usable_point',
    	'month_usable_point',
		array(
		      'name' => 'update_time',
		      'value' => 'date("Y-m-d H:i:s",$data->update_time)',
		),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}',
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('MemberPointGrade.Update')"
                ),
            )
        )
    ),
));
?>
