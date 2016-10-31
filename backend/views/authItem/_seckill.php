<?php
$config = array(
    '权限检查'=> array(
	    '公共函数(必须打勾,否则权限无效)' => 'SecondKillActivity.CheckCreate',
	),
	'红包活动管理' => array(
	    '列表'=>'SecondKillActivity.RedAdmin',
		'新建红包活动'=>'SecondKillActivity.Create1',
		'活动商品'=>'SecondKillActivity.Product1',
		'查看详情'=>'SecondKillActivity.Update1',
		'开启活动'=>'SecondKillActivity.Start1',
		'强制结束'=>'SecondKillActivity.Stop1',
		'活动规则编辑'=>'SecondKillActivity.Edit1',
                '导出excel'=>'SecondKillActivity.AdminExport'
	),
	'拍卖活动管理' => array(
		'列表'=>'SeckillAuctionActivity.SeckillAuctionAdmin',
		'新建拍卖活动'=>'SeckillAuctionActivity.SeckillAuctionCreate',
		'查看详情'=>'SeckillAuctionActivity.SeckillAuctionUpdate',
		'开启活动'=>'SeckillAuctionActivity.Start',
		'强制结束'=>'SeckillAuctionActivity.Stop',

	),
        
	'拍卖活动商品管理' => array(
		'拍卖商品列表'=>'SecKillAuction.Admin',
		'添加拍卖商品'=>'SecKillAuction.Add',
		'更新拍卖商品'=>'SecKillAuction.Update',
		'删除拍卖商品'=>'SecKillAuction.Delete',
	),
        
	'应节性活动管理' => array(
	    '列表'=>'SecondKillActivity.FestiveAdmin',
		'新建应节活动'=>'SecondKillActivity.Create2',
		'活动商品'=>'SecondKillActivity.Product2',
		'查看详情'=>'SecondKillActivity.Update2',
		'开启活动'=>'SecondKillActivity.Start2',
		'强制结束'=>'SecondKillActivity.Stop2',
		'活动规则编辑'=>'SecondKillActivity.Edit2',
                '导出excel'=>'SecondKillActivity.AdminExport',
	),
	
	'限时秒杀活动管理' => array(
	    '列表'=>'SecondKillActivity.SeckillAdmin',
	    '新建活动日期'=>'SecondKillActivity.CreateDate',
		'新建秒杀设置'=>'SecondKillActivity.Create3',
		'活动商品'=>'SecondKillActivity.Product3',
		'活动详情'=>'SecondKillActivity.Seting',
		'秒杀设置'=>'SecondKillActivity.Update3',
		'开启活动'=>'SecondKillActivity.Start3',
		'强制结束'=>'SecondKillActivity.Stop3',
		'活动规则编辑'=>'SecondKillActivity.Edit3',
            '导出excel'=>'SecondKillActivity.AdminExport',
	),
	
	'今日必抢管理' => array(
		'列表' => 'SecKillGrab.Admin',
		'添加必抢商品' => 'SecKillGrab.AddProduct', 
		'更新所有商品'=> 'SecKillGrab.UpdateAll',
		'移除' => 'SecKillGrab.Delete',            
	),
	'活动商品类别管理' => array(
		'修改' => 'SecondKillActivity.ActiveCategory',
	),
	);
$this->renderPartial('_input', array('config' => $config, 'rights' => $rights));
?>