<?php
/* @var $this RegionManageController */

$this->breadcrumbs=array(
		Yii::t('RegionManage', '加盟商管理'),
		Yii::t('RegionManage', '大区配置'),
);

$form = $this->beginWidget('CActiveForm',array(
		'id'=>'RegionManage-index',
		'enableClientValidation'=>true,
		'clientOptions'=>array( 'validateOnSubmit'=>true,),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		'method'=>'get',
));
?>
<div class="border-info clearfix search-form">
<table class="searchTable">
    <tr>
		<th class="align-right"><?php echo Yii::t('RegionManage','大区名称')?>：</th>
		<td>
		<?php  echo $form->TextField($model,'name',array('class'=>'text-input-bj  least',));?>
		</td>
		<td>
		<?php echo CHtml::submitButton(Yii::t('RegionManage','搜索'),array('class'=>'reg-sub','id'=>'search_button'));?>
		</td>
   </tr>
</table>
</div>

<input id="Btn_Add" type="button" value="<?php echo Yii::t('RegionManage', '创建大区'); ?>" class="regm-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/RegionManage/createregion"); ?>'" />

<?php 
$this->endWidget();

$this->widget('GridView', array(
		'id' => 'Region-Manage',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				array(
						'headerHtmlOptions' => array('width' => '15%'),
						'name'=>'id',
				),
				array(
						'headerHtmlOptions' => array('width' => '20%'),
						'name'=>'name',
				),
				array(
						'headerHtmlOptions' => array('width' => '20%'),
						'header' => Yii::t('RegionManage', '所属会员姓名'),
						'value'=>'$data->real_name',
				),
				array(
		            'class' => 'CButtonColumn',
		            'header' => Yii::t('RegionManage', '操作'),
		            'updateButtonImageUrl' => false,
		            'deleteButtonImageUrl' => false,
					'template' => '{update}{delete}{SaveGW}',
		            'buttons' => array(
		                 'create' => array(
		                    'label' => Yii::t('machine', '编辑'),
		                    'imageUrl' => false,
		                    'url' => 'Yii::app()->createUrl("/RegionManage/create",array("id"=>$data->id))',
		                    'options' => array(
		                        'class' => 'regm-sub-b',
		                    )
		                ),
		            	 'delete' => array(
		            		'label' => Yii::t('machine', '删除'),
		            		'imageUrl' => false,
		            		'url'=>'Yii::app()->controller->createUrl("/RegionManage/delete",array("id"=>$data->id))',
		            		'options' => array(
		            				'class' => 'regm-sub-b',
		            		)
		            	), 
	            		'SaveGW' => array(
	            				'label' => Yii::t('machine', '后台账户'),
	            				'imageUrl' => false,
	            				'url'=>'Yii::app()->controller->createUrl("/RegionManage/SaveGW",array("id"=>$data->id))',
	            				'options' => array(
	            						'class' => 'regm-sub-a',
	            				)
	            		),
            ),
		        ) 
		),
));
?>

