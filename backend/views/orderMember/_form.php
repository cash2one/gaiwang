<?php $form=$this->beginWidget('CActiveForm', array(
     'id'=>'orderMember-form',
     'enableClientValidation' => true,
     'enableAjaxValidation'=>false,
     'clientOptions' => array(
               'validateOnSubmit' => true,
     ),
	
     'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
      <tr><td colspan="2" class="title-th even" align="center">订单用户信息添加</td></tr>
        <tr>
          <th style="width: 220px"><?php echo $form->labelEx($model, 'member_id'); ?></th>
          <td>
          <?php echo $form->textField($model,'member_id',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'member_id'); ?>
          </td>
        </tr>
        
        <tr>
          <th><?php echo $form->labelEx($model, 'code'); ?></th>
          <td>
          <?php echo $form->textField($model,'code',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'code'); ?>
          </td>
        </tr>
        
        <tr>
          <th><?php echo $form->labelEx($model, 'real_name'); ?></th>
          <td>
          <?php echo $form->textField($model,'real_name',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'real_name'); ?>
          </td>
        </tr>
        <tr>
          <th><?php echo $form->labelEx($model, 'sex'); ?></th>
		   <td>
			<?php echo $form->radioButtonList($model, 'sex', orderMember::getMemberSex(), array('separator' => '')); ?>
		   </td>
        </tr>
       <tr>
          <th><?php echo $form->labelEx($model, 'identity_number'); ?></th>
          <td>
          <?php echo $form->textField($model,'identity_number',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'identity_number'); ?>
          </td>
        </tr>
        
       <tr>
            <th><?php echo $form->labelEx($model, 'identity_front_img'); ?></th>
            <td>
                <?php echo $form->fileField($model, 'identity_front_img'); ?>
                <?php echo $form->error($model, 'identity_front_img', array(), false); ?>
                <?php if ($model->identity_front_img): ?>
                    <input type="hidden" name="oldFrontImg" value="<?php echo $model->identity_front_img; ?>" />
                    <?php echo CHtml::image(ATTR_DOMAIN . DS . $model->identity_front_img, '', array('width' => '100px', 'height' => '100px')); ?>
                <?php endif; ?>
            </td>
        </tr>
        
        <tr>
            <th><?php echo $form->labelEx($model, 'identity_back_img'); ?></th>
            <td>
                <?php echo $form->fileField($model, 'identity_back_img'); ?>
                <?php echo $form->error($model, 'identity_back_img', array(), false); ?>
                <?php if ($model->identity_back_img): ?>
                    <input type="hidden" name="oldBackImg" value="<?php echo $model->identity_back_img; ?>" />
                    <?php echo CHtml::image(ATTR_DOMAIN . DS . $model->identity_back_img, '', array('width' => '100px', 'height' => '100px')); ?>
                <?php endif; ?>
            </td>
        </tr>

         <tr>
          <th><?php echo $form->labelEx($model, 'mobile'); ?></th>
          <td>
          <?php echo $form->textField($model,'mobile',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'mobile'); ?>
          </td>
        </tr>
        
         <tr>
          <th><?php echo $form->labelEx($model, 'street'); ?></th>
          <td>
          <?php echo $form->textField($model,'street',array('size'=>'200','maxLength'=>'250','class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'street'); ?>
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


          