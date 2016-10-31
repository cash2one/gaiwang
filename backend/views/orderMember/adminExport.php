<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'order-grid',
	'title'=>'订单用户列表',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
		array(
            'name' => 'code',
            'value' => '" ".$data->code',
        ),
        'member_id',
        'real_name',
    	'mobile',
    	array(
    		'name' => '周岁',
    		'value' => '(date("Y")+1)-substr("$data->identity_number",6,4)',
    		'type' => 'raw',
    	),
    	array(
    		'name' => 'identity_number',
    		'value' => '" ".$data->identity_number',
    	),
        array(
            'name' => 'identity_front_img',
            'value' => 'IMG_DOMAIN . "/" . $data->identity_front_img',
            'type' => 'raw',
        ),
    	array(
    		'name' => 'identity_back_img',
    		'value' => 'IMG_DOMAIN . "/" . $data->identity_back_img',
    		'type' => 'raw',
    		),
    	array(
    		'name' => 'sex',
    		'value' => 'OrderMember::getMemberSex($data->sex)',
    		'type' => 'raw',
    		),
    	array(
    		'name' => 'create_time',
    		'value' => 'date("Y-m-d G:i:s",$data->create_time)',
    		'type' => 'raw',
    	),
       
    ),
));
?>