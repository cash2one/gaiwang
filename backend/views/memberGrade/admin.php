<?php
/* @var $this MemberGradeController */
/* @var $model MemberGrade */

$this->breadcrumbs = array(
    Yii::t('memberGrade', '会员积分额度管理 ') => array('admin'),
    Yii::t('memberGrade', '级别管理'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#member-grade-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
<?php if (Yii::app()->user->checkAccess('MemberGrade.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/memberGrade/create') ?>">添加会员级别</a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'member-grade-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
        'name',
        'description',
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}',
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('MemberGrade.Update')"
                ),
            )
        )
    ),
));
?>
