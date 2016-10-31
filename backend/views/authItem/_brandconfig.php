<?php
$config = array(
    '商品分类管理'=>array(
        '列表'=>'Category.Admin',
        '添加'=>'Category.Create',
        '编辑'=>'Category.Update',
        '删除'=>'Category.Delete', 
        '缓存更新'=>'Category.GenerateAllCategoryCache', 
    ),
      '商品品牌管理'=>array(
        '列表'=>'Brand.Admin',
        '添加'=>'Brand.Create',  
        '编辑'=>'Brand.Update', 
        '删除'=>'Brand.Delete',   
    ),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>
