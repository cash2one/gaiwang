<?php

/* @var $this AccountFlowController */
/* @var $model AccountFlow */

$this->breadcrumbs = array(
    'APP交易记录' => array('appConsumRecord'),
);
?>
<?php
$this->widget('GridView', array(
    'id' => 'advert-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns' => array(
            array('name'=>'app_type','value'=>'AppVersion::getAppType($data->app_type)'),
            array('name'=>'system_type','value'=>'AppVersion::getSystemType($data->system_type)'),
            array('name'=>'order_type','value'=>'AppConsumRecord::getOrderType($data->order_type)'),
            array('name'=>'member_id','value'=>
                        'Yii::app()->db
                        ->createCommand()
                        ->select("gai_number")
                        ->from(Member::model()->tableName())
                        ->where("id = {$data->member_id}")
                        ->queryScalar()'),
            'order_id',
            'order_num',
            'amount',
            array('name'=>'create_time','value'=>'date("Y-m-d H:i:s",$data->create_time)'),
    ),
));
?>