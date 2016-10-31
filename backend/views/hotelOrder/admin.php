<?php

/* @var $this HotelOrderController */
/* @var $model HotelOrder */

$this->breadcrumbs = array(
    Yii::t('hotelOrder', '酒店订单') => array('admin'),
    Yii::t('hotelOrder', '查询列表'),
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
    'dataProvider' => $dataProvider,
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'ajaxUpdate' => false,
    'columns' => array(
        'code',
        array(
            'name' => Yii::t('HotelOrder', '买家会员编号'),
            'value' => 'empty($data->member->gai_number) ? "" : $data->member->gai_number'
        ),
        'hotel_name',
        array(
            'name' => 'create_time',
            'value' => '$data->create_time ? date("Y-m-d H:i:s", $data->create_time) : ""'
        ),
        array(
            'name' => 'settled_time',
            'value' => '$data->settled_time ? date("Y-m-d H:i:s", $data->settled_time) : ""'
        ),
        array(
            'name' => 'leave_time',
            'value' => '$data->leave_time ? date("Y-m-d H:i:s", $data->leave_time) : ""'
        ),
        'contact',
        array(
            'name' => 'people_infos',
            'value' => 'HotelOrder::analysisLodgerInfo($data->people_infos, false, chr(13).chr(10))'
        ),
        'mobile',
        array(
            'name' => 'status',
            'value' => 'HotelOrder::getOrderStatus($data->status)',
            'cssClassExpression' => 'HotelOrderController::getStatusColor($data->status)'
        ),
        array(
            'name' => 'pay_type',
            'value' => 'OnlinePay::getPayWayList($data->pay_type)',
            'cssClassExpression' => 'HotelOrderController::getPayStatusColor($data->pay_status)'
        ),
        array(
            'name' => 'pay_status',
            'value' => 'HotelOrder::getPayStatus($data->pay_status)',
            'cssClassExpression' => 'HotelOrderController::getPayStatusColor($data->pay_status)'
        ),
        array(
            'name' => 'unit_gai_price',
            'value' => 'HtmlHelper::formatPrice($data->unit_gai_price)',
            'htmlOptions' => array(
                'style' => 'color: #F60; font-weight: bold;',
            ),
        ),
        array(
            'name' => 'rooms',
            'value' => '$data->rooms',
        ),
        array(
            'name' => 'total_price',
            'value' => 'HtmlHelper::formatPrice($data->total_price)',
            'htmlOptions' => array(
                'style' => 'color: #F60; font-weight: bold;',
            ),
        ),
        array(
            'name' => 'amount_returned',
            'value' => 'Common::convertSingle($data->amount_returned,$data->member->type_id)',
        ),
        array(
            'name' => 'is_lottery',
            'value' => 'HotelOrder::getIsLottery($data->is_lottery)'
        ),
        array(
            'name' => 'is_recon',
            'value' => 'HotelOrder::getIsRecon($data->is_recon)',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonLabel' => Yii::t('hotelOrder', '查看'),
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'visible' => "Yii::app()->user->checkAccess('HotelOrder.View')"
                ),
            ),
        ),
    ),
));
?>
<?php $this->renderPartial('//layouts/_export', array('exportPage' => $exportPage, 'totalCount' => $totalCount)); ?>
