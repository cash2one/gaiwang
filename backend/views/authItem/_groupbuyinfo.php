<?php 
$config = array(
    '线下团购' => array(
        '列表' => 'FranchiseeGroupbuy.Admin',
        '发布团购' => 'FranchiseeGroupbuy.Create',
        '编辑' => 'FranchiseeGroupbuy.Update',
        '删除' => 'FranchiseeGroupbuy.Delete'
    ),
    '类目管理' => array(
        '列表' => 'FranchiseeGroupbuyCategory.Admin',
        '添加类目' => 'FranchiseeGroupbuyCategory.Create',
        '重命名' => 'FranchiseeGroupbuyCategory.Update',
        '删除' => 'FranchiseeGroupbuyCategory.Delete'
    )
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>
