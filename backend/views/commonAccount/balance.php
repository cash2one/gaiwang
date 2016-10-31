<?php
$this->breadcrumbs = array(
    Yii::t('commonAccount', '代理管理'),
    Yii::t('commonAccount', '资金次账户余额'),
);
$from = $this->beginWidget('CActiveForm',array(
		'id'=>'CommonAccount-Balance',
		'enableClientValidation'=>true,
		'clientOptions'=>array( 'validateOnSubmit'=>true,),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		'method'=>'get',
));
?>
<div class="border-info clearfix search-form">
<table class="searchTable">
    <tr>
		<th class="align-right"><?php echo $from->labelex($model,'name');?>：</th>
		<td>
		<?php  echo $from->TextField($model,'name',array('class'=>'text-input-bj',));?>
		</td>
		<th class="align-right"><?php echo $from->labelex($model,'type');?>：</th>
		<td>
		<?php  echo $from->dropdownList($model,'type',array('6'=>'机动','7'=>'区域代理资金池'),array('class'=>'text-input-bj',));?>
		</td>
		<td>
		<?php echo CHtml::submitButton(Yii::t('commonAccount','搜索'),array('class'=>'reg-sub','id'=>'search_button'));?>
		</td>
		
   </tr>
</table>
</div>
<?php 
$this->endwidget();

$this->widget('GridView', array(
		'id' => 'Region-Manage',
		'dataProvider' => $model->searchBalance(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns' => array(
				array(
						'headerHtmlOptions' => array('width' => '15%'),
						'name'=>'name',
				),
				array(
						'headerHtmlOptions' => array('width' => '20%'),
						'header' => Yii::t('commonAccount', '类型'),
						'value'=>'$data->type = $data->type == "6" ? "机动" : "区域代理资金池"',
				),
//				array(
//						'headerHtmlOptions' => array('width' => '20%'),
//						'header' => Yii::t('commonAccount', '昨天余额'),
//						'value'=>'$data->yesterday_amount',
//				),
				array(
						'headerHtmlOptions' => array('width' => '20%'),
						'header' => Yii::t('commonAccount', '今天余额'),
						'value'=>'$data->today_amount',
				),
		)));
?>