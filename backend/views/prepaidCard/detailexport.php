<?php

/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
?>
<?php

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'prepaid-card-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'title' => '积分返还充值卡使用记录',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'number',
            'value' => '" ".PrepaidCard::showNumber($data->number)'
        ),
        'value',
        'money',
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