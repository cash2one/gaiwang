<?php

/**
 * 会员后台中心 左侧菜单
 *
 * curr：当前控制器+方法 存在 curr数组中，则菜单显示当前样式，一般默认等于 url中的值
 * in_array($this->id.'/'.$this->action->id, $curr);
 */
$infoId = Yii::app()->user->getState('enterpriseId');
return array(
    'userInfo' => array(//账户管理
        array('curr' => array('enterpriseLog/process', 'enterpriseLog/enterprise','enterpriseLog/enterprise2', 'enterpriseLog/view', 'enterpriseLog/print'),
            'name' =>  Yii::t('home', '网络店铺签约'),
            'url' =>  'enterpriseLog/process'),
        array(
            'curr' => array('site/index', 'member/update'),
            'name' => $infoId ? Yii::t('home', '企业基本信息') : Yii::t('home', '用户基本信息'),
            'url' => 'site/index'),
        array(
            'curr' => array('member/avatar'),
            'name' => $infoId ? Yii::t('home', '企业头像') : Yii::t('home', '用户头像'),
            'url' => 'member/avatar'),
        array('curr' => array('interest/index'), 'name' => Yii::t('home', '兴趣爱好'), 'url' => 'interest/index'),
        array('curr' => array('member/safe'), 'name' => Yii::t('home', '安全信息'), 'url' => 'member/safe'),
//        array('curr' => array('bankAccount/index'), 'name' => Yii::t('home', '银行账户设置'), 'url' => 'bankAccount/index'),
        array('curr' => array('member/password', 'member/setPassword1', 'member/setPassword2', 'member/setPassword3'),
            'name' => Yii::t('home', '密码设置'), 'url' => 'member/password'),
        array('curr' => array('message/index'), 'name' => Yii::t('home', '站内信息'), 'url' => 'message/index'),
        array('curr' => array('member/recommendUrl'), 'name' => Yii::t('home', '推荐链接'), 'url' => 'member/recommendUrl'),
        array('curr' => array('member/recommendUsers'), 'name' => Yii::t('home', '我的推荐会员'), 'url' => 'member/recommendUsers'),
    ),
    'qy' => array(// 企业管理
        // array('curr' => array('wealth/enterpriseCashDetail'), 'name' => Yii::t('home', '账户明细'), 'url' => 'wealth/enterpriseCashDetail'),
        array('curr' => array('applyCash/log'), 'name' => Yii::t('home', '提现列表'), 'url' => 'applyCash/log'),
        array(
            'curr' => array('applyCash/list', 'enterpriseApplyCash/complete'),
            'name' => Yii::t('home', '申请提现'), 'url' => 'applyCash/list'),
        array('curr' => array(), 'name' => Yii::t('home', '卖家平台'), 'url' => '/seller'),
//        array('curr'=>array(''),'name'=>Yii::t('home','网签'),'url'=>'/member/creditor/create'),
     array('curr' => array('wealth/offline'), 'name' => Yii::t('home', '线下交易明细'), 'url' => 'wealth/offline'),
    ),
    'jf' => array(//积分管理
        array('curr' => array('redEnvelope/index'), 'name' => Yii::t('home', '我的钱包'), 'url' => 'redEnvelope/index','title'=>Yii::t('home', '余额、红包')),
        array('curr' => array('wealth/cashDetail'), 'name' => Yii::t('home', '消费明细'), 'url' => 'wealth/cashDetail'),
//        array(
//            'curr' => array('applyCash/index', 'applyCash/confirm', 'applyCash/complete'),
//            'name' => Yii::t('home', '申请兑现'), 'url' => 'applyCash/index'),
//        array('curr' => array('applyCash/log'), 'name' => Yii::t('home', '申请兑现记录'), 'url' => 'applyCash/log'),
//        array('curr' => array('test/avatar'), 'name' => Yii::t('home', '用积分缴费'), 'url' => 'test/avatar'),
        array('curr' => array('prepaidCard/use'), 'name' => Yii::t('home', '充值卡充值'), 'url' => 'prepaidCard/use'),
        //关闭网银充值
        array(
            'curr' => array('recharge/index', 'recharge/unionPayResult'),
            'name' => Yii::t('home', '网银充值'), 'url' => 'recharge/index'),
        array('curr' => array('recharge/list'), 'name' => Yii::t('home', '网银充值记录'), 'url' => 'recharge/list'),
        array('curr' => array('quickPay/list'), 'name' => Yii::t('home', '快捷支付'), 'url' => 'quickPay/list'),
        array(
            'curr' => array('giveCash/index'),
            'name' => Yii::t('home', '派发红包'),
            'url' => 'giveCash/index'
        ),
    ),
	'order' => array(//买入管理
		array(
			'curr' => array('order/admin', 'order/detail'),
			'name' => Yii::t('home', '我的订单'), 'url' => 'order/admin'),
		array('curr' => array('comment/index'), 'name' => Yii::t('home', '我的评价'), 'url' => 'comment/index'),

		array(
			'curr' => array('address/index', 'address/update'),
			'name' => Yii::t('home', '收货地址'), 'url' => 'address/index'
		),
		array('curr' => array('hotelOrder/index'), 'name' => Yii::t('home', '我的酒店订单'), 'url' => 'hotelOrder/index'),
		//array('curr' => array('coupon/index'), 'name' => Yii::t('home', '我的盖惠券'), 'url' => 'coupon/index'),
	),
	
	'center' => array(//订单中心
		array('curr' => array('order/admin'), 'name' => Yii::t('home', '我的订单'), 'url' => 'order/admin'),
	    array('curr' => array('hotelOrder/index','hotelOrder/view'), 'name' => Yii::t('home', '酒店订单'), 'url' => 'hotelOrder/index'),
		array('curr' => array('orderMember/index'), 'name' => Yii::t('home', '订单用户信息'), 'url' => 'orderMember/index'),
		array('curr' => array('comment/index'), 'name' => Yii::t('home', '我的评价'), 'url' => 'comment/index'),
        array('curr' => array('auction/admin', 'auction/order'), 'name' => Yii::t('home', '我的竞拍'), 'url' => 'auction/admin'),
	),
	'afterSales' => array(//售后服务
		array('curr' => array('exchangeGoods/admin'), 'name' => Yii::t('home', '退换货'), 'url' => 'exchangeGoods/admin'),
	),
	'assets' => array(//资产中心
		array('curr' => array('redEnvelope/index','redEnvelope/redList'), 'name' => Yii::t('home', '我的钱包'), 'url' => 'redEnvelope/index'),
		array('curr' => array('prepaidCard/use','recharge/index'), 'name' => Yii::t('home', '帐户充值'), 'url' => 'prepaidCard/use'),
		array('curr' => array('wealth/cashDetail'), 'name' => Yii::t('home', '消费明细'), 'url' => 'wealth/cashDetail'),
		//array('curr' => array('quickPay/list'), 'name' => Yii::t('home', '快捷支付'), 'url' => 'quickPay/list'),                                  
		array('curr' => array('giveCash/index'), 'name' => Yii::t('home', '派发红包'), 'url' => 'giveCash/index'),
                                   array('curr' => array('memberCash/cashList'), 'name' => Yii::t('home', '提现列表'), 'url' => 'memberCash/cashList'),
                                   array( 'curr' => array('memberCash/applyCash'), 'name' => Yii::t('home', '申请提现'), 'url' => 'memberCash/applyCash'),
//                                   array( 'curr' => array('memberCash/updateBank'), 'name' => Yii::t('home', '提现银行账户'), 'url' => 'memberCash/updateBank'),
	),
	'specialised' => array(//特色服务
		array('curr' => array('member/recommendUrl'), 'name' => Yii::t('home', '推荐链接'), 'url' => 'member/recommendUrl'),
		array('curr' => array('member/recommendUsers'), 'name' => Yii::t('home', '我的推荐会员'), 'url' => 'member/recommendUsers'),
	),
	'setup' => array(//设置
		array('curr' => array('member/update'), 'name' => Yii::t('home', '个人信息'), 'url' => 'member/update'),
		array('curr' => array('address/index'), 'name' => Yii::t('home', '收货地址'), 'url' => 'address/index'),
	),
	'security' => array(//安全中心
		array('curr' => array('member/accountSafe'), 'name' => Yii::t('home', '帐户安全'), 'url' => 'member/accountSafe'),
	),
    'qyv20' => array(// 改版企业管理 
                array('curr' => array('enterprise/cashList'), 'name' => Yii::t('home', '提现列表'), 'url' => 'enterprise/cashList'),
                array(
                        'curr' => array('enterprise/applyCash', 'enterprise/complete'),
                        'name' => Yii::t('home', '申请提现'), 'url' => 'enterprise/applyCash'),
                array('curr' => array(), 'name' => Yii::t('home', '卖家平台'), 'url' => '/seller'),
                array('curr' => array('enterprise/offline'), 'name' => Yii::t('home', '线下交易明细'), 'url' => 'enterprise/offline'),
        ),
);
