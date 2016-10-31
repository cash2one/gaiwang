<div class="main loginMain">
    <?php
    $form = $this->beginWidget('ActiveForm', array(
        'id' => $this->id . '-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="loginForm">
        <div class="divInput codeCon">
            <?php
            echo $form->textField($model, 'mobile', array(
                'class' => 'inputTxt', 'placeholder' => Yii::t('mhome', '请输入手机号码'),
            ));
            ?>
            
            <a href="#"  id="sendMobileCode">
                <div class="sendCode"><span data-status="1">发送验证码</span></div>
            </a>
            
            <?php echo $form->error($model, 'mobile'); ?>
        </div>
        <div class="divInput">
            <?php
            echo $form->textField($model, 'mobileVerifyCode', array(
                'class' => 'inputTxt',
                'placeholder' => Yii::t('mhome', '请输入验证码'),
            ));
            ?>
            <?php echo $form->error($model, 'mobileVerifyCode'); ?>
        </div>

        <div class="divInput codeCon">
            <?php echo $form->passwordField($model, 'password', array('class' => 'inputTxt bbot', 'placeholder' => Yii::t('mhome', '设置登录密码'))); ?>
            <input type="button" class="LFBut2" num="1"/>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>
    <?php echo CHtml::link(Yii::t('mhome', '《盖网通软件许可及服务协议》'), $this->createUrl('/m/home/agreement'), array('target' => '_blank', 'class' => 'rLink')); ?>
    <?php echo CHtml::submitButton(Yii::t('mhome', '同意以上协议并注册'), array('type' => 'submit', 'name' => 'yt0', 'value' => '同意以上协议并注册', 'class' => 'loginSub')) ?>
    <?php $this->endwidget(); ?>
    <input type="hidden" id="isMobileFlag" value="2">
    <input type="button" value="已经有账号，点击登录" class="loginSub"
           onclick="location.href = '<?php echo $this->createUrl('home/login'); ?>'"/>
</div>

<?php $this->renderPartial('_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function (){
        //会员注册短信发送
        sendMobileCode('#sendMobileCode', '#home-form #Member_mobile');        
    });
</script>