<?php
$this->breadcrumbs = array(
	Yii::t('MemberGoodNumber','靓号管理'),
	Yii::t('MemberGoodNumber','靓号管理'),	
);
$form = $this->beginWidget('CActiveForm',array(
		'id'=>'Search-Form',
		'enableClientValidation'=>true,
		'clientOptions'=>array('validateOnsubmit'=>true),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		'action'=>Yii::app()->createUrl('/MemberGoodNumber/index'),
		'method'=>'get',
));
?>
<div class="border-info clearfix search-form">
	<table class="searchTable">
		<tr >
		    <th class="align-right" ><?php echo Yii::t('MemberGoodNumber','靓号')?>:</th>
		    <td><?php echo $form->TextField($model,'number',array('class'=>'text-input-bj  least'));?></td>
		    
		    <td><?php echo CHtml::submitButton(Yii::t('MemberGoodNumber','搜索'),array('class'=>'reg-sub','id'=>'search-button'));?></td>
		</tr>
		
	</table>

<?php 
$this->endwidget();

// $form = $this->beginWidget('CActiveForm',array(
// 		'id'=>'Add-Form',
// 		'enableClientValidation'=>true,
// 		'clientOptions'=>array('validateOnsubmit'=>true),
// 		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
// 		'action'=>Yii::app()->createUrl('/MemberGoodNumber/Index',array('id'=>'2')),
// 		'method'=>'get',
// ));
?>
<!--     <table class="searchTable"> -->
<!-- 		<tr> -->
		    <th class="align-right"><?php //echo Yii::t('MemberGoodNumber','靓号类型');?></th>
		    <td><?php //echo $form->dropDownList($model,'type',array('2'=>'两位数靓号','3'=>'三位数靓号','4'=>'四位数靓号'),array('class' => 'text-input-bj'))?></td>
		     <td><?php // echo CHtml::submitButton(Yii::t('MemberGoodNumber','生成'),array('class'=>'reg-sub','id'=>'create-button'));?></td>
<!-- 		</tr> -->
<!-- 	</table> -->
<!-- </div> -->
<?php 
//$this->endwidget();

$this->widget('GridView',array(
		'id' => 'Member-Good-Number',
		'dataProvider' => $model->search(),
		'cssFile' => false,
		'itemsCssClass' => 'tab-reg',
		'columns'=>array(
			   array(
			   		'headerHtmlOptions' => array('width' => '20%'),
			   		'name' => 'number'
			   ),	
			   array(
			   		'headerHtmlOptions' => array('width' => '20%'),
			   		'name' => 'status'
			   ),
			   array(
					'headerHtmlOptions' => array('width' => '20%'),
					'name' => 'type'
			   ),
			   array(
			   		'class' => 'CButtonColumn',
			   		'header' => Yii::t('MemberGoodNumber', '操作'),
			   		'deleteButtonImageUrl' => false,
			   		'template' => '{delete}',
			   		'buttons' => array(
			   				         'delete' => array(
			   				         		       'label'=> Yii::t('MemberGoodNumber', '删除'),
			   				         		       'imageUrl' => false,
			   				         		       'url' => 'Yii::app()->createUrl("/MemberGoodNumber/Delete",array("number"=>$data->number))',
			   				         		       'options' => array(
			   				         				             'class' => 'regm-sub-b',
			   				         		                    ),
			   				                     ),
			   		            ),
			   ),
         ),
       ));
?>