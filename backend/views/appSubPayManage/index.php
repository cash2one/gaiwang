<?php
/* @var $this AppSubPayManageController */

$this->breadcrumbs=array(
	Yii::t('AppSubPayManage', '支付渠道设置')=> array('AppPayManage/index'),
	Yii::t('AppSubPayManage', '编辑支付渠道'),
);
$click = "function() {
    if(!confirm('是否确定改变状态?')){
        return false;
}}";
?>
<?php
$this->widget('GridView', array(
		'id' => 'AppBrands-grid',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				//'id',
				'name',
// 				array(
// 						'htmlOptions' => array('width' => '3%'),
// 						'headerHtmlOptions' => array('width' => '3%'),
// 						'class' => 'zii.widgets.grid.CCheckBoxColumn',
// 						'checkBoxHtmlOptions' => array(
// 								'name' => 'id[]',
// 						)
// 				),
				 array(
		           // 'headerHtmlOptions' => array('width' => '10%'),
		            'name'=>'status',
		            'value'=>$ManageType.' == AppPayManage:: APP_PAY_TYPE_JFANDCASH ? AppSubPayManage::getAppPayTypeStatus($data->status_jfandcash) : AppSubPayManage::getAppPayTypeStatus($data->status_cash)',
		        ),
				array(
						'name'=>'type',
						'value'=>'AppSubPayManage::getAppPayType($data->type)',
				),
				'sort',
				array(
						'class' => 'CButtonColumn',
						'header' => Yii::t('home', '操作'),
						'template' => '{update}{change}',
						'updateButtonImageUrl' => false,
						'deleteButtonImageUrl' => false,
						'buttons' => array(
								'update' => array(
									'label' => Yii::t('AppSubPayManage', '编辑'),
									'visible' => "Yii::app()->user->checkAccess('AppSubPayManage.Update')",
									'url'=>'Yii::app()->createUrl("AppSubPayManage/Update",array("id"=>$data->id,"paytype"=>'.$ManageType.'))',	
								),
								'change' => array(
										'label' => Yii::t('AppSubPayManage', "改变状态"),
										'visible' => "Yii::app()->user->checkAccess('AppSubPayManage.Change')",
										'url' => 'Yii::app()->createUrl("AppSubPayManage/Change",array("id"=>$data->id,"paytype"=>'.$ManageType.'))',
										'options' => array('class' => 'regm-sub', 'style' => 'width:83px; background: url("images/sub-fou.gif");'),
										'click'=>$click,
								),
						)
				)
		),
));

?>
