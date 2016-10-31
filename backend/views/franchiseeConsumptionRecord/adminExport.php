<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'franchisee-consumption-record-grid',
	'title' => '加盟商对账列表',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
		array(
            'name' => Yii::t('franchiseeConsumptionRecord', '加盟商名称'),
            'value' => '!empty($data->franchisee_name)?$data->franchisee_name:""',
        ),
        
        array(
            'name' => Yii::t('franchiseeConsumptionRecord', '加盟商编号'),
            'value' => '!empty($data->franchisee_code)?$data->franchisee_code:""',
        ),

        array(
            'name' => Yii::t('franchiseeConsumptionRecord', '消费会员'),
            'value' => '!empty($data->gai_number)?$data->gai_number:""',
        ),

        array(
            'name' => Yii::t('franchiseeConsumptionRecord', '消费会员手机号码'),
            'value' => '!empty($data->member)?$data->mobile:""',
        ),
        
        array(
            'name' => Yii::t('franchiseeConsumptionRecord', '对账状态'),
            'value' => 'FranchiseeConsumptionRecord::getCheckStatus($data->status)',
        ),
        
        array(
            'name' => Yii::t('franchiseeConsumptionRecord', '盖网通折扣(百分比)'),
            'value' => '$data->gai_discount',
        ),
        
        array(
            'name' => Yii::t('franchiseeConsumptionRecord', '会员折扣(百分比)'),
            'value' => '$data->member_discount',
        ),
        
        array(
            'name' => Yii::t('franchiseeConsumptionRecord', '账单时间'),
            'value' => 'date("Y-m-d H:i:s",$data->create_time)',
        ),
        
        array(
            'name' => Yii::t('franchiseeConsumptionRecord', '消费金额'),
            'value' => '$data->spend_money',
        ),
        
        array(
            'name' => Yii::t('franchiseeConsumptionRecord', '分配金额'),
            'value' => '$data->distribute_money',
        ),
        
        array(
            'name' => Yii::t('franchiseeConsumptionRecord', '应付金额'),
            'value' => '$data->spend_money-$data->distribute_money',
        ),
    	array(
    		'name' => Yii::t('franchiseeConsumptionRecord', '消费物品'),
    		'value' => '!empty($data->goods_name)?$data->goods_name:""',
    	),
        
    ),
));
?>