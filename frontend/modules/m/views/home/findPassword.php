<div class="main loginMain">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
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
            <a href="#" id="sendMobileCode">
                <div class="sendCode"><span data-status="1">发送验证码</span></div>
            </a>
            <?php echo $form->error($model, 'mobile'); ?>
        </div>

        <div class="divInput">
            <?php
            echo $form->textField($model, 'mobileVerifyCode', array(
                'class'=> 'inputTxt',
                'placeholder' => Yii::t('mhome', '请输入验证码'),
            ));
            ?>
            <?php echo $form->error($model, 'mobileVerifyCode'); ?>
        </div>

        <div class="divInput codeCon">
            <?php echo $form->passwordField($model, 'password', array('class' => 'inputTxt bbot', 'placeholder' => Yii::t('mhome', '设置新的登录密码'))); ?>
            <input type="button" class="LFBut2" num="1"/>
            <?php echo $form->hiddenField($model, 'id', array('value' => Tool::authcode($model->id))) ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>

    <?php echo CHtml::link(Yii::t('mhome', '《盖网通软件许可及服务协议》'), $this->createUrl('/m/home/agreement'), array('target' => '_blank', 'class' => 'rLink')); ?>
    <?php echo CHtml::submitButton(Yii::t('mhome', '完成重设登录密码'), array('type' => 'submit', 'name' => 'yt0', 'value' => '完成重设登录密码', 'class' => 'loginSub')) ?>
    <?php $this->endwidget(); ?>
</div>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <script type="text/javascript">
        alert('<?php echo $this->getFlash('success');?>');
        location.href = '<?php echo $this->createUrl('home/login');?>';
    </script>
<?php endif; ?>
<?php $this->renderPartial('_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function () {
        //会员注册短信发送
        sendMobileCode('#sendMobileCode', '#home-form #Member_mobile');
    });
</script>

