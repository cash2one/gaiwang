<?php

/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
?>
<?php

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'prepaid-card-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'title' => '充值卡使用列表',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'owner_id',
            'value' => 'PrepaidCard::showOwner($data)',
            'type' => 'raw'
        ),
        array(
            'name' => 'number',
            'value' => '" ".PrepaidCard::showNumber($data->number)'
        ),
        array(
            'name' => 'value',
            'value' => 'PrepaidCard::showScore($data->value)',
            'type' => 'raw'
        ),
        array(
            'name' => 'money',
            'value' => 'PrepaidCard::showMoney($data->money,$data->value)',
            'type' => 'raw'
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
        ),
        array(
            'name' => 'member_id',
            'value' => 'isset($data->member) ? $data->member->gai_number : ""'
        ),
        array(
            'name' => 'use_time',
            'value' => 'date("Y-m-d H:i:s", $data->use_time)'
        ),
    ),
));
?>