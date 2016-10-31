<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2015/7/22
 * Time: 13:12
 */
$config = array(
    '热卖分类' => array(
        '浏览'=>'AppHotCategory.Admin',
        '添加'=>'AppHotCategory.Create',
        '修改'=>'AppHotCategory.Update',
        '删除'=>'AppHotCategory.Delete',
    ),
    '商城热卖' => array(
        '浏览'=>'AppHotGoods.Admin',
        '添加'=>'AppHotGoods.Create',
        '修改'=>'AppHotGoods.Update',
        '删除'=>'AppHotGoods.Remove',
    ),
	'热卖管理' => array(
		'浏览'=>'HosSellOrder.Index',
		'添加'=>'HosSellOrder.Create',
		'修改'=>'HosSellOrder.Update',
		'删除'=>'HosSellOrder.Delete',
		'修改状态'=>'HosSellOrder.Change',
	),
	'活动标题' => array(
		'浏览/修改'=>'AppActiveTitle.Index',
    ),
	'热搜关键字' => array(
		'浏览/修改'=>'AppHotKey.Index',
	),
	'欢迎页设置' => array(
		'浏览'=>'AppHomePicture.Admin',
		'添加'=>'AppHomePicture.Create',
		'修改'=>'AppHomePicture.Update',
		'删除'=>'AppHomePicture.Delete',
	),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>
