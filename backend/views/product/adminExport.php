<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'product-grid',
	'title'=>'商品列表',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'id', 
		'name',
        array(
            'name' => 'code',
            'value' => '" ".$data->code',
        ),
        array(
            'name' => 'store_id',
            'value' => '!empty($data->store->name)?$data->store->name:""'
        ),
        array(
            'name' => 'category_id',
            'value' => '!empty($data->category->name)?$data->category->name:""'
        ),
        //'market_price',
        array(
            'type' => 'raw',
            'name' => 'gai_price',
            'value' => 'Product::showPrice($data->gai_price)'
        ),
        array(
            'type' => 'raw',
            'name' => 'price',
            'value' => 'Product::showPrice($data->price)'
        ),
        array(
            'name' => 'is_publish',
            'value' => '$data->is_publish ? "是" : "否"'
        ),
        array(
            'type' => 'raw',
            'name' => 'stock',
            'value' => 'Product::showStock($data->stock)'
        ),
        'sales_volume',
        array(
            'type' => 'raw',
            'name' => 'status',
            'value' => 'Product::showNewStatus($data->status, $data->reviewer, $data->audit_time, $data->id)'
        ),
        array(
            'type' => 'raw',
            'name' => 'show',
            'value' => '$data->show ? "是" : "否"'
        ),
       array(
            'name' => '上架时间',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
            ),
       array(
            'name' => '更新时间',
            'value' => '($data->update_time!=0 && $data->update_time!="") ? date("Y-m-d H:i:s", $data->update_time) : ""'           
        ),
    ),
));
?>