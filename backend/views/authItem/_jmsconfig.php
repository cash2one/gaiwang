<?php
$config = array(
    '线下加盟商列表' => array(
        '列表' => 'Franchisee.Admin',
        '添加' => 'Franchisee.Create',
        '图片管理' => 'Franchisee.UpdateImgs',
        '基本信息' => 'Franchisee.Update',
        '重要信息' => 'Franchisee.UpdateImportant',
        '删除' => 'Franchisee.Delete',
        '导出excel' => 'Franchisee.AdminExport',
    ),
    '加盟商审核列表' => array(
        '列表' => 'Auditing.Admin',
        '查看' => 'Auditing.View',
        '批量审核通过' => 'Auditing.Pass',
        '批量审核不通过' => 'Auditing.NotPass',
    ),
    '加盟商对账' => array(
        '列表' => 'FranchiseeConsumptionRecord.Admin',
        '批量对账' => 'FranchiseeConsumptionRecord.Confirm',
        '申请撤销' => 'FranchiseeConsumptionRecord.ReBack',
        '导出excel' => 'FranchiseeConsumptionRecord.AdminExport',
    ),
    '加盟商对账申请' => array(
        '列表' => 'FranchiseeConsumptionRecord.ConsumptionApply',
        '通过' => 'FranchiseeConsumptionRecord.ConsumptionPass',
        '审核'=>'FranchiseeConsumptionRecord.ConsumptionAuditing',
        '拒绝' => 'FranchiseeConsumptionRecord.ConsumptionFail',
    ),
    '加盟商对账撤销申请' => array(
        '列表' => 'FranchiseeConsumptionRecord.RebackApply',
        '通过' => 'FranchiseeConsumptionRecord.Pass',
        '审核'=>'FranchiseeConsumptionRecord.Auditing',
        '拒绝' => 'FranchiseeConsumptionRecord.Fail',
    ),
      '异常商户列表' => array(
        '列表' => 'Franchisee.Abnormal',
        '移出'=>'Franchisee.Remove',
        '选择加盟商'=>'Franchisee.PullInto',
        '导出excel' => 'Franchisee.AbnormalExport',
        '获取加盟商列表'=>'Franchisee.GetFranchisee',
    ),
    '加盟商线下活动城市' => array(
        '列表' => 'FranchiseeActivityCity.Admin',
        '添加' => 'FranchiseeActivityCity.Create',
        '修改' => 'FranchiseeActivityCity.Update',
        '删除' => 'FranchiseeActivityCity.Delete',
    ),
    '加盟商文章列表' => array(
        '列表' => 'FranchiseeArtile.Admin',
        '修改' => 'FranchiseeArtile.Update',
        '删除' => 'FranchiseeArtile.Delete',
    ),
    '盖机列表' => array(
        '列表' => 'Machine.Admin',
        '添加推荐者' => 'Machine.Create',
        '移除推荐者' => 'Machine.Delete',
    	'导入推荐者' => 'Machine.Import',
    	'收益分配' => 'Machine.Distribution',
        '导出excel' => 'Machine.AdminExport',
    ),
    '加盟商分类' => array(
        '列表' => 'FranchiseeCategory.Admin',
        '添加' => 'FranchiseeCategory.Create',
        '编辑' => 'FranchiseeCategory.Update',
        '删除' => 'FranchiseeCategory.Delete',
        '缓存更新' => 'FranchiseeCategory.GenerateAllCategoryCache',
    ),
     '加盟商品牌' => array(
        '列表' => 'FranchiseeBrand.Admin',
        '添加' => 'FranchiseeBrand.Create',
        '编辑' => 'FranchiseeBrand.Update',
        '删除' => 'FranchiseeBrand.Delete',       
    ),
    '电子化签约审核列表'=> array(
        '审核列表' => 'offlineSignStoreExtend.admin',
        '编辑' => 'OfflineSignStoreExtend.Update',
        '审核' => 'OfflineSignStoreExtend.QualificationAudit',
        '审核进度' => 'OfflineSignAuditLogging.AuditSchedule',
        '查看详情' => 'OfflineSignStoreExtend.DetailsView',
        '查看备注' => 'OfflineSignAuditLogging.ShowRemarks',
        '添加备注' => 'OfflineSignAuditLogging.AddRemarks',
        '导出EXCEL' => 'OfflineSignStore.ExportExcel',
    ),
    '归属方信息列表' => array(
        '列表' => 'OfflineSignMachineBelong.Admin',
        '添加' => 'OfflineSignMachineBelong.Create',
        '编辑' => 'OfflineSignMachineBelong.Update',   
    ),
		'售货机列表' => array(
				'列表' => 'VendingMachine.Admin',
				'商品列表' => 'VendingMachine.GoodsList',
				'商品更新' => 'VendingMachine.GoodsUpdate',
				'商品库存流水' => 'VendingMachine.GoodsStockBalance',
				'商品库存流水导出' => 'VendingMachine.GoodsStockBalanceExport',
				'编辑绑定' => 'VendingMachine.GoodsEditBind',
		),
		'大区设置' => array(
				'列表'=>'RegionManage.Index',
				'添加' => 'RegionManage.CreateRegion',
				'修改' => 'RegionManage.Update',
				'大区保存'=>'RegionManage.SaveRegion',
				'删除' => 'RegionManage.Delete',
				'查看后台账户' => 'RegionManage.SaveGW',
				'账户添加'=>'RegionManage.RelationCreate',
				'账户删除'=>'RegionManage.RelationDelete',
		),
);
$this->renderPartial('_input', array('config' => $config, 'rights' => $rights));
?>

