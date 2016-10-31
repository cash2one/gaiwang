 <?php $this->widget('GridView', array(
    'id'=>'pay-result-grid',
    'dataProvider'=>$model->search(),
    'itemsCssClass' => 'tab-reg',
    'cssFile' => false,
    'columns'=>array(
        'id',
        'name',
        array(
            'name'=>'value',
            'value'=>'Tool::truncateUtf8String($data->value,20);',
        ),
    	array(
    		'name'=>'create_time',
    		'value' => '$data->create_time ? date("Y-m-d H:i:s", $data->create_time): ""'
    	),
        array(
            'class' => 'CButtonColumn',
            'template' => '{pass}',
            'viewButtonLabel' => Yii::t('paymentBatch', '查看'),
            'viewButtonImageUrl' => false,
            'buttons' => array(      
            	'pass' => array(
            		'label' => Yii::t('store', '查看'),
            		'url' => 'Yii::app()->createUrl("paymentBatch/logview",array("id"=>$data->id))',
            		'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
            		'visible' => "Yii::app()->user->checkAccess('PaymentBatch.Logview')"
            	),
            )
        ),
    ),
));