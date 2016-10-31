<?php

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'recharge-grid',
	'title'=>'积分充值列表',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
		array(
            'name' => 'code',
            'value' => '" ".$data->code'
        ),
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
