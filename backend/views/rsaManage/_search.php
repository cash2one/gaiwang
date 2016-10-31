<?php
$form = $this->beginWidget('CActiveForm',array(
		'id'=>'RsaManage-Search',
		'enableClientValidation'=>true,
		'clientOptions'=>array( 'validateOnSubmit'=>true,),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		'method'=>'get',
));

?>
<div class="border-info clearfix search-form">
<table class="searchTable">
    <tr>
		<th class="align-right"><?php echo Yii::t('RsaManage','商户号')?>：</th>
		<td>
		<?php  echo $form->TextField($model,'merchant_num',array('class'=>'text-input-bj  least',));?>
		</td>
		<td>
		<?php echo CHtml::submitButton(Yii::t('RsaManage','搜索'),array('class'=>'reg-sub','id'=>'search_button'));?>
		</td>
		<td>
		<input id="Btn_Add" type="button" value="<?php echo Yii::t('RsaManage', '创建商户号'); ?>" class="regm-sub" onclick="location.href = '<?php echo $this->createAbsoluteUrl("/RsaManage/createmerchant"); ?>'" />
		</td>
   </tr>
   
</table>
</div>


<?php $this->endWidget();?>