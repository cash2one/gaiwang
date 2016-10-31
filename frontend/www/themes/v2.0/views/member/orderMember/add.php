 <!--添加订单用户-->
          <?php
		  $form = $this->beginWidget('ActiveForm', array(
			  'id' => 'order-member-form',
			  'enableAjaxValidation' => false,
			  'enableClientValidation' => true,
			  'clientOptions' => array(
				  'validateOnSubmit' => true, //客户端验证
			  ),
		  	  'htmlOptions' => array('enctype' => 'multipart/form-data'),
		  ));
		  ?>
          <div class="address-pop">
              <!--<div class="address-bg"></div>-->
              <div class="address-pop-bg">
                  <p class="pop-title"><?php echo Yii::t('OrderMember', '新增订单用户'); ?></p>
                  <div class="pop-conter">
                  <ul>
                      <li> 
                          <div class="pop-left"><?php echo $form->labelEx($model, 'code',array('class'=>'required')); ?>：</div>
                            <?php echo $form->textField($model, 'code', array('class' => 'input-name')); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'code'); ?></div>
                      </li>     
                      <li>
                          <div class="pop-left"><?php echo $form->labelEx($model, 'real_name'); ?>：</div>
                           <?php echo $form->textField($model, 'real_name', array('class' => 'input-name')); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'real_name'); ?></div>
                      </li>
                      <li>
                          <div class="pop-left"><?php echo $form->label($model, 'sex'); ?>：</div>
			                <?php echo $form->radioButtonList($model, 'sex', orderMember::getMemberSex(), array()); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'sex'); ?></div>
                      </li>
                      <li>
                          <div class="pop-left"><?php echo $form->labelEx($model, 'identity_number'); ?>：</div>
			                <?php echo $form->textField($model, 'identity_number', array('class' => 'input-phone')); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'identity_number'); ?></div>
                      </li>
                      
                      <li>
                          <div class="pop-left"><?php echo $form->labelEx($model, 'identity_front_img'); ?>：</div>
			                <?php echo $form->fileField($model, 'identity_front_img',array('class' => 'input-phone')); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'identity_front_img'); ?></div>
                      </li>
                      
                      <li>
                          <div class="pop-left"><?php echo $form->labelEx($model, 'identity_back_img'); ?>：</div>
			                <?php echo $form->fileField($model, 'identity_back_img',array('class' => 'input-phone')); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'identity_back_img'); ?></div>
                      </li>
                      
                      <li>
                          <div class="pop-left"><?php echo $form->labelEx($model, 'mobile'); ?>：</div>
			                <?php echo $form->textField($model, 'mobile', array('class' => 'input-phone')); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'mobile'); ?></div>
                      </li>
                     <li class="pop-address">
                          <div class="pop-left"><?php echo $form->labelEx($model, 'street'); ?>：</div>
                          <?php echo $form->textArea($model, 'street', array('class' => 'input-address','maxlength'=>100)); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'street'); ?></div>
                      </li>
                      <li class="pop-btn"><div class="pop-left"></div><?php echo CHtml::submitButton(Yii::t('message', '保存'), array('class' => 'btn-deter')); ?>
                      <input  type="button" class="btn-delete" value="<?php echo Yii::t('OrderMember', '取消'); ?>" /></li>
                    </ul>
                  </div>
              </div>
          </div>
            <script type="text/javascript">
              $('.btn-delete').on('click',function(){
                   $('#order-member-form').remove();
              });
            </script>
          <?php $this->endWidget(); ?>
          <!--添加订单用户结束-->