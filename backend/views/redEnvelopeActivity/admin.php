<?php
/* @var $this SpecialTopicController */
/* @var $model SpecialTopic */

$this->breadcrumbs = array(
    '红包充值活动' => array('admin'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#red-envelope-activity-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php  $this->renderPartial('_search', array('model' => $model)); ?>
<div class="clearfix">
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th>红包总金额：</th>
            <td><?php echo $totalMoney?></td>
        </tr>
        <tr>
            <th>送出总金额：</th>
            <td <?php if($is_neeed_recharge) echo 'style="color:red"'?>><?php echo $sentTotalMoney ?></td>
            <td><?php if($is_neeed_recharge):?><span style='color:red'>请管理员充值积分红包总金额</span><?php endif?></td>
        </tr>
        <tr>
            <th>红包总余额：</th>
            <td><?php echo $surplusMoney?></td>
        </tr>
    </table>
</div>
    <?php if ($this->getUser()->checkAccess('redEnvelopeActivity.Create')): ?>
        <a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/redEnvelopeActivity/create') ?>"><?php echo Yii::t('redEnvelopeActivity', '添加红包活动'); ?></a>
    <?php endif; ?>
    <?php if ($this->getUser()->checkAccess('redEnvelopeActivity.AddHongBaoAmount')): ?>
        &nbsp;<a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/redEnvelopeActivity/addHongBaoAmount') ?>"><?php echo Yii::t('redEnvelopeActivity', '添加金额'); ?></a>
    <?php endif; ?>
    <?php if ($this->getUser()->checkAccess('redEnvelopeActivity.CommonAccountLog')): ?>
        &nbsp;<a class="regm-sub" href="<?php echo Yii::app()->createAbsoluteUrl('/redEnvelopeActivity/commonAccountLog') ?>"><?php echo Yii::t('redEnvelopeActivity', '金额添加历史'); ?></a>
    <?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'red-envelope-activity-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'type',
            'value' => 'Activity::getType($data->type)',
        ),
        array(
            'type' => 'datetime',
            'name' => 'create_time',
            'value' => '$data->create_time'
        ),
        'money',
        'sendout',
        array(
                'name' => 'status',
                'value' => 'Activity::getStatus($data->status)',
        ),
        array(
            'name' => 'valid_end',
            'value' => 'date("Y-m-d",$data->valid_end)'
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{statusOn}{statusOff}{updateValidEnd}',
            'header' => Yii::t('home', '操作'),
            'updateButtonImageUrl' => false,
            'viewButtonImageUrl' => false,
            'htmlOptions' => array('class' => 'tc'),
            'buttons' => array(
                'statusOn' => array(
                        'label' => Yii::t('redEnvelopeActivity', '【开启领取】'),
                        'url'	=>'Yii::app()->createUrl("redEnvelopeActivity/updateValidEnd", array("id"=>$data->id,"status"=>Activity::STATUS_ON))',
                        'visible' => ' $data->status != Activity::STATUS_ON and '."Yii::app()->user->checkAccess('redEnvelopeActivity.statusChange')",
                        'options' => array(
                                'class' => 'regm-sub-a',
                               // 'onclick' => 'return confirm("' . Yii::t('redEnvelopeActivity', '开启送出当前的积分红包，则其他同类型活动将停止?') . '")',
                        )
                ),
                'statusOff' => array(
                        'label' => Yii::t('redEnvelopeActivity', '【暂停领取】'),
                        'url'	=>'Yii::app()->createUrl("redEnvelopeActivity/statusChange", array("id"=>$data->id,"status"=>Activity::STATUS_OFF))',
                        'visible' => '$data->status != Activity::STATUS_OFF and '."Yii::app()->user->checkAccess('redEnvelopeActivity.statusChange')",
                        'options' => array(
                                'class' => 'regm-sub-a',
                                'onclick' => 'return confirm("' . Yii::t('redEnvelopeActivity', '确定暂停送出当前的积分红包?') . '")',
                        )
                ),
                'updateValidEnd' => array(
                    'label' => Yii::t('redEnvelopeActivity', '【修改派送截止时间】'),
                    'url'	=>'Yii::app()->createUrl("redEnvelopeActivity/updateValidEnd",array("id"=>$data->id))',
                    'visible' => "Yii::app()->user->checkAccess('redEnvelopeActivity.updateValidEnd')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                    )
                ),
            ),
        ),
    ),
));
?>
