<?php
$config = array(
    '友情链接列表' => array(
        '列表' => 'Link.Admin',
        '添加' => 'Link.Create',
        '编辑' => 'Link.Update',
        '删除' => 'Link.Delete'
    )
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>