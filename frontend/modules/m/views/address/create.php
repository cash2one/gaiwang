
</div>
</div>
<div class="main">
    <?php
    $goods = isset($_GET['goods']) ? $this->getQuery('goods') : '';
    $quantity = isset($_GET['quantity']) ? $this->getQuery('quantity') : '';
    ?>
       <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'address-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                              'validateOnSubmit' => true,
                            ),
                    ));
                    ?>
                    
        <?php if(Yii::app()->user->hasFlash('message') && !empty($goods) && !empty($quantity)): ?>
           <script type="text/javascript">
                 alert('<?php echo Yii::app()->user->getFlash('message'); ?>');
            </script>
        <?php endif;?>   
	    	<table class="loginForm addressForm">	
	    		<tr>
	    			<td><?php echo $form->textField($model, 'real_name', array('Placeholder' => '收货人姓名')); ?>   
	    		    <?php echo $form->error($model,'real_name'); ?>
	    		    </td>
	    		</tr>
	    		<tr>
	    			<td>
	    				<?php echo $form->textField($model, 'mobile', array('Placeholder' => '收货人手机')); ?>
	    			    <?php echo $form->error($model,'mobile'); ?>
	    			</td>
	    		</tr>
	    		<tr>
	    			<td>
	    			 
	    				<?php
                                echo $form->dropDownList($model, 'province_id', Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
                                    'prompt' => Yii::t('memberAddress', '选择省份'),
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createAbsoluteUrl('address/updateCity'),
                                        'dataType' => 'json',
                                        'data' => array(
                                            'province_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                        'success' => 'function(data) {
                                        $("#Address_city_id").html(data.dropDownCities);
                                        $("#Address_district_id").html(data.dropDownCounties);
                                    }',
                                )));
                                ?> 
                                <?php echo $form->error($model,'province_id'); ?>
	    			</td>    			
	    		</tr>
	    		<tr>
	    			<td>
	    			 <?php
                                echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
                                    'prompt' => Yii::t('memberAddress', '选择城市'),
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'url' => $this->createAbsoluteUrl('address/updateArea'),
                                        'update' => '#Address_district_id',
                                        'data' => array(
                                            'city_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                )));
                                ?>
                         <?php echo $form->error($model,'city_id'); ?>
	    			</td>
	    			
	    		</tr>
	    		<tr>
	    			<td> <?php
                                echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
                                    'prompt' => Yii::t('memberAddress', '选择区/县'),
                                    'ajax' => array(
                                        'type' => 'POST',
                                        'data' => array(
                                            'city_id' => 'js:this.value',
                                            'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                                        ),
                                )));
                                ?>
                          <?php echo $form->error($model,'district_id'); ?>
                   </td>
                  
	    		</tr>
	    		<tr>
	    			<td><?php echo $form->textField($model, 'street', array('Placeholder' => '详细街道')); ?>
	    			    <?php echo $form->error($model,'street'); ?>
	    			</td>
	    		   
	    		</tr>
	    		<tr>
	    			<td>
	    				<?php echo $form->textField($model, 'zip_code', array('Placeholder' => '邮政编码')); ?>
	    			    <?php echo $form->error($model,'zip_code'); ?>
	    			</td>
	    		</tr>
	    		<tr>
	    			<td>
	    				<span class="AFDefault" num="1">设为默认收货地址
	    				<?php echo $form->hiddenField($model, 'default'); ?>
	    				</span>
	    			</td>
	    		</tr>
	    	</table>
    	<?php echo CHtml::submitButton(Yii::t('message', '确认添加'), array('class' => 'loginSub')); ?>
      <?php $this->endWidget(); ?>
    </div>
   </div>
	<script type="text/javascript" src="<?php echo DOMAIN; ?>/js/m/member.js"></script>
  </body>
</html>

