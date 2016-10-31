<?php
$config = array(
		'售后咨询' => array(
				'订单问题'=>'AppService.Order',
				'支付问题'=>'AppService.Pay',
				'消费积分'=>'AppService.Consum',
		),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));