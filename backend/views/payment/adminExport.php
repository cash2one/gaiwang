<?php

/* @var $this PaymentController */
/* @var $model payment */
?>
<?php

$this->widget('comext.PHPExcel.EExcelView', array(
    'id' => 'prepaid-card-grid',
    'dataProvider' => $model->search(),
    'itemsCssClass' => 'tab-reg',
    'title' => '企业会员提现代付申请单',
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => Yii::t('payment', '企业会员gw号'),
            'value' => '$data->member_id',
            'type' => 'raw'
        ),
       
        array(
            'name' => Yii::t('payment', '申请提现金额'),
            'value' => '$data->amount',
            'type' => 'raw'
        ), 
        array(
            'name' => Yii::t('payment', '状态'),
            'value' => 'payment::getStatus($data->status)',
            'type' => 'raw'
        ),
        
        array(
            'name' => Yii::t('payment', '开户银行'),
            'value' => '$data->bank_name',
            'type' => 'raw'
        ),
      
        array(
            'name' => Yii::t('payment', '银行帐户名'),
            'value' => '$data->account_name',
            'type' => 'raw'
        ),
        
        array(
            'name' => Yii::t('payment', '银行卡号'),
            'value' => '" ".$data->account',
            'type' => 'raw'
        ),
        
        
    ),
));
?>