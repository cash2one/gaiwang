<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'common-account-grid',
	'title'=>'代理账户分配金额记录',
    'dataProvider' => $model->searchExport(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => Yii::t('CommonAccountAgentDist', '账户名称'),
            'value' => '!empty($data->common_account->name)?$data->common_account->name:""',	
        ),
        
        array(
            'name' => Yii::t('CommonAccountAgentDist', '分配金额'),
            'value' => '$data->dist_money',	
        ),
        
        array(
            'name' => Yii::t('CommonAccountAgentDist', '剩余金额'),
            'value' => '$data->remainder_money',	
        ),
        
        array(
            'name' => Yii::t('CommonAccountAgentDist', '分配时间'),
            'value' => '$data->create_time',	
        ),
        
        array(
            'name' => Yii::t('CommonAccountAgentDist', '省级分配'),
            'value' => '($data->province_money > 0 && !empty($data->province))?$data->province->name.Yii::t("commonAccountAgentDist", "代理会员").$data->member_province->gai_number.Yii::t("commonAccountAgentDist", "获得金额")."¥".$data->province_money."，".Yii::t("commonAccountAgentDist", "实占比率").$data->province_ratio."%":""',	
        ),
        
        array(
            'name' => Yii::t('CommonAccountAgentDist', '市级分配'),
            'value' => '($data->city_money > 0 && !empty($data->city))?$data->city->name.Yii::t("commonAccountAgentDist", "代理会员").$data->member_city->gai_number.Yii::t("commonAccountAgentDist", "获得金额")."¥".$data->city_money."，".Yii::t("commonAccountAgentDist", "实占比率").$data->city_ratio."%":""',	
        ),
        
        array(
            'name' => Yii::t('CommonAccountAgentDist', '区/县级分配'),
            'value' => '($data->district_money > 0 && !empty($data->district))?$data->district->name.Yii::t("commonAccountAgentDist", "代理会员").$data->member_district->gai_number.Yii::t("commonAccountAgentDist", "获得金额")."¥".$data->district_money."，".Yii::t("commonAccountAgentDist", "实占比率").$data->district_ratio."%":""',	
        ),
        
    ),
));
?>
