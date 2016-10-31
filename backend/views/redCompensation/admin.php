<?php

$this->breadcrumbs = array(
    '红包补偿' => array('红包补偿'),
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
<?php  $this->renderPartial('_search', array('model' => $model)); ?>
<?php if ($this->getUser()->checkAccess('redCompensation.Create')): ?>    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/redCompensation/create') ?>"><?php echo Yii::t('redCompensation', '红包补偿'); ?></a>

<?php endif; ?>
<?php if ($this->getUser()->checkAccess('redCompensation.BatchCreate')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/redCompensation/BatchCreate') ?>"><?php echo Yii::t('redCompensation', '红包批量补偿'); ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'red-compensation-grid',
    'dataProvider' => $model->compensationSearch(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'member.gai_number',
        ),
        array(
            'name' => 'member.mobile',
        ),
        array(
            'name' => 'type',
            'value' => 'Activity::getType($data->type)',
        ),
        'money',
        array(
            'header' => Yii::t('redCompensation','补偿时间'),
            'type' =>'dateTime',
            'name' => 'create_time',
        ),
    ),
));
?>
