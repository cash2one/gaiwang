<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'common-account-agent-dist-grid',
	'title' => '代理列表',
    'dataProvider' => $model->searchAgent(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'name',
        array(
            'name' => Yii::t('region', '地区级别'),
            'value' => 'Region::getAgentLevel($data->depth)'
        ),
        array(
            'name' => 'agent_gai_number',
            'value' => '$data->agent_gai_number'
        ),
        array(
            'name' => 'agent_username',
            'value' => '$data->agent_username'
        ),
        array(
            'name' => 'agent_mobile',
            'value' => '$data->agent_mobile'
        ),
    ),
));
?>