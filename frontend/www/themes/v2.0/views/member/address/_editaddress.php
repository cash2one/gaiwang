<!--编辑收货地址-->
          <?php
		  $form = $this->beginWidget('ActiveForm', array(
			  'id' => 'address-form',
			  'enableAjaxValidation' => true,
			  'enableClientValidation' => true,
			  'clientOptions' => array(
				  'validateOnSubmit' => true, //客户端验证
			  ),
                          'htmlOptions'=>array(
                              'class'=>'address-form'
                          )
		  ));
		  ?>
            <?php CHtml::$beforeRequiredLabel="<span class='red'>*</span>";CHtml::$afterRequiredLabel="";?>
          <div class="editor-pop">
              <div class="address-bg"></div>
              <div class="address-pop-bg">
                  <p class="pop-title"><?php echo Yii::t('memberAddress', '编辑收货地址'); ?></p>
                  <div class="pop-conter">
                  <ul>
                      <li>
                          <div class="pop-left"><?php echo $form->labelEx($model, 'real_name'); ?>：</div>
                          <?php echo $form->textField($model, 'real_name', array('class' => 'input-name')); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'real_name'); ?></div>
                      </li>
                      <li>
                          <div class="pop-left"><?php echo $form->labelEx($model, 'province_id'); ?>：</div>
                          <?php
                                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                                        'prompt' => Yii::t('memberAddress', '选择省份'),
                                        'class' => 'input-province',
                                        'id' => 'Address_province_id',
                                        'ajax' => array(
                                                'type' => 'POST',
                                                'url' => $this->createAbsoluteUrl('region/updateCity'),
                                                'dataType' => 'json',
                                                'data' => array(
                                                        'province_id' => 'js:this.value',
                                                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                                ),
                                                'success' => 'function(data) {
                                        $("#Address_city_id2").html(data.dropDownCities);
                                        $("#Address_district_id2").html(data.dropDownCounties);
                                    }',
                                )));
                            ?>
                            <?php
                                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                                        'prompt' => Yii::t('memberAddress', '选择城市'),
                                        'class' => 'input-city',
                                        'id' => 'Address_city_id',
                                        'ajax' => array(
                                                'type' => 'POST',
                                                'url' => $this->createAbsoluteUrl('region/updateArea'),
                                                'update' => '#Address_district_id2',
                                                'data' => array(
                                                        'city_id' => 'js:this.value',
                                                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                                ),
                                )));
                            ?>
                            <?php
                                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                                        'prompt' => Yii::t('memberAddress', '选择区/县'),
                                        'class' => 'input-area',
                                        'id' => 'Address_district_id',
                                        'ajax' => array(
                                                'type' => 'POST',
                                                'data' => array(
                                                        'city_id' => 'js:this.value',
                                                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                                ),
                                )));
                            ?>
                            <div class="pop-message">
                                <?php echo $form->error($model, 'province_id'); ?>
                                <?php echo $form->error($model, 'city_id'); ?>
                                <?php echo $form->error($model, 'district_id'); ?>
                            </div>
                      </li>
                      <li class="pop-address">
                          <div class="pop-left"><?php echo $form->labelEx($model, 'street'); ?>：</div>
			  <?php echo $form->textArea($model, 'street', array('class' => 'input-address','maxlength'=>60)); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'street'); ?></div>
                      </li>
                      <li>
                          <div class="pop-left"><?php echo $form->labelEx($model, 'zip_code'); ?>：</div>
                          <?php echo $form->textField($model, 'zip_code', array('class' => 'input-postal')); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'zip_code'); ?></div>
                      </li>
                      <li>
                          <div class="pop-left"><?php echo $form->labelEx($model, 'mobile'); ?>：</div>
			  <?php echo $form->textField($model, 'mobile', array('class' => 'input-phone')); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'mobile'); ?></div>
                      </li>
                      <li>
                          <div class="pop-left"><?php echo $form->label($model, 'telephone'); ?>：</div>
			  <?php echo $form->textField($model, 'telephone', array('class' => 'input-tel')); ?>
                          <div class="pop-message"><?php echo $form->error($model, 'telephone'); ?></div>
                      </li>
                      <li class="pop-set"><div class="pop-left"></div><?php echo $form->checkBox($model, 'default', array('class'=>'btn-cleck')); ?><?php echo Yii::t('memberAddress', '设置为默认地址'); ?></li>
                      <li class="pop-btn"><div class="pop-left"></div><?php echo CHtml::submitButton(Yii::t('message', '保存'), array('class' => 'btn-deter')); ?>
                      <input type="button" class="btn-delete" value="<?php echo Yii::t('memberAddress', '取消'); ?>" /></li>
                    </ul>
                  </div>
              </div>
          </div>
          <script type="text/javascript">
              $('.btn-delete').on('click',function(){
                   $('.address-form').remove();
              });
          </script>
          <?php $this->endWidget(); ?>
          <!--编辑收货地址结束-->