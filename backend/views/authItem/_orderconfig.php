<?php
$config = array(
    '订单管理' => array(
        '列表' => 'Order.Admin',
        '查看' => 'Order.View',
        '导出excel' => 'Order.AdminExport',
        '关闭订单' => 'Order.CloseOrder',
    ),
    '订单评论' => array(
        '列表' => 'Comment.Admin',
        '切换状态' => 'Comment.ChangeStatus'
    ),
    '异常订单' => array(
        '列表' => 'Order.Exception',
        '导出excel' => 'Order.ExceptionExport'
    ),
    '未阅读订单查询' => array(
        '列表' => 'Order.Unread',
        '查看' => 'Order.View'
    ),
    '运费编辑管理' => array(
        '列表' => 'FreightEdit.Admin'
    ),
    '消费者维权订单' => array(
        '列表' => 'Order.Rights',
        '维权操作' => 'Order.RightView'
    ),
    '异常退款退货订单' => array(
        '列表' => 'ExceptionOrder.Admin',
        '退款操作' => 'ExceptionOrder.Operate'
    ),
    '手动对账' => array(
        '提交' => 'PayResult.Admin',
        '异常支付日志' => 'PayResult.ExceptionPay'
    ),
    '退款到银行卡' => array(
        '列表' => 'OrderRefund.Admin',
        '新增' => 'OrderRefund.Add'
    ),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>