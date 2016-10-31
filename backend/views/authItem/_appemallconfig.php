<?php
$config = array(
    '盖鲜汇' => array(
    	//'新动'=>'AppTopicCar.Admin',
       // '商务小礼列表' => 'AppTopic.AdminGift',
        '盖鲜汇列表' => 'AppTopic.AdminFresh',
        '专题删除' => 'AppTopic.Delete',
        '添加主题专题' => 'AppTopic.Create',      
        '专题编辑' => 'AppTopic.Update',
    ),
	'臻致生活' => array(
		'臻致生活列表' => 'AppTopicLife.Admin',
		'审核' => 'AppTopicLife.AuditTopics',
		'查看评论' => 'AppTopicProblem.Admin',
		'修改评论' => 'AppTopicProblem.Update',
		'删除评论' => 'AppTopicProblem.Delete',
		'查看回复' => 'AppTopicProblem.ReplyPeople',
		'修改回复' => 'AppTopicProblem.UpdateReplyPeople',
	),
	'新动'=>array(
		'浏览'=>'AppTopicCar.Admin',
		'添加'=>'AppTopicCar.Create',
		'修改'=>'AppTopicCar.Update',
		'删除'=>'AppTopicCar.Delete',
		'查看评论'=>'AppTopicCarComment.Admin',
		'修改评论'=>'AppTopicCarComment.Update',
		'删除评论'=>'AppTopicCarComment.Delete',
		'查看回复'=>'AppTopicCarComment.ReplyPeople',
		'修改回复'=>'AppTopicCarComment.UpdateReplyPeople',
	),
    '仕品'=>array(
        '浏览'=>'AppTopicHouse.AdminHouse',
        '添加'=>'AppTopicHouse.Create',
        '添加图片'=>'AppTopicHouse.TitlePic',
        '修改'=>'AppTopicHouse.Update',
        '删除'=>'AppTopicHouse.Delete',
        '商品'=>'AppTopicHouse.Goods',
    ),
	'品牌馆'=>array(
		'浏览'=>'AppBrands.Admin',
		'添加'=>'AppBrands.Create',
		//'添加图片'=>'AppTopicHouse.TitlePic',
		'修改'=>'AppBrands.Update',
		'删除'=>'AppBrands.Delete',
		'商品'=>'AppBrandsGoods.Admin',
	),
);
$this->renderPartial('_input', array('config' => $config, 'rights' => $rights));
?>