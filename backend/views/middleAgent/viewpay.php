<?php
// 切换加盟商视图
$this->breadcrumbs = array(
    Yii::t('middleAgent','居间商列表') => array('middleAgent/admin'), 
    Yii::t('middleAgent', '销售额记录')
);
?>
<div class="border-info clearfix" style="font-size: 14px;font-weight:bold">
	历史累计共 
	<span style="color: red;font-size:14px;font-weight:bold"><?php echo $dataProvider->getTotalItemCount();?></span>个月，
	总销售额 
	<span style="color: red;font-size:14px;font-weight:bold">
	<?php 
		$count = 0;
//		$jf = 0;
		foreach ($dataProvider->getData() as $value) {
			$count += $value['account'];
//			$jf += Store::getJF($id,$value['months']);
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
            	'name' => Yii::t('middleAgent','月份'),
            	'value' => '$data->months==date("Ym",time())?$data->months."(统计到:".date("Y-m-d",time()-86400).")":$data->months'
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
//                'value'=> 'Store::getJF($data->store_id,$data->months)'
//            ),
            array(
            'class' => 'CButtonColumn',
            'template' => '{viewMonth}',
            'header' => Yii::t('home', '操作'),
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'viewMonth' => array(
                    'label' => Yii::t('store', '查看详情'),
                    'url' => 'Yii::app()->createUrl("middleAgent/viewMonth",array("months"=>$data->months,"store_id"=>$data->store_id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                    'visible' => "Yii::app()->user->checkAccess('MiddleAgent.viewMonth')"
                ),
            ))
    )
    ));

?>
