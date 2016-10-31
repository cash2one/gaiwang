<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
?>
<?php
?>
    
  <div class="accounts-box accounts-box2">
      <div class="accounts-revise">
          <div class="revise-progress">
              <div class="revise-item on">
                  <p class="number">1</p>
                  <p class="title"><?php echo Yii::t('memberMember','验证身份');?></p>
                  <span class="on"></span>
              </div>
              <div class="revise-item <?php if($step >=2 ){ echo 'on';}?>">
                  <p class="number">2</p>
                  <p class="title"><?php echo Yii::t('memberMember','绑定手机');?></p>
                  <span <?php if($step > 2 ){ echo 'class="on"';}?>></span>
              </div>
              <div class="revise-item <?php if($step == 3){ echo 'on';}?>">
                  <p class="number">3</p>
                  <p class="title"><?php echo Yii::t('memberMember','完成');?></p>
              </div>
          </div>
          
          <?php
		  $form = $this->beginWidget('ActiveForm', array(
			  'id' => $this->id . '-form',
			  'enableAjaxValidation' => false,
			  'enableClientValidation' => true,
			  'clientOptions' => array(
				  'validateOnSubmit' => true,
			  ),
		  ));
		  ?>
          <?php if($step == 1){?>
          <div class="revise-box">
            <ul class="revise-box-ul">
                <li>
                    <span class="revise-left"><?php echo Yii::t('member','手机号码') ?>：</span>
                    <span class="revise-phone"><?php echo substr_replace($model->mobile,'****',3,4) ?></span></li>
                    <input type="hidden" id="Member_mobile" name="Member[mobile]" value="<?php echo $model->mobile; ?>" />
                <li>
                    <span class="revise-left"><?php echo Yii::t('memberMember','手机验证码');?>：</span>
                    <?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'input-number','value'=>'')) ?>
                    <input id="sendMobileCode2" type="button" class="btn-send" value="<?php echo Yii::t('memberMember', '获取验证码'); ?>" />
                    <span class="revise-message revise-message2"><?php CHtml::$errorContainerTag='span'; echo $form->error($model, 'mobileVerifyCode'); ?></span>
                </li>
                <li><?php echo CHtml::submitButton(Yii::t('memberMember','确认'), array('class' => 'btn-deter')) ?></li>
            </ul>
          </div>
          <?php }else if($step == 2){?>
          <div class="revise-box">
            <ul class="revise-box-ul">
                <li>
                    <span class="revise-left"><?php echo Yii::t('memberMember','新手机号码');?>：</span>
                    <?php echo $form->textField($model, 'mobile', array('class' => 'input-phone','value'=>'')) ?>
                    <span class="revise-message revise-message2"><?php CHtml::$errorContainerTag='span'; echo $form->error($model, 'mobile'); ?></span>
                </li>
                <li>
                    <span class="revise-left"><?php echo Yii::t('memberMember','新手机验证码');?>：</span>
                    <?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'input-number','value'=>'')) ?>
                    <input id="sendMobileCode2" type="button" class="btn-send" value="<?php echo Yii::t('memberMember', '获取验证码'); ?>" />
                    <span class="revise-message revise-message2"><?php CHtml::$errorContainerTag='span'; echo $form->error($model, 'mobileVerifyCode'); ?></span>
              </li>
              <li><?php echo CHtml::submitButton(Yii::t('memberMember','确定'), array('class' => 'btn-deter')) ?></li>
            </ul>
          </div>
          
          <?php }else if($step == 3){?>
          <div class="revise-box bind-success">
              <p class="revise-result"><span><i class="cover-icon"></i><?php echo Yii::t('memberMember','绑定手机成功 ！');?></span></p>
              <p class="revise-result-btn"><input onclick="window.location.href='<?php echo Yii::app()->createAbsoluteUrl('/member/member/update');?>';" type="button" class="btn-deter" value="<?php echo Yii::t('memberMember','确认');?>" /></p>
          </div>
          <?php }?>
          <?php $this->endWidget(); ?>            
      </div>
  </div>
   
 
<?php echo $this->renderPartial('/layouts/_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function() {
        sendMobileCode("#sendMobileCode2","#Member_mobile");
    });
</script>