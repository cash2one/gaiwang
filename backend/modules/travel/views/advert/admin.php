<?php $this->breadcrumbs = array(Yii::t('advert', '广告位') => array('admin'), Yii::t('advert', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#advert-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('Advert.Create')): ?>
    <a class="regm-sub"  href="<?php echo Yii::app()->createAbsoluteUrl('travel/advert/create') ?>"><?php echo '添加广告' ?></a>
<?php endif; ?>
<?php if (Yii::app()->user->checkAccess('Advert.GenerateAllAdvertCache')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('travel/advert/updateAllCache') ?>"><?php echo '更新所有缓存' ?></a>
<?php endif; ?>
    <div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'advert-grid',
    'dataProvider' => $model->search(),
    'ajaxUpdate' => false,
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        'code',
        'content',
        array('name' => 'type', 'value' => 'Advert::getAdvertType($data->type)'),
        'width',
        'height',
        array('name' => 'status', 'value' => 'Advert::getAdvertStatus($data->status)'),
        'creater',
        array(
            'name' => 'created_at',
            'type' => 'dateTime',
        ),
        'updater',
        array(
            'name' => 'updated_at',
            'type' => 'dateTime',
        ),
        array(
            'type' => 'raw',
            'name' => Yii::t('advert', '正在投放广告'),
//            'value' => '$data->getCountPicture($data->id)',
            'value' => 'CHtml::link( $data->getCountPicture($data->id), array("advertPicture/admin","aid"=>"$data->id") ,array("class"=>"reg-sub" ))',
            'visible' => "Yii::app()->user->checkAccess('AdvertPicture.Admin')",
            'type'=>'raw',
        ),

        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => Yii::t('advert', '删除广告位将连同删除所有所属广告，请谨慎操作！'),
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('user', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Advert.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Advert.Delete')"
                ),
            )
        )
    ),
));
?>