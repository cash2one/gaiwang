<?php
$config = array(
    'POS差异流水对账'=>array(
        '列表'=>'AccountPosRecord.Admin',
        '添加备注'=>'AccountPosRecord.Remark',
        '查看详情'=>'AccountPosRecord.Detail',
        '增补流水'=>'AccountPosRecord.Transactions',
    ),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>