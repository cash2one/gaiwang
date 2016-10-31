<?php

$this->breadcrumbs = array(
    '红包兑换管理' => array('红包兑换管理'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#red-compensation-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php  $this->renderPartial('_search2', array('model' => $model)); ?>

    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/redCompensation/entryPage') ?>"><?php echo Yii::t('redCompensation', '录入兑换码'); ?></a>

<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'red-compensation-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => '兑换码',
             'value' => '$data->name',
        ),
        array(
            'name' => '面值',
            'value' => '"¥".$data->money',
        ),
        array(
            'name' => '兑换状态',
            'value' => 'ExchangeCode::status($data->status)',
        ),
        array(
            'name' => '兑换账号（GW号）',
            'value' => '$data->account',
        ),
        array(
            'header' => Yii::t('redCompensation','兑换时间'),
            'type' =>'dateTime',
            'name' => 'time',
        ),
    ),
));
?>