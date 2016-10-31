<?php 
$config = array(
    
    '合同补充协议(代理版)' => array(
        '展示' => 'Contract.agency',
        '新增' => 'Contract.createAgency',
        '编辑' => 'Contract.updateAgency',
        '删除' => 'Contract.delAgency',
    ),
    '合同补充协议(直营版)' => array(
        '展示' => 'Contract.regularChain',
        '新增' => 'Contract.createRegularChain',
        '编辑' => 'Contract.updateRegularChain',
        '删除' => 'Contract.delRegularChain',
    ),
    '协议相关商户列表' => array(
        '展示' => 'FranchiseeContract.listAgreement',
        '新增' => 'FranchiseeContract.create',
        '编辑' => 'FranchiseeContract.update',
        '预览' => 'FranchiseeContract.view',
        '删除' => 'FranchiseeContract.delete',
    ),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>