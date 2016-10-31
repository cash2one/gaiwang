<?php
/* @var $this OrderRefundController */
/* @var $model OrderRefund */
?>

<div class="search-form">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->
<?php
?>
<?php
$this->widget('GridView', array(
    'id' => 'order-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'columns' => array(
        'id',
        'code',
        array(
            'name'=>'gw号',
            'value'=>'$data->member->gai_number'
        ),
        'money',
        array('name'=>'操作人','value'=>'$data->user->username'),
        array(
            'name' => 'create_time',
            'type' => 'datetime'
        ),
        array(
            'name'=>'account_type',
            'value'=>'OrderRefund::accountType($data->account_type)',
        ),
        'remark'
    ),
));
?>

