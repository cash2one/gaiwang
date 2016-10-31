<?php

$this->breadcrumbs = array(
    '红包充值活动' => array('红包活动商品标签'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#red-activity-tag-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php  $this->renderPartial('_search', array('model' => $model)); ?>
<?php if ($this->getUser()->checkAccess('redActivityTag.Create')): ?>
    <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/redActivityTag/create') ?>"><?php echo Yii::t('redActivityTag', '添加活动标签'); ?></a>
    <div class="c10"></div>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'red-activity-tag-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        'name',
        array(
            'type' => 'datetime',
            'name' => 'create_time',
            'value' => '$data->create_time'
        ),
        array(
            'name' => 'ratio',
            'value' => '$data->ratio."%"',
        ),
        array(
            'name' => 'status',
            'value' => 'ActivityTag::getStatus($data->status)',
        ),

        array(
            'class' => 'CButtonColumn',
            'template' => '{statusOn}{statusOff}{updateName}{updateRatio}',
            'header' => Yii::t('home', '操作'),
            'updateButtonImageUrl' => false,
            'viewButtonImageUrl' => false,
            'htmlOptions' => array('class' => 'tc'),
            'buttons' => array(
                'statusOn' => array(
                    'label' => Yii::t('redActivityTag', '【开启活动】'),
                    'url'	=>'Yii::app()->createUrl("redActivityTag/statusChange", array("id"=>$data->id,"status"=>ActivityTag::STATUS_ON))',
                    'visible' => ' $data->status != ActivityTag::STATUS_ON and '."Yii::app()->user->checkAccess('redActivityTag.statusChange')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                        'onclick' => 'return confirm("' . Yii::t('redActivityTag', '确定开启送出当前的积分红包?') . '")',
                    )
                ),
                'statusOff' => array(
                    'label' => Yii::t('redEnvelopeActivity', '【停止活动】'),
                    'url'	=>'Yii::app()->createUrl("redActivityTag/statusChange", array("id"=>$data->id,"status"=>ActivityTag::STATUS_OFF))',
                    'visible' => '$data->status != ActivityTag::STATUS_OFF and '."Yii::app()->user->checkAccess('redActivityTag.statusChange')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                        'onclick' => 'return confirm("' . Yii::t('redActivityTag', '确定暂停送出当前的积分红包?') . '")',
                    )
                ),
                'updateName' => array(
                    'label' => Yii::t('redActivityTag', '【标签重命名】'),
                    'url'	=>'Yii::app()->createUrl("redActivityTag/updateName",array("id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('redActivityTag.updateName')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                    )
                ),
                'updateRatio' => array(
                    'label' => Yii::t('redActivityTag', '【修改比例】'),
                    'url'	=>'Yii::app()->createUrl("redActivityTag/updateRatio",array("id"=>$data->id))',
                    'visible' =>"Yii::app()->user->checkAccess('redActivityTag.updateRatio')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                    )
                ),
            ),
        ),
    ),
));
?>
