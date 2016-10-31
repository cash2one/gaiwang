<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'order-grid',
	'title'=>'订单列表',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
		array(
            'name' => 'code',
            'value' => '" ".$data->code',
        ),
        'member_id',
        'store_id',
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d G:i:s",$data->create_time)',
            'type' => 'raw',
        ),
        array(
            'name' => 'status',
            'value' => 'Order::status($data->status)',
            'type' => 'raw',
        ),
        array(
            'name' => 'delivery_status',
            'value' => 'Order::deliveryStatus($data->delivery_status)',
        ),
        array(
            'name' => 'pay_status',
            'value' => 'Order::payStatus($data->pay_status)',
        ),
        array(
            'name' => 'refund_status',
            'value' => 'Order::refundStatus($data->refund_status)',
        ),
        array(
            'name' => 'return_status',
            'value' => 'Order::returnStatus($data->return_status)',
        ),
        
        array(
            'name' => '总销售价',
            'value' => '$data->real_price - $data->freight',
        ),
        array(
            'name' => '总供货价',
            'value' => '$data->total_gai_price',
        ),
        array(
            'name' => '总运费',
            'value' => '$data->freight',
        ),

    ),
));
?>