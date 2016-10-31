<?php

$config = array(
    '盖粉转账'=>array(
        '转账查询'=>'AccountFlowHistory.GfAdmin',
    ),
);

$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));