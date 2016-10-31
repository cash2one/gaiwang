<?php
/* @var $this OrderController */
/* @var $model Order */
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#order-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
//	return false;
});
");
?>

<div class="search-form" >
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php
?>
<?php
$this->widget('GridView', array(
    'id' => 'order-grid',
    'dataProvider' => $model->search2RException(),
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => 'code',
            'value' => '$data->real_price>=20000?"<span class=\"ico_sb\">".$data->code."</span>":$data->code',
            'type' => 'raw',
        ),
        'member_id',
        'store_id',
        array(
            'name' => 'status',
            'value' => '"<span class=\"status\" data-status=\"$data->status\">".Order::status($data->status)."</span>"',
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
        array('name' => 'create_time', 'type' => 'dateTime'),
        array(
            'name' => '支付单号',
            'value' => '$data->parent_code'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => '操作',
            'buttons' => array(
                'attr' => array(
                    'label' => '退款',
                    'imageUrl' => false,
                    'url' => 'Yii::app()->createUrl("/exceptionOrder/operate",array("id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('ExceptionOrder.Operate')"
                ),
            ),
            'template' => '{attr}',
        ),
    ),
));
?>

