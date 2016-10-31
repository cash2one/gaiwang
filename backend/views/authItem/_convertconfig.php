<?php

$config = array(
    '商品管理' => array(
        '列表' => 'Product.Admin',
        '编辑' => 'Product.Update',
        '导出excel' => 'Product.AdminExport',
    ),
    '商品管理(活动)' => array(
        '列表' => 'Product.ActiveAdmin',
        '编辑' => 'Product.Update',
        '导出excel' => 'Product.ActiveAdminExport',
    ),
    '积分日志' => array(
        '列表' => 'Wealth.Admin',
        '导出excel' => 'Wealth.AdminExport',
    ),
    '物流公司管理' => array(
        '列表' => 'Express.Admin',
        '添加' => 'Express.Create',
        '编辑' => 'Express.Update',
        '删除' => 'Express.Delete',
    ),
    '商品规格管理' => array(
        '列表' => 'Spec.Admin',
        '添加' => 'Spec.Create',
        '编辑' => 'Spec.Update',
        '删除' => 'Spec.Delete',
    ),
    '商品规格值管理' => array(
        '列表' => 'SpecValue.Admin',
        '添加' => 'SpecValue.Create',
        '编辑' => 'SpecValue.Update',
        '删除' => 'SpecValue.Delete',
    ),
    '商品类型管理' => array(
        '列表' => 'Type.Admin',
        '添加' => 'Type.Create',
        '编辑' => 'Type.Update',
        '删除' => 'Type.Delete',
    ),
    '商品属性管理' => array(
        '列表' => 'Attribute.Admin',
        '添加' => 'Attribute.Create',
        '编辑' => 'Attribute.Update',
        '删除' => 'Attribute.Delete',
    ),
    '商品属性值管理' => array(
        '列表' => 'AttributeValue.Admin',
        '添加' => 'AttributeValue.Create',
        '编辑' => 'AttributeValue.Update',
        '删除' => 'AttributeValue.Delete',
    ),
    '商品搜索管理' => array(
        '列表' => 'Keyword.Admin',
        '删除' => 'Keyword.Delete',
    ),
    '商品咨询管理' => array(
        '列表' => 'Guestbook.Admin',
        '编辑' => 'Guestbook.Update',
        '删除' => 'Guestbook.Delete',
    ),
    '用户反馈管理' => array(
        '列表' => 'Feedback.Admin',
        '查看' => 'Feedback.View',
        '删除' => 'Feedback.Delete',
    ),
);
$this->renderPartial('_input', array('config' => $config, 'rights' => $rights));
?>

