<?php
/**
 * @var RatePlanController $this
 * @var HotelRatePlan $model
 */
$this->breadcrumbs = array(
    Yii::t('hotel', '酒店管理') => array('admin'),
    Yii::t('hotel', '酒店热门地址列表'),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function(){
        $('#ratePlan-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<div class="search-form"><?php $this->renderPartial('_search', array('model' => $model)); ?></div>
<?php $soucre = Hotel::model()->find(array('select' => 'source', 'condition' => 'hotel_id=:hotel_id', 'params' => array(':hotel_id' => $model->hotel_id))) ?>
<?php if (Yii::app()->user->checkAccess('Hotel.Create') && ($soucre->source == Hotel::SOURCE_BY_HAND)): ?>
    <a class="regm-sub"
       href="<?php echo Yii::app()->createAbsoluteUrl('travel/ratePlan/create',array('hotelId'=>$model->hotel_id,'roomId'=>$model->room_id)) ?>"><?php echo Yii::t('hotel', '添加价格计划') ?></a>
    <div class="c10"></div>
<?php endif; ?>

<?php
$this->widget('GridView', array(
    'id' => 'ratePlan-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => false,
    'columns' => array(
        'rate_plan_id',
        'rate_plan_name',
        'bed_type',
        'commend_level',
        'pay_method',
        'supply_name',
        'notices',

        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'template' => '{term}{update}{delete}',
            'updateButtonLabel' => Yii::t('hotel', '编辑'),
            'updateButtonImageUrl' => false,
            'deleteButtonLabel' => Yii::t('hotel', '删除'),
            'deleteButtonImageUrl' => false,
            'deleteConfirmation' => '确定删除？',
            'buttons' => array(
                'term' => array(
                    'label' => Yii::t('hotel', '条款'),
                    'url' => 'Yii::app()->createUrl("travel/hotelTerm/admin",array("ratePlanId"=>$data->rate_plan_id))',
                    'visible' => "Yii::app()->user->checkAccess('Hotel.Update')"
                ),
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
