<div class="accounts-box accounts-box2">
    <div class="accounts-revise">
        <div class="revise-progress">
            <div class="revise-item on">
                <p class="number">1</p>
                <p class="title"><?php echo Yii::t('memberMember','验证身份')?></p>
                <span class="on"></span>
            </div>
            <div class="revise-item <?php if($step ===2 || $step ===3) echo 'on';?>">
                <p class="number">2</p>
                <p class="title"><?php echo Yii::t('memberMember','修改密码')?></p>
                <span class="<?php if($step ===2 || $step ===3) echo 'on';?>"></span>
            </div>
            <div class="revise-item <?php if($step ===3) echo 'on';?>">
                <p class="number">3</p>
                <p class="title"><?php echo Yii::t('memberMember','完成');?></p>
            </div>
        </div>
        <?php 
            $form = $this->beginWidget('ActiveForm',array(
                'id'=> $this->id . '-form',
                'enableAjaxValidation'=> true,
                'enableClientValidation'=>true,
                'clientOptions' => array(
                    'validateOnSubmit'=>true,
                    'beforeValidate' =>"js:function(form){
                         $('#Member_password3').attr('disabled',true);
                         $('#Member_confirmPassword').attr('disabled',true);
                         return true;
                     }",
                    'afterValidate' =>"js:function(form, data, hasError){
                         if($(\"#Member_password3\").val() != $(\"#Member_confirmPassword\").val()){
                             $('#Member_password3').attr('disabled',false);
                             $('#Member_confirmPassword').attr('disabled',false);
                            $(\"#Member_confirmPassword_em_\").css('display','').html('两次输入密码不一致');
                            return false;
                         }
                          return true;
                     }",
                    'beforeValidateAttribute'=>"js:function(form, attribute){
                         $('#Member_password3').attr('disabled',true);
                         $('#Member_confirmPassword').attr('disabled',true);
                         return true;
                     }",
                    'afterValidateAttribute' => "js:function(form,data,hasError){
                        $('#Member_password3').attr('disabled',false);
                        $('#Member_confirmPassword').attr('disabled',false);
                        if($(\"#Member_confirmPassword\").val() != '' && $(\"#Member_password3\").val() != $(\"#Member_confirmPassword\").val()){
                            $(\"#Member_confirmPassword_em_\").css('display','').html('两次输入密码不一致');
                            return false;
                         }
                    }"
                )
            ));
        ?>
        <?php if($step ===1):?>
        <div class="revise-box">
            <p>
                <span class="revise-left"><?php echo $form->label($model,'mobile')?>：</span>
                <span class="revise-phone"><?php echo substr_replace($model->mobile,'****',3,4) ?></span>
                <?php echo $form->hiddenField($model,'mobile',array('id'=>'Member_mobile'))?>
            </p>
            <p>
                <span class="revise-left"><?php echo $form->label($model, 'mobileVerifyCode'); ?>：</span>
                <?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'input-number')); ?>
                <input  data-status="1" type="button" class="btn-send" value="<?php echo Yii::t('memberHome', '获取验证码'); ?>" id="sendMobileCode" />
                <?php CHtml::$errorContainerTag = 'span'; echo $form->error($model,'mobileVerifyCode',array('class'=>'revise-message'))?>
            </p>
            <p><?php echo CHtml::submitButton(Yii::t('memberMember','确认'),array('class'=>'btn-deter'))?></p>
        </div>
        <?php elseif($step === 2):?>

            <div class="revise-box">
                <p>
                    <?php echo CHtml::tag('span',array('class'=>'revise-left'),Yii::t('memberMember','新密码')); ?>
                    <?php echo $form->passwordField($model,'password3',array('class'=>'input-password','value'=>'','maxlength'=>20));?>
                    <?php echo $form->hiddenField($model, 'password3', array('id' => 'hidden_password1'))?>
                    <?php echo $form->hiddenField($model, 'token', array('id' => 'hidden_time'))?>
                    <?php CHtml::$errorContainerTag = 'span'; echo $form->error($model,'password3',array('class'=>'revise-message'))?>
                </p>
                <p>
                    <?php echo CHtml::tag('span',array('class'=>'revise-left'),Yii::t('memberMember','确认新密码')); ?>
                    <?php echo $form->passwordField($model,'confirmPassword',array('class'=>'input-password','value'=>'','maxlength'=>20));?>
                    <?php echo $form->hiddenField($model, 'confirmPassword', array('id' => 'hidden_password2'))?>
                    <?php CHtml::$errorContainerTag = 'span'; echo $form->error($model,'confirmPassword',array('class'=>'revise-message')) ?>
                </p>
                <p><?php echo CHtml::submitButton(Yii::t('memberMember','确认'),array('class'=>'btn-deter'))?></p>
            </div>
        <?php elseif($step === 3):?>
            <div class="revise-box bind-success">
                <p class="revise-result"><span><i class="cover-icon cover-icon2"></i><?php echo Yii::t('memberMember','修改密码成功 ！')?></span></p>
                <p class="revise-result-btn">
                    <input type="button" class="btn-deter btn-deter2" value="返回会员首页" onclick="window.location.href='<?php echo $this->createAbsoluteUrl("/member/site/index")?>'" />
                    <input type="button" class="btn-deter btn-deter2" value="返回首页" onclick="window.location.href='<?php echo DOMAIN?>'" />
                </p>
            </div>
        <?php endif;?>
        <?php  $this->endWidget();?>
    </div>
</div>
<?php echo $this->renderPartial('/layouts/_sendMobileCodeJs'); ?>
<script src="/js/jsencrypt.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">

    $("#Member_password3,#Member_confirmPassword").bind("blur", function() {
        var value = $(this).val();
        if (value == '' || value.length < 6 || (value.indexOf(" ") >=0)){
            return false;
        }
        newValue = generatePassword(value);
        if ($(this).attr('id') == 'Member_password3'){
            $("#hidden_password1").val(newValue);
        }else {
            $("#hidden_password2").val(newValue);
        }
    });

    /*生成密钥*/
    function generatePassword(value){
        var token = "<?php $RsaPassword = new RsaPassword(); echo $RsaPassword->generateSalt('21');?>";
        var pubkey = "<?php echo $RsaPassword->public_key;?>";
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubkey);
        encrypted = encrypt.encrypt(JSON.stringify({"encrypt": "yes", "password": value+token}));
        $('#hidden_time').val(token);
        return encrypted;
    }

    $(function () {
        sendMobileCode("#sendMobileCode", "#Member_mobile");
    });
</script>