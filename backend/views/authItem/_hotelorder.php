<?php
$config = array(
    '酒店订单查询列表' => array(
        '列表' => 'HotelOrder.Admin',
        '查看' => 'HotelOrder.View',
        '导出excel' => 'HotelOrder.AdminExport'
    ),
	'酒店订单用户管理' => array(
		'列表' => 'OrderMember.Admin',
		'添加' => 'OrderMember.Create',
		'编辑' => 'OrderMember.Update',
		'导出excel' => 'OrderMember.AdminExport',
		'删除' => 'OrderMember.Delete',
	),
    '酒店新订单列表' => array(
        '列表' => 'HotelOrder.NewList',
        '签收' => 'HotelOrder.Sign',
        '取消' => 'HotelOrder.CancelNewOrder',
    ),
    '酒店待确认订单列表' => array(
        '列表' => 'HotelOrder.NoVerifyList',
        '确认' => 'HotelOrder.VerifyOrder',
        '取消' => 'HotelOrder.CancelOrder'
    ),
    '酒店已确认订单列表' => array(
        '列表' => 'HotelOrder.VerifyList',
        '取消' => 'HotelOrder.CancelVerifyOrder',
        '核对' => 'HotelOrder.OrderCheck'
    ),
    '酒店已核对订单列表' => array(
        '列表' => 'HotelOrder.CheckList',
        '对账' => 'HotelOrder.OrderChecking',
        '导出excel' => 'HotelOrder.CheckListExport'
    ),
    '酒店已对账订单列表' => array(
        '列表' => 'HotelOrder.CheckingList',
        '完成' => 'HotelOrder.OrderComplete'
    )
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>