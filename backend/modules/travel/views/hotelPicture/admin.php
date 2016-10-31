<?php $this->breadcrumbs = array(Yii::t('hotelPicture', '酒店图片') => array('admin'), Yii::t('hotelPicture', '列表')); ?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#hotelPicture-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php if (Yii::app()->user->checkAccess('Travel.HotelPicture.Create')): ?>
    <a class="regm-sub"
       href="<?php echo Yii::app()->createAbsoluteUrl('travel/hotelPicture/create',array('hotelId'=>$model->hotel_id)) ?>"><?php echo '添加酒店图片' ?></a>
<?php endif; ?>
    <div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'hotelPicture-grid',
    'dataProvider' => $model->search(),
    'ajaxUpdate' => false,
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => '房间',
            'value' => 'isset($data->hotel)?$data->hotel->chn_name:""',
        ),
        array(
            'name' => '图片',
            'value' => 'CHtml::image(IMG_DOMAIN . "/" .$data->path, "", array("width" => 100,"height" => 80, "style" => "display: inline-block"))',
            'type' => 'raw',
        ),
        array(
            'name' => '房间',
            'value' => 'isset($data->hotelRoom)?$data->hotelRoom->name:""',
        ),
        array(
            'name' => 'type',
            'value' => '$data->pType->name',
        ),
        'sort',
        'creater',
        array(
            'name' => 'created_at',
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
                    'visible' => 'Yii::app()->user->checkAccess("Travel.HotelPicture.Update")'
                ),
                'delete' => array(
                    'label' => Yii::t('user', '删除'),
                    'visible' => 'Yii::app()->user->checkAccess("Travel.HotelPicture.Delete")',
                ),
            )
        )
    ),
));
?>