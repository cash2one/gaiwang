<?php
$this->breadcrumbs = array(
    Yii::t('franchisee', '加盟商管理') => array('admin'),
    Yii::t('franchisee', '盖网通商城订单'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#machineProductOrder-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_searchorder', array('model' => $model)); ?>

<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'machineProductOrder-grid',
    'dataProvider' => $model->searchOrder(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'code',
        'phone',
        array(
            'name'=>'加盟商名称',
            'value'=>'$data->franchisee ? $data->franchisee->name : "null"'
        ),
        array(
            'name' => '买家会员编号',
            'value' => '$data->member ? $data->member->gai_number : "null"'
        ),
        array(
            'name'=>'支付状态',
            'value'=>'MachineProductOrder::payStatus($data->pay_status)'
        ),
        array(
            'name'=>'pay_time',
            'value'=>'date("Y-m-d",$data->pay_time)'
        ),
        array(
            'name'=>'订单状态',
            'value'=>'MachineProductOrder::status($data->status)'
        ),
        array(
            'name'=>'消费状态',
            'value'=>'MachineProductOrder::consumeStatus($data->consume_status)'
        ),
        array(
            'name'=>'消费时间',
            'value'=>'date("Y-m-d",$data->consume_time)'
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => Yii::t('home', '操作'),
            'template' => '{detail}',
            //'updateButtonImageUrl' => false,
           // 'deleteButtonImageUrl' => false,
            'buttons' => array(
                'detail' => array(
                    'label' => Yii::t('MachineProductOrder', '详情'),
                    'url'=>'Yii::app()->createUrl("franchisee/machineOrderDetail", array("id"=>$data->id))',
                   // 'visible' => "Yii::app()->user->checkAccess('Franchisee.Update')"
                    
                ),
            )
        )
    ),
));
?>
