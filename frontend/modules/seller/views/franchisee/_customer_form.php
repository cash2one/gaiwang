<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchisee-customer-form',
//    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
		<tbody><tr>
				<th width="10%"><?php echo $form->labelEx($model, 'username'); ?></th>
				<td width="90%">
					<?php echo $form->textField($model, 'username', array('class' => 'inputtxt1','style'=>'width:130px;')); ?>
            		<?php echo $form->error($model, 'username'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo $form->labelEx($model, 'password'); ?></th>
				<td>
					<?php echo $form->hiddenField($model, 'oldPassword')?>
					<?php echo $form->passwordField($model, 'password', array('class' => 'inputtxt1','style'=>'width:130px;')); ?>
					<?php
		                if (!$model->isNewRecord) :
		                echo "<font color = 'red'>".Yii::t('sellerFranchisee','密码为空则不修改原有密码!')."</font>";
		                endif;
		            ?>
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
			<tr>
				<th><?php echo $form->labelEx($model, 'mobile'); ?></th>
				<td>
					<?php echo $form->textField($model, 'mobile', array('class' => 'inputtxt1','style'=>'width:130px;')); ?>
            		<?php echo $form->error($model, 'mobile'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo $form->labelEx($model, 'remark'); ?></th>
				<td>
					<?php echo $form->textArea($model, 'remark',array('style'=>'width:330px; height:80px;'))?>
				</td>
			</tr>
	</tbody></table>

	<div class="profileDo mt15">
		<a href="javascript:void(0);" class="sellerBtn03" onclick="$('#franchisee-customer-form').submit();"><span><?php echo $model->isNewRecord?Yii::t('sellerFranchisee', '添加'):Yii::t('sellerFranchisee', '确定');  ?></span></a>&nbsp;&nbsp;<a href="javascript:history.go(-1);" class="sellerBtn01"><span><?php echo Yii::t('sellerFranchisee', '返回');?></span></a>
	</div>

<?php $this->endWidget(); ?>
