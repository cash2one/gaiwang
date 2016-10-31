<?php
/* @var $this MemberRegisterNumberLimitController */

$this->breadcrumbs=array(
	Yii::t('MemberRegisterNumberLimit','靓号管理'),
	Yii::t('MemberRegisterNumberLimit','注册号段管理'),
);

$form = $this->beginWidget('CActiveForm',array(
		'id'=>'Search-Form',
		'enableClientValidation'=>true,
		'clientOptions'=>array('validateOnsubmit'=>true),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		'method'=>'get'
));
?>
<div class="border-info clearfix search-form">
	<table class="searchTable">
		<tr >
		    <th class="align-right" ><?php echo Yii::t('MemberRegisterNumberLimit','开始账号')?> --</th>
		    <th class="align-right" ><?php echo Yii::t('MemberRegisterNumberLimit','结束账号')?>:</th>
		    <td><?php echo $form->TextField($model,'number_start',array('class'=>'text-input-bj  least'));?> --</td>
		    
		     
		    <td><?php echo $form->TextField($model,'number_end',array('class'=>'text-input-bj  least'));?></td>
		    
		    <td><?php echo CHtml::submitButton(Yii::t('MemberRegisterNumberLimit','搜索'),array('class'=>'reg-sub','id'=>'search-button'));?></td>
		</tr>
		
	</table>
</div>

<input id="Btn_Add" type="button" value="<?php echo Yii::t('MemberRegisterNumberLimit', '创建'); ?>" class="regm-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/MemberRegisterNumberLimit/membercreate"); ?>'" />
<?php $this->endWidget();
$this->widget('GridView', array(
		'id' => 'Region-Manage',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				array(
						'headerHtmlOptions' => array('width' => '25%'),
						'name'=>'number_start',
				),
				array(
						'headerHtmlOptions' => array('width' => '25%'),
						'name'=>'number_end',
				),
				array(
						'class' => 'CButtonColumn',
						'header' => Yii::t('MemberRegisterNumberLimit', '操作'),
						'updateButtonImageUrl' => false,
						'deleteButtonImageUrl' => false,
						'viewButtonImageUrl' => false,
						'template' => '{updateMember}{delete}',
						'buttons' => array(
								'updateMember' => array(
										'label' => Yii::t('MemberRegisterNumberLimit', '编辑'),
										'imageUrl' => false,
										'url' => 'Yii::app()->createUrl("/MemberRegisterNumberLimit/memberupdate",array("id"=>$data->id))',
								),
								'delete' => array(
										'label' => Yii::t('MemberRegisterNumberLimit', '删除'),
										'imageUrl' => false,
										'url'=>'Yii::app()->controller->createUrl("/MemberRegisterNumberLimit/delete",array("id"=>$data->id))',
										'options' => array(
												'class' => 'regm-sub-b',
										)
								),
						),
				)
		),
));
?>
