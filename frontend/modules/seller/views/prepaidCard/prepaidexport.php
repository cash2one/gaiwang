<?php

/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
?>
<?php

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'prepaidCard-grid',
    'dataProvider' => $model->searchList(),
    'itemsCssClass' => 'tab-reg',
    'title' => date('YmdHis').'商家充值卡记录',
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
            'name' => 'money',
            'value' => 'PrepaidCard::showMoney($data->money,$data->value)',
            'type' => 'raw'
        ),  
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
        ),
        array(
            'name' => 'status',
            'value' => 'PrepaidCard::showStatus($data->status)'
        ),
        array(
            'name' => 'is_recon',
            'value' => 'PrepaidCard::showRecon($data->is_recon)'
        ),
    ),
));
?>