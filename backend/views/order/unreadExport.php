<?php

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'recharge-grid',
	'title'=>'未阅读订单列表',
    'dataProvider' => $model->searchExport(Order::IS_READ_NO),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'code',
            'value' => '" ".$data->code',
        ),
        array('name'=>'o_member_id','header'=>'买家会员编号'),
        array('name'=>'o_store_id','header'=>'店铺名称'),
        array(
            'name' => 'create_time',
            'type' => 'dateTime',
        ),
        array(
            'name' => 'refund_status',
            'value' => 'Order::refundStatus($data->refund_status)',
        ),
        array(
            'name' => 'return_status',
            'value' => 'Order::returnStatus($data->return_status)',
        ),
        array('name'=>'sum_total_price','header'=>'总销售价'),
        array('name'=>'sum_gai_price','header'=>'总供货价'),
        array('name'=>'freight','header'=>'总运费'),
    ),
));
?>
