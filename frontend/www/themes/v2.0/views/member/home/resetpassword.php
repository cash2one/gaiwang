<div class="pages-header">
    <div class="w1200">
        <div class="pages-logo"><a href="<?php echo DOMAIN; ?>"><img src="<?php echo DOMAIN.Yii::app()->theme->baseUrl; ?>/images/temp/register_logo.jpg" width="213" height="86" /></a></div>
        <div class="pages-title icon-cart"><?php echo Yii::t('site', '找回密码')?></div>
        <div class="pages-top">
            <?php echo CHtml::link(Yii::t('site','注册'),array('/member/home/register'),array('id'=>'register_')); ?>|
            <?php echo CHtml::link(Yii::t('site','登录'),array('/member/home/login'),array('id'=>'login_')); ?>
        </div>
    </div>
</div>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'beforeValidate' =>"js:function(form){
             $('#Member_password').attr('disabled',true);
             $('#Member_confirmPassword').attr('disabled',true);
             return true;
             }",
        'afterValidate' =>"js:function(form, data, hasError){

             if($(\"#Member_password\").val() != $(\"#Member_confirmPassword\").val()){
                $('#Member_password').attr('disabled',false);
                $('#Member_confirmPassword').attr('disabled',false);
                $(\"#Member_confirmPassword_em_\").css('display','').html('两次输入密码不一致');
                return false;
             }
              return true;
             }",
        'beforeValidateAttribute'=>"js:function(form, attribute){
             $('#Member_password').attr('disabled',true);
             $('#Member_confirmPassword').attr('disabled',true);
             return true;
             }",
        'afterValidateAttribute' => "js:function(form,data,hasError){
            $('#Member_password').attr('disabled',false);
            $('#Member_confirmPassword').attr('disabled',false);
            if($(\"#Member_confirmPassword\").val() != '' && $(\"#Member_password\").val() != $(\"#Member_confirmPassword\").val()){
                $(\"#Member_confirmPassword_em_\").css('display','').html('两次输入密码不一致');
                return false;
             }
        }"
    ),
));
CHtml::$errorContainerTag = 'span';
if (!$model->id) {
?>


<div class="main w1200">
    <div class="status status05"></div>
    <div class="forgotPassword">
        <div class="title"><?php echo Yii::t('home', "请输入您需要找回登录密码的帐号") ?>：</div>

            <p><span><i>*</i> <?php echo Yii::t('memberHome', '帐号') ?>:</span>

                <?php echo $form->textField($model, 'username', array(
                    'class' => 'input-name',
                    'id' => 'username',
                    'placeholder' => Yii::t('memberHome', '请输入您的已验证手机/盖网编号/用户名'),
                )); ?>
                <?php if(!$users) echo $form->error($model, 'username',array('class'=>"new-message")) ?>
            </p>

            <span class="userNameSpan userNameSpan2 userNameSpan3">
                    <?php
                    if(!empty($users)){
                        echo CHtml::label(
                            Yii::t('memberHome', '{mobile}绑定了多个盖网编号，请选择',array('{mobile}'=>$model->username)),
                            'gai_number',array('style'=>'color:##FF0000;background:#FFFFC0;padding:2px 1px;'));
                        echo CHtml::dropDownList('Member[gai_number]','',$users);
                    }
                    ?>
                </span>
            <p><span><i>*</i> <?php echo Yii::t('memberHome', '验证码'); ?>:</span>

                <?php echo $form->textField($model, 'verifyCode', array('class' => 'input-code'));?>
                <span class="picture">
                    <?php
                    $this->widget('CCaptcha', array(
                        'showRefreshButton' => false,
                        'clickableImage' => true,
                        'id' => 'verifyCodeImg',
                        'imageOptions' => array('alt' => Yii::t('memberHome', '点击换图'), 'title' => Yii::t('memberHome', '点击换图'), 'style' => "width:100%;height:100%;")
                    ));
                    ?>
                </span>
                <a onclick="changeVeryfyCode()"><?php echo Yii::t('memberHome', '看不清？') ?><span class="code-change"><em><?php echo Yii::t('memberHome', '换一张') ?></em></span></a>
                <?php echo $form->error($model, 'verifyCode',array('class'=>"new-message")); ?>
            </p>
            <p><span>&nbsp;</span>
                <input type="submit" value="<?php echo Yii::t('memberHome', '下一步') ?>" name="yt0" class="btn-dete"/></p>
    </div>
        <?php
        }else{
        ?>

            <div class="main w1200">
                <div class="status status04"></div>
                <div class="setPassword">
                    <div class="title"><?php echo Yii::t('memberHome', '请设置您的新密码'); ?>：</div>
                    <div class="setDate">
                        <p><span><?php echo $form->label($model, 'gai_number'); ?></span><?php echo $model->gai_number ?></p>
                        <p><span><?php echo $form->label($model, 'mobile'); ?></span><?php echo $model->mobile ?></p>
                        <input type="hidden" value="<?php echo $model->mobile ?>" name="Member[mobile]" />
                    </div>
                    <div class="newPassword">
                        <p><span><i>*</i> <?php echo Yii::t('memberHome', '手机验证码'); ?></span>
                            <?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'input-phone')); ?>
                            <input data-status="1" id="sendMobileCode" name="" type="button" class="btn-send" value="获取验证码" />
                            <span id="secondId" class="picture" style="display: none" >0</span>
                            <?php echo $form->error($model, 'mobileVerifyCode',array('class'=>"new-message error")) ?>
                            </p>
                        <span id="infoId" style="width: 300px;margin-left:125px"></span>
                        <p><span><i>*</i> <?php echo Yii::t('memberHome', '新密码'); ?></span>
                            <?php echo $form->passwordField($model, 'password', array('class' => 'input-password', 'maxlength' => '20')); ?>
                            <?php echo $form->hiddenField($model, 'token', array('id' => 'hidden_time'))?>
                            <?php echo $form->hiddenField($model, 'password', array('id' => 'hidden_password1'))?>
                            <?php echo $form->error($model, 'password',array('class'=>"new-message error")) ?>
                        </p>
                        <p><span><i>*</i> <?php echo Yii::t('memberHome', '确认密码'); ?></span>
                            <?php echo $form->passwordField($model, 'confirmPassword', array('class' => 'input-passwords', 'maxlength' => '20')); ?>
                            <?php echo $form->hiddenField($model, 'confirmPassword', array('id' => 'hidden_password2'))?>
                            <?php echo $form->error($model, 'confirmPassword',array('class'=>"new-message error")) ?>
                            <?php echo $form->hiddenField($model,'id',array('value'=>Tool::authcode($model->id))) ?>
                            <?php echo $form->hiddenField($model,'',array('value'=>$model->mobile,'id'=>'Member_mobile')) ?>
                        </p>
                        <p><span>&nbsp;</span>
                            <?php echo CHtml::submitButton(Yii::t('memberHome','确 定'), array('type'=>'submit','name'=>'yt0','value'=>'确 定','class'=>'btn-dete'))?>
                        </p>
                    </div>
                </div>
            </div>

        <?php } ?>
    <?php $this->endWidget(); ?>
</div>

<?php if ($model->id) { ?>
    <?php echo $this->renderPartial('_resetPasswordSendMobileCodeJs'); ?>
    <script src="/js/jsencrypt.js" type="text/javascript" charset="utf-8"></script>
<script>
    $("#Member_password,#Member_confirmPassword").bind("blur", function() {
        var value = $(this).val();
        if (value == '' || value.length < 6 || (value.indexOf(" ") >=0)){
            return false;
        }
        newValue = generatePassword(value);
        if ($(this).hasClass('input-password')){
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

    $(function(){
        /* $("form").submit( function () {
         $("#Member_mobileVerifyCode_info").css('display','none').html('');
         $("#password_info").css('display','none').html('');
         $("#confirmPassword_info").css('display','none').html('');
         var  Member_password = $("#Member_password").val();
         var Member_confirmPassword = $("#Member_confirmPassword").val();
         var Member_mobileVerifyCode = $("#Member_mobileVerifyCode").val()
         if(Member_mobileVerifyCode.length < 1){
         $("#Member_mobileVerifyCode_info").css('display','').html('验证码不能为空');
         return false;
         }
         if(Member_password.length < 1){
         $("#password_info").css('display','').html('新密码不能为空');
         return false;
         }
         if(Member_password.length < 6){
         $("#password_info").css('display','').html('新密码至少是六位数');
         return false;
         }
         $("#password_info").html('');
         if(Member_confirmPassword.length < 1){
         return false;
         }
         if(Member_password != Member_confirmPassword){
         $("#confirmPassword_info").css('display','').html('新密码与确认密码不一致！');
         return false;
         }
         return true;

         } );*/

        sendMobileCode("#sendMobileCode", "#Member_mobile" ,"#infoId");
    })
    </script>
<?php }else{ ?>
<script>
    //点击旁边的刷选验证码
    function changeVeryfyCode() {
        jQuery.ajax({
            url: "<?php echo Yii::app()->createUrl('/member/home/captcha/refresh/1') ?>",
            dataType: 'json',
            cache: false,
            success: function(data) {
                jQuery('#verifyCodeImg').attr('src', data['url']);
                jQuery('body').data('captcha.hash', [data['hash1'], data['hash2']]);
            }
        });
        return false;
    }

    $(function(){
        $("form").submit( function () {
            var username = $('#username').val();
            var verifyCode = $('#Member_verifyCode').val();

            if(username.length < 1){
                $('#username_error').css('display','');
                return false;
            }else{
                $('#username_error').css('display','none');
            }
            if(verifyCode.length < 1){
                $('#verifyCode_error').css('display','');
                return false;
            }else{
                $('#verifyCode_error').css('display','none');
            }

        } );
    })

</script>

<?php } ?>
<!-- 验证码结束 -->