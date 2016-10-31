<?php
$this->breadcrumbs=array(
		Yii::t('RsaManage', '秘钥管理'),
		Yii::t('RsaManage', '秘钥查看'),
);
$form = $this->beginWidget('CActiveForm',array(
		'id'=>'RsaManage-View',
		'enableClientValidation'=>true,
		'clientOptions'=>array( 'validateOnSubmit'=>true,),
		'htmlOptions'=>array('enctype'=>'multipart/form-data'),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
      <tr>
        <th><?php  echo $form->labelEx($model,'id');?>:</th>
        <td><?php echo $model['id'];?></td>
      </tr>
      
      <tr>
        <th><?php  echo $form->labelEx($model,'merchant_num');?>:</th>
        <td><?php echo $model['merchant_num'];?></td>
      </tr>
      
      <tr>
        <th><?php  echo $form->labelEx($model,'status');?>:</th>
        <td><?php echo $form->radioButtonList($model,'status',array('0'=>'停用','1'=>'使用'),array('separator'=>''));?></td>
      </tr>
      
      <tr>
        <th><?php  echo $form->labelEx($model,'public_key');?>:</th>
        <td><?php echo $model['public_key'];?></td>
      </tr>
      
      <tr>
        <th><?php  echo $form->labelEx($model,'private_key');?>:</th>
        <td><?php echo $model['private_key'];?></td>
      </tr>
      
      <tr>
      <th></th>
        <td ><?php echo CHtml::submitButton(Yii::t('RsaManage','保存'),array('class'=>'reg-sub','id'=>'search_button'));?></td>
      </tr>
</table>
<?php $this->endWidget();?>