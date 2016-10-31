<div class="main loginMain">
    <?php
    /** @var CActiveForm $form */
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'home-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
    ));
    ?>
    <div class="loginForm">
        <div class="divInput">
        <?php if (empty($users)):?>
            <?php
            echo $form->textField($model, 'username', array(
                'class' => 'inputTxt',
                'placeholder' => Yii::t('mhome', 'GW号/手机号'),
            ));?>
            <?php echo $form->error($model, 'username'); ?>
        </div>
      <?php endif;?>
        <?php if (!empty($users)):?>
        <div class="divInput">
        <?php 
           echo CHtml::label(Yii::t('memberHome', '{mobile}绑定了多个GW号，请选择', array('{mobile}' => $model->username)),
                    'gai_numbers', array('class' => 'errorMessage'));?>
           <div class="custom-select">
            <?php 
                echo CHtml::dropDownList('gai_numbers', '', $users, array('class' => 'inputTxt'));
            ?>
            </div>
        </div> 
          <input type="hidden" id="gai_number" name="LoginForm[username]" value=<?php echo current($users);?>>
        <?php endif;?>
        <div class="divInput codeCon">
            <?php
            echo $form->passwordField($model, 'password', array(
                'class' => 'inputTxt bbot', 'placeholder' => Yii::t('mhome', '登录密码'),
            ));
            ?>
            <?php echo CHtml::button('', array('class' => 'LFBut', 'num' => 1)); ?>
            <!--<input type="button" class="LFBut" num="1"/>-->
            <?php echo $form->error($model, 'password'); ?>
        </div>

        <?php
        if (LoginForm::captchaRequirement()):
            ?>
            <div class="divInput">
                <?php
                echo $form->textField($model, 'verifyCode', array(
                    'class' => 'inputTxt',
                    'placeholder' => Yii::t('mhome', '请输入验证码'),
                ));
                ?>
                <?php $this->widget('CCaptcha', array('showRefreshButton' => false, 'clickableImage' => true, 'imageOptions' => array('alt' => Yii::t('mhome', '点击换图'), 'title' => Yii::t('mhome', '点击换图'), 'style' => 'margin-bottom:-12px;cursor:pointer', 'class' => 'captchaImg'))); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php echo CHtml::submitButton(Yii::t('mhome', '登录'), array('class' => 'loginSub')) ?>
    <div class="loginCz">
        <?php echo CHtml::link(Yii::t('mhome', '新用户注册'), array('/m/home/register'), array('class' => 'fl', 'title' => '')); ?>
        <?php echo CHtml::link(Yii::t('mhome', '忘记密码'), array('/m/home/findpassword'), array('class' => 'fr', 'title' => '')); ?>
        <div class="clear"></div>
    </div>
    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
        $("#gai_numbers").change(function(){
            var uname=$(this).val();
           $("#gai_number").val(uname);
         })

</script>