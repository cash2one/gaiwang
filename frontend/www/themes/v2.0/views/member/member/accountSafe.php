<?php
/* @var $this  HomeController */
/** @var $model Member */
/** @var $form CActiveForm */
$this->breadcrumbs = array(
    Yii::t('memberMember', '账户管理') => '',
    Yii::t('memberMember', ' 帐户安全'),
);
?>

<div class="main-contain">
      
  <div class="accounts-box">
      <p class="accounts-title cover-icon"><?php echo Yii::t('memberMember','账户安全'); ?></p>
      <div class="accounts-safety">
          <div class="safety-item">
              <table id="safety-table" width="970" height="100" border="0">
                <tr>
                  <td class="safety-logo2 password"></td>
                  <td class="safety-name"><?php echo Yii::t('memberMember','登录密码'); ?></td>
                  <td class="safety-summary"><?php echo Yii::t('memberMember','用于账号登录，为了您的账号安全，建议您定期更换密码，密码最好为长度超过6位以上的字母、数字组合。'); ?></td>
                  <td class="safety-status"><?php echo Yii::t('memberMember','使用中'); ?></td>
                  <td class="safety-operate"><?php echo CHtml::link(Yii::t('memberMember','修改'),$this->createAbsoluteUrl('member/setPwd1'),array('target'=>'_blank')); ?></td>
                </tr>
              </table>
          </div>
          <div class="safety-item">
              <table id="safety-table" width="970" height="100" border="0">
                <tr>
                  <td class="safety-logo3 password"></td>
                  <td class="safety-name"><?php echo Yii::t('memberMember','支付密码'); ?></td>
                  <td class="safety-summary"><?php echo Yii::t('memberMember','用于购买商品，积分消费，密码最好为长度 6-12 位的字母、数字组合。'); ?></td>
                  <td class="safety-status"><?php echo Yii::t('memberMember','使用中'); ?></td>
                  <td class="safety-operate"><?php echo CHtml::link(Yii::t('memberMember','修改'),$this->createAbsoluteUrl('member/setPwd3'),array('target'=>'_blank')); ?></td>
                </tr>
              </table>
          </div>
          <div class="safety-item">
              <table id="safety-table" width="970" height="100" border="0">
                <tr>
                  <td class="safety-logo password"></td>
                  <td class="safety-name"><?php echo Yii::t('memberMember','积分管理密码'); ?></td>
                  <td class="safety-summary"><?php echo Yii::t('memberMember','用于积分管理，密码最好为长度 6-12 位的字母、数字组合。'); ?></td>
                  <td class="safety-status"><?php echo Yii::t('memberMember','使用中'); ?></td>
                  <td class="safety-operate"><?php echo CHtml::link(Yii::t('memberMember','修改'),$this->createAbsoluteUrl('member/setPwd2'),array('target'=>'_blank')); ?></td>
                </tr>
              </table>
          </div>
          <div class="safety-item">
              <table id="safety-table" width="970" height="100" border="0">
                <tr>
                  <td class="safety-logo phone"></td>
                  <td class="safety-name"><?php echo Yii::t('memberMember','绑定手机'); ?></td>
                  <?php if($model->mobile){?>
                  <td class="safety-summary"><?php echo Yii::t('memberMember','您绑定的手机为：'); ?><?php echo substr_replace($model->mobile,'****',3,4) ?> <?php echo Yii::t('memberMember',' 若丢失或停用，请及时更改。'); ?></td>
                  <td class="safety-status"><?php echo Yii::t('memberMember','使用中'); ?></td>
                  <td class="safety-operate"><?php echo CHtml::link(Yii::t('memberMember','修改'),$this->createAbsoluteUrl('member/bindMobile'),array('target'=>'_blank')); ?></td>
                  <?php }else{?>
                  <td class="safety-summary"><?php echo Yii::t('memberMember','您还没有绑定手机'); ?></td>
                  <td class="safety-status"></td>
                  <td class="safety-operate"><?php echo CHtml::link(Yii::t('memberMember','修改'),$this->createAbsoluteUrl('member/bindMobile'),array('target'=>'_blank')); ?></td>
                  <?php }?>
                </tr>
              </table>
          </div>
          <div class="safety-item">
              <table id="safety-table" width="970" height="100" border="0">
                <tr>
                  <td class="safety-logo mailbox"></td>
                  <td class="safety-name"><?php echo Yii::t('memberMember','验证邮箱'); ?></td>
                  <?php if($model->active_email && $model->email){?>
                  <td class="safety-summary"><?php echo Yii::t('memberMember','您的邮箱：'); ?><?php echo $model->email; ?> <?php echo Yii::t('memberMember','如有变更请及时修改。'); ?></td>
                  <td class="safety-status"><?php echo Yii::t('memberMember','使用中'); ?></td>
                  <td class="safety-operate"><?php echo CHtml::link(Yii::t('memberMember','修改'),$this->createAbsoluteUrl('member/updateBindEmail'),array('target'=>'_blank')); ?></td>
                  <?php }else{?>
                  <td class="safety-summary"><?php echo Yii::t('memberMember','您还没有添加邮箱');?></td>
                  <td class="safety-status"></td>
                  <td class="safety-operate">
                    <?php
                        echo CHtml::link(Yii::t('memberMember','绑定'),$this->createAbsoluteUrl('member/bindEmail'),array('target'=>'_blank'));
                    ?>
                  </td>
                  <?php }?>
                </tr>
              </table>
          </div>
      </div>
  </div>
  
  
</div>
