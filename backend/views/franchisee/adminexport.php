<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'franchisee-grid',
	'title'=>'加盟商列表',
    'dataProvider' => $model->searchWithStatistics(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        'code',
        array(
            'name' => Yii::t('franchisee', '所属会员'),
            'value' => '!empty($data->member)?(!empty($data->member->username)?$data->member->username:$data->member->gai_number):"null"'
        ),
        'mobile',
        'gai_discount',
        'member_discount',
        'max_machine',
        array(
            'name' => '地区',
            'value' => 'Region::getName($data->province_id,$data->city_id,$data->district_id)' 
        ),
        'street',
        array(
            'name' => 'categoryId',
            'value' => 'Franchisee::franchiseeCategoryName($data->id)'
        ),
//        'sum_money',
    ),
));
?>