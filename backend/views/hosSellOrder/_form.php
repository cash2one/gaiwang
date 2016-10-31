<?php
$form = $this->beginWidget('CActiveForm',array(
	'id'=>'hotSellOrder-form',
    'enableClientValidation' => true,
    'enableAjaxValidation'=>false,
	'clientOptions' => array(
			'validateOnSubmit' => true,
	),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
));?>
	<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
          <th style="width: 220px"><?php echo $form->labelEx($model, 'name'); ?></th>
          <td>
          <?php echo $form->textField($model,'name',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'name'); ?>
          </td>
        </tr>
        
        <tr>
          <th style="width: 220px"><?php echo $form->labelEx($model, 'sequence'); ?></th>
          <td>
          <?php echo $form->textField($model,'sequence',array('class'=> 'text-input-bj  long valid'));?><span>数字越小排序越前</span>
          <?php echo $form->error($model, 'sequence'); ?>
          </td>
        </tr>
        
        <tr>
          <th><?php echo $form->labelEx($model, 'type'); ?></th>
          <td>
          <?php echo $form->dropDownList($model,'type',HosSellOrder::getHotSellType(),array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'type'); ?>
          </td>
        </tr>
        
        <tr>
          <th><?php echo $form->labelEx($model, 'link'); ?></th>
          <td>
          <?php echo $form->textField($model,'link',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'link'); ?>
          </td>
        </tr>
        
        
        <tr>
          <th><?php echo  $form->labelEx($model, 'logo'); ?></th>
          <td>
               <?php echo $form->fileField($model,'logo');?><span>*请上传250*250且不大于500k的图片</span>
               <?php 	
               if($model->logo != ''){
               	echo CHtml::image(ATTR_DOMAIN. '/' .$model->logo, '', array('width' => '220px', 'height' => '70px'));
               	
               	
               }?>
               <?php echo $form->error($model, 'logo'); ?> 
               </br> 
          </td>
        </tr>
     </tr>
       
    </tbody>
    <tfoot>
    <tr>
         <th class="odd"></th>
         <td colspan="2" class="odd">
             <?php echo CHtml::submitButton(Yii::t('HosSellOrder', '保存'), array('class' => 'reg-sub','style')); ?>
         </td>
    </tr>
    </tfoot>
</table>
<?php $this->endwidget();?>