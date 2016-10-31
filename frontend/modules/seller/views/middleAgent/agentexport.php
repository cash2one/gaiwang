<?php

/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
?>
<?php
$title=array(
       '0'=>'直招居间商导出列表',
       '2'=>'二级居间商家导出列表',
       '3'=>'三级居间商家导出列表',
);
$array=array(
        array(
                'name' => '商家编号',
                'value' => 'substr_replace($data->gai_number, "****", 3,5)'
        ),
        array(
                'name' => '商家名称',
                'value' => '$data->username'
        ),
        
        array(
                'name' => 'create_time',
                'value'=> 'date("Y-m-d H:i:s",$data->create_time)'
        ),
       
        array(
                'name' => '店铺状态',
                'value' => 'Store::status($data->status)'
        ),
        array(
                'name' => '月销售额（元）',
                'value' => 'Store::getAcount($data->sid,strtotime(date("Y-m")),strtotime("-1 days",strtotime(date("Y-m-d 23:59:59"))))'
        ),
);

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'Store-grid',
    'dataProvider' => $model,
    'itemsCssClass' => 'tab-reg',
    'title' => date('YmdHis').$title[$exType],
    'cssFile' => false,
    'columns' => $array
));
?>