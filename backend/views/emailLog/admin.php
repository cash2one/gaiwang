<?php
/* @var $this SmsLogController */
/* @var $model SmsLog */

$this->breadcrumbs = array(
    Yii::t('smsLog', '短信发送记录') => array('admin'), 
    '列表',   
);

?>

<?php
$this->renderPartial('_search', array(
    'model' => $model,
));

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#EmailLog-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'EmailLog-grid',
    'dataProvider' => $model->search(),
    'cssFile' => false,
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
		'email',
        'content',
		array(
			'name'=>'create_time',
			'value'=>'date("Y-m-d H:i:s",$data->create_time)',
		),
		array(
			'name'=>'status',
			'header'=>'状态',
//			'value'=>'$data->status?(EmailLog::showStatus($data->status)):""',
                    'value'=>'$data->type?(EmailLog::showStatus($data->status)):""',
		),	
		'count',		
	
		array(
			'name'=>'type',
			'header'=>'类型',
			'value'=>'$data->type?(EmailLog::showType($data->type)):""',
		),
		array(
			'name'=>'send_time',
			'value'=>'date("Y-m-d H:i:s",$data->send_time)',
		),
		
    ),
));
?>
