<?php

/*
 * 卖家平台右侧菜单
 */
return array(
    'assistantInfo' => array(
        'name' => Yii::t('home', '用户信息'),
        'class' => 'bartenderMana',
        'children' => array(
            Yii::t('home', '店小二信息') => '/seller/assistantManage/defaultShow',
            Yii::t('home', '修改密码') => '/seller/assistantManage/changePw',
        ),
    ),
    'dealManage' => array(
        'name' => Yii::t('home', '交易管理'),
        'class' => 'transMana',
        'children' => array(
            Yii::t('home', '已卖出商品') => array(
                'value' => '/seller/order/index',
                'actions' => array(
                    'order/detail' => Yii::t('home', '订单详情'),
                    'order/stockUp' => Yii::t('home', '备货'),
                    'order/express' => Yii::t('home', '发货'),
                    'order/closeOrder' => Yii::t('home', '取消订单'),
                    'order/setRead' => Yii::t('home', '批量标记为已读'),
                    'order/excel' => Yii::t('home', '导出excel'),
                ),
            ),
            Yii::t('home', '运费模板') => array(
                'value' => '/seller/freightTemplate/index',
                'actions' => array(
                    'freightArea/create' => Yii::t('home', '新增区域运费'),
                    'freightArea/update' => Yii::t('home', '修改区域运费'),
                    'freightTemplate/create' => Yii::t('home', '新增运费模板'),
                    'freightTemplate/update' => Yii::t('home', '修改运费模板'),
                    'freightType/view' => Yii::t('home', '查看运费类型'),
                    'freightType/update' => Yii::t('home', '修改默认运费'),
                    'freightType/close' => Yii::t('home', '关闭运送方式'),
                ),
            ),
            Yii::t('home', '地址库') => array(
                'value' => '/seller/storeAddress/index',
                'actions' => array(
                    'storeAddress/create' => Yii::t('home', '新增'),
                    'storeAddress/update' => Yii::t('home', '修改'),
                    'storeAddress/delete' => Yii::t('home', '删除'),
                    'storeAddress/set' => Yii::t('home', '设置默认地址'),
                ),
            ),
//            Yii::t('home', '账单明细') => array(
//                'value' => '/seller/wealth/index'
//            )
        Yii::t('home','退货管理') => array(
            'value' => '/seller/backOrder/index',
        ),
        ),
    ),
    'sellManage' => array(
        'name' => Yii::t('home', '宝贝管理'),
        'class' => 'productMana',
        'children' => array(
            Yii::t('home', '我要卖') => array(
                'value' => '/seller/goods/selectCategory',
                'actions' => array(
                    'goods/create' => Yii::t('home', '添加商品'),
                ),
            ),
            Yii::t('home', '品牌管理') => array(
                'value' => '/seller/brand/index',
                'actions' => array(
                    'brand/create' => Yii::t('home', '添加品牌'),
                    'brand/update' => Yii::t('home', '修改品牌'),
                ),
            ),
//            Yii::t('home', '设置商品销售属性') => '',
            Yii::t('home', '宝贝分类管理') => array(
                'value' => '/seller/scategory/admin',
                'actions' => array(
                    'scategory/create' => Yii::t('home', '添加'),
                    'scategory/update' => Yii::t('home', '修改'),
                ),
            ),
            Yii::t('home', '我的宝贝列表') => array(
                'value' => '/seller/goods/index',
                'actions' => array(
                    'goods/updateBase' => Yii::t('home', '修改基本信息'),
                    'goods/updateImportant' => Yii::t('home', '修改重要信息'),
                    'goods/delete' => Yii::t('home', '删除商品'),
                    'goods/adGoods' => Yii::t('home', '推荐广告商品'),
                )
            ),
        		
        		
        	/**
        	 * 未上线
        	 */
//              Yii::t('home','导入数据包')=>array(
//                  'value' => '/seller/goodsImport/index',
//              ),
        	/**
        	 * 未上线
        	 */
        		
        ),
    ),
    'shopManage' => array(
        'name' => Yii::t('home', '店铺管理'),
        'class' => 'shopMana',
        'children' => array(
            Yii::t('home', '查看店铺') => '/seller/store/view',
            Yii::t('home', '店铺装修') => array(
                'value'=>'/seller/design/main',
                'actions'=>array(
                    'design/index'=>Yii::t('home','管理首页'),
                    'design/setBg'=>Yii::t('home','设置背景'),
                    'design/setNav'=>Yii::t('home','设置网站导航'),
                    'design/setSlide'=>Yii::t('home','设置幻灯片'),
                    'design/setAdPic'=>Yii::t('home','设置图片广告'),
                    'design/setContact'=>Yii::t('home','设置在线客服'),
                    'design/goodsFilter'=>Yii::t('home','设置模板商品'),
                    'design/help'=>Yii::t('home','查看帮助'),
                    'design/changeStatus'=>Yii::t('home','修改店铺装修状态'),
                    'design/reBack'=>Yii::t('home','还原'),
                    'design/store'=>Yii::t('home','实体店管理'),
                    'design/storeInfo'=>Yii::t('home','实体店介绍'),
                    'design/storeSlide'=>Yii::t('home','实体店幻灯片展示'),
                    'design/storeContact'=>Yii::t('home','实体店联系'),
                    'design/storeMap'=>Yii::t('home','实体店地图'),
                ),
            ),
            Yii::t('home', '店铺基本设置') => '/seller/store/update',
//            Yii::t('home', '店铺文章') => '',
            Yii::t('home', '店铺文章') =>array(
            	'value' => '/seller/storeArticle/index',
            	'actions' => array(
            			'storeArticle/create' => Yii::t('home', '添加'),
            			'storeArticle/update' => Yii::t('home', '修改'),
            			'storeArticle/delete' => Yii::t('home', '删除'),
            	),
            ),
            Yii::t('home', '游戏店铺') =>array(
                'value' => '/seller/gameStore/view',
                'actions' => array(
                    'gameStore/create' => Yii::t('home', '添加'),
                    'gameStore/update' => Yii::t('home', '修改'),
                    'gameStore/delete' => Yii::t('home', '删除'),
                ),
            ),
        ),
    ),
    'cardManage' => array(
        'name' => Yii::t('home', '充值卡管理'),
        'class' => 'rechargeMana',
        'children' => array(
            Yii::t('home', '充值卡列表') =>array(
                'value'=> '/seller/prepaidCard/index',
                'actions'=>array(
                    'prepaidCard/view'=>Yii::t('home','查看详情'),
                    'prepaidCard/prepaidExport'=>Yii::t('home','导出execl'),
                    'prepaidCard/viewRechange'=>Yii::t('home','充值')
                ),
            ),
        ),
    ),
    'bizManage' => array(
        'name' => Yii::t('home', '加盟商管理'),
        'class' => 'franMana',
        'children' => array(
            Yii::t('home', '切换加盟商') => '/seller/franchisee/change',
            Yii::t('home', '查看加盟商') => array(
                'value' => '/seller/franchisee/info',
                'actions' => array(
                    'franchisee/update' => Yii::t('franchisee','修改'),
                ),
            ),
            Yii::t('home', '密码管理') => '/seller/franchisee/pwd',
            Yii::t('home', '图片空间') => '/seller/franchisee/imgList',
            Yii::t('home', '文章列表') => array(
                'value' => '/seller/franchisee/artile',
                'actions' => array(
                    'franchisee/artileAdd' => Yii::t('franchisee','添加'),
                    'franchisee/artileEdit' => Yii::t('franchisee','修改'),
                    'franchisee/artileDel' => Yii::t('franchisee','删除'),
                ),
            ),
            
            
//            Yii::t('home', '客服列表') => array(
//                'value' => '/seller/franchisee/customerList',
//                'actions' => array(
//                    'franchisee/customerCreate' => Yii::t('franchisee','添加'),
//                    'franchisee/customerUpdate' => Yii::t('franchisee','修改'),
//                    'franchisee/customerDel' => Yii::t('franchisee','删除'),
//                ),
//            ),
            Yii::t('home', '盖网机列表') => array(
                'value' => '/seller/franchisee/machineList',
                'actions' => array(
                    'franchisee/machineStop' => Yii::t('franchisee','启动'),
                    'franchisee/machineRun' => Yii::t('franchisee','禁用'),
            		'franchisee/machineConsumptionRecord' => Yii::t('franchisee','消费记录'),
                    'franchisee/machineConsumptionRecordInfo' => Yii::t('franchisee','消费记录详细'),
            		'franchisee/machineSigninRecord' => Yii::t('franchisee','签到记录'),
                    'franchisee/machineRegistrationRecord' => Yii::t('franchisee','注册记录'),
                    'franchisee/machineOrderRecord' => Yii::t('franchisee','产品交易记录'),
                ),
            ),
            
            
            Yii::t('home', '售货机列表') =>array(
            'value'=> '/seller/franchisee/vendingMachineList',
            'actions' => array(
            		'franchisee/vendingMachineStop' => Yii::t('franchisee','启动'),
                    'franchisee/vendingMachineRun' => Yii::t('franchisee','禁用'),
                    'franchisee/vendingMachineGoods' => Yii::t('franchisee','商品管理'),
                    'franchisee/vendingMachineGoodsBalances' => Yii::t('franchisee','售货机商品库存管理'),
            ),
            ),
            
        		/**
        		 * 未上线
        		 */
        		
/*          Yii::t('home', '线下商品分类管理') =>array(
            'value'=> '/seller/franchiseeGoodsCategory/admin',
            ),
            Yii::t('home', '线下商品列表') =>array(
           	 	'value'=> '/seller/franchiseeGoods/index',
            ),
            Yii::t('home', '线下订单列表') =>array(
            'value'=> '/seller/franchiseeOrder/index',
            ),
             */
            
//            Yii::t('home', '盖网通商城订单') => array(
//            	'value' => '/seller/franchisee/machineOrderList',
//            	'actions' => array(
//            		'franchisee/machineOrderDetail' => Yii::t('franchisee','订单详情'),
//            	),
//            ),

        		/**
        		 * 未上线
        		 */
        		
        ),
    ),
    'assistantManage' => array(
        'name' => Yii::t('home', '店小二管理'),
        'class' => 'bartenderMana',
        'children' => array(
            Yii::t('home', '店小二列表') => array(
                'value' => '/seller/assistant/admin',
                'actions' => array(
                    'assistant/create' => Yii::t('home', '添加'),
                    'assistant/update' => Yii::t('home', '修改'),
                    'assistant/delete' => Yii::t('home', '删除'),
                ),
            ),
            Yii::t('home', '操作日志') => '/seller/sellerLog/index',
        ),
    ),
    
		
		
	/**
	 * 未上线
	 */
		
    'middleAgentManage' => array(
            'name' => Yii::t('home', '商家居间管理'),
            'class' => 'franMana',
            'children' => array(
                    Yii::t('home', '商家列表') => '/seller/middleAgent/list',
        ),
   ),
        
       'cityShowManage' => array(
        'name' => Yii::t('home', '城市馆管理'),
        'class' => 'franMana',
        'children' => array(
            Yii::t('home', '城市馆列表') => array(
                'value' => '/seller/cityshow/list',
                'actions' => array(
                    'cityShow/create' => Yii::t('home', '添加'),
                    'cityShow/update' => Yii::t('home', '修改'),
                    'cityShow/delete' => Yii::t('home', '删除'),
                ),
            ),
        /*
            Yii::t('home', '入驻商家') => array(
                'value' => '/seller/cityShowStore/list',
                'actions' => array(
                    'cityShowStore/create' => Yii::t('home', '添加'),
                    'cityShowStore/storeUpdate' => Yii::t('home', '修改'),
                    'cityShowStore/storeDel' => Yii::t('home', '删除'),
                ),
            ),
            Yii::t('home', '城市馆主题') => array(
            'value' => '/seller/cityShowTheme/list',
            'actions' => array(
            'cityShowTheme/create' => Yii::t('home', '添加'),
            'cityShowTheme/themeUpdate' => Yii::t('home', '修改'),
            'cityShowTheme/themeDel' => Yii::t('home', '删除'),
            ),
            ),*/
        ),
    ),
		
		
);




/**
 * 所有店小二都能访问的方法，在/frontend/models/AssistantPermission.php 的 checkAssistant 设置
 * assistantManage/defaultShow
 * goods/getJson
 * goods/proStepThree
 * goods/imgRemove
 * scategory/setStatus
 * scategory/getTreeGridData
 * assistantManage/changePw
 * design/mapSelect
 * */
