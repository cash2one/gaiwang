<?php
//注册模板
// binbin.liao
/* @var $this HomeController */
/* @var $model Member */
/* @var $form CActiveForm */
$countVerify = $this->getSession('showCaptcha');
?>
<?php $this->renderPartial('/layouts/_redad'); ?>
<div class="title clearfix">
	<?php echo CHtml::link('普通用户注册',Yii::app()->createAbsoluteUrl('/member/home/register'),array('class'=>'curr')) ?>
	<?php echo CHtml::link('企业用户注册',Yii::app()->createAbsoluteUrl('/member/home/registerEnterprise'));?>
</div>
<div class="content clearfix">
	<?php
	$form = $this->beginWidget('ActiveForm', array(
		'id' => $this->id . '-form',
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
            'afterValidateAttribute'=>'js:function(form, attribute, data, hasError){
                if(data.Member_mobileVerifyCode=="error"){
                    $(".verifyCode").show();
                    $("#home-form #Member_mobileVerifyCode_em_").hide();
                }

            }',
		),
	));
	?>
	<table cellspacing="0" cellpadding="0" border="0" width="450" class="reg_t fl">
		<tbody><tr>
			<th><span class="red">*</span><?php echo $form->label($model, 'mobile'); ?>：</th>
			<td>
				<?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt error')); ?>
				<?php echo $form->error($model, 'mobile'); ?>
			</td>
		</tr>

		<tr style="<?php echo $countVerify==3?'':'display:none'; ?>" class="verifyCode">
			<th><?php echo $form->labelEx($model, 'verifyCode'); ?>：</th>
			<td>
				<?php echo $form->textField($model, 'verifyCode', array('class' => 'inputtxt codeInputtxt')); ?>&nbsp;
				<a href="javascript::void();" class="changeCode" style="cursor: pointer">
					<?php
					$this->widget('CCaptcha', array(
						'showRefreshButton' => false,
						'clickableImage' => true,
						'id' => 'verifyCodeImg',
						'captchaAction'=>'captcha2',
						'imageOptions' => array(
							'alt' => Yii::t('memberHome', '点击换图'),
							'title' => Yii::t('memberHome', '点击换图'),
						)
					));
					?>
				</a>
				<?php echo $form->error($model, 'verifyCode'); ?>

			</td>
		</tr>

		<tr>
			<th><span class="red">*</span><?php echo $form->label($model, 'mobileVerifyCode'); ?>：</th>
			<td>
				<?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'inputtxt verInputtxt')); ?> &nbsp;<a class="btnMobCode" href="#" id="sendMobileCode"><span data-status="1">获取验证码</span></a>
				<?php echo $form->error($model, 'mobileVerifyCode'); ?>
			</td>
		</tr>
		<tr>
			<th><span class="red">*</span> <?php echo $form->label($model, 'password'); ?>：</th>
			<td>
				<div class="pwd_c2">
					<?php echo $form->passwordField($model, 'password', array('class' => 'inputtxt passInputtxt showPwd1')); ?>
					<a id="passSwitch" class="passOn passOff passOff3" href="javascript:;"></a>
				</div>
				<?php echo $form->error($model, 'password'); ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form->label($model, 'tmp_referrals_id'); ?>：</th>
			<td>
				<?php if($this->getParam('code')): ?>
                    <?php $code = Tool::lowEncrypt(rawurldecode($this->getParam('code')),'DECODE') ?>
					<?php echo  $code ?>
					<?php echo $form->hiddenField($model,'tmp_referrals_id',array('value'=>$code)) ?>
                    <?php echo CHtml::hiddenField('is_invite',Tool::authcode('yes'))?>
				<?php else: ?>
					<?php echo $form->textField($model, 'tmp_referrals_id',array('class' => 'inputtxt')); ?>
					<?php echo $form->error($model, 'tmp_referrals_id'); ?>
				<?php endif; ?>
			</td>
		</tr>
		<tr class="ta_c" >
			<td colspan="2">
				<?php echo CHtml::link(Yii::t('memberHome', '《盖象商城用户入驻协议》'), $this->createUrl('/help/article/agreement'), array('target' => '_blank','class'=>'agreement')); ?>
			</td>
		</tr>
        <tr>
            <th>&nbsp;</th>
            <td class="do">
                <?php echo CHtml::submitButton(Yii::t('memberHome','同意协议并注册'), array('type'=>'submit','name'=>'yt0','value'=>'同意协议并注册','class'=>'regBtn'))?>
            </td>
        </tr>
		</tbody>
	</table>
	<?php $this->endWidget(); ?>
	<!-- 用户名快速注册 -->
	<?php $this->renderPartial('_quickregister') ?>


	<?php $this->renderPartial('_kefu') ?>
</div>

<?php $this->renderPartial('_weixin') ?>
</div>

<?php  $this->renderPartial('_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function(){
        //会员注册短信发送
       sendMobileCode('#sendMobileCode','#home-form #Member_mobile',function(){
           var attr = $('.verifyCode').css('display');
            if(attr =='none'){
                return true;
            }
           //验证码检查
           var hash = jQuery('body').data('captcha2.hash');
           if (hash == null)
           <?php
             $captcha = Yii::app()->getController()->createAction("captcha2");
             $code = $captcha->verifyCode;
             $hash=$captcha->generateValidationHash(strtolower($code));
            ?>
               hash = <?php echo $hash ?>;
           else
               hash = hash[1];
           var value = $("#Member_verifyCode").val();
           for(var i=value.length-1, h=0; i >= 0; --i) h+=value.toLowerCase().charCodeAt(i);
           if(h != hash) {
               if(value.length>0){
                   //刷新验证码
                   jQuery.ajax({
                       url: "<?php echo Yii::app()->createAbsoluteUrl('/member/home/captcha2/refresh/1') ?>",
                       dataType: 'json',
                       cache: false,
                       success: function(data) {
                           jQuery('#verifyCodeImg').attr('src', data['url']);
                           jQuery('body').data('captcha2.hash', [data['hash1'], data['hash2']]);
                       }
                   });
               }
               $("#Member_verifyCode").focus();
               $("#Member_mobile").focus();
               $("#Member_verifyCode").focus();
               $('#sendMobileCode').find('span').attr('data-status', '1').html("<?php echo Yii::t('memberHome', '获取验证码'); ?>");
               return false;
           }
           return true;
       });
    });
</script>
<script>
    //点击显示密码
    $(function(){
        // 先取得 #password1 及產生一個文字輸入框
        var $password = $('.showPwd1');
        var $passwordInput = $('<input type="text" name="' + $password.attr('name') + '" class="' + $password.attr('class') + '" />');
        $('#passSwitch').toggle(
            // 用 $passwordInput 來取代 $password
            // 並把 $passwordInput 的值設為 $password 的值
            function(){
                $password.replaceWith($passwordInput.val($password.val()));
               $('#passSwitch').removeClass('passOff');
            },
            // 用 $password 來取代 $passwordInput
            // 並把 $password 的值設為 $passwordInput 的值
            function(){
                $passwordInput.replaceWith($password.val($passwordInput.val()));
               $('#passSwitch').addClass('passOff');
            }
        );
    });
</script>