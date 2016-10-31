<?php
$config = array(
    '线下交易流水'=>array(
        '联动支付交易流水'=>'AccountOfflineTransactions.OfflineTransactions',
        '联动补增流水'=>'AccountOfflineTransactions.Supplementary',
        'APP交易记录'=>'AccountOfflineTransactions.AppConsumRecord',
    ),
    );
$this->renderPartial('_input',array('config'=>$config,'rights'=>$rights));
?>