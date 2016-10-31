<?php
// 编辑加盟商视图
$this->breadcrumbs = array(
    Yii::t('sellerFranchisee', '密码管理') => array('/seller/franchisee/pwd')
);
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchisee-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
        ));
?>

<div class="toolbar">
	<b><?php echo $model->name;?> <?php echo Yii::t('sellerFranchisee', '密码管理'); ?></b>
	<span><?php echo Yii::t('sellerFranchisee', '对卖家管理登录的密码设置。'); ?></span>
</div>
<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
	<tbody><tr>
			<th width="10%"><?php echo $form->labelEx($model, 'originalPassword'); ?></th>
			<td width="90%">
				<?php echo $form->passwordField($model, 'originalPassword', array('class' => 'inputtxt1','style'=>'width:130px;')); ?>
                <?php echo $form->error($model, 'originalPassword'); ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form->labelEx($model, 'password'); ?></th>
			<td>
				<?php echo $form->passwordField($model, 'password', array('class' => 'inputtxt1','style'=>'width:130px;')); ?>
                <?php echo $form->error($model, 'password'); ?>
			</td>
		</tr>
		<tr>
			<th><?php echo $form->labelEx($model, 'confirmPassword'); ?></th>
			<td>
				<?php echo $form->passwordField($model, 'confirmPassword', array('class' => 'inputtxt1','style'=>'width:130px;')); ?>
                <?php echo $form->error($model, 'confirmPassword'); ?>
			</td>
		</tr>
</tbody></table>
<div class="profileDo mt15">
	<a href="#" class="sellerBtn03" onclick="javascript:$('#franchisee-form').submit();"><span><?php echo Yii::t('sellerFranchisee', '提交'); ?></span></a>
</div>

<?php $this->endWidget(); ?>