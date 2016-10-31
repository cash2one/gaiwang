<?php
$config = array(
    '余额列表（新）'=>array(
        '列表'=>'AccountBalance.Admin',                    
    ),
      '历史余额'=>array(
        '列表'=>'AccountBalanceHistory.Admin',   
    ),
);
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>

