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
                    'validateOnSubmit'=>true
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
                    <?php echo $form->passwordField($model,'password2',array('class'=>'input-password','value'=>''));?>
                    <?php CHtml::$errorContainerTag = 'span'; echo $form->error($model,'password2',array('class'=>'revise-message'))?>
                </p>
                <p>
                    <?php echo CHtml::tag('span',array('class'=>'revise-left'),Yii::t('memberMember','确认新密码')); ?>
                    <?php echo $form->passwordField($model,'confirmPassword',array('class'=>'input-password','value'=>''));?>
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
<script type="text/javascript">
    $(function () {
        sendMobileCode("#sendMobileCode", "#Member_mobile");
    });
</script>