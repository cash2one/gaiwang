<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'product-grid',
    'dataProvider' => $model->search(),
    'title'=>'活动商品列表',
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name'=> 'product_id',
            'value'=>'$data->product_id',
            'type'=>'raw',
        ),
        array(
            'name' => 'product_name',
            'value' => 'CHtml::link($data->product_name, DOMAIN."/JF/".$data->product_id,array("target"=>"_blank"))',
            'type' => 'raw',
        ),
        array(
            'name' => 'seller_name',
            'value' => '!empty($data->seller_name)?$data->seller_name:""'
        ),
        array(
            'type'=>'raw',
            'name' => '商城分类',
            'value' => 'Category::getCategoryName($data->g_category_id)'
        ),
        array(
            'type' => 'raw',
            'name' => '盖网售价',
            'value' => 'Product::showPrice($data->gai_sell_price)'
        ),
        array(
            'type' => 'raw',
            'name' => 'price',
            'value' => 'Product::showPrice($data->price)'
        ),
        array(
            'type' => 'raw',
            'name' => '库存',
            'value' => '$data->stock'
        ),
        array(
            'type' => 'raw',
            'name' => '销量',
            'value' => '$data->sales_volume'
        ),
        array(
            'name'=>'活动日期',
            'value' => '$data->date_start . " 至 " .$data->date_end'
        ),
        array(
            'name'=>'活动名称',
            'value'=>'$data->name',
            'type' => 'raw'
        ),
        array(
            'type' => 'raw',
            'name' => '商品审核状态',
            'value' => 'Product::showNewStatus($data->g_status, $data->reviewer, $data->audit_time, $data->product_id)'
        ),
        array(
            'name'=>'status',            
            'value'=>'isset($data->status) ? SeckillProductRelation::showActiveAudit($data->product_id,$data->rules_seting_id) : "未参加活动"',
            'type'=>'raw',
        )
    ),
));
?>