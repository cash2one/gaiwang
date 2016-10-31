<?php
$config = array(
		'支付渠道设置' => array(
				'浏览'=>'AppPayManage.Index',
				'查看'=>'AppSubPayManage.Index',
				'修改状态'=>'AppPayManage.Update',
		),
		'支付渠道编辑' => array(
				'修改'=>'AppSubPayManage.Update',
				'改变状态'=>'AppSubPayManage.Change',
		),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
