<?php
/* @var $this OrderController */
/* @var $model Order */

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
    $('#order-grid').yiiGridView('update', {data: $(this).serialize()});
    return false;
});
");
?>

<div class="border-info clearfix search-form">
    <?php
    // 搜索表单
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'code'); ?>：</th>
            <td><?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <?php echo CHtml::submitButton('搜索', array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>
<?php
$emptyText = !isset($_GET['Order']) ? '请查找订单号' : null;
$this->widget('GridView', array(
    'id' => 'order-grid',
    'dataProvider' => $model->searchRights(),
    'itemsCssClass' => 'tab-reg',
    'emptyText' => $emptyText,
    'columns' => array(
        'code',
        array(
            'name' => 'member_id',
            'value' => '!$data->member ? "" : $data->member->gai_number',
        ),
        array(
            'name' => 'store_id',
            'value' => '!$data->store ? "" : $data->store->name',
        ),
        array(
            'name' => 'create_time',
            'value' => '$data->create_time',
            'type' => 'datetime'
        ),
        array(
            'name' => 'pay_time',
            'value' => '$data->pay_time',
            'type' => 'datetime'
        ),
        array(
            'name' => 'delivery_time',
            'value' => '$data->delivery_time',
            'type' => 'datetime'
        ),
        array(
            'name' => 'refund_status',
            'value' => 'Order::refundStatus($data->refund_status)',
        ),
        array(
            'name' => 'return_status',
            'value' => 'Order::returnStatus($data->return_status)',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view}',
            'viewButtonImageUrl' => false,
            'buttons' => array(
                'view' => array(
                    'label' => Yii::t('user', '查看'),
                    'url' => 'Yii::app()->createAbsoluteUrl("/order/rightView", array("id" => $data->id))',
                    'visible' => "Yii::app()->user->checkAccess('Order.rightView')"
                ),
            )
        ),
    ),
));
?>