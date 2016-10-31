<?php
/**
 * @var HotelTermController $this
 * @var HotelTerm $model
 */
$this->breadcrumbs = array(
    Yii::t('hotel', '酒店管理') => array('admin'),
    Yii::t('hotel', '酒店热门地址列表'),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#hotelTerm-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<div class="search-form"><?php $this->renderPartial('_search', array('model' => $model)); ?></div>
<?php
$ratePlan = HotelRatePlan::model()->find(array('select' => 'hotel_id', 'condition' => 'rate_plan_id=:rate_plan_id', 'params' => array(':rate_plan_id' => $model->rateplan_id)));
$soucre = Hotel::model()->find(array('select' => 'source', 'condition' => 'hotel_id=:hotel_id', 'params' => array(':hotel_id' => $ratePlan->hotel_id)));
?>

<?php if (Yii::app()->user->checkAccess('Hotel.Create') && ($soucre->source == Hotel::SOURCE_BY_HAND)): ?>
    <a class="regm-sub"
       href="<?php echo Yii::app()->createAbsoluteUrl('travel/hotelTerm/create', array('ratePlanId' => $model->rateplan_id)) ?>"><?php echo Yii::t('hotel', '添加条款') ?></a>
    <div class="c10"></div>
<?php endif; ?>

<?php
$this->widget('GridView', array(
    'id' => 'hotelTerm-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => false,
    'columns' => array(
        'time',
        'term_content',
        'room_num',
        'bind_start_date',
        'bind_end_date',
        array(
            'name'=>'条款类型',
            'value'=>'HotelTerm::getType($data->term_type)',
        ),
        'term_name',
        'days',
        'book_start_date',
        'book_end_date',
        'need_assure',

        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'template' => '{update}{delete}',
            'updateButtonImageUrl' => false,
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => '确定删除？',
            'buttons' => array(
                'update' => array(
                    'label' => Yii::t('hotel', '编辑'),
                    'visible' => "Yii::app()->user->checkAccess('Hotel.Update')"
                ),
                'delete' => array(
                    'label' => Yii::t('hotel', '删除'),
                    'visible' => "Yii::app()->user->checkAccess('Hotel.Delete')"
                ),
            ),
        ),
    ),
));
?>
