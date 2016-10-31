<?php
/**
 * @var HotAddressController $this
 * @var HotAddress $model
 */
$this->breadcrumbs = array(
    Yii::t('hotel', '酒店管理') => array('admin'),
    Yii::t('hotel', '酒店热门地址列表'),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#hotAddress-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<div class="search-form"><?php $this->renderPartial('_search', array('model' => $model)); ?></div>

<?php if (Yii::app()->user->checkAccess('Travel.Hotel.Create')): ?>
    <a class="regm-sub"
       href="<?php echo Yii::app()->createAbsoluteUrl('travel/hotAddress/create') ?>"><?php echo Yii::t('hotel', '添加热门地址') ?></a>
    <div class="c10"></div>
<?php endif; ?>

<?php
$this->widget('GridView', array(
    'id' => 'hotAddress-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => false,
    'columns' => array(
        'name',
        array(
            'name' => '国家',
            'value' => '$data->city->province->nation->name',
        ),
        array(
            'name' => '省份',
            'value' => '$data->city->province->name',
        ),
        array(
            'name' => '城市',
            'value' => '$data->city->name',
        ),
        array(
            'name' => 'created_at',
            'value' => '$data->created_at',
            'type' => 'datetime',
        ),
        array(
            'name' => 'updated_at',
            'value' => '$data->updated_at',
            'type' => 'datetime',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'template' => '{update}{delete}',
            'updateButtonLabel' => Yii::t('hotel', '编辑'),
            'updateButtonImageUrl' => false,
            'deleteButtonLabel' => Yii::t('hotel', '删除'),
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => '确定删除？',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('hotel', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Hotel.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('hotel', '删除'),
                    'url' => 'Yii::app()->createUrl("travel/hotAddress/delete",array("id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('Hotel.Delete')"
                ),
            ),
        ),
    ),
));
?>
