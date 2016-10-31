<?php
$config = array(
    '积分返还卡' => array(
        '列表' => 'PrepaidCard.Index',
        '添加' => 'PrepaidCard.CreateGeneral',
        '使用记录' => 'PrepaidCard.Detail',
        '使用记录导出excel' => 'PrepaidCard.DetailExport'
    )
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>