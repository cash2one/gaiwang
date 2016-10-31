<div class="line container_fluid">       
    <div class="row_fluid line">
        <div class="vip_title red">
            <p class="unit fl"><?php echo $model->isNewRecord?Yii::t('AgentMaintenance', '添加运维人员'):Yii::t('AgentMaintenance', '编辑运维人员')?></p>
            <?php echo CHtml::link(Yii::t('AgentMaintenance','返回列表'),$this->createUrl('AgentMaintenance/index'),array('class'=>'fr mr10 return'))?>
        </div>     
        <div class="line table_white">
             <?php
                $form = $this->beginWidget('CActiveForm',array(
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                ));
             ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table5">
                <tr class="table1_title">
                    <td colspan="3"><div class="red"><?php echo Yii::t('AgentMaintenance','用户信息')?></div></td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($model,'user_name')?>：</td>
                    <td align="left" class="table_form_right">
                        <?php if($this->action->id == 'create'):?>
                        <?php echo $form->textField($model,'user_name',array('class'=>'input_box','size'=>40))?><p style="color:Red" class="fl">*</p>
                        <?php echo $form->error($model,'user_name')?>
                        <?php elseif($this->action->id == 'update'):?>
                        <?php echo $model->user_name;?>
                        <?php endif;?>
                    </td>
                 </tr>
              <tr>
                 <td align="right"><?php echo $form->label($model,'password')?>：</td>
                 <td align="left" class="table_form_right">
                    <?php echo $form->passwordField($model,'password',array('class'=>'input_box','size'=>40))?><p style="color:Red" class="fl">*</p>
                    <?php echo $form->error($model, 'password');?>
                 </td>
              </tr>
              <tr>
                 <td align="right"><?php echo $form->label($model,'mobile')?>：</td>
                 <td align="left" class="table_form_right">
                    <?php echo $form->textField($model,'mobile',array('class'=>'input_box','size'=>40)) ?><p style="color:Red" class="fl">*</p>
                    <?php echo $form->error($model, 'mobile');?>
                 </td>
             </tr>
           <tr>
               <td align="right"></td>
                   <td align="left" class="table_form_right">
                   <?php echo CHtml::submitButton(Yii::t('AgentMaintenance','提交'),array('class'=>'btn1 btn_large13'))?>
               </td>
           </tr>
           </table>
           <?php $this->endWidget();?>
        </div>
    </div>
 </div>