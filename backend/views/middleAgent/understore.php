<?php 
	$this->breadcrumbs = array(
		Yii::t('store', '居间商列表') => array('middleAgent/admin'), Yii::t('store', '下属商家列表')
	);

    $this->renderPartial('_searchStore',array('model'=>$model));
?>
<?php if(empty($model)): ?>
<?php echo Yii::t('store','对不起！您查询的下属商家不存在'); ?>
<?php else: ?>
<?php

    $this->widget('GridView', array(
        'id' => 'member-grid',
        'dataProvider' => $model->businessStore(),
        'itemsCssClass' => 'tab-reg',
        'cssFile'   => false,
        'columns' => array(
            array(
            	'name' => Yii::t('middleAgent','会员编号'),
            	'value' => '$data->gai_number'
        	),
            array(
                'name'=> Yii::t('middleAgent','商家名称'),
                'value'=> '$data->name'
            ),
            array(
                    'name' => 'create_time',
                    'value'=> 'date("Y-m-d H:i:s",$data->create_time)'
            ),
            array(
                    'name'=> 'status',
                    'value'=> 'Store::status($data->status)'
            ),
            array(
                'name'=> 'category_id',
                'value' => '$data->categoryname'
            ),
            array(
                'name'=>Yii::t('middleAgent','当月销售额（元）'),
                'value'=> 'Store::getAcount($data->id,strtotime(date("Y-m")),strtotime("+1 month"))."(".date("Y年m月").")"'
            ),
//            array(
//                'name' => Yii::t('middleAgent', '返还积分'),
//                'value' => 'Store::getJF($data->id,date("Ym"))."(".date("Y年m月").")"'
//            ),
            array(
            'class' => 'CButtonColumn',
            'template' => '{viewStore}{viewPay}',
            'header' => Yii::t('home', '操作'),
            'updateButtonImageUrl' => false,
            'buttons' => array(
                'viewStore' => array(
                    'label' => Yii::t('store', '商家详情'),
                    'url' => 'Yii::app()->createUrl("middleAgent/viewStore",array("store_id"=>$data->id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                    'visible' => "Yii::app()->user->checkAccess('MiddleAgent.viewStore')"
                ),
                'viewPay' => array(
                    'label' => Yii::t('store', '销售额记录'),
                    'url' => 'Yii::app()->createUrl("middleAgent/viewPay",array("store_id"=>$data->id))',
                    'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
                    'visible' => 'Yii::app()->user->checkAccess("MiddleAgent.viewPay")',
                ),
            ))
        )
    ));

?>
<?php endif; ?>