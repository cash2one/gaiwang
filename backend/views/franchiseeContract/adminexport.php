<?php

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'franchiseecontract-grid',
	'title'=>'补充协议相关用户列表',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => Yii::t('franchisee', '用户名'),
            'value' => '!empty($data->member)?$data->member->username:""'
        ),
        array(
            'name' => Yii::t('franchisee', '盖网编号'),
            'value' => '!empty($data->member->gai_number)?$data->member->gai_number:""'
        ),
        'protocol_no',
        'number',
        array(
            'name' => Yii::t('contract', '合同类型'),
            'value' => '!empty($data->contract)?Contract::showType($data->contract->type):""'
        ),
        array(
            'name' => Yii::t('contract', '版本'),
            'value' => 'Contract::showVersion($data->contract->version,$data->contract->type)',
        ),
        array(
            'name' => 'status',
            'value' => 'FranchiseeContract::getConfirmStatu($data->status)',
            'id' => 'confirm_statu',
        ),
        array(
            'name' => 'confirm_time',
            'value' => '!empty($data->confirm_time)?date("Y-m-d H:i:s",$data->confirm_time):""',
        ),
    ),
));
?>