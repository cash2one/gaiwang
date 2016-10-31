<?php

/**
 * @var $this HotelOrderController
 * @var $model HotelOrder
 */
$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'hotel-order-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'title' => '酒店订单报表',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'code',
            'value' => '" ".$data->code'
        ),
        array(
            'name' => Yii::t('HotelOrder', '买家会员编号'),
            'value' => 'isset($data->member->gai_number) ? $data->member->gai_number : ""'
        ),
        array(
            'name' => 'create_time',
            'value' => 'date("Y-m-d G:i:s", $data->create_time)'
        ),
        'hotel_name',
        'room_name',
        'rooms',
        array(
            'name' => 'settled_time',
            'value' => 'date("Y-m-d", $data->settled_time)'
        ),
        array(
            'name' => Yii::t('HotelOrder', '退房日期'),
            'value' => 'date("Y-m-d",$data->leave_time)'
        ),
        array(
            'name' => Yii::t('HotelOrder', '盖网通供货单价'),
            'value' => '$data->unit_gai_price'
        ),
        array(
            'name' => Yii::t('HotelOrder', '销售单价'),
            'value' => '$data->unit_price'
        ),
        array(
            'name' => Yii::t('HotelOrder', '间夜量'),
            'value' => '$data->rooms*floor(($data->leave_time-$data->settled_time)/(3600*24))'
        ),
        array(
            'name' => Yii::t('HotelOrder', '入住天数'),
            'value' => 'floor(($data->leave_time-$data->settled_time)/(3600*24))'
        ),
        'peoples',
        array(
            'name' => Yii::t('HotelOrder', '入住人'),
            'value' => 'HotelOrder::analysisLodgerInfo($data->people_infos, false, chr(13).chr(10))'
        ),
        'contact',
        'mobile',
        array(
            'name' => Yii::t('HotelOrder', '供应商'),
            'value' => 'isset($data->provider->name) ? $data->provider->name : ""'
        ),
        array(
            'name' => 'status',
            'value' => 'HotelOrder::getOrderStatus($data->status)',
        ),
        array(
            'name' => 'pay_type',
            'value' => 'OnlinePay::getPayWayList($data->pay_type)',
            'cssClassExpression' => 'HotelOrderController::getPayStatusColor($data->pay_status)'
        ),
        array(
            'name' => 'pay_status',
            'value' => 'HotelOrder::getPayStatus($data->pay_status)',
        ),
        array(
            'name' => Yii::t('HotelOrder', '销售总价'),
            'value' => '$data->total_price',
        ),
        array(
            'name' => Yii::t('HotelOrder', '供货总价'),
            'value' => '$data->unit_gai_price * (floor(($data->leave_time-$data->settled_time)/(3600*24)) * $data->rooms)'
        ),
        array(
            'name' => Yii::t('HotelOrder', '返还积分'),
            'value' => 'Common::convertSingle($data->amount_returned,$data->type_id)'
        ),
        array(
            'name' => 'is_lottery',
            'value' => 'HotelOrder::getIsLottery($data->is_lottery)'
        ),
        array(
            'name' => Yii::t('HotelOrder', '是否对账'),
            'value' => '!empty($data->is_recon) ? "是" : "否"'
        ),
        array(
            'name' => Yii::t('HotelOrder', '中奖金额'),
            'value' => 'HotelCalculate::obtainBonus($data)'
        ),
        array(
            'name' => Yii::t('HotelOrder', '返还金额'),
            'value' => '$data->amount_returned'
        ),
        'sign_user',
        'sign_remark',
        'confirm_user',
        array(
            'name' => Yii::t('HotelOrder', '跟进详情'),
            'value' => 'HotelOrder::getOrderFollow($data->id)'
        ),
    ),
));
?>