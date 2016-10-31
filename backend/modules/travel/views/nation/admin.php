<?php $this->breadcrumbs = array(Yii::t('advert', '国家') => array('admin'), Yii::t('advert', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#nation-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('Travel.Nation.Create')): ?>
    <a class="regm-sub"  href="<?php echo Yii::app()->createAbsoluteUrl('travel/nation/create') ?>"><?php echo '添加国家' ?></a>
<?php endif; ?>
    <div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'nation-grid',
    'dataProvider' => $model->search(),
    'ajaxUpdate' => false,
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        'sort',
        'creater',
        array(
            'name'=>'created_at',
            'type'=>'dateTime',
        ),
        'updater',
        array(
            'name'=>'updated_at',
            'type'=>'dateTime',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => Yii::t('nation', '确定要删除！'),
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Travel.Nation.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => 'Yii::app()->user->checkAccess("Travel.Nation.Delete") && !Nation::hasProvince($data->id)',
                ),
            )
        )
    ),
));
?>