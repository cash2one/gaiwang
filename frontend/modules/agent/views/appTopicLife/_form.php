<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<!-- <link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css"> -->
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/uploadImg.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
     'id'=>'appTopicLife-form',
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
            <th><?php echo $form->label($model, 'sequence'); ?>：</th>
            <td><?php echo $form->dropDownList($model, 'sequence',array(1,2,3,4,5,6,7,8,9,10))?></td>
            <td> <?php echo $form->error($model, 'sequence'); ?></td>
        </tr>
        <tr>
        <th width="100" align="right"><?php echo $form->labelEx($model, 'topic_img'); ?></th>
        <td>
            <?php echo $form->fileField($model, 'topic_img'); ?>
            <?php echo $form->error($model, 'topic_img'); ?>
            *请上传不大于500K的图片，比例1:1
        </td>
        </tr>
        <tr>
            <th width="100" align="right"></th>
            <td>
                <?php
                if ($model->topic_img):?>
                    <a onclick="return _showBigPic(this)" href="<?php echo ATTR_DOMAIN.DS.$model->topic_img ?>"><img style="'width' => '220px', 'height' => '70px'" src="<?php echo ATTR_DOMAIN.DS.$model->topic_img ?>"></a>
                <?php endif;?>
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
            <th><?php echo $form->labelEx($model, 'profess_proof'); ?></th>
            <td>
                <?php echo $form->textField($model,'profess_proof',array('class'=> 'text-input-bj  long valid'));?>
                *多个专业证明以‘/’隔开
                <?php echo $form->error($model, 'profess_proof'); ?>
            </td>
        </tr>
        <tr>
            <th><?php echo  $form->labelEx($model, 'rele_status'); ?></th>
            <td>
                <?php echo   $form->dropDownList($model, 'rele_status', AppTopicLife::getReleStatus(),array('onChange'=>"GaiBian(this)"));?>
                <?php echo $form->error($model, 'rele_status'); ?>

            </td>
        </tr>
        <tr>
            <th width="100" align="right"><?php echo $form->labelEx($model, 'comHeadUrl'); ?></th>
            <td>
                <?php echo $form->fileField($model, 'comHeadUrl'); ?>
                <?php echo $form->error($model, 'comHeadUrl', false); ?>
                *请上传不大于500K的图片，比例1:1
            </td>
        </tr>
        <tr>
            <th width="100" align="right"></th>
            <td>
                <?php
                if ($model->comHeadUrl):?>
                    <a onclick="return _showBigPic(this)" href="<?php echo ATTR_DOMAIN.DS.$model->comHeadUrl ?>"><img style="'width' => '220px', 'height' => '70px'" src="<?php echo ATTR_DOMAIN.DS.$model->comHeadUrl ?>"></a>
                <?php endif;?>
            </td>
        </tr>
      <tr>
          <th><?php echo $form->labelEx($model, 'online_time'); ?></th>
          <td>
          <?php 
          $this->widget('comext.timepicker.timepicker', array(
          		'model' => $model,
          		'name' => 'online_time',
          		'options' => array(
          				'minDate' => date('Y-m-d'),
          		),
//           		'htmlOptions' => array(
//           				'class' => 'datefield text-input-bj middle hasDatepicker',
//           		)
          ));
              // echo $form->textField($model,'online_time',array('class'=> 'text-input-bj  long valid','placeholder'=>"2016-08-08(请输入所示日期格式)"));?>
          <?php echo $form->error($model, 'online_time'); ?>
          </td>
     </tr>
       
    </tbody>
</table>
<?php $this->renderPartial('_detail_content',array('model'=>$model,'subcontent'=>$subcontent));?>
 
 <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">

    <tr>
         <th class="odd"></th>
        <?php echo $form->hiddenField($model,'step')?>
         <td colspan="2" class="odd">
             <?php echo CHtml::submitButton(Yii::t('appTopicLife', '保存'), array('class' => 'reg-sub','id'=>'submit')); ?>
         </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<script>
    function GaiBian(obj){
        if($(obj).val() == <?php echo AppTopicLife::RELE_STATUS_YES?>) {
            var url = '<?php echo $this->createAbsoluteUrl('/agent/appTopicLife/ReleStatus') ?>';
            $.ajax({
                type: "post", async: false, dataType: "json", timeout: 5000,
                url: url,
                data: {YII_CSRF_TOKEN: '<?php echo Yii::app()->request->csrfToken ?>'},
                success: function (data) {
                    if (data.success != <?php echo AppTopicLife::RELE_STATUS_YES;?>){
                        art.dialog({icon: 'success', content: data.success, ok: true});
                        $("#AppTopicLife_rele_status").find("option[value='"+'<?php echo AppTopicLife::RELE_STATUS;?>'+"']").attr("selected",true);
                    }
                }
            });
        }
    }
</script>


          