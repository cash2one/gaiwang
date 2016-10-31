 <?php $this->widget('GridView', array(
    'id'=>'pay-result-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
     'itemsCssClass' => 'tab-reg',
     'cssFile' => false,
    'columns'=>array(
        'id',
        'code',
        array(
            'name'=>'pay_result',
            'value'=>'Tool::truncateUtf8String($data->pay_result,20);',
        ),
        array('name'=>'pay_type','value'=>'Order::payType($data->pay_type)'),
        array('name'=>'update_time','type'=>'dateTime'),
        array('name'=>'create_time','type'=>'dateTime'),
        'times',
        array('name'=>'order_type','value'=>'PayResultForm::OrderType($data->order_type)'),
        array(
            'class'=>'CButtonColumn',
            'template' => '{view}',
            'viewButtonImageUrl' => false,
        ),
    ),
));