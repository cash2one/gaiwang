<?php
/* @var $this BitUpdateLogController */
/* @var $model BitUpdateLog */

$this->breadcrumbs=array(
	'Bit Update Logs'=>array('index'),
	'Manage',
);
$this->menu=array(
	array('label'=>'List BitUpdateLog', 'url'=>array('index')),
	array('label'=>'Create BitUpdateLog', 'url'=>array('create')),
);
?>

<?php echo CHtml::button('添加更新日志', array('class' => 'regm-sub', 'onclick' => 'location.href = \'' . Yii::app()->createUrl('bitUpdateLog/create') . "'")); ?>

<div class="c10"></div>
<?php $this->widget('GridView', array(
	'id'=>'bit-update-log-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'itemsCssClass' => 'tab-reg',
	'columns'=>array(
		'id',
		array(
            'name'=>'content',
            'value'=>'Tool::truncateUtf8String("$data->content",20)'
        ),
		'dev',
		'test',
		array(
            'name'=>'created',
            'type'=>'dateTime'
        ),
		array(
			'class'=>'CButtonColumn',
            'updateButtonImageUrl' => false,
            'viewButtonImageUrl' => false,
            'template'=>'{update}'
		),
	),
)); ?>
