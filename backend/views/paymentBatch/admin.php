<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */

$this->breadcrumbs = array(
    Yii::t('paymentBatch', '体现批次') => array('admin'),
    Yii::t('paymentBatch', '列表')
);
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>

<?php if (Yii::app()->user->checkAccess('PaymentBatch.PayLog')): ?>
    <input id="Btn_Add" type="button" value="<?php echo Yii::t('paymentBatch', '代付日志'); ?>" class="regm-sub" onclick="location.href = '<?php echo Yii::app()->createAbsoluteUrl("/paymentBatch/payLog"); ?>'">
<?php endif; ?>

<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'payment-batch-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'ajaxUpdate' => false,
    'columns' => array(
        'batch_number',
    	array(
    		'name' => 'author_id',
    		'value' => 'User::getAuthorNameBy($data->author_id)'
    	),
    	array(
    		'name' => 'auditor_id',
    		'value' => 'User::getAuthorNameBy($data->auditor_id)'
    	),
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d H:i:s", $data->create_time)'
        ),
        array(
            'name' => 'audit_time',
            'value' => '$data->audit_time ? date("Y-m-d H:i:s", $data->audit_time): ""'
        ),
        array(
            'name' => 'status',
            'value' => 'PaymentBatch::getStatus($data->status)'
        ),
    	'remark',
        array(
            'class' => 'CButtonColumn',
            'template' => '{pass}',
            'viewButtonLabel' => Yii::t('paymentBatch', '审核'),
            'viewButtonImageUrl' => false,
            'buttons' => array(      
            	'pass' => array(
            		'label' => Yii::t('store', '审核'),
            		'url' => 'Yii::app()->createUrl("payment/admin",array("bid"=>$data->id))',
            		'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
            		'visible' => "Yii::app()->user->checkAccess('Payment.Admin')"
            	),
            )
        ),
    ),
));
?>