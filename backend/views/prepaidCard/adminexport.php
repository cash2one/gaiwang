<?php

/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
?>
<?php

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'prepaid-card-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'title' => '充值卡记录',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'number',
            'value' => '" ".PrepaidCard::showNumber($data->number)'
        ),
        array(
            'name' => 'password',
            'value' => '" ".Tool::authcode($data->password,"DECODE")'
        ),
        array(
            'name' => 'value',
            'value' => 'PrepaidCard::showScore($data->value)',
            'type' => 'raw'
        ),
        array(
            'name' => 'owner_id',
            'value' => 'isset($data->owner) ? $data->owner->gai_number : ""'
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:is", $data->create_time)'
        ),
        'author_name',
        array(
            'name' => 'status',
            'value' => 'PrepaidCard::showStatus($data->status)'
        ),
    ),
));
?>