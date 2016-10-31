<?php $form=$this->beginWidget('CActiveForm', array(
     'id'=>'appSubPayManage-form',
     'enableClientValidation' => true,
     'enableAjaxValidation'=>true,
     'clientOptions' => array(
               'validateOnSubmit' => true,
     ),
	
     'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
          <th style="width: 220px"><?php echo $form->labelEx($model, 'name'); ?></th>
          <td>
          <?php echo $form->textField($model,'name',array('class'=> 'text-input-bj  long valid','disabled'=>'disabled'));?>
          <?php echo $form->error($model, 'title'); ?>
          </td>
        </tr>
   
       <tr>
           <th style="width: 220px">是否开启：<span class="required">*</span></th>
           <td><?php 
           if($ManageType == AppPayManage::APP_PAY_TYPE_JFANDCASH) 
	          echo $form->RadioButtonList($model,'status_jfandcash',AppPayManage::getAppPayTypeStatus(), array('separator'=>'',)); 
           if($ManageType == AppPayManage::APP_PAY_TYPE_CASH)
           	  echo $form->RadioButtonList($model,'status_cash',AppPayManage::getAppPayTypeStatus(), array('separator'=>'',));  ?>
	        </td>
        </tr>
        
        <tr>
          <th style="width: 220px"><?php echo $form->labelEx($model, 'sort'); ?></th>
          <td>
          <?php echo $form->textField($model,'sort',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'sort'); ?>
          </td>
        </tr>
        
         <tr>
          <th style="width: 220px"><?php echo $form->labelEx($model, 'prompt'); ?></th>
          <td>
          <?php echo $form->textArea($model,'prompt',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'prompt'); ?>
          </td>
        </tr>
    </tbody>
</table>
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">

    <tr>
         <th class="odd"></th>
         <td colspan="2" class="odd">
             <?php echo CHtml::submitButton(Yii::t('appTopicCar', '保存'), array('class' => 'reg-sub','style')); ?>
         </td>
    </tr>
</table>

 
<?php $this->endWidget(); ?>


          