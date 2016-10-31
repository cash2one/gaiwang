<div class="line container_fluid">       
    <div class="row_fluid line">
        <div class="vip_title red">
            <p class="unit fl"><?php echo $model->isNewRecord?Yii::t('Member', '添加会员'):Yii::t('Member', '编辑会员')?></p>
            <?php echo CHtml::link(Yii::t('Member','返回列表'),$this->createUrl('Member/index'),array('class'=>'fr mr10 return'))?>
        </div>     
        <div class="line table_white">
             <?php
                $form = $this->beginWidget('CActiveForm',array(
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                ));
             ?>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table5">
                <tr class="table1_title">
                    <td colspan="3"><div class="red"><?php echo Yii::t('Member','用户信息')?></div></td>
                </tr>
                <tr>
                    <td align="right"><?php echo $form->label($model,'username')?>：</td>
                    <td align="left" class="table_form_right">
                        <?php echo $form->textField($model,'username',array('class'=>'input_box','size'=>40))?><p style="color:Red" class="fl">*</p>
                        <?php echo $form->error($model,'username')?>
                    </td>
                 </tr>
              <tr>
                 <td align="right"><?php echo $form->label($model,'mobile')?>：</td>
                 <td align="left" class="table_form_right">
                    <?php echo $form->textField($model,'mobile',array('class'=>'input_box','size'=>40))?><p style="color:Red" class="fl">*</p>
                    <?php echo $form->error($model, 'mobile');?>
                 </td>
              </tr>
              <tr>
                 <td align="right"><?php echo $form->label($model,'identity_type')?>：</td>
                 <td align="left" class="table_form_right">
                    <?php echo $form->dropDownList($model,'identity_type',MemberAgent::_getIdentityType(),array('class' => 'input_box2 mt5 dib fl',)) ?><p style="color:Red" class="fl">*</p>
                    <?php echo $form->error($model, 'identity_type');?>
                 </td>
             </tr>
             <tr>
                 <td align="right"><?php echo $form->label($model,'identity_number')?>：</td>
                 <td align="left" class="table_form_right">
                     <?php echo $form->textField($model,'identity_number',array('class'=>'input_box','size'=>40))?><p style="color:Red" class="fl">*</p> 
                     <?php echo $form->error($model, 'identity_number');?>
                 </td>
             </tr>
             <tr>
                 <td align="right"><?php echo $form->label($model,'real_name')?>：</td>
                 <td align="left" class="table_form_right">
                    <?php echo $form->textField($model,'real_name',array('class'=>'input_box','size'=>40))?><p style="color:Red" class="fl">*</p> 
                    <?php echo $form->error($model, 'real_name');?>
                 </td>
             </tr>
             <tr>
                 <td align="right"><?php echo $form->label($model,'sex')?>：</td>
                 <td align="left" class="table_form_right">
                    <?php echo $form->radioButtonList($model, 'sex', MemberAgent::_getSex(), array('separator'=>' '))?>
                    <?php echo $form->error($model, 'sex');?>
                 </td>
             </tr>
            <tr>
               <td align="right"><?php echo $form->label($model,'birthday')?>：</td>
               <td align="left" class="table_form_right">
                   <?php
                      $this->widget('comext.timepicker.timepicker', array(
                          'cssClass' => 'input_box',
                          'model' => $model,
                          'name' => 'birthday',
                          'select'=>'date',
                      	  'options'=>array(
		                      'yearRange'=>'-100y',
		                  ),
                      ));
                   ?>
                   <p style="color:Red" class="fl">*</p>
                   <?php echo $form->error($model, 'birthday');?>
               </td>
           </tr>
           <tr>
               <td align="right"></td>
                   <td align="left" class="table_form_right">
                   <?php echo CHtml::submitButton(Yii::t('Member','提交'),array('class'=>'btn1 btn_large13'))?>
               </td>
           </tr>
           </table>
           <?php $this->endWidget();?>
        </div>
    </div>
 </div>