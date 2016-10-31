<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'machine-grid',
	'title'=>'盖机列表',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'name' => 'province_id',
            'value' => 'Region::getName($data->province_id, $data->city_id, $data->district_id)',
        ),
        'biz_name',
        'intro_member_id',
    	array(
    		'name' =>  Yii::t('machine', '状态'),
    		'value' => '($data->status == 1) ? "已激活":"未激活" ',
    	),
    ),
));
?>
