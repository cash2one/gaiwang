<?php
/*
$this->setSession('mytest',time());
$rsa = new RSA();
var_dump($rsa->public_key);
*/?>
<div class="wrap">
    <div class="pages-header">
        <div class="w1200">
            <div class="pages-logo"><a href="<?php echo DOMAIN ?>"><img src="<?php echo DOMAIN ?>/themes/v2.0/images/temp/register_logo.jpg" width="213" height="86" /></a></div>
            <div class="pages-title icon-cart"><?php echo Yii::t('home', '欢迎注册') ?></div>
            <div class="pages-top">
                <?php
                //搜索旁边的小广告
                $searchAds = WebAdData::getLogoData('top_search_ad');  //调用接口
                $searchAd = !empty($searchAds) && AdvertPicture::isValid($searchAds[0]['start_time'], $searchAds[0]['end_time']) ? $searchAds[0] : array();
                ?>
                <?php if (!empty($searchAd)): ?>
                    <a href="<?php echo $searchAd['link'] ?>" title="<?php echo $searchAd['title'] ?>" target="<?php echo $searchAd['target'] ?>" class="gx-top-advert2">
                        <img width="190" height="88" src="<?php echo ATTR_DOMAIN . '/' . $searchAd['picture']; ?>"/>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="main w1200">
        <div class="register-index">
            <div class="register-type clearfix">
                <div class="left">
                    <p class="on"><?php echo CHtml::link(Yii::t('home', '普通用户注册'), Yii::app()->createAbsoluteUrl('/member/home/register')); ?></p>
                    <p><?php echo CHtml::link(Yii::t('home', '企业用户注册'), Yii::app()->createAbsoluteUrl('/member/home/registerEnterprise')); ?></p>
                    <p><?php echo CHtml::link(Yii::t('home', '用户快速注册'), Yii::app()->createAbsoluteUrl('/member/home/quickRegister')); ?><span class="icon-cart"><?php echo Yii::t('home', '快') ?></span></p>
                </div>
                <div class="right">
                    <?php echo Yii::t('home', '已有帐号') ?>？ <?php echo CHtml::link(Yii::t('home', '马上登录') . '>>', Yii::app()->createAbsoluteUrl('/member/home/login')) ?>
                </div>
            </div>

            <div class="register-contents">
                <div class="register-box">
                    <div class="register-company clearfix">

                        <div class="left">
                            <?php
                            $form = $this->beginWidget('ActiveForm', array(
                                'id' => $this->id . '-form',
                                'enableAjaxValidation' => true,
                                'enableClientValidation' => true,
                                'clientOptions' => array(
                                    'validateOnSubmit' => true,
                                    'beforeValidate' =>"js:function(form){
                                        $('#Member_password').attr('disabled',true);
                                         return true;
                                     }",
                                    'afterValidate' =>"js:function(form, data, hasError){
                                        if(hasError){
                                            $('#Member_password').attr('disabled',false);
                                            return false;
                                        }
                                          return true;
                                     }",
                                    'beforeValidateAttribute'=>"js:function(form, attribute){
                                         $('#Member_password').attr('disabled',true);
                                         return true;
                                     }",
                                    'afterValidateAttribute' => "js:function(form,data,hasError){
                                        $('#Member_password').attr('disabled',false);
                                    }"
                                ),
                            ));
                            ?>
                            <table class="register-tab">
                                <tr>
                                    <td><span><i>*</i> <?php echo $form->label($model, 'mobile'); ?>:</span></td>
                                    <td>
                                        <?php echo $form->textField($model, 'mobile', array('maxlength' => '16', 'class' => 'input-name')); ?>
                                        <?php echo $form->error($model, 'mobile'); ?>
                                        <div class="phoneMessage phoneMessage2">完成验证后，您可以用该手机号登录和找回密码</div>
                                    </td>
                                </tr>
                                <tr >
                                    <td><span><i>*</i> <?php echo $form->label($model, 'verifyCode'); ?>：</span></td>
                                    <td>
                                        <?php echo $form->textField($model, 'verifyCode', array('maxlength' => '8', 'class' => 'input-code')); ?>&nbsp;
                                        <a href="javascript::void();" class="changeCode" style="cursor: pointer" id="clearCode">
                                            <?php
                                            $this->widget('CCaptcha', array(
                                                'clickableImage' => true,
                                                'id' => 'verifyCodeImg',
                                                'captchaAction' => 'captcha2',
                                                'buttonLabel' => '&nbsp看不清？换一张'
                                            ));
                                            ?>
                                               <?php echo $form->error($model, 'verifyCode'); ?>
                                        </a>
                                         
                                    </td>
                                </tr>
                                <tr>
                                    <td><span><i>*</i> <?php echo $form->label($model, 'mobileVerifyCode'); ?>：</span></td>
                                    <td>
<?php echo $form->textField($model, 'mobileVerifyCode', array('maxlength' => '8', 'class' => 'input-code')); ?>
                                        &nbsp;<a class="btn-send" href="#" id="sendMobileCode"><b data-status="1">获取验证码</b></a><?php echo $form->error($model, 'mobileVerifyCode'); ?>
                                    </td>
                                </tr>                              
                                <tr>
                                    <td><span><i>*</i> <?php echo $form->label($model, 'password'); ?>：</span></td>
                                    <td>
<?php echo $form->passwordField($model, 'password', array('class' => 'input-password', 'maxlength' => '20')); ?>
<?php echo $form->hiddenField($model, 'password', array('class' => 'input-passwords')); ?>
                                        <?php echo $form->error($model, 'password'); ?>
                                        <?php echo $form->hiddenField($model, 'token', array('id' => 'hidden_time'))?>
                                        <span class="eyea"></span><span class="eyeb on"></span>
                                        <div class="passwordMessage passwordMessage2">设置的密码不能少于6位</div>
                                    </td>
                                </tr>                             
                                <tr>
                                    <td><span><?php echo $form->label($model, 'tmp_referrals_id'); ?>：</span></td>
                                    <td>
<?php if ($this->getParam('code')): ?>
                                            <?php $code = Tool::lowEncrypt(rawurldecode($this->getParam('code')), 'DECODE') ?>
                                            <?php echo $code ?>
                                            <?php echo $form->hiddenField($model, 'tmp_referrals_id', array('value' => $code)) ?>
                                            <?php echo CHtml::hiddenField('is_invite', Tool::authcode('yes')) ?>
                                        <?php else: ?>
                                            <?php echo $form->textField($model, 'tmp_referrals_id', array('class' => 'input-member')); ?>
                                            <?php echo $form->error($model, 'tmp_referrals_id'); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <span>&nbsp;</span><?php echo CHtml::link(Yii::t('memberHome', '《盖象商城用户入驻协议》'), $this->createUrl('/help/article/agreement'), array('target' => '_blank', 'class' => 'agreement')); ?></br>
                                        <span>&nbsp;</span><?php echo CHtml::submitButton(Yii::t('memberHome', '同意协议并注册'), array('type' => 'submit', 'name' => 'yt0', 'value' => '同意协议并注册', 'class' => 'btn-dete')) ?>
                                    </td>
                                </tr>
                            </table>
<?php $this->endWidget(); ?>

                        </div>
                        <div class="right-common">
                            <div class="msg">
                                <p class="title">免手机快速注册</p>
                                <p class="txtle">暂无手机号码？选择极速注册</p>
                                <p class="link"><?php echo CHtml::link(Yii::t('home', '免手机注册'), Yii::app()->createAbsoluteUrl('/member/home/quickRegister')); ?></p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<?php $this->renderPartial('_sendMobileCodeJs'); ?>
<script src="/js/jsencrypt.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(function () {
        //会员注册短信发送
        sendMobileCode('#sendMobileCode', '#home-form #Member_mobile', '#home-form #Member_verifyCode');
        //更换验证码清空文本框
          clearCode('#clearCode','#Member_verifyCode');
      
    });
    $('#Member_password').blur(function(){
        var value = $("#Member_password").val();
        if (value == '' || value.length < 6 || value.indexOf(" ") >=0){
            return false;
        }
        var token = "<?php $RsaPassword = new RsaPassword(); echo $RsaPassword->generateSalt('21');?>";
        var pubkey = "<?php echo $RsaPassword->public_key;?>";
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubkey);
        var encrypted = encrypt.encrypt(JSON.stringify({"encrypt": "yes", "password": value+token}));

        $('.input-passwords').val(encrypted);
        $('#hidden_time').val(token);
    });
</script>



