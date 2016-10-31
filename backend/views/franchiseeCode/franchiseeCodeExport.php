<?php

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'franchiseeCode-grid',
    'title' => '生成预设加盟商编号',
    'dataProvider' => $model->exportSearch(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'code',
//        'status',
//        'create_time',
        array(
            'name' => 'status',
            'value' => 'FranchiseeCode::getStatic($data->status)',
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y/m/d H:i:s", $data->create_time)',
        ),
    ),
));
?>
