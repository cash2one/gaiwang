<div class="positionWrap pt10">
    <div class="position"><a href="<?php echo $this->createAbsoluteUrl('/') ?>"><?php echo Yii::t('Public','盖象商城')?></a>&nbsp;&gt;&nbsp;<a href="<?php echo $this->createAbsoluteUrl('site/index') ?>"><?php echo Yii::t('Public','盖网红包')?></a>&nbsp;&gt;&nbsp;<b><?php echo Yii::t('Public','领取红包')?></b></div>
</div>
<div class="main">
    <div class="redEnvLoginWrap">
        <div class="redEnvLogin">
            <?php
            $form = $this->beginWidget('ActiveForm', array(
                'id' => $this->id . '-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'clientOptions' => array(
                    'validateOnSubmit' => true
                ),
            ));
            ?>
            <div class="items">
                <?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt error','Placeholder'=>Yii::t('Public','请输入手机号码'))); ?>
                <?php echo $form->error($model, 'mobile'); ?>
            </div>
            <div class="items">
                <?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'inputtxt error','Placeholder'=>Yii::t('Public','请输入验证码'))); ?><a class="sendMobile" href="#" id="sendMobileCode"><span data-status="1"><?php echo Yii::t('Public','发送验证码')?></span></a>
                <?php echo $form->error($model, 'mobileVerifyCode'); ?>
            </div>
            <div class="items">
                <?php echo $form->passwordField($model, 'password', array('class' => 'inputtxt error showPwd1','Placeholder'=>Yii::t('Public','设置登录密码'))); ?><a id="passSwitch" class="passOn passOff" href="javascript:;"></a>
                <?php echo $form->error($model, 'password'); ?>
            </div>
            <div class="items itemsRecom">
            <?php if($this->getParam('code')): ?>
                <?php $code = Tool::lowEncrypt(rawurldecode($this->getParam('code')),'DECODE') ?>
                <b>推荐会员编号：</b>
                <?php echo $form->textField($model,'tmp_referrals_id',array('class' => 'inputtxt','value'=>$code,'readOnly'=>'true','Placeholder'=>Yii::t('Public','推荐会员编号:'))) ?>
            <?php else: ?>
                <b>推荐会员编号：</b>
                <?php echo $form->textField($model,'tmp_referrals_id',array('class' => 'inputtxt error')) ?>
                <?php echo $form->error($model, 'tmp_referrals_id'); ?>
            <?php endif ?>

            </div>

            <div class="items">
                <?php echo CHtml::submitButton('', array('type'=>'submit','name'=>'','value'=>'','class'=>'btnSubmit'))?>
            </div>

            <a href="<?php echo $this->createAbsoluteUrl('/member/home/login') ?>" class="hasCount"><?php echo Yii::t('Public','已经有帐户，点击登录')?></a>
            <?php $this->endWidget(); ?>
        </div>
    </div>
    <div class="redEnvLoginTips">
        <div class="w1200">
            <p><?php echo Yii::t('Public','红包说明:')?></p>
            <p><?php echo Yii::t('Public','1、每位新用户即可以领取一个价值520元的红包；')?></p>
            <p><?php echo Yii::t('Public','2、红包可以在盖象商城购物时使用；')?></p>
            <p><?php echo Yii::t('Public','3、成功领取红包后，您的账户与推荐人账户视为绑定关系；')?></p>
            <p><?php echo Yii::t('Public','4、红包最终解释权归盖网所有，如有任何疑问请咨询盖网客服。')?></p>
        </div>
    </div>
</div>
<?php  $this->renderPartial('_sendMobileCodeJs'); ?>

<script type="text/javascript">
    $(function(){
        //会员注册短信发送
        sendMobileCode('#sendMobileCode','#Member_mobile');
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
