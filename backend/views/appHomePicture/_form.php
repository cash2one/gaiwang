<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'appHomePicture-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('MemberPoint', '欢迎页主题 ') : Yii::t('MemberPoint', '修改主题'); ?></td>
    </tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'title'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </td>
    </tr>
      
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'image'); ?> 
        </th>
       <td class="odd">
      
            <?php echo $form->fileField($model, 'image'); ?> <span>请上传1242*2208且不大于500k的图片</span>
            <?php echo $form->error($model, 'image'); ?>
             <?php 	
               if($model->image != ''){
               	echo CHtml::image(ATTR_DOMAIN. '/' .$model->image, '', array('width' => '220px', 'height' => '70px'));
               	
               	
               }?>
        </td>
           
          </tr>
    
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'start_time'); ?>
        </th>
        <td class="even">
           <?php 
	          $model->start_time = $model->start_time == "0" ? "" : date("Y-m-d H:i:s",$model->start_time);
	          $this->widget('comext.timepicker.timepicker', array(
	          		'model' => $model,
	          		'name' => 'start_time',
	          		//'select'=>'date',
	          ));?>
          <?php echo $form->error($model, 'start_time'); ?>
        </td>
    </tr>
    <tr>
        <th style="width:120px" class="odd">
            <?php echo $form->labelEx($model, 'end_time'); ?>
        </th>
        <td class="odd">
           <?php 
	          $model->end_time = $model->end_time == "0" ? "" : date("Y-m-d H:i:s",$model->end_time);
	          $this->widget('comext.timepicker.timepicker', array(
	          		'model' => $model,
	          		'name' => 'end_time',
	          		//'select'=>'date',
	          ));?>
          <?php echo $form->error($model, 'end_time'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('AppHomePicture', '新增 ') : Yii::t('AppHomePicture', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>          
<?php $this->endWidget(); ?>