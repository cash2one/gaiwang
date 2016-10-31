<?php
$this->breadcrumbs = array(
    Yii::t('interestCategory', '兴趣爱好分类管理') => array('admin'),
    Yii::t('interestCategory', '兴趣爱好分类列表'),
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#interestCategory-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model,)); ?>
<?php if (Yii::app()->user->checkAccess('InterestCategory.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/interestCategory/create') ?>">添加新分类</a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'interestCategory-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('InterestCategory.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('InterestCategory.Delete')"
                ),
            )
        )
    ),
));
?>
