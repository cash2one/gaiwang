<?php 
$config = array(
    '积分分配配置' => array(
        '编辑' => 'Home.AllocationConfig'
    ),
    '积分兑现配置' => array(
        '编辑' => 'Home.CreditsConfig'
    ),
    '企业会员提现配置' => array(
        '编辑' => 'Home.ShopCashConfig'
    ),
	'企业会员提现白名单' => array(
		'编辑' => 'Home.CashHistoryConfig'
	),
    '普通会员提现配置' => array(
        '编辑' => 'Home.MemberCashConfig'
    ),
    '推荐商家会员配置' => array(
        '编辑' => 'Home.RefConfig'
    ),
    '代理分配比率设置' => array(
        '编辑' => 'Home.AgentDistConfig'
    ),
    '支付接口配置' => array(
        '编辑' => 'Home.PayAPIConfig'
    ),
    '线下自动对账配置' => array(
        '编辑' => 'Home.CheckConfig'
    ),
    '代扣配置' => array(
        '编辑' => 'Home.HistoryBalanceConfig'
    ),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>