<?php $this->breadcrumbs = array(Yii::t('city', '城市') => array('admin'), Yii::t('city', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#city-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('Travel.City.Create')): ?>
    <a class="regm-sub"  href="<?php echo Yii::app()->createAbsoluteUrl('travel/city/create') ?>"><?php echo '添加城市' ?></a>
<?php endif; ?>
    <div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'city-grid',
    'dataProvider' => $model->search(),
    'ajaxUpdate' => false,
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name'=>'省份',
            'value' => '$data->province->name',
        ),
        'name',
        'code',
        'sort',
        array(
            'name' => 'creater',
            'value' => '$data->creater?$data->creater:"API"'
        ),
        array(
            'name'=>'created_at',
            'type'=>'dateTime',
        ),
        array(
            'name' => 'updater',
            'value' => '$data->updater?$data->updater:""'
        ),
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
                    'visible' => "Yii::app()->user->checkAccess('Travel.Province.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => 'Yii::app()->user->checkAccess("Travel.Province.Delete") && !Province::hasCity($data->code)',
                ),
            )
        )
    ),
));
?>