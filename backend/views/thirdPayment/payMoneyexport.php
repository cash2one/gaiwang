<?php

/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
?>
<?php

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'third-payment-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'title' => '代收付列表',
    'cssFile' => false,
    'columns' => array(
        'req_id',
         array(
            'name' => 'bank_code',
            'value' => 'ThirdPayment::bankList($data->bank_code)',
            'type' => 'raw'
        ),
        'account_no',
        'account_name',
        'amout',
        array(
           'name' => 'payment_type',
           'value' => 'ThirdPayment::getPaymentType($data->payment_type)'
            ),
         array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
        ), 
    ),
));
?>