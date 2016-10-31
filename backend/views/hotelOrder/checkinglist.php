<?php
/* @var $this HotelOrderController */
/* @var $model HotelOrder */

$this->breadcrumbs = array(
    Yii::t('hotelOrder', '酒店订单') => array('admin'),
    Yii::t('hotelOrder', '订单对账列表'),
);

Yii::app()->clientScript->registerScript('search', "
$('#hotel-order-form').submit(function(){
	$('#hotel-order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php
$this->widget('GridView', array(
    'id' => 'hotel-order-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'ajaxUpdate' => false,
    'cssFile' => false,
    'columns' => array(
        'code',
        array(
            'name' => Yii::t('HotelOrder', '买家会员编号'),
            'value' => 'empty($data->member->gai_number) ? "" : $data->member->gai_number'
        ),
        'hotel_name',
        array(
            'type' => 'date',
            'name' => 'settled_time',
            'value' => '$data->settled_time'
        ),
        'contact',
        'mobile',
        array(
            'name' => 'total_price',
            'value' => 'HtmlHelper::formatPrice($data->total_price)',
            'htmlOptions' => array(
                'style' => 'color: #F60; font-weight: bold;',
            ),
        ),
        array(
            'type' => 'datetime',
            'name' => 'create_time',
            'value' => '$data->create_time'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('hotelOrder', '操作'),
            'template' => '{view}{complete}',
            'viewButtonLabel' => Yii::t('hotelOrder', '查看'),
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'visible' => "Yii::app()->user->checkAccess('HotelOrder.View')"
                ),
                'complete' => array(
                    'label' => Yii::t('hotelOrder', '完成'),
                    'url' => 'Yii::app()->createAbsoluteUrl("hotelOrder/orderComplete", array("id"=>$data->primaryKey))',
                    'imageUrl' => false,
                    'visible' => "Yii::app()->user->checkAccess('HotelOrder.OrderComplete')",
                )
            )
        ),
    ),
));
?>

