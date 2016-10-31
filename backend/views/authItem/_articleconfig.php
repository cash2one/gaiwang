<?php
$config = array(
    '文章列表'=>array(
        '列表'=>'Article.Admin',
        '添加'=>'Article.Create',
        '编辑'=>'Article.Update',
        '删除'=>'Article.Delete',              
    ),
      '文章分类列表'=>array(
        '列表'=>'ArticleCategory.Admin',
        '添加'=>'ArticleCategory.Create',  
        '编辑'=>'ArticleCategory.Update', 
//        '删除'=>'ArticleCategory.Delete',   
    ),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>
