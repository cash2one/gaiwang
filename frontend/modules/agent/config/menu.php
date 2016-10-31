<?php

return array(
    Yii::t('Member', '会员管理') => array(
    		'icon' => 'user.gif',
    		'children'=> array(
    			Yii::t('Member', '会员列表') => array('/agent/member/index'),
//                        Yii::t('Member', '添加个人会员') => array('/member/memberEdit'),
//                        Yii::t('Member', '申请添加企业会员') => array('/member/storeEdit'),
//                        Yii::t('Member', '申请列表') => array('/member/applyList'),
    		),
   		 ),
    Yii::t('Franchisee', '加盟商管理') => array(
    		'icon' => 'customers.gif',
    		'children'=> array(
    					Yii::t('Franchisee', '加盟商列表') => array('/agent/franchiseeAgent/admin'),
//                        Yii::t('Franchisee', '添加加盟商') => array('/franchiseeAgent/create'),
//                        Yii::t('Franchisee', '申请列表') => array('/franchiseeAgent/applyList'),
//                        Yii::t('Franchisee', '审核列表') => array('/franchiseeAgent/auditList'),
    		),
   		 ),
//   Yii::t('Product','盖网通商城') => array(
//       'icon' => 'memberproducts.jpg',
//       'children' => array(
//           Yii::t('Product','盖网通商城') => array('/agent/productAgent/index'),
//       ),
//   ),
   	Yii::t('Machine', '盖机管理') => array(
    		'icon' => 'settings.gif',
    		'children'=> array(
    			Yii::t('Machine', '盖机列表') => array('/agent/machineAgent/index'),
                        Yii::t('Machine','远程监控')=>array('/agent/machineMonitorAgent/index'),
                        Yii::t('Machine','盖机运营数据')=>array('/agent/machineAgent/operateData'),
    		),
   		 ),
   	Yii::t('Advert', '广告管理') => array(
    		'icon' => 'invoice-2.gif',
    		'children'=> array(
    			 Yii::t('Advert', '格子铺管理') => array('/agent/machineAdvertAgent/coupon'),
                         Yii::t('Advert', '首页轮播广告管理') => array('/agent/machineAdvertAgent/sign'),
    		),
   		 ),
   	Yii::t('Agent', '代理概况') => array(
    		'icon' => 'edit.gif',
    		'children'=> array(
    			Yii::t('Agent','盖网机概况') => array('/agent/gwdetail/machineDetail'),
    			Yii::t('Agent','会员数量概况') => array('/agent/gwdetail/memberCountDetail'),
    			Yii::t('Agent','代理进账明细') => array('/agent/gwdetail/accountDetail'),
    		),
   		 ),
	Yii::t('AgentMaintenance', '运维人员') => array(
		'icon' => 'user.gif',
		'children'=> array(
			Yii::t('AgentMaintenance', '运维人员列表') => array('/agent/agentMaintenance/index'),
			Yii::t('AgentMaintenance', '盘点情况') => array('/agent/machineInventory/index'),
		),
	),
	Yii::t('offlineSignStoreExtend', '电子化签约管理') => array(
		'icon' => 'user.gif',
		'children'=> array(
			Yii::t('offlineSignStoreExtend', '电子化签约申请列表') => array('/agent/offlineSignStoreExtend/admin'),
	),
),
    Yii::t('appTopicLife', '盖象APP') => array(
        'icon' => 'user.gif',
        'children'=> array(
            Yii::t('appTopicLife', '臻致生活') => array('/agent/appTopicLife/admin'),
        ),
    ),
);
