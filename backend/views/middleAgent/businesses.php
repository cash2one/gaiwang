<?php
    /**
     * 居间商直属商家页面
     */
	$this->breadcrumbs = array(
		Yii::t('store', '居间商列表') => array('middleAgent/admin'), Yii::t('store', '属下商家列表')
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
                'name'=>  Yii::t('middleAgent','当月销售额（元）'),
                'value'=> 'Store::getAcount($data->id,strtotime(date("Y-m")),mktime(0,0,0,date("m"),date("d")-1))."(".date("Y年m月").")"'
            ),
            array(
                'name'=> 'is_partner',
                'value' => 'Store::is_partner($data->is_partner)'
            ),
            array(
                'type'=>'raw',
                'name'=>  Yii::t('middleAgent','伙伴招入商家'),
                'value'=> 'CHtml::link(Store::getPartnerRef($data->member_id), array("/middle-agent/viewPartner","referrals_id"=>"$data->member_id","p_referrals"=>$data->referrals_id) ,array("class"=>"reg-sub" ))'
            ),
            array(
            'class' => 'CButtonColumn',
            'template' => '{viewStore}{viewPay}{deletePartner}{addPartner}',
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
                'deletePartner'=>array(
                    'label' => Yii::t('store', '删除合作伙伴'),
                    'url' => 'Yii::app()->createUrl("middleAgent/deletePartner",array("store_id"=>$data->id,"referrals_id"=>$data->referrals_id))',
                    'options' => array(
                        'class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");font-size:13px;',
                        'onclick'=> 'return confirm("确定删除该商家的合作伙伴关系？")'
                    ),
                    'visible' => '$data->is_partner == Store::STORE_ISMIDDLEMAN_YES and '.'Yii::app()->user->checkAccess("MiddleAgent.deletePartner")',
                ),
                'addPartner'=>array(
                    'label' => Yii::t('store', '设为合作伙伴'),
                    'url' => 'Yii::app()->createUrl("middleAgent/addPartner",array("store_id"=>$data->id,"referrals_id"=>$data->referrals_id))',
                    'options' => array(
                        'class' => 'regm-sub', 'style' => 'width:83px;background: url("images/sub-fou.gif");font-size:13px',
                        'onclick'=> 'return confirm("确定把该商家设为合作伙伴")'
                    ),
                    'visible' =>'!($data->is_partner == Store::STORE_ISMIDDLEMAN_YES) and '. 'Yii::app()->user->checkAccess("MiddleAgent.addPartner")',
                ),
            ))
        )
    ));

?>
<?php endif; ?>