<?php

$this->breadcrumbs = array(
    '充值卡转账' => array('充值卡转账列表'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#prepaid-card-transfer-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php  $this->renderPartial('_search', array('model' => $model)); ?>
<?php if ($this->getUser()->checkAccess('prepaidCardTransfer.Create')): ?>
    <a class="regm-sub" style="width: 100px;background:url('');background-color:rgb(228,8,8);border-radius:4px" href="<?php echo Yii::app()->createAbsoluteUrl('/prepaidCardTransfer/create') ?>"><?php echo Yii::t('prepaidCardTransfer', '充值卡转账申请'); ?></a>
<?php endif; ?>
<?php if ($this->getUser()->checkAccess('prepaidCardTransfer.CreateTransfer')): ?>
    <a class="regm-sub" style="width: 100px;background:url('');background-color:rgb(228,8,8);border-radius:4px" href="<?php echo Yii::app()->createAbsoluteUrl('/prepaidCardTransfer/CreateTransfer') ?>"><?php echo Yii::t('prepaidCardTransfer', '旧余额转账申请'); ?></a>
<?php endif; ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'prepaid-card-transfer-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'ajaxUpdate' => false,
    'columns' => array(
        'card_number',
        'value',
        'money',
        array(
            'name' => 'transfer_gw',
            'value' => '$data->transfer_gw',
        ),
        array(
            'name' => 'receiver_gw',
            'value' => '$data->receiver_gw',
        ),
        array(
            'name' => 'status',
            'value' => 'PrepaidCardTransfer::getStatus($data->status)',
        ),
        array(
            'name' => 'remark',
            'type' => 'raw',
            'value' => '$data->formatRemark($data->remark)',
        ),
        array(
            'name'=>'author_ip',
            'value'=>'Tool::int2ip($data->author_ip)'
        ),
        'author_name',
        array(
            'name'=>'auditor_ip',
            'value'=>'Tool::int2ip($data->auditor_ip)'
        ),
        'auditor_name',
        array(
            'type' => 'datetime',
            'name' => 'create_time',
            'value' => '$data->create_time'
        ),
        array(
            'type' => 'datetime',
            'name' => 'audit_time',
            'value' => '$data->audit_time'
        ),


        array(
            'class' => 'CButtonColumn',
            'template' => '{auditNO}{auditYes}',
            'header' => Yii::t('home', '操作'),
            'updateButtonImageUrl' => false,
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'auditNO' => array(
                    'label' => Yii::t('prepaidCardTransfer', '不通过'),
                    'url'	=>'Yii::app()->createUrl("prepaidCardTransfer/audit", array("id"=>$data->id,"status"=>PrepaidCardTransfer::STATUS_NO))',
                    'visible' => ' $data->status == PrepaidCardTransfer::STATUS_APPLY and '."Yii::app()->user->checkAccess('prepaidCardTransfer.audit')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                        'onclick' => 'return confirm("' . Yii::t('PrepaidCardTransfer', '确定不通过?') . '")',
                    )
                ),
                'auditYes' => array(
                    'label' => Yii::t('prepaidCardTransfer', '通过'),
                    'url'	=>'Yii::app()->createUrl("prepaidCardTransfer/audit", array("id"=>$data->id,"status"=>prepaidCardTransfer::STATUS_YES))',
                    'visible' => '$data->status == prepaidCardTransfer::STATUS_APPLY and '."Yii::app()->user->checkAccess('prepaidCardTransfer.audit')",
                    'options' => array(
                        'class' => 'regm-sub-a',
                        'onclick' => 'return confirm("' . Yii::t('prepaidCardTransfer', '确定通过?') . '")',
                    )
                ),
            ),
        ),
    ),
));
?>
