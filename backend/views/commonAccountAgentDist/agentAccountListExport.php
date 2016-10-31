<?php
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'common-account-agent-dist-grid',
	'title' => '代理账户列表',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        array(
            'name' => Yii::t('commonAccount', '账户名称'),
            'value' => '$data->name'
        ),
        array(
            'name' => 'city_id',
            'value' => '$data->dis->name'
        ),
        array(
            'name' => 'cash',
            'value' => 'CommonAccount::showMoney($data)',
            'type' => 'raw'
        ),
    ),
));
?>
