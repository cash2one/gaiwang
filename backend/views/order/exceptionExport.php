<?php $this->widget('comext.PHPExcel.EExcelView', array(
    'id'=>'order-grid',
	'title'=>'异常订单列表',
    'dataProvider'=>$model->searchException(),
    'itemsCssClass' => 'tab-reg',
    'columns'=>array(
        array(
            'name' => 'code',
            'value' => '" ".$data->code',
        ),
        array(
            'name'=>'member_id',
            'header'=>'买家会员编号'
        ),
        array(
            'name'=>'store_id',
            'header'=>'商铺名称',
        ),
        array(
            'name'=>'refund_status',
            'value'=>'Order::refundStatus($data->refund_status)',
        ),
        array(
            'name'=>'return_status',
            'value'=>'Order::returnStatus($data->return_status)',
        ),
        array(
            'name'=>'create_time',
            'type'=>'dateTime'
        ),
        'pay_price',
        'real_price',
        'freight',
    ),
)); ?>