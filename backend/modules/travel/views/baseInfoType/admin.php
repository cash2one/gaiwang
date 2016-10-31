<?php $this->breadcrumbs = array(Yii::t('baseInfoType', '静态信息类型') => array('admin'), Yii::t('baseInfoType', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#baseInfoType-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('Travel.BaseInfoType.Create')): ?>
    <a class="regm-sub"
       href="<?php echo Yii::app()->createAbsoluteUrl('travel/baseInfoType/create') ?>"><?php echo '添加信息类型' ?></a>
<?php endif; ?>
    <div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'baseInfoType-grid',
    'dataProvider' => $model->search(),
    'ajaxUpdate' => false,
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'code',
        'name',
        array(
            'name' => 'creater',
            'value' => '$data->creater?$data->creater:"API"'
        ),
        array(
            'name' => 'created_at',
            'type' => 'dateTime',
        ),
        array(
            'name' => 'updater',
            'value' => '$data->updater?$data->updater:""'
        ),
        array(
            'name' => 'updated_at',
            'type' => 'dateTime',
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
                    'visible' => 'Yii::app()->user->checkAccess("Travel.BaseInfo.Update") && $data->creater != "API"',
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => 'Yii::app()->user->checkAccess("Travel.BaseInfo.Delete") && $data->creater != "API"',
                ),
            )
        )
    ),
));
?>