</div>
	</div>
	<div class="main">
    	       <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'address-form',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'clientOptions' => array(
                              'validateOnSubmit' => false,
                            ),
                    ));
                    ?>	    	
			<div class="loginForm">
				<p class="InputTitle">持卡人信息</p>
				<div class="divInput">
				    <?php echo $form->textField($model, 'accountName', array('class'=>'inputTxt','Placeholder' => '请输入持卡人姓名')); ?>
					<?php echo $form->error($model,'accountName'); ?>
				</div>
				<div class="divInput">
				<?php echo $form->textField($model, 'bankCardNo', array('class'=>'inputTxt','Placeholder' => '请输入银行卡号')); ?>
                <?php echo $form->error($model,'bankCardNo'); ?>
				</div>
				<div class="divInput">
				<?php echo $form->textField($model, 'certificateNo', array('class'=>'inputTxt','Placeholder' => '请输入身份证号码')); ?>
				<?php echo $form->error($model,'certificateNo'); ?>
				</div>
				
				<?php if($model->bankCardType=='02'):?>
				<div class="divInput">
				<?php echo $form->textField($model, 'valid', array('class'=>'inputTxt','Placeholder' => '请输入信用卡有效期')); ?>
				<?php echo $form->error($model,'valid'); ?>
				</div>
				<div class="divInput">
				<?php echo $form->textField($model, 'cvn2', array('class'=>'inputTxt','Placeholder' => '请输入信用卡背面后三位')); ?>
				<?php echo $form->error($model,'cvn2'); ?>
				</div>
				<?php endif;?>
				<?php echo $form->hiddenField($model,'certificateType',array('value'=>'ZR01'));?>
				<?php echo $form->hiddenField($model,'bankCardType',array('value'=>$model->bankCardType));?>
				<p class="InputTitle" style="padding-top:10px;border-top:1px solid #eee" >验证信息</p>
				<div class="divInput">
				<?php echo $form->textField($model, 'mobilePhone', array('class'=>'inputTxt','Placeholder' => '请输入银行预留手机号码')); ?>
                <?php echo $form->error($model,'mobilePhone'); ?>
				</div>
				<?php echo $form->hiddenField($model,'sendReqMsgId',array('value'=>Tool::buildOrderNo(16)));?>
				<div class="divInput codeCon">					
				<?php echo $form->textField($model, 'validateCode', array('class'=>'inputTxt','Placeholder' => '请输入验证码')); ?>
				<div style="cursor: pointer" class="sendCode" id="sendMobileCode">发送验证码</div>
				<?php echo $form->error($model,'validateCode'); ?>
				</div>											
			</div>
			   <?php echo CHtml::submitButton(Yii::t('message', '确认绑定'), array('class' => 'loginSub')); ?>
		<?php $this->endWidget(); ?>
    </div>	
</div>
</body>
 <script type="text/javascript">
     $("#sendMobileCode").click(function(){
         var mobile=$("#GhtForm_mobilePhone").val();
         var reqid=$("#GhtForm_sendReqMsgId").val();
         $(this).text('发送中...').attr('disabled','disabled');
         $.ajax({
             type: "POST",
             url: "<?php echo $this->createAbsoluteUrl('/m/orderConfirm/sendMobileCode') ?>",
             dataType: 'json',
             data: {
                 "YII_CSRF_TOKEN": "<?php echo Yii::app()->request->csrfToken ?>",
                 "mobile": mobile,
                 "reqid":reqid
             },
             success: function(data){
            	 index = setInterval(function(){
                     if(time < 0){ //倒计时完毕
                         $(this).removeAttr('disabled').removeAttr('style').text('再发送...');
                         clearInterval(index);
                         time = 59;
                     } else{
                         if(time<10) time = time;
                         $(this).text('发送('+time+')').css('font-size','10px');
                         time--;
                     }
                 },1000);
             }
         });
      })
   </script>

</html>