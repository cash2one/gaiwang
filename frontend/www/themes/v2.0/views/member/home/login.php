<div class="header">
    <div class="w1200">
        <div class="login-logo">
            <a href="<?php echo DOMAIN; ?>" target="_blank">
                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/temp/register_logo.jpg" alt="盖象商城" width="213" height="90">
            </a>
            <span><?php echo Yii::t('home', "欢迎登录")?></span>
        </div>
    </div>
</div>
<!-- CONTENT -->
<div class="content">
    <div class="w1200">
        <div class="pic">
            <?php if(!empty($adver)){
                ?>
                <a href="<?php echo $adver[0]['link'] ?>" target="_blank">
                    <!--  540x360  -->
                    <img src="<?php echo ATTR_DOMAIN.'/'.$adver[0]['picture']; ?>" alt="<?php echo $adver[0]['title'] ?>" width="540" height="360">
                </a>
            <?php
            }else{
                ?>
                <a href="#" target="_blank">
                    <!--  540x360  -->
                    <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/temp/red_paper540x360.jpg" alt="红包购物狂" width="540" height="360">
                </a>
            <?php
            } ?>


        </div>
        <div class="login-form code-box">
            <div class="lg-box">
                <div class="lg-title">
                    <span><?php echo Yii::t('home', "登录盖象商城") ?></span>
                    <!--<a href="#">立即注册<b></b></a>-->
                    <?php echo CHtml::link(Yii::t('site', Yii::t('home', "立即注册<b></b>")), array('/member/home/register')); ?>
                </div>
                <!--<div class="lg-error hide">请输入正确的用户名</div>-->
                <?php
                /** @var CActiveForm $form */
                $form = $this->beginWidget('CActiveForm', array(
                    'id' => 'home-form',
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                    'clientOptions' => array(
                        'validateOnSubmit' => true,
                        'afterValidate'=>'js:function(form, data, hasError){
                                                if(!hasError){
                                                    var value = $("#LoginForm_password").val();
                                                    verifyCode = $("#LoginForm_verifyCode").val();
                                                    if(value == \'\'){
                                                        $("#LoginForm_password_em_").text(\'密码不可为空白\').show();
                                                        return false;
                                                    }
                                                    if(value != \'\'  || verifyCode == undefined ){
                                                        $(\'.input-password\').attr(\'disabled\',true);
                                                    }
                                                     $(\'.input-password\').attr(\'disabled\',true);

                                                     $("#login").val("'.Yii::t('memberHome','正在登录…').'");
                                                     //layer.load(2);
                                                     return true;
                                                }
                                        }'
                    ),
                ));
                ?>
                    <div class="field username-field" style="margin-bottom:35px;">

                        <label for="lg-username"></label>
                        <?php
                        echo $form->textField($model, 'username', array(
                            'placeholder' => Yii::t('memberHome', '会员编号 / 用户名 /公司名称 /手机号'),
                            'onblur' => "this.value=this.value.replace(/(^\s+)|(\s+$)/g,'')",
                        ));
                        ?>
                        <?php echo $form->error($model, 'username',array('class'=>'lg-error')); ?>
                    </div>
                <span class="userNameSpan userNameSpan2">
                    <?php
                    if(!empty($users)){
                        echo CHtml::label(
                            Yii::t('memberHome', '{mobile}绑定了多个盖网编号，请选择',array('{mobile}'=>$model->username)),
                            'gai_number',array('style'=>'color:##FF0000;background:#FFFFC0;padding:2px 1px;'));
                        echo CHtml::dropDownList('gai_number','',$users,array('style'=>'width:235px;'));
                    }
                    ?>
                    <?php echo $form->error($model, 'username'); ?>
                </span>
                    <div class="field pwd-field" style="margin-bottom:25px;">

                        <label for="lg-pwd"></label>
                        <?php
                        echo $form->passwordField($model, 'password', array('class' => 'input-password', 'maxlength' => '20'));
                        ?>
                        <?php
                        echo $form->hiddenField($model, 'password', array('class' => 'input-passwords', 'maxlength' => '20'));
                        ?>
                        <?php echo $form->hiddenField($model, 'token', array('id' => 'hidden_time'))?>
                        <?php echo $form->error($model, 'password',array('class'=>'lg-error')); ?>
                    </div>

                    <!-- 验证码开始 -->
                <?php if (LoginForm::captchaRequirement()): ?>

                    <div class="code-field" style="height: 45px;">
                        <?php
                        echo $form->textField($model, 'verifyCode', array(
                            'class' => 'lg-code',
                            'placeholder' => Yii::t('memberHome', '验证码'),
                        ));
                        ?>

                        <span class="code-num">
                            <?php
                            $this->widget('CCaptcha', array(
                                'showRefreshButton' => false,
                                'clickableImage' => true,
                                'id' => 'verifyCodeImg',
                                'imageOptions' => array('alt' => Yii::t('memberHome', '点击换图'), 'title' => Yii::t('memberHome', '点击换图'),'style' => "width:100%;height:100%;")
                            ));
                            ?>
                        </span>
                        <span class="code-change">看不清？<em onclick="changeVeryfyCode()" >换一张</em></span>
                    </div>
                    <?php echo $form->error($model, 'verifyCode',array('class'=>'lg-error')); ?>
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
                   </script>
               
                <?php endif; ?>

                    <!-- 验证码结束 -->
                    <div class="field-remember">
                        <?php echo $form->checkBox($model, 'rememberMe',array('id'=>'savestate')); ?>
                        <label for="savestate"><?php echo Yii::t('memberHome', '自动登录') ?></label>
                        <?php echo CHtml::link(Yii::t('memberHome', '忘记密码'), array('/member/home/resetPassword'), array('target' => '_blank','class'=>'forget-pwd')) ?>
                    </div>
                    <div class="lg-btn">
                        <input type="submit" value="<?php echo Yii::t('memberHome', '登录') ?>" id="login"  style="cursor:pointer;"/>
                    </div>
                <?php $this->endWidget(); ?>
                <div class="lg-entry">
                    <p><?php echo Yii::t('home', "使用合作网站账号登录盖象") ?>：</p>
                    <ul class="clearfix">
                        <li>
                            <a href="<?php echo DOMAIN.'/sociallogin/qq'?>" target="_blank" class="qq" title="QQ"></a>
                        </li>
                        <li>
                            <a href="<?php echo DOMAIN.'/sociallogin/weibo'?>" target="_blank" class="weibo" title="<?php echo Yii::t('memberHome', '新浪微博') ?>"></a>
                        </li>
                        <li>
                            <a href="<?php echo DOMAIN.'/sociallogin/duimian'?>" target="_blank" class="txweibo" title="<?php echo Yii::t('memberHome', '对面登录') ?>"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
<script src="/js/jsencrypt.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    //如果验证码不正确，刷新验证码图片
   $("#LoginForm_verifyCode").blur(function(){
       setTimeout(function(){
           if($("#LoginForm_verifyCode_em_:visible").html() == "<?php echo Yii::t('home','验证码不正确.') ?>"){
                $("#verifyCodeImg").click();
           }
       },500)
   });

    $('#LoginForm_password').blur(function(){
        var value = $("#LoginForm_password").val();
        if(value == ''){
            !$(this).hasClass('disabled')
            $("#LoginForm_password_em_").css('display','').html('密码不可为空白').show();
            return ;
        }
        if ( value.length < 6 || value.length > 20){
            return false;
        }
        var token = "<?php $RsaPassword = new RsaPassword(); echo $RsaPassword->generateSalt('21');?>";
        var pubkey = "<?php echo $RsaPassword->public_key;?>";
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubkey);
        var encrypted = encrypt.encrypt(JSON.stringify({"encrypt": "yes", "password": $("#LoginForm_password").val()+token}));
        $('.input-passwords').val(encrypted);
        $('#hidden_time').val(token);
    });
</script>