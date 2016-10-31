<?php 
$config = array(
    '充值卡管理' => array(
        '列表' => 'PrepaidCard.Admin',
        '添加' => 'PrepaidCard.Create',
        '充值卡导出excel' => 'PrepaidCard.AdminExport',
        '使用记录' => 'PrepaidCard.List',
        '查看' => 'PrepaidCard.View',
        '删除' => 'PrepaidCard.Delete',
        '使用记录导出excel' => 'PrepaidCard.ListExport',
//        '批量导入充值' => 'ImportRecharge.Index',        
        '下载批发充值卡Execl表格' => 'PrepaidCard.DownLoadExecl',
        '批量生成充值卡' => 'PrepaidCard.Batch',
    	'批发充值卡结果导出' => 'PrepaidCard.PrepaidCardExport',        
        '批发充值卡生成记录列表' => 'PrepaidCard.HistoryBatch',
        '下载批发充值卡生成记录execl表' => 'PrepaidCard.HistoryDownLoad',
        '下载导入充值Execl表格' => 'ImportRecharge.DownLoadExecl',
        '导入批量充值' => 'ImportRecharge.ImportRecharge',
        '导入充值结果导出' => 'ImportRecharge.ImportExport',
        '导入充值记录列表' => 'ImportRecharge.HistoryRechange',
        '下载导入充值记录execl表' => 'ImportRecharge.HistoryDownLoad',  
        '转账列表'=> 'PrepaidCardTransfer.Admin',
        '充值卡转账申请'=> 'PrepaidCardTransfer.Create',
        '旧余额转账申请'=> 'PrepaidCardTransfer.CreateTransfer',
        '转账审核'=> 'PrepaidCardTransfer.Audit',
    )
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>
