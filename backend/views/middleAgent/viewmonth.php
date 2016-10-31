<?php
    $this->breadcrumbs = array(
        Yii::t('middleAgent','居间商列表') => array('/middleAgent/admin'),
        Yii::t('middleAgent', '下属商家列表')=>array('middleAgent/view','referrals_id'=>Store::model()->findByPk($id)->referrals_id),
        Yii::t('middleAgent','销售额记录')=> array('middleAgent/viewPay','store_id'=>$id),
//        CHtml::link(Yii::t('main', '销售额记录'), 'javascript:history.back()'),
        Yii::t('middleAgent','每月记录明细')
    )
?>

<div class="border-info clearfix" style="font-size: 14px;font-weight:bold">
	
	<span><?php echo date('Y年m月',strtotime($month))?>，</span>
	总销售额 
	<span style="color: red;font-size:14px;font-weight:bold">
	<?php 
		$count = 0;
		foreach ($dataProvider->getData() as $value) {
			$count += $value['account'];
		}
		echo $count;
	?></span>元
</div>
<?php
    $this->widget('GridView', array(
        'id' => 'member-grid',
        'dataProvider' => $dataProvider,
        'itemsCssClass' => 'tab-reg',
        'cssFile'   => false,
        'columns' => array(
            array(
            	'name' => Yii::t('middleAgent','日期'),
            	'value' => '$data->months'
        	),
            array(
                'name'=> Yii::t('middleAgent','订单数'),
                'value'=> '$data->orderCount?$data->orderCount:0'
            ),
            array(
                'name'=> Yii::t('middleAgent','销售额（元）'),
                'value'=> '$data->account?$data->account:0'
            ),
//            array(
//                'name' => Yii::t('middleAgent','返还积分'),
//                'value'=> 'Store::getJF($data->store_id,$data->months,false)'
//            ),
        )
    ));

?>

