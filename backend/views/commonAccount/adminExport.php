<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'common-account-grid',
	'title'=>'共有账户列表',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        array(
            'name' => 'type',
            'value' => 'CommonAccount::showType($data->type)'
        ),
        array(
            'name' => 'gai_number',
            'value' => '$data->gai_number',
        ),
//        array(
//            'name' => 'cash',
//            'value' => 'CommonAccount::showMoney($data)',
//            'type' => 'raw'
//        ),
    ),
));
?>
