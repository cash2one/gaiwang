<?php
$config = array(
    '商铺列表' => array(
        '列表' => 'Store.Admin',
        '编辑' => 'Store.Update',
        '设推荐人' => 'Store.UpdateRecommend',
    ),
    '店铺装修列表' => array(
        '列表' => 'Design.Index',
        '审核' => 'Design.ChangeStatus',
        '批量审核' => 'Design.BatchOperate'
    ),
    '商铺文章' => array(
        '列表' => 'StoreArticle.Admin',
        '编辑' => 'StoreArticle.Update'
    )
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>