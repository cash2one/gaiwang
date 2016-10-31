<?php

return array(
    'userInfo' => array(// 用户信息
        Yii::t('main', '用户信息') => array(
            'url' => '/sub/user',
            'sub' => array(
                Yii::t('main', '修改密码') => '/user/modifyPassword',
                Yii::t('main', '程序更新日志') => '/bitUpdateLog/admin',
            )
        ),
    ),
    'webConfig' => array(// 网站配置
        Yii::t('main', '网站配置管理') => array(
            'url' => '/sub/config',
            'sub' => array(
                Yii::t('main', '网站配置') => '/home/siteConfig',
                Yii::t('main', '首页楼层配置') => '/home/floorConfig',
                Yii::t('main', '游戏开关配置') => '/home/gameConfig',
                Yii::t('main', 'SEO配置') => '/home/seoConfig',
                Yii::t('main', '短信接口配置') => '/home/smsApiConfig',
                Yii::t('main', '短信模板配置') => '/home/smsModelConfig',
                Yii::t('main', '文件上传配置') => '/home/uploadConfig',
                Yii::t('main', '系统信息') => '/home/main',
                Yii::t('main', '敏感词设置') => '/home/filterWorldConfig',
                Yii::t('main', '地址配置') => '/region/admin',
                Yii::t('main', '会员升级配置') => '/home/scheduleConfig',
                Yii::t('main', '系统任务管理') => '/home/taskConfig',
                Yii::t('main', '运费修改客服配置') => '/home/freightLinkConfig',
                Yii::t('main', '全局搜索热门词配置') => '/home/globalKeyWordConfig',
                Yii::t('main', '短信发送记录') => '/smsLog/admin',
                Yii::t('main', '发送邮件设置') => '/home/emailConfig',
                Yii::t('main', '邮件模板配置') => '/home/emailModelConfig',
                Yii::t('main', '邮件发送记录') => '/emailLog/admin',
                Yii::t('main', '汇率配置') => '/home/rateConfig',
                Yii::t('main', '订单配置') => '/home/orderConfig',
                Yii::t('main', '合约机配置') => '/home/heyuejiConfig',
                Yii::t('main', '盖付通免密支付额度设置') => '/gftNopwdPayLimitSetting/admin',
            )
        ),
        Yii::t('main', '积分配置管理') => array(
            'url' => '/sub/score',
            'sub' => array(
                Yii::t('main', '积分分配配置') => '/home/allocationConfig',
                Yii::t('main', '积分兑现配置') => '/home/creditsConfig',
                Yii::t('main', '企业会员提现配置') => '/home/shopCashConfig',
            	Yii::t('main', '企业会员提现白名单') => '/home/CashHistoryConfig',
                Yii::t('main', '普通会员提现配置') => '/home/memberCashConfig',
                Yii::t('main', '推荐商家会员配置') => '/home/refConfig',
                Yii::t('main', '代理分配比率设置') => '/home/agentDistConfig',
                Yii::t('main', '支付接口配置') => '/home/payAPIConfig',
                Yii::t('main', '线下自动对账配置') => '/home/checkConfig',
                Yii::t('main', '代扣配置') => '/home/historyBalanceConfig',
            )
        ),
        Yii::t('main', '盖网通公益管理') => array(
            'url' => '/sub/charity',
            'sub' => array(
                Yii::t('main', '捐款列表') => '/charity/admin',
            )
        ),
        Yii::t('main', '网站数据管理') => array(
            'url' => '/sub/data',
            'sub' => array(
                Yii::t('main', '静态页管理') => '/cache/admin',
                Yii::t('main', '多语言-后台') => '/home/languageBackend',
                Yii::t('main', '多语言-前台') => '/home/languageFrontend',
                Yii::t('main', '多语言-API') => '/home/languageApi',
            )
        ),
        Yii::t('main', '红包配置管理') => array(
            'url' => '/sub/hongbao',
            'sub' => array(
                Yii::t('main', '线下红包配置') => '/home/hongbaoConfig',
            )
        ),
        Yii::t('main', '网签合同管理') => array(
            'url' => '/sub/contract',
            'sub' => array(
                Yii::t('main', '盖网通及网店合同') => '/home/contractStore',
//                Yii::t('main', '盖网通及网店合同(免费)') => '/home/contractStore2',
                Yii::t('main', '网店管理规范及合作结算流程') => '/home/management',
//                Yii::t('main', '合作及结算流程') => '/home/settlement',
//                Yii::t('main', '承诺书') => '/home/commitment',
//                Yii::t('main', '自有品牌承诺书') => '/home/commitment2',
            )
        ),
        Yii::t('main', '电子化合同签约管理') => array(
            'url' => '/sub/electronicSigningContract',
            'sub' => array(
                Yii::t('main', '电子化签约合同模板') => '/home/offlineSignContractConfig',
                Yii::t('main', '电子化签约示例图片配置') => '/home/offlineSignDemoImgsConfig',
            )
        ),
    	Yii::t('main', '便民服务') => array(
    		'url' => '/sub/MobileRange',
    		'sub' => array(
    				Yii::t('main', '手机号码段管理') => '/MobileRange/Index',
    				Yii::t('main', '话费充值价格表') => '/mobileMoneyRechargeConfig/index',
    				Yii::t('main', '流量充值价格表') => '/MobileFlowRechargeConfig/index',
    				//Yii::t('main', '靓号管理') => '/MemberGoodNumber/index',
    				//Yii::t('main', '注册号段管理') => '/MemberRegisterNumberLimit/index',
    		)
    	),
        Yii::t('main', '盖付通配置管理') => array(
            'url' => '/sub/Gft',
            'sub' => array(
                Yii::t('main', '银行卡支付设置') => '/home/payMentlistConfig',
                Yii::t('main', '是否开启菜单选项') => '/home/gftMenuConfig',
                Yii::t('main', '主菜单设置') => '/gftMenuConfig/index',
            )
        ),
        Yii::t('main', '该掌柜配置管理') => array(
            'url' => '/sub/Gzg',
            'sub' => array(
                Yii::t('main', '银行卡支付设置') => '/home/gzgPayMentlistConfig',
            )
        ),
    	Yii::t('main', '靓号管理') => array(
    		'url' => '/sub/MemberGoodNumber',
    		'sub' => array(
    		Yii::t('main', '靓号管理') => '/MemberGoodNumber/index',
    		Yii::t('main', '注册号段管理') => '/MemberRegisterNumberLimit/index',
    		)
    		),
       Yii::t('main', '盖象优选配置管理') => array(
    		'url' => '/sub/AppPayManage',
    		'sub' => array(
    		Yii::t('main', '支付渠道设置') => '/AppPayManage/index',
    		//Yii::t('main', '注册号段管理') => '/MemberRegisterNumberLimit/index',
    		)
    		),
    ),
    'administrators' => array(// 管理员管理
        Yii::t('main', '管理员管理') => array(
            'url' => '/sub/admin',
            'sub' => array(
                Yii::t('main', '管理员列表') => '/user/admin',
                Yii::t('main', '管理员角色') => 'authItem/admin',
                Yii::t('main', '管理员操作日志') => '/user/log',
                Yii::t('main', '权限查询') => '/user/queryAuth',
            ),
        )
    ),
    'memberManagement' => array(// 会员管理
        Yii::t('main', '会员管理') => array(
            'url' => '/sub/member',
            'sub' => array(
                Yii::t('main', '普通会员列表') => '/member/admin',
//                Yii::t('main','新注册的企业会员') =>'/member/auditing',
//                Yii::t('main','企业会员审核列表') =>'/member/enterpriseMemberList',
                Yii::t('main', '企业会员列表') => '/member/list',
                Yii::t('main', '网签列表') => '/enterprise/admin',
                Yii::t('main', '开店管理') => '/enterprise/storeAdmin',
                Yii::t('main', '会员类型配置') => '/memberType/admin',
                Yii::t('main', '会员角色列表') => '/memberRole/admin',
                Yii::t('main', '会员级别列表') => '/memberGrade/admin',
            	Yii::t('main', '会员积分消费额度级别列表') => '/memberPointGrade/admin',
            	Yii::t('main', '会员积分消费额度列表') => '/memberPoint/admin',
                Yii::t('main', '兴趣爱好列表') => '/interest/admin',
                Yii::t('main', '兴趣爱好分类列表') => '/interestCategory/admin',
                Yii::t('main', '群发站内信') => '/message/create',
//                Yii::t('main', '批量导入会员') => '/importMember/index',
            )
        ),
        Yii::t('main', '加盟商管理') => array(
            'url' => '/sub/jms',
            'sub' => array(
                Yii::t('main', '线下加盟商列表') => '/franchisee/admin',
                Yii::t('main', '加盟商审核列表') => '/auditing/admin',
                Yii::t('main', '加盟商对账') => '/franchiseeConsumptionRecord/admin',
                Yii::t('main', '加盟商对账申请') => '/franchiseeConsumptionRecord/consumptionApply',
                Yii::t('main', '加盟商对账撤销申请') => '/franchiseeConsumptionRecord/rebackApply',
                Yii::t('main', '异常商户列表') => '/franchisee/abnormal',
                Yii::t('main', '线下加盟商活动城市') => '/franchiseeActivityCity/admin',
                Yii::t('main', '线下加盟商文章列表') => '/franchiseeArtile/admin',
                Yii::t('main', '盖机列表') => '/machine/admin',
                Yii::t('main', '加盟商分类列表') => '/franchiseeCategory/admin',
                //Yii::t('main', '生成预设加盟商编号') => 'franchiseeCode/admin',
                Yii::t('main', '加盟商品牌') => 'franchiseeBrand/admin',
                Yii::t('main', '电子化签约审核列表') => 'offlineSignStoreExtend/admin',
                Yii::t('main', '归属方信息列表') => 'OfflineSignMachineBelong/admin',
                Yii::t('main', '大区配置') => '/regionManage/Index',
            )
        ),
    	Yii::t('main', '线下角色管理') => array(
    		'url' => '/sub/offRole',
    		'sub' => array(
    			Yii::t('main', '线下角色管理') => '/offlineRole/admin',
    			Yii::t('main', '代理列表') => '/offlineRoleRelation/agentList',
    		)
    	),
        Yii::t('main', '商铺管理') => array(
            'url' => '/sub/store',
            'sub' => array(
                Yii::t('main', '商铺列表') => '/store/admin',
                Yii::t('main', '店铺装修列表') => '/Design/index',
                Yii::t('main', '商铺文章') => '/storeArticle/admin',
            )
        ),
        Yii::t('main', '公用账户管理') => array(
            'url' => '/sub/common',
            'sub' => array(
                Yii::t('main', '共有账户列表') => '/commonAccount/admin',
            )
        ),
        Yii::t('main', '代理管理') => array(
            'url' => '/sub/agent',
            'sub' => array(
                Yii::t('main', '代理列表') => '/commonAccountAgentDist/agentList',
//                Yii::t('main','代理账户列表') =>'/commonAccountAgentDist/agentAccountList',
                Yii::t('main', '代理账户分配金额记录') => '/commonAccountAgentDist/admin',
            	Yii::t('main', '资金池账户余额') => '/CommonAccount/Balance',
//                Yii::t('main','代理统计') =>'/commonAccountAgentDist/agentStatistics',
            )
        ),
       Yii::t('main', '居间商管理') => array(
            'url' => '/sub/middleAgent',
            'sub' => array(
            Yii::t('main', '居间商列表') => '/middleAgent/admin',
            )
            ),
    ),
    'rechargeCashManagement' => array(// 充值兑现管理
        Yii::t('main', '充值卡管理') => array(
            'url' => '/sub/card',
            'sub' => array(
                Yii::t('main', '添加充值卡') => '/prepaidCard/create',
                Yii::t('main', '充值卡列表') => '/prepaidCard/admin',
                Yii::t('main', '充值卡使用记录') => '/prepaidCard/list',
//                Yii::t('main', '批量充值') => '/importRecharge/index',
                Yii::t('main', '批发充值卡') => '/prepaidCard/batch',
                Yii::t('main', '批发充值卡记录') => '/prepaidCard/historybatch',
                Yii::t('main', '导入充值') => '/importRecharge/ImportRecharge',
                Yii::t('main', '导入充值记录') => '/importRecharge/historyRechange',
                Yii::t('main', '充值卡转账列表') => '/prepaidCardTransfer/admin',
            )
        ),
        Yii::t('main', '积分返还管理') => array(
            'url' => '/sub/return',
            'sub' => array(
                Yii::t('main', '积分返还充值卡列表') => '/prepaidCard/index',
                Yii::t('main', '积分返还卡使用记录') => '/prepaidCard/detail',
            )
        ),
        Yii::t('main', '提现管理') => array(
            'url' => '/sub/cash',
            'sub' => array(
                Yii::t('main', '代理提现申请单') => '/cashHistory/applyCash',
                Yii::t('main', '企业会员提现申请单') => '/cashHistory/enterpriseApplyCash',
                Yii::t('main', '普通会员提现申请单') => '/cashHistory/memberApplyCash',
            	Yii::t('main', '自动提现申请单') => '/paymentBatch/admin',
            )
        ),
        Yii::t('main', '网银充值管理') => array(
            'url' => '/sub/recharge',
            'sub' => array(
                Yii::t('main', '积分充值列表') => '/recharge/admin',
            )
        ),
       Yii::t('main', '代收代付管理') => array(
            'url' => '/sub/ThirdPayment',
            'sub' => array(
              Yii::t('main', '实时代付申请') => '/ThirdPayment/PayMoney/tid/'.ThirdPayment::PAY_MONEY,
              Yii::t('main', '代付申请列表') => '/ThirdPayment/PayMoneyList',
            )
       ),
    ),
    'mallManagement' => array(// 商城管理
        Yii::t('main', '广告管理') => array(// 广告管理
            'url' => '/sub/advert',
            'sub' => array(
                Yii::t('main', '广告位列表') => '/advert/admin',
                Yii::t('main', '导航') => '/home/navigationConfig'
            )
        ),
        Yii::t('main', '文章管理') => array(// 文章管理
            'url' => '/sub/article',
            'sub' => array(
                Yii::t('main', '文章列表') => '/article/admin',
                Yii::t('main', '文章分类列表') => '/articleCategory/admin'
            )
        ),
        '品牌类别管理' => array(// 品牌管理
            'url' => '/sub/brand',
            'sub' => array(
                '类别列表' => '/category/admin',
                '品牌列表' => '/brand/admin',
            )
        ),
        Yii::t('main', '积分兑换管理') => array(
            'url' => '/sub/integral',
            'sub' => array(
                Yii::t('main', '商品管理') => '/product/admin',
                 Yii::t('main','商品管理(活动)')=>'/product/activeAdmin',
                Yii::t('main', '常见物流管理') => '/express/admin',
                Yii::t('main', '商品规格管理') => '/spec/admin',
                Yii::t('main', '商品类型') => '/type/admin',
                Yii::t('main', '商品搜索管理') => '/keyword/admin',
                Yii::t('main', '商品咨询列表') => '/guestbook/admin',
                Yii::t('main', '用户反馈') => '/feedback/admin',//新增用户反馈
            )
        ),
        Yii::t('main', '订单管理') => array(
            'url' => '/sub/order',
            'sub' => array(
                Yii::t('main', '订单列表') => '/order/admin',
                Yii::t('main', '订单评论管理') => '/comment/admin',
                Yii::t('main', '异常订单查询') => '/order/exception',
                Yii::t('main', '未阅读订单查询') => '/order/unread',
                Yii::t('main', '消费者维权订单') => '/order/rights',
                Yii::t('main', '运费编辑管理') => '/freightEdit/admin',
                Yii::t('main', '手动对账') => '/payResult/admin',
                Yii::t('main', '退款到银行卡') => '/orderRefund/admin',
            )
        ),
        Yii::t('main', '友情链接管理') => array(
            'url' => '/sub/link',
            'sub' => array(
                Yii::t('main', '友情链接列表') => '/link/admin',
            )
        ),
        Yii::t('main', '活动管理') => array(
            'url' => '/sub/activity',
            'sub' => array(
                Yii::t('main', '专题活动管理') => '/specialTopic/admin',
                Yii::t('main', '充值红包活动') => '/redEnvelopeActivity/admin',
                Yii::t('main', '红包活动商品标签') => '/redActivityTag/admin',
                Yii::t('main', '红包补偿') => '/redCompensation/admin',
                Yii::t('main', '审核商家盖惠券') => '/couponActivity/admin',
                Yii::t('main', '盖惠券商家管理') => '/couponActivity/CreditAdmin',
                Yii::t('main', '红包兑换管理') => '/redCompensation/ExchangeCode',
                Yii::t('main', '红包,盖惠券派发纪录') => '/coupon/admin',
            )
        ),
        Yii::t('main', '活动专题管理') => array(
            'url' => '/sub/seckill',
            'sub' => array(
                Yii::t('main', '应节活动管理') => '/secondKillActivity/FestiveAdmin',
				Yii::t('main', '红包活动管理') => '/secondKillActivity/RedAdmin',
				Yii::t('main', '秒杀活动管理') => '/secondKillActivity/SeckillAdmin',
                Yii::t('main', '今日必抢管理') => '/secKillGrab/admin',
                Yii::t('main', '活动商品类别管理') => '/secondKillActivity/ActiveCategory',
                Yii::t('main', '军旅专题红包奖励') => '/redCompensation/votered',
                Yii::t('main', '拍卖活动管理') => '/seckillAuctionActivity/SeckillAuctionAdmin',
                Yii::t('main', '拍卖活动商品管理') => '/secKillAuction/admin',
            ),
        ),
        Yii::t('main', '城市频道管理') => array(
            'url' => '/sub/cityShow',
            'sub' => array(
                Yii::t('main', '城市馆大区') => '/cityshowRegion/admin',
                Yii::t('main', '城市馆审核列表') => '/cityshow/admin',
                Yii::t('main', '城市馆权限管理列表') => '/cityshowRights/admin',
            ),
        ),
    ),
    'statisticsManagement' => array(// 统计管理
        Yii::t('main', '会员统计') => array(
            'url' => '/sub/memberStatistics',
            'sub' => array(
                Yii::t('main', '会员人数统计') => '/statistics/memberCount',
            )
        ),
        Yii::t('main', '商铺统计') => array(
            'url' => '/sub/shopStatistics',
            'sub' => array(
                Yii::t('main', '商铺统计') => '/statistics/storeCount',
                Yii::t('main', '商铺排行') => '/statistics/storeList',
            )
        ),
        Yii::t('main', '商品统计') => array(
            'url' => '/sub/goodsStatistics',
            'sub' => array(
                Yii::t('main', '商品统计') => '/statistics/product',
                Yii::t('main', '商品分类统计') => '/statistics/catProCount',
                Yii::t('main', '商品排行') => '/statistics/productList',
            )
        ),
        Yii::t('main', '订单统计') => array(
            'url' => '/sub/orderStatistics',
            'sub' => array(
                Yii::t('main', '订单统计') => '/statistics/orderCount',
            )
        ),
       Yii::t('main', '推广统计') => array(
            'url' => '/sub/promotionStatistics',
            'sub' => array(
            Yii::t('main', '推广渠道列表') => '/promotionStatistics/admin',
            )
       ),
        Yii::t('main', '其它统计') => array(
            'url' => '/sub/otherStatistics',
            'sub' => array(
                Yii::t('main', '商家总销售额统计') => '/statistics/storesRank',
                Yii::t('main', '消费者总消费统计') => '/statistics/customerRank',
                Yii::t('main', '商家近三天销售额统计') => '/statistics/storesRankExtend',
                Yii::t('main', '消费者近一个月消费统计') => '/statistics/customerRankExtend',
            )
        ),
        Yii::t('main', '每周统计') => array(
            'url' => '/sub/weeklyStatistics',
            'sub' => array(
                Yii::t('main', '盖机数据') => '/weeklyStatistics/machine',
                Yii::t('main', '加盟商数据') => '/weeklyStatistics/franchisee',
                Yii::t('main', '会员数据') => '/weeklyStatistics/member',
                Yii::t('main', '盖机运行时间') => '/weeklyStatistics/machineTime',
                Yii::t('main', '订单数据(商城)') => '/weeklyStatistics/order',
                Yii::t('main', '盖机最新运行时间') => '/weeklyStatistics/machineDelay',
            )
        ),
    ),
    'hotelManagement' => array(// 酒店管理
        Yii::t('main', '酒店信息') => array(
            'url' => '/sub/hotelInfo',
            'sub' => array(
                Yii::t('main', '酒店列表') => '/hotel/admin',
                Yii::t('main', '酒店级别列表') => '/hotelLevel/admin',
                Yii::t('main', '酒店品牌列表') => '/hotelBrand/admin',
                Yii::t('main', '酒店供应商列表') => '/hotelProvider/admin',
                Yii::t('main', '酒店热门地址列表') => '/hotelAddress/admin',
                Yii::t('main', '住客国籍列表') => '/nationality/admin',
                Yii::t('main', '酒店参数配置') => '/hotelParams/hotelParamsConfig',
            )
        ),
        Yii::t('main', '酒店订单') => array(
            'url' => '/sub/hotelOrder',
            'sub' => array(
                Yii::t('main', '酒店订单查询列表') => '/hotelOrder/admin',
            	Yii::t('main', '酒店订单用户列表') => '/orderMember/admin',
                Yii::t('main', '酒店新订单列表') => '/hotelOrder/newList',
                Yii::t('main', '酒店待确认订单列表') => '/hotelOrder/noVerifyList',
                Yii::t('main', '酒店已确认订单列表') => '/hotelOrder/verifyList',
                Yii::t('main', '酒店已核对订单列表') => '/hotelOrder/checkList',
                Yii::t('main', '酒店已对账订单列表') => '/hotelOrder/checkingList',
            )
        )
    ),
    'travelManagement' => array(// 酒店管理
        Yii::t('main', '酒店网站配置') => array(
            'url' => '/sub/travelConfig',
            'sub' => array(
                Yii::t('main', '酒店网站配置') => 'travel/webConfig/site',
                Yii::t('main', '酒店参数配置') => '/travel/webConfig/params',
                Yii::t('main', '广告位设置') => '/travel/advert/admin',
                Yii::t('main', '静态信息类型配置') => '/travel/baseInfoType/admin',
                Yii::t('main', '静态信息配置') => '/travel/baseInfo/admin',
            )
        ),
        Yii::t('main', '地址管理') => array(
            'url' => '/sub/travelAddress',
            'sub' => array(
                Yii::t('main', '国家') => 'travel/nation/admin',
                Yii::t('main', '省份') => '/travel/province/admin',
                Yii::t('main', '城市') => '/travel/city/admin',
                Yii::t('main', '行政区') => '/travel/district/admin',
                Yii::t('main', '商业区') => '/travel/business/admin',
            )
        ),
        Yii::t('main', '城市名片管理') => array(
            'url' => '/sub/cityCard',
            'sub' => array(
                Yii::t('main', '城市名片列表') => 'travel/cityCard/admin',
            )
        ),

        Yii::t('main', '酒店信息管理') => array(
           'url' => '/sub/travelInfo',
            'sub' => array(
                Yii::t('main', '酒店列表') => 'travel/hotel/admin',
                Yii::t('main', '酒店热门地址列表') => 'travel/hotAddress/admin',
                Yii::t('main', '酒店供应商列表') => 'travel/provider/admin',
            )
        ),
        Yii::t('main', '酒店订单管理') => array(
            'url' => '/sub/travelOrder',
            'sub' => array(
                Yii::t('main', '酒店订单查询列表') => '/hotelOrder/admin',
                Yii::t('main', '酒店新订单列表') => '/hotelOrder/newList',
                Yii::t('main', '酒店已确认订单列表') => '/hotelOrder/verifyList',
                Yii::t('main', '酒店已核对订单列表') => '/hotelOrder/checkList',
                Yii::t('main', '酒店已对账订单列表') => '/hotelOrder/checkingList',
            )
        )
    ),
    'mshopManagement' => array(// 客服管理
                Yii::t('main', '微商城广告管理') => array(
                        'url' => '/sub/mshopAdvert',
                        'sub' => array(
                                Yii::t('main', '广告位管理') => '/mshopAdvert/admin',
                        ),
                        
                ) 
        ),
    'appManagement' => array(// APP管理
        Yii::t('main', 'APP广告管理') => array(
            'url' => '/sub/appAdvert',
            'sub' => array(
                Yii::t('main', '广告位管理') => '/appAdvert/admin',
            )
        ),
        Yii::t('main', 'APP管理') => array(
            'url' => '/sub/appManage',
            'sub' => array(
                Yii::t('main', '版本管理') => '/appVersion/admin',
            )
        )
    ),
    'tradeManagement' => array(// 交易管理
        Yii::t('main', '帐户余额') => array(
            'url' => '/sub/accountBalance',
            'sub' => array(
                Yii::t('main', '余额列表（新）') => '/accountBalance/admin',
                Yii::t('main', '历史余额') => '/accountBalanceHistory/admin'
            )
        ),
        Yii::t('main', '交易流水') => array(
            'url' => '/sub/accountFlow',
            'sub' => array(
                Yii::t('main', '流水日志（新）') => '/accountFlow/admin',
                Yii::t('main', '历史流水') => '/accountFlowHistory/admin',
                Yii::t('main', '流水导出') => '/accountFlow/exportMonth',
                Yii::t('main', '余额导出') => '/accountFlow/exportBalance',
            )
        ),
        Yii::t('main', '线下交易流水') => array(
            'url' => '/sub/accountOfflineTransactions',
            'sub' => array(
                Yii::t('main', '联动支付交易流水') => '/accountOfflineTransactions/offlineTransactions',
                Yii::t('main', '线下机器交易记录') => '/accountOfflineTransactions/appConsumRecord',
                    )
        ),
        Yii::t('main', '交易对账') => array(
            'url' => '/sub/accountPosRecord',
            'sub' => array(
                Yii::t('main', 'POS差异流水对账') => 'accountPosRecord/admin',
            )
        ),
    	Yii::t('main', '盖粉转账') => array(
    		'url' => '/sub/accountFlowHistory',
    		'sub' => array(
    		Yii::t('main', '盖粉转账查询') => '/accountFlowHistory/gfAdmin',
    	   )
       ),
    ),
    'groupbuyManagement' => array(//团购管理
        Yii::t('main', '团购管理') => array(
            'url' => '/sub/groupbuy',
            'sub' => array(
                Yii::t('main', '线下团购') => '/franchiseeGroupbuy/admin',
                Yii::t('main', '类目管理') => '/franchiseeGroupbuyCategory/admin',
            )
        )
    ),
    'serviceManagement' => array(// 客服管理
        Yii::t('main', '客服管理') => array(
            'url' => '/sub/service',
            'sub' => array(
                Yii::t('main', '投诉建议') => '/complaint/admin',
                Yii::t('main', '电话报修') => '/repairs/admin',
            ),
        )
    ),
    'sideAgreementManagement' => array( // 补充协议管理
        Yii::t('main','补充协议管理') => array(
            'url' => 'sub/contract',
            'sub' => array(
                Yii::t('contract','合同补充协议(代理版)') => '/contract/agency',
                Yii::t('contract','合同补充协议(直营版)') => '/contract/regularChain',
                Yii::t('franchiseecontract', '协议相关商户列表')    => '/franchiseeContract/listAgreement',
            ),
        )
    ),
	'gateApp' => array( // 盖象APP
			Yii::t('main','主题') => array(
					'url' => 'sub/contract',
					'sub' => array(
                        Yii::t('contract','新动') =>'/appTopicCar/admin',
                        Yii::t('contract','臻至生活审核列表')=>'appTopicLife/admin',
                       // Yii::t('contract','臻致生活') => '/appTopic/adminLife',
//                         Yii::t('contract','商务小礼') => '/appTopic/adminGift',
                        Yii::t('contract','盖鲜汇') => '/appTopic/adminFresh',
                        Yii::t('contract','仕品') => '/appTopicHouse/adminHouse',
						Yii::t('contract','品牌馆') => '/appBrands/admin',
						
					),
			),
			Yii::t('main','商城热卖') => array(
					'url' => 'sub/hot',
					'sub' => array(
							Yii::t('contract','品质至上') => '/appHotCategory/admin',
							Yii::t('contract','绑定商品') => '/appHotGoods/admin',
							Yii::t('contract','热卖管理') => '/HosSellOrder/index',
							Yii::t('contract','活动标题') => '/AppActiveTitle/index',
							Yii::t('contract','热搜关键字') => '/AppHotKey/index',
							Yii::t('contract','欢迎页设置') => '/appHomePicture/admin',
					),
			),
			Yii::t('main','秘钥管理') => array(
					'url' => 'rsamanage/index',
					'sub' => array(
							Yii::t('rsamanage','秘钥管理') => '/RsaManage/index',
							),
			),
			Yii::t('main','售后&咨询') => array(
				'url' => 'sub/service',
				'sub' => array(
				           Yii::t('rsamanage','订单问题') => '/AppService/order',
						   Yii::t('rsamanage','支付问题') => '/AppService/pay',
						   Yii::t('rsamanage','消费积分') => '/AppService/consum',
				        ),
			),
	),

    'gameConfig' => array( //游戏配置管理
        Yii::t('main', '游戏配置管理') => array(
            'url' => '/sub/gameConfig',
            'sub' => array(
                Yii::t('game','积分兑换开关') => '/gameConfig/switchConfig',
                Yii::t('game','撤销兑换金币') => '/gameConfig/revokeGold',
                Yii::t('game','撤销兑换金币列表') => '/gameConfig/revokeGoldList',
                Yii::t('game', '三国跑跑概率表') => '/gameConfig/multipleConfig',
                Yii::t('game','三国跑跑房间表') => '/gameConfig/roomConfig',
                Yii::t('game','啪啪萌僵尸配置表') => '/gameConfig/paipaimengConfig',
                Yii::t('game','黄金矿工价格表') => '/gameConfig/minerConfig',
                Yii::t('game','黄金矿工配置表') => '/gameConfig/goldenConfig',
                Yii::t('game','神偷莉莉配置表') => '/gameConfig/shentouliliConfig',
                Yii::t('game','攀枝花抢水果配置') => '/gameStore/admin',
                Yii::t('game','弹跳公主配置表') => '/gameConfig/tantiaogongzhuConfig',
                Yii::t('game','美女走钢丝配置表') => '/gameConfig/zougangsiConfig',
            	Yii::t('game','绿光配置表') => '/gameConfig/lvguangConfig',
            	Yii::t('game','猴犀利配置表') => '/gameConfig/housaileiConfig',             
            	Yii::t('game','熊孩子逃学记配置表') => '/gameConfig/xionghaiziConfig',
                Yii::t('game','超神特工配置表') => '/gameConfig/jumpConfig',
		Yii::t('game','兽人来了配置表') => '/gameConfig/shourenlaileConfig',
                Yii::t('game','大冒险配置表') => '/gameConfig/damaoxianConfig',
                Yii::t('game','狗狗别作死配置表') => '/gameConfig/gougouConfig',
		Yii::t('game','保卫师傅技能配置表') => '/gameConfig/skillConfig',
		Yii::t('game','保卫师傅配置表') => '/gameConfig/baoweishifuConfig',
                Yii::t('game','深入敌后配置表') => '/gameConfig/shenrudihouConfig',
                Yii::t('game','进击魔王配置表') => '/gameConfig/jinjimowangConfig',
                Yii::t('game','大鱼吃小鱼配置表') => '/gameConfig/dayuchixiaoyuConfig',
                Yii::t('game','盖付通大乱斗配置表')=>'/gameConfig/daluandouConfig',
		Yii::t('game','宅男与女仆配置表') =>'/gameConfig/zhainanyunvpuConfig',
		Yii::t('game','逃出动物园配置表') =>'/gameConfig/taochudongwuyuanConfig',
            ),
        ),
    ),
);
