<div class="wrap">
    <div class="pages-header">
        <div class="w1200">
            <div class="pages-logo"><a href="<?php echo DOMAIN ?>"><img src="<?php echo DOMAIN?>/themes/v2.0/images/temp/register_logo.jpg" width="213" height="86" /></a></div>
            <div class="pages-title icon-cart"><?php echo Yii::t('home','欢迎注册')?></div>
            <div class="pages-top">
                <?php
                //搜索旁边的小广告
                $searchAds = WebAdData::getLogoData('top_search_ad');  //调用接口
                $searchAd = !empty($searchAds) && AdvertPicture::isValid($searchAds[0]['start_time'], $searchAds[0]['end_time']) ? $searchAds[0] : array();
                ?>
                <?php if(!empty($searchAd)): ?>
                    <a href="<?php echo $searchAd['link'] ?>" title="<?php echo $searchAd['title'] ?>" target="<?php echo $searchAd['target'] ?>" class="gx-top-advert2">
                        <img width="190" height="88" src="<?php echo ATTR_DOMAIN.'/'.$searchAd['picture']; ?>"/>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="main w1200">
        <div class="register-index">
            <div class="register-type clearfix">
                <div class="left">
                    <p><?php echo CHtml::link(Yii::t('home','普通用户注册'),Yii::app()->createAbsoluteUrl('/member/home/register'));?></p>
                    <p><?php echo CHtml::link(Yii::t('home','企业用户注册'),Yii::app()->createAbsoluteUrl('/member/home/registerEnterprise'));?></p>
                    <p class="on"><?php echo CHtml::link(Yii::t('home','用户快速注册'), Yii::app()->createAbsoluteUrl('/member/home/quickRegister'));?><span class="icon-cart"><?php echo Yii::t('home','快')?></span></p>
                </div>
                <div class="right">
                    <?php echo Yii::t('home','已有帐号')?>？ <?php echo CHtml::link(Yii::t('home','马上登录').'>>',Yii::app()->createAbsoluteUrl('/member/home/login'))?>
                </div>
            </div>

            <div class="register-contents">
                <div class="register-box">
                    <div class="register-fast">
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
                                <td><span><i>*</i> <?php echo $form->label($model, 'username'); ?>:</span></td>
                                <td>
                                    <?php echo $form->textField($model, 'username', array('class' => 'input-name')); ?>
                                    <?php echo $form->error($model, 'username'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span><i>*</i> <?php echo $form->label($model, 'password'); ?>:</span></td>
                                <td>
                                    <?php echo $form->passwordField($model, 'password',array('class'=>'input-password','maxlength' => '20')); ?>
                                    <?php echo $form->hiddenField($model, 'password',array('class'=>'input-passwords')); ?>
                                    <?php echo $form->hiddenField($model, 'token', array('id' => 'hidden_time'))?>
                                    <!--<span class="eyea icon-cart"></span><span class="eyeb icon-cart on"></span>-->
                                                                        <?php echo $form->error($model, 'password'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><span><i>*</i> <?php echo $form->label($model, 'verifyCode'); ?>:</span></td>
                                <td class="mobile_code">
                                    <?php echo $form->textField($model, 'verifyCode', array('class' => 'input-code')); ?>
                                    <a href="javascript::void();" class="changeCode" style="cursor: pointer">
                                        <span class="picture picture2">
                                        <?php
                                        $this->widget('CCaptcha', array(
                                            'showRefreshButton' => false,
                                            'clickableImage' => true,
                                            'id' => 'verifyCodeImgQuick',
                                            'captchaAction'=>'captcha',
                                            'imageOptions' => array(
                                                'alt' => Yii::t('memberHome', '点击换图'),
                                                'title' => Yii::t('memberHome', '点击换图'),
                                            )
                                        ));
                                        ?>
                                    </a>
                                    </span>看不清？<span class="another another2">换一张</span>

                                    <?php echo $form->error($model, 'verifyCode'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <span>&nbsp;</span><?php echo CHtml::link(Yii::t('memberHome', '《盖象商城用户入驻协议》'), $this->createUrl('/help/article/agreement'), array('target' => '_blank','class'=>'agreement')); ?></br>
                                    <span>&nbsp;</span>
                                    <?php echo CHtml::submitButton(Yii::t('memberHome','同意协议并注册'), array('type'=>'submit','name'=>'yt0','value'=>'同意协议并注册','class'=>'btn-dete'))?>
                                </td>
                            </tr>
                        </table>
                        <?php $this->endWidget(); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<script src="/js/jsencrypt.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('.another2').click(function(){
        $('#verifyCodeImgQuick').click();
    })
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