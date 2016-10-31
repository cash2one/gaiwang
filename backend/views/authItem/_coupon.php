<?php 
$config = array(
    '充值卡管理' => array(
        '列表' => 'Coupon.Admin',
        '添加' => 'Coupon.Create',
        '充值卡导出excel' => 'Coupon.AdminExport',
        '使用记录' => 'Coupon.List',
        '查看' => 'Coupon.View',
        '删除' => 'Coupon.Delete',
        '使用记录导出excel' => 'Coupon.ListExport',
    )
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>
