<?php $form=$this->beginWidget('CActiveForm', array(
     'id'=>'appTopicCar-form',
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
          <th style="width: 220px"><?php echo $form->labelEx($model, 'title'); ?></th>
          <td>
          <?php echo $form->textField($model,'title',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'title'); ?>
          </td>
        </tr>
        
        <tr>
          <th><?php echo $form->labelEx($model, 'subtitle'); ?></th>
          <td>
          <?php echo $form->textField($model,'subtitle',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'subtitle'); ?>
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
          <th><?php echo $form->labelEx($model, 'author'); ?></th>
          <td>
          <?php echo $form->textField($model,'author',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'author'); ?>
          </td>
        </tr>
                <tr>
          <th><?php echo $form->labelEx($model, 'online_time'); ?></th>
          <td>
          <?php 
          $model->online_time = $model->online_time == "0" ? "" : date("Y-m-d",$model->online_time);
          $this->widget('comext.timepicker.timepicker', array(
          		'model' => $model,
          		'name' => 'online_time',
          		'select'=>'date',
          ));
//           $this->widget('comext.timepicker.timepicker', array(
//           		'model' => $model,
//           		'name' => 'online_time',
//           		'options' => array(
//           				'minDate' => date('Y-m-d'),
//           		),
// //           		'htmlOptions' => array(
// //           				'class' => 'datefield text-input-bj middle hasDatepicker',
// //           		)
//           ));
              // echo $form->textField($model,'online_time',array('class'=> 'text-input-bj  long valid','placeholder'=>"2016-08-08(请输入所示日期格式)"));?>
          <?php echo $form->error($model, 'online_time'); ?>
          </td>
     </tr>
        
        <tr>
          <th><?php echo $form->labelEx($model, 'photographer'); ?></th>
          <td>
          <?php echo $form->textField($model,'photographer',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'photographer'); ?>
          </td>
        </tr>
        
        <tr>
          <th><?php echo  $form->labelEx($model, 'image'); ?></th>
          <td>
               <?php echo $form->fileField($model,'image');?><span>请上传1080*628且不大于500k的图片</span>
               <?php 	
               if($model->image != ''){
               	echo CHtml::image(ATTR_DOMAIN. '/' .$model->image, '', array('width' => '220px', 'height' => '70px'));
               	
               	
               }?>
               <?php echo $form->error($model, 'image'); ?></br>
               
          </td>
        </tr>
       <tr>
          <th><?php echo  $form->labelEx($model, 'status'); ?></th>
          <td>
               <?php echo   $form->dropDownList($model, 'status', AppTopicCar::getPublish());?>
               <?php echo $form->error($model, 'status'); ?>
               
          </td>
        </tr>
       <tr>
          <th><?php echo $form->labelEx($model, 'topic_goods_name'); ?></th>
          <td>
          <?php echo $form->textField($model,'topic_goods_name',array('class'=> 'text-input-bj  long valid'));?>
          <?php echo $form->error($model, 'topic_goods_name'); ?>
          </td>
        </tr>

      <tr> <td class="even"></td></tr>
        <tr><td class="even"></td></tr>
        <tr>
          <th><?php echo $form->labelEx($model, 'content'); ?></th>
          <td id="appTopicCar_content">
          <?php //echo $form->textArea($model,'content',array('class'=> 'text-input-bj  long valid'));?>
           <?php
                $this->widget('comext.wdueditor.WDueditor', array(
                    'model' => $model,
                    'attribute' => 'content',
                ));?>
                <?php echo $form->error($model, 'content'); ?><br/>
          </td>
                 <script type="text/javascript">
                    //处理输入框提示错误的问题
                    $("#appTopicCar_content").mouseout(function() {
                        var str = $("#baidu_editor_0").contents().find('body').find('p').html();
                        if (str == '<br>')
                            str = ' ';
                        $("#AppTopicCar_content").html(str);
                        $("#AppTopicCar_content").blur();

                    });
                </script>
        </tr>
        

            
    </tbody>
</table>
 <?php $this->renderPartial('_detail_content',array('model'=>$model,'subcontent'=>$subcontent));?>
 
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">

    <tr>
         <th class="odd"></th>
         <td colspan="2" class="odd">
             <?php echo CHtml::submitButton(Yii::t('appTopicCar', '保存'), array('class' => 'reg-sub','style')); ?>
         </td>
    </tr>
</table>

 
<?php $this->endWidget(); ?>


          