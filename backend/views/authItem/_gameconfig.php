<?php
$config = array(
     '积分兑换开关' => array(
         '编辑积分兑换开关' => 'GameConfig.SwitchConfig',
    ),
    '撤销兑换金币' => array(
        '撤销兑换金币' => 'GameConfig.RevokeGold',
    ),
    '撤销兑换金币列表' => array(
        '查看列表' => 'GameConfig.RevokeGoldList'
    ),
    '三国跑跑' => array(
        '编辑概率表' => 'GameConfig.MultipleConfig',
        '编辑房间表' => 'GameConfig.RoomConfig',
    ),
    '啪啪萌僵尸' => array(
        '编辑配置表' => 'GameConfig.PaipaimengConfig',
    ),
    '黄金矿工' => array(
        '编辑配置表' => 'GameConfig.GoldenConfig',
        '编辑价格表' => 'GameConfig.MinerConfig',
    ),
    '神偷莉莉' => array(
        '编辑配置表' => 'GameConfig.ShentouliliConfig',
    ),
    '攀枝花抢水果' => array(
        '游戏店铺列表' => 'GameStore.Admin',
        '添加游戏店铺' => 'GameStore.Create',
        '编辑游戏店铺' => 'GameStore.Update',
        '游戏商品列表' => 'GameStoreItems.Admin',
        '添加游戏商品' => 'GameStoreItems.Create',
        '编辑游戏商品' => 'GameStoreItems.Update',
    ),
    '弹跳公主' => array(
        '编辑配置表' => 'GameConfig.TantiaogongzhuConfig',
    ),
    '美女走钢丝' => array(
        '编辑配置表' => 'GameConfig.ZougangsiConfig',
    ),
    '绿光' => array(
        '编辑配置表' => 'GameConfig.LvguangConfig',
    ),
	'猴犀利' => array(
        '编辑配置表' => 'GameConfig.HousaileiConfig',
    ),
    '熊孩子逃学记' => array(
        '编辑配置表' => 'GameConfig.XionghaiziConfig',
    ),
    '超神特工' => array(
        '编辑配置表' => 'GameConfig.JumpConfig',
    ),
    '兽人来了' => array(
        '编辑配置表' => 'GameConfig.ShourenlaileConfig',
    ),
    '狗狗别作死' => array(
        '编辑配置表' => 'GameConfig.GougouConfig',
    ),
    '大冒险' => array(
        '编辑配置表' => 'GameConfig.DamaoxianConfig',
    ),
    '深入敌后' => array(
        '编辑配置表' => 'GameConfig.ShenrudihouConfig',
    ),
    '进击魔王' => array(
        '编辑配置表' => 'GameConfig.JinjimowangConfig',
    ),
    '大鱼吃小鱼' => array(
        '编辑配置表' => 'GameConfig.DayuchixiaoyuConfig',
    ),
    '盖付通大乱斗'=>array(
        '编辑配置表'=> 'GameConfig.DaluandouConfig',
    ),
    '宅男与女仆'=>array(
        '编辑配置表'=> 'GameConfig.ZhainanyunvpuConfig',
    ),
    '逃出动物园'=>array(
        '编辑配置表'=>'GameConfig.TaochudongwuyuanConfig',
    )
);
$this->renderPartial('_input', array('config' => $config, 'rights' => $rights));
?>