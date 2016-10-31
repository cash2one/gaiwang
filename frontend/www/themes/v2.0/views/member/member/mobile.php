<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
?>
<style>
.phone_tips{ padding-left:140px;}
</style>
<?php
?>
  <div class="accounts-box accounts-box2">
      <div class="accounts-revise bind-phone">
          <div class="revise-progress revise-progress2">
              <div class="revise-item on">
                  <p class="number">1</p>
                  <p class="title"><?php echo Yii::t('memberMember','绑定手机');?></p>
                  <span class="on"></span>
              </div>
              <div class="revise-item <?php if($is){ echo 'on';}?>">
                  <p class="number">2</p>
                  <p class="title"><?php echo Yii::t('memberMember','完成');?></p>
              </div>
          </div>
          <?php if(!$is):?>
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
          <?php CHtml::$beforeRequiredLabel="<span class='red'>*</span>";CHtml::$afterRequiredLabel="";?>
          <div class="revise-tip"><?php echo Yii::t('memberMember','您的账号还没绑定手机，为了您的账户安全，请绑定手机！')?></div>
          <div class="revise-box">
            <ul class="revise-box-ul">
                <li><span class="revise-left"><?php echo  $form->label($model,'username')?>：</span><span class="username"><?php echo $model->username?></span></li>
                <li><span class="revise-left"><?php echo $form->label($model,'gai_number')?>：</span><span class="gw-account"><?php echo $model->gai_number?></span></li>
                <li>
                    <span class="revise-left"><?php echo $form->labelEx($model,'mobile');?>：</span>
                    <?php echo $form->textField($model, 'mobile', array('class' => 'input-phone','value'=>'')) ?>
                    <span class="revise-message revise-message2"><?php CHtml::$errorContainerTag='span'; echo $form->error($model, 'mobile'); ?></span>
                </li>
                <li>
                    <span class="revise-left"><?php echo $form->labelEx($model,'mobileVerifyCode');?>：</span>
                    <?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'input-number','value'=>'')) ?>
                    <input id="sendMobileCode" type="button" class="btn-send" value="<?php echo Yii::t('memberMember', '获取验证码'); ?>" />
                    <span class="revise-message revise-message2"><?php CHtml::$errorContainerTag='span'; echo $form->error($model, 'mobileVerifyCode'); ?></span>
              </li>
              <li><?php echo CHtml::submitButton(Yii::t('memberMember','确定'), array('class' => 'btn-deter')) ?></li>
            </ul>
          </div>
          
          <?php $this->endWidget(); ?>     
          <?php else:?>
          <?php $referrer = Yii::app()->request->getUrlReferrer()?> 
          <div class="revise-box bind-success">
                <p class="revise-result"><span><i class="cover-icon"></i><?php echo Yii::t('memberMember', '绑定手机成功 ！'); ?></span></p>
                <p class="revise-result-btn">
                    <input onclick="window.location.href='<?php if(trim($referrer) == DOMAIN || empty($referrer)){ echo Yii::app()->createAbsoluteUrl('/member/site');} else {echo $referrer;} ?>';" type="button" class="btn-deter" value="<?php echo Yii::t('memberMember', '确认'); ?>" />
                </p>
            </div>
          <?php endif;?>
      </div> 
 
<?php echo $this->renderPartial('/layouts/_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function() {
        sendMobileCode("#sendMobileCode","#Member_mobile");
    });
</script>