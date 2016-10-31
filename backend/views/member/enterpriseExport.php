<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'member-grid',
    'dataProvider' => $model->enterprise(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'gai_number',
        'username',
        'mobile',
        array(
            'name' => 'type_id',
            'value' => 'isset($data->memberType) ? $data->memberType->name:""'
        ),
        array(
            'name' => 'referrals_id',
            'value' => 'isset($data->referrals) ? $data->referrals->gai_number : ""'
        ),
        array(
            'name' => 'register_time',
            'value' => 'date("Y-m-d H:i:s", $data->register_time)',
        ),
        array(
            'header' => Yii::t('member', '可提现金额'),
            'value' => '"<span class=\"jf\">¥".$data->getTotalCash($data->id)."</span>"',
            'type' => 'raw'
        ),
        array(
            'name' => 'register_type',
            'value' => 'Member::registerType($data->register_type)',
        ),
        array(
            'name' => 'enterprise_id',
            'value' => 'isset($data->enterprise) ? $data->enterprise->name:""'
        ),
        array(
            'name' => 'status',
            'value' => 'Member::status($data->status)'
        )
    ),
));