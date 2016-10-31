<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'appBrands-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('AppBrands', '添加主题 ') : Yii::t('AppBrands', '修改专题'); ?></td>
    </tr>
    <tr>
        <th >
            <?php echo $form->labelEx($model, 'title'); ?>
        </th>
        <td>
            <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </td>
    </tr>
      
     <tr>
        <th>
            <?php echo $form->labelEx($model, 'img'); ?> 
        </th>
        <td >
      
            <?php echo $form->fileField($model, 'img'); ?> <span>请上传1080*628且不大于500k的图片</span>
            <?php echo $form->error($model, 'img'); ?>
             <?php 	
               if($model->img != ''){
               	echo CHtml::image(ATTR_DOMAIN. '/' .$model->img, '', array('width' => '220px', 'height' => '70px'));
               	
               	
               }?>
        </td>
           
      </tr>
    
       <tr>
          <th><?php echo  $form->labelEx($model, 'status'); ?></th>
          <td>
               <?php echo   $form->dropDownList($model, 'status', AppBrands::getPublish());?>
               <?php echo $form->error($model, 'status'); ?>
               
          </td>
        </tr>
      
    <tr>
        <th >
            <?php echo $form->labelEx($model, 'sort'); ?>
        </th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
    
    <tr>
        <th >
            <?php echo $form->labelEx($model, 'description'); ?>
        </th>
        <td >
            <?php echo $form->textArea($model, 'description', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </td>
    </tr>

    <tr>
        <th></th>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('AppBrands', '新增 ') : Yii::t('AppBrands', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>          
<?php $this->endWidget(); ?>