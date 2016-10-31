<?php
/** @var HomeController $this */
/** @var CActiveForm $form */
/** @var Member $model */
/** @var Enterprise $modelEnterprise */
?>
<?php $this->renderPartial('/layouts/_redad'); ?>
<div class="title clearfix">
	<?php echo CHtml::link('普通用户注册',Yii::app()->createAbsoluteUrl('/member/home/register')) ?>
	<?php echo CHtml::link('企业用户注册',Yii::app()->createAbsoluteUrl('/member/home/registerEnterprise'),array('class'=>'curr'));?>
</div>
<div class="content clearfix">
	<?php
	$form = $this->beginWidget('ActiveForm', array(
		'id' => $this->id . '-form',
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'clientOptions' => array(
			'validateOnSubmit' => true,
		),
		'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		),
	));
	?>
	<table cellspacing="0" cellpadding="0" border="0" width="100%" class="reg_t comReg_t fl">
		<tbody>
		<tr>
			<th><span class="red">*</span><?php echo $form->label($model, 'mobile'); ?>：</th>
			<td>
				<?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt')); ?>
				<?php echo $form->error($model, 'mobile') ?>
			</td>
		</tr>
		<tr>
			<th><span class="red">*</span><?php echo $form->label($model, 'mobileVerifyCode') ?>：</th>
			<td>
				<?php echo $form->textField($model, 'mobileVerifyCode', array('class' => 'inputtxt verInputtxt')); ?>
				&nbsp;
				<a href="#" class="btnMobCode" id="sendMobileCode">
					<span data-status="1"><?php echo Yii::t('memberHome','获取验证码'); ?></span>
				</a>
				<?php echo $form->error($model, 'mobileVerifyCode') ?>
			</td>
		</tr>

		<tr>
			<th><span class="red">*</span><?php echo $form->label($model, 'password'); ?>：</th>
			<td>
				<?php echo $form->passwordField($model, 'password', array('class' => 'inputtxt passInputtxt')); ?>
				<?php echo $form->error($model, 'password'); ?>
			</td>
		</tr>
		<tr>
			<th><span class="red">*</span><?php echo $form->label($model, 'confirmPassword'); ?>：</th>
			<td>
				<?php echo $form->passwordField($model, 'confirmPassword', array('class' => 'inputtxt passInputtxt')); ?>
				<?php echo $form->error($model, 'confirmPassword'); ?>
			</td>
		</tr>

		<tr>
			<th><?php echo $form->label($modelEnterprise, 'email'); ?>：</th>
			<td>
				<?php echo $form->textField($modelEnterprise, 'email', array('class' => 'inputtxt')); ?>
				<?php echo $form->error($modelEnterprise, 'email') ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form->label($model, 'tmp_referrals_id'); ?>：</th>
			<td>
				<?php if ($this->getParam('code')): ?>
                    <?php $code = Tool::lowEncrypt(rawurldecode($this->getParam('code')),'DECODE') ?>
					<?php echo $code  ?>
					<?php echo $form->hiddenField($model, 'tmp_referrals_id', array('value' => $code)) ?>
				<?php else: ?>
					<?php echo $form->textField($model, 'tmp_referrals_id', array('class' => 'inputtxt')); ?>
					<?php echo $form->error($model, 'tmp_referrals_id'); ?>
				<?php endif; ?>
			</td>
		</tr>
        <tr>
            <th><?php echo $form->label($modelEnterprise, 'service_id'); ?>：</th>
            <td>
            <?php echo $form->textField($modelEnterprise, 'service_id', array('class' => 'inputtxt')); ?>
            <?php echo $form->error($modelEnterprise, 'service_id'); ?>
            </td>
        </tr>
		<tr>
			<th>&nbsp;</th>
			<td class="do">
				<?php echo CHtml::submitButton(Yii::t('memberHome','同意协议并注册'), array('type'=>'button','class'=>'regBtn'))?>
			</td>
		</tr>
		<tr>
			<td class="ta_c" colspan="2">
				<?php echo $form->checkBox($model, 'agree',array('checked'=>'checked','style'=>'display:none;')); ?>
				<?php echo Yii::t('memberHome', ' ') . CHtml::link(Yii::t('memberHome', '《盖象商城用户入驻协议》'), $this->createUrl('/help/article/agreementEnterprise'), array('target' => '_blank','class'=>'agreement')); ?>
				<?php echo $form->error($model, 'agree'); ?>
			</td>
		</tr>
		<tr>
			<td class="ta_c" colspan="2" >
				<hr/>
				<?php echo Yii::t('memberHome','普通用户点击{0}，升级为企业用户',array('{0}'=>CHtml::link(Yii::t('memberHome','这里'),'/home/memberUpgrade',array('class'=>'red')))) ?>
			</td>
		</tr>

		
		</tbody>
	</table>
	<?php $this->renderPartial('_kefu') ?>
	<?php $this->endWidget(); ?>
  
</div>

<?php $this->renderPartial('_weixin') ?>
<?php echo $this->renderPartial('_sendMobileCodeJs'); ?>
<script type="text/javascript">
    $(function () {
        sendMobileCode("#sendMobileCode","#Member_mobile");
    });
</script>