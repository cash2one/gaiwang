<?php
$this->breadcrumbs = array(
	Yii::t('RegionManageRelation','加盟商管理'),
	Yii::t('RegionManageRelation','绑定后台账号')	,
);

$form = $this->beginWidget('CActiveForm',array(
	'id'=>'RegionManageRelation',	
	'enableClientValidation'=>true,
	'clientOptions'=>array( 'validateOnSubmit'=>true,),
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
	'method'=>'get',
));
?>
<div class="border-info clearfix search-form">
<table class="searchTable">
    <tr>
		<th class="align-right"><?php echo Yii::t('RegionManageRelation','会员账号')?>：</th>
		<td>
		<?php  echo $form->TextField($model,'username',array('class'=>'text-input-bj  least',));?>
		</td>
		<td>
		<?php echo CHtml::submitButton(Yii::t('RegionManageRelation','搜索'),array('class'=>'reg-sub','id'=>'search_button'));?>
		</td>
   </tr>
</table>
</div>

<input id="Btn_Add" type="button" value="<?php echo Yii::t('RegionManageRelation', '添加'); ?>" class="regm-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/RegionManage/RelationCreate",array("id"=>$id)); ?>'" />
<input id="Btn_Ruturn" type="button" value="<?php echo Yii::t('RegionManageRelation', '返回'); ?>" class="regm-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/RegionManage/Index"); ?>'" />

<?php $this->endwidget();

$this->widget('GridView', array(
		'id' => 'Region-Manage',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				array(
						'headerHtmlOptions' => array('width' => '25%'),
						'name'=>'id',
				),
				array(
						'headerHtmlOptions' => array('width' => '25%'),
						'header' => Yii::t('RegionManageRelation', '会员账号'),
						'value'=>'$data->username',
				),
				array(
						'class' => 'CButtonColumn',
						'header' => Yii::t('RegionManageRelation', '操作'),
						'updateButtonImageUrl' => false,
						'deleteButtonImageUrl' => false,
						'template' => '{delete}',
						'buttons' => array(
								'delete' => array(
										'label' => Yii::t('RegionManageRelation', '删除'),
										'imageUrl' => false,
										'url'=>'Yii::app()->controller->createUrl("/RegionManage/RelationDelete",array("id"=>$data->id))',
										'options' => array(
												'class' => 'regm-sub-b',
										)
								),
						),
				)
		),
));
?>