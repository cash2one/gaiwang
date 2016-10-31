<?php
/* @var $this Cotroller */
/* @var $model Coupon */

$this->breadcrumbs = array(
    '红包,盖惠券派发纪录' => array('admin'),
);

?>
<?php  $this->renderPartial('_search', array('model' => $model)); ?>
<div class="c10"></div>
<?php
$this->widget('GridView', array(
    'id' => 'coupon-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'member.gai_number',
        ),
        'money',
        array(
            'type' => 'datetime',
            'name' => 'create_time',
            'value' => '$data->create_time'
        ),
        array(
            'name' => 'mode',
            'value' => '$data->mode==1 ? "积分红包" : "盖惠券"',
        ),
        array(
            'name' => 'source',
            'value' => '$data->source==1 ? "商城" : "盖网通"',
        ),
        array(
            'type' => 'datetime',
            'name' => 'valid_end_time',
            'value' => '$data->valid_end_time',
        ),
        array(
            'name' => 'is_compensate',
            'value' => '$data->is_compensate == 1 ? "是" : "否"',
        ),

    ),
));
?>
