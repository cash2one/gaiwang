<?php

/* @var $this AccountFlowController */
/* @var $model AccountFlow */

$this->breadcrumbs = array(
    '流水' => array('admin'),
    '列表',
);
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php
$this->widget('GridView', array(
    'id' => 'accountFlow-grid',
    'dataProvider' => $model->backendSearch(),
    'filter' => $model,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'gai_number',
        array(
            'filter' => false,
            'name' => 'card_no',
            'value' => '$data->card_no'
        ),
        array(
            'filter' => false,
            'name' => 'debit_amount',
            'value' => '$data->debit_amount'
        ),
        array(
            'filter' => false,
            'name' => 'credit_amount',
            'value' => '$data->credit_amount'
        ),
        'node',
        array(
            'filter' => false,
            'name' => 'transaction_type',
            'value' => 'AccountFlow::showTransactinnType($data->transaction_type)',
        ),
        array(
            'filter' => false,
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
        ),
        array(
            'filter' => AccountFlow::getType(),
            'name' => 'type',
            'value' => 'AccountFlow::showType($data->type)'
        ),
        array(
            'filter' => AccountFlow::getOperateType(),
            'name' => 'operate_type',
            'value' => 'AccountFlow::showOperateType($data->operate_type)'
        ),
        'order_code',
        array(
            'filter' => false,
            'name' => 'ratio',
            'value' => '$data->ratio'
        ),
        array(
            'filter' => false,
            'name' => 'remark',
            'value' => '$data->remark'
        ),
        array(
            'filter' => false,
            'name' => 'ip',
            'value' => 'Tool::int2ip($data->ip)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonImageUrl' => false,
        ),
    ),
));


$this->renderPartial('/layouts/_export', array(
    'model' => $model, 'exportPage' => $exportPage, 'totalCount' => $totalCount,
));
?>
