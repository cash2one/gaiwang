<?php

/* @var $this RechargeController */
/* @var $model Recharge */

$this->breadcrumbs = array(
    '积分充值' => array('admin'),
    '列表',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#recharge-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php

$this->widget('GridView', array(
    'id' => 'recharge-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',    
    'cssFile' => false,
    'ajaxUpdate' => false,
    'columns' => array(
        'code',
        array(
            'name' => 'member_id',
            'value' => '!empty($data->member->gai_number)?$data->member->gai_number:""'
        ),
        array(
            'name' => 'money',
            'value' => 'Recharge::showMoney($data->money)',
            'type' => 'raw'
        ),
        array(
            'name' => 'score',
            'value' => 'Recharge::showScore($data->score)',
            'type' => 'raw'
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
        ),
        array(
            'name' => 'status',
            'value' => 'Recharge::showStatus($data->status)',
            'type' => 'raw'
        ),
        array(
            'name' => 'pay_time',
            'value' => '$data->pay_time ? date("Y-m-d H:i:s", $data->pay_time) :""'
        ),
        array(
            'name' => 'pay_type',
            'value' => 'Recharge::showPayType($data->pay_type)',
            'type' => 'raw'
        ),
        array(
            'name' => 'number',
            'value' => 'Recharge::showNumber($data->description)',
            'type' => 'raw'
        )
    ),
));
?>

<?php 
	$this->renderPartial('/layouts/_export', array(
	    'model' => $model,'exportPage' => $exportPage,'totalCount'=>$totalCount,
	));
?>
