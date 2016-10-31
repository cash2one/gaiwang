<?php
/* @var $this OfflineSignEnterpriseController */
/* @var $model OfflineSignEnterprise */
/* @var $form CActiveForm */
?>
<style>
	/*表单错误提示调整*/
	span{
		float: left;
	}
	input{float: left;}
	.errorMessage{float: left;}
	select{float: left;}
</style>
<script type="text/javascript">
//	OfflineSignEnterprise_account_pay_type
$(document).ready(function(){
	//对公还是对私
	$('.accountPublic').show();
	$('.accountPrivate').hide();
	var payType = $('#OfflineSignEnterprise_account_pay_type');
	if(payType.val() == <?php echo OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PUBLIC?>){
		$('.accountPublic').show();
		$('.accountPrivate').hide();
	}else{
		$('.accountPublic').hide();
		$('.accountPrivate').show();
	}

	payType.change(function(){
		if(payType.val() == <?php echo OfflineSignEnterprise::ACCOUNT_PAY_TYPE_PUBLIC?>){
			$('.accountPublic').show();
			$('.accountPrivate').hide();
		}else{
			$('.accountPublic').hide();
			$('.accountPrivate').show();
		}
	});

	//是否长期
	var isLongTime = $('#OfflineSignEnterprise_license_is_long_time');
    var endTime = $('#OfflineSignEnterprise_license_end_time');

    if(isLongTime.attr('checked')){
		isLongTime.val(1);
        endTime.attr('disabled','true');
        endTime.attr('value','');
    }else{
		isLongTime.val(0);
        endTime.removeAttr('disabled');
    }
	isLongTime.change(function(){
		if(isLongTime.attr('checked')){
			isLongTime.val(1);
			endTime.attr('disabled','true');
			endTime.attr('value','');
		}else{
			isLongTime.val(0);
			endTime.removeAttr('disabled');
		}
	});

	//点击的是上一步还是下一步
	var step = $('#OfflineSignEnterprise_step');
	var lastStep = $('#lastStep');
	var nextStep = $('#nextStep');
	lastStep.click(function(){
		step.val(<?php echo OfflineSignEnterprise::LAST_STEP?>);
		$('div.errorMessage').attr({style: 'display:none;'}).text('');
		$('#offline-sign-enterprise-form').yiiactiveform({
			'validateOnSubmit':false
		});
		$('#offline-sign-enterprise-form').submit();
	});

	nextStep.click(function(){
		step.val(<?php echo OfflineSignEnterprise::NEXT_STEP?>);
	});
});

</script>
	<div class="com-box">
		<!-- com-box -->
		<div class="sign-contract">
			<div class="sign-top clearfix">
				<p><strong>请提交以下签约资质审核资料，审核成功后，该商户可享受盖网一系列优质服务。</strong></p>
				<p><strong>温馨提示：</strong><span class="red" style="float: inherit">*</span> 为必填项。支持上传的图片文件格式jpg、jpeg、gif、bmp，单张图片大小3M以内。</p>
				<div class="c10"></div>
				<div class="contract-list clearfix">
					<p>1、合同信息<span></span></p>
					<p class="on">2、企业与帐号信息<span></span></p>
					<p>3、盖机与店铺信息</p>
				</div>
			</div>
			<div class="c10"></div>
			<div class="sign-conten">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'offline-sign-enterprise-form',
                    'enableAjaxValidation'=>true,
					'enableClientValidation' => true,
					'clientOptions' => array(
						'validateOnSubmit' => true,
					),
					'htmlOptions' => array(
						'enctype'=>'multipart/form-data'
					),
				)); ?>
				<!--企业信息补充-->
				<div class="sign-tableTitle">企业信息补充</div>
				<div class="sign-list">
					<ul>
						<li>
							<span><i class="red">*</i>企业名称</span>
							<?php echo $form->telField($model,'name',array('class'=>'input ml','placeholder'=>'请填写公司完整名称'))?>
							<?php echo $form->error($model,'name'); ?>
						<li>
							<span id="isChains">是否连锁</span>
							<?php echo $form->dropDownList($model,'is_chain',OfflineSignEnterprise::getIsChain(),array('prompt' => '请选择','class'=>'sign-select fl'))?>
							<span class="liansuo" style="width:100px;">企业连锁形态</span>
							<?php echo $form->dropDownList($model,'chain_type',OfflineSignEnterprise::getChainType(),array('class'=>'sign-select fl liansuo'))?>
							<span  class="liansuo" style="width:100px;">连锁数量</span>
							<?php echo $form->textField($model,'chain_number',array('class'=>'input sl liansuo'))?>
							<?php echo $form->error($model,'chain_number')?>
						</li>
						<li>
							<span><i class="red">*</i>企业联系人姓名</span>
							<?php echo $form->textField($model,'linkman_name',array('class'=>'input ml'))?>
							<?php echo $form->error($model,'linkman_name'); ?>
							<span><i class="red">*</i>企业联系人职位</span>
							<?php echo $form->textField($model,'linkman_position',array('class'=>'input ml'))?>
							<?php echo $form->error($model,'linkman_position'); ?>
						</li>
						<li>
							<span>企业联系人微信</span>
							<?php echo $form->telField($model,'linkman_webchat',array('class'=>'input ml'))?>
							<?php echo $form->error($model,'linkman_webchat')?>
							<span>企业联系人QQ</span>
							<?php echo $form->telField($model,'linkman_qq',array('class'=>'input ml'))?>
							<?php echo $form->error($model,'linkman_qq')?>
						</li>
						<li>
							<span><i class="red">*</i>企业类型</span>
							<?php echo $form->dropDownList($model,'enterprise_type',OfflineSignEnterprise::getEnterType(),array('class'=>'sign-select fl'))?>
							<?php echo $form->error($model,'enterprise_type'); ?>
						</li>
						<li>
							<span><i class="red">*</i>营业执照注册号</span>
							<?php echo $form->textField($model,'enterprise_license_number',array('class'=>'input ml'))?>
							<?php echo $form->error($model,'enterprise_license_number'); ?>
							<span><i class="red">*</i>成立日期</span>
							<?php echo $form->telField($model,'registration_time',array('class'=>'input ml','onfocus' => "WdatePicker()"))?>
							<?php echo $form->error($model,'registration_time'); ?>
						</li>
						<li>
							<span><i class="red">*</i>营业期限开始日期</span>
							<?php echo $form->telField($model,'license_begin_time',array('class'=>'input ml','onfocus' => "WdatePicker()"))?>
							<?php echo $form->error($model,'license_begin_time'); ?>
							<span><i class="red">*</i>营业期限结束日期</span>
							<?php echo $form->telField($model,'license_end_time',array('class'=>'input ml','onfocus' => "WdatePicker()"))?>
							<?php echo $form->error($model,'license_end_time'); ?>
							<?php echo $form->checkBox($model,'license_is_long_time')?>长期

						</li>
						<li>
							<span><i class="red">*</i>法人代表</span>
							<?php echo $form->textField($model,'legal_man',array('class'=>'input ml'))?>
							<?php echo $form->error($model,'legal_man'); ?>
							<span><i class="red">*</i>法人身份证号</span>
							<?php echo $form->textField($model,'legal_man_identity',array('class'=>'input ml'))?>
							<?php echo $form->error($model,'legal_man_identity'); ?>
						</li>
						<li>
							<span><i class="red">*</i>税务登记证</span>
							<?php echo $form->textField($model,'tax_id',array('class'=>'input ml'))?>
							<?php echo $form->error($model,'tax_id'); ?>
						</li>
						<li class="clearfix">
							<span><i class="red">*</i>营业执照电子版</span>
							<div class="sign-upload">
								<p>
									<input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
										   onclick="uploadPicture(this,
											   '<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1121))?>',
											   'OfflineSignEnterprise_license_image',
										   <?php echo isset($model->id) ? $model->id : '0' ?>)">
									<?php echo $form->hiddenField($model,'license_image');?>
									<span class="prc-line" style="width: auto"><?php echo empty($model->license_image) ? '未上传文件' : OfflineSignFile::getOldName($model->license_image)?></span>
									<a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($model->license_image) ? '#' : OfflineSignFile::getfileUrl($model->license_image) ?>">预览</a>
								</p>
								<p>请确保图片清晰，并加盖公章</p>
                                <?php echo $form->error($model,'license_image'); ?>
							</div>
							<span><i class="red">*</i>税务登记证电子版</span>
							<div class="sign-upload">
								<p>
									<input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl" onclick="
										uploadPicture(
										this,
										'<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1122))?>',
										'OfflineSignEnterprise_tax_image',
									<?php echo isset($model->id) ? $model->id : '0' ?>)">
									<?php echo $form->hiddenField($model,'tax_image')?>
									<span class="prc-line" style="width: auto"><?php echo empty($model->tax_image) ? '未上传文件' : OfflineSignFile::getOldName($model->tax_image)?></span>
                                    <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($model->tax_image) ? '#' : OfflineSignFile::getfileUrl($model->tax_image) ?>">预览</a>
								</p>
								<p>请确保图片清晰，并加盖公章</p>
								<?php echo $form->error($model,'tax_image'); ?>
							</div>
							<div class="clear"></div>
						</li>
						<li>
							<span><i class="red">*</i>法人身份证电子版</span>
							<div class="sign-upload">
								<p>
									<input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl" onclick="
										uploadPicture(
										this,
										'<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1123))?>',
										'OfflineSignEnterprise_identity_image',
									<?php echo isset($model->id) ? $model->id : '0' ?>)">
									<?php echo $form->hiddenField($model,'identity_image')?>
									<span class="prc-line" style="width: auto"><?php echo empty($model->identity_image) ? '未上传文件' : OfflineSignFile::getOldName($model->identity_image)?></span>
									<a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($model->identity_image) ? '#' : OfflineSignFile::getfileUrl($model->identity_image) ?>">预览</a>
								</p>
								<p>请确保图片清晰，并加盖公章</p>
								<?php echo $form->error($model,'identity_image'); ?>
							</div>
						</li>
					</ul>
				</div>

				<!--帐号补充信息-->
				<div class="sign-tableTitle">帐号补充信息</div>
				<div class="sign-list">
					<ul>
						<li><span><i class="red">*</i>结算账户类型</span>
							<?php echo $form->dropDownList($model,'account_pay_type',OfflineSignEnterprise::getAccountPayType(),array('class'=>'sign-select'))?>
						</li>
						<li><span><i class="red">*</i>开户行区域</span>
							<?php
							echo $form->dropDownList($model, 'bank_province_id',Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
								'class' => 'sign-select',
								'prompt' => Yii::t('Public','选择省份'),
								'ajax' => array(
									'type' => 'POST',
									'url' => $this->createUrl('region/updateCity'),
									'dataType' => 'json',
									'data' => array(
										'province_id' => 'js:this.value',
										'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
									),
									'success' => 'function(data) {
									$("#OfflineSignEnterprise_bank_city_id").html(data.dropDownCities);
									$("#OfflineSignEnterprise_bank_district_id").html(data.dropDownCounties);
								}',
								)));
							?>
							<?php echo $form->error($model,'bank_province_id'); ?>
							<?php
							echo $form->dropDownList($model, 'bank_city_id', Region::getRegionByParentId($model->bank_province_id), array(
								'prompt' => Yii::t('machine', '选择城市'),
								'class' => 'sign-select ml10',
								'ajax' => array(
									'type' => 'POST',
									'url' => $this->createUrl('region/updateArea'),
									'update' => '#OfflineSignEnterprise_bank_district_id',
									'data' => array(
										'city_id' => 'js:this.value',
										'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
									),
								)));
							?>
							<?php echo $form->error($model,'bank_city_id'); ?>
							<?php
							echo $form->dropDownList($model, 'bank_district_id', Region::getRegionByParentId($model->bank_city_id), array(
								'class' => 'sign-select ml10',
								'prompt' => Yii::t('Public','选择区/县'),
							));
							?>
							<?php echo $form->error($model,'bank_district_id'); ?>
						</li>
						<li class="accountPublic">
							<span><i class="red">*</i>开户许可证（或对公账户证明）电子版</span>
							<div class="sign-upload">
								<p>
									<input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
										   onclick="uploadPicture(
											   this,
											   '<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1124))?>',
											   'OfflineSignEnterprise_bank_permit_image',
										   <?php echo isset($model->id) ? $model->id : '0' ?>)">
									<?php echo $form->hiddenField($model,'bank_permit_image')?>
									<span class="prc-line" style="width: auto"><?php echo empty($model->bank_permit_image) ? '未上传文件' : OfflineSignFile::getOldName($model->bank_permit_image)?></span>
                                    <a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($model->bank_permit_image) ? '#' : OfflineSignFile::getfileUrl($model->bank_permit_image) ?>">预览</a>
								</p>
								<p>请确保图片清晰，并加盖公章</p>
                                <?php echo $form->error($model,'bank_permit_image'); ?>
							</div>
						</li>
						<li class="accountPrivate">
							<span><i class="red">*</i>收款人身份证号</span>
							<?php echo $form->telField($model,'payee_identity_number',array('class'=>'input ml'))?>
							<?php echo $form->error($model,'payee_identity_number'); ?>
						</li>
						<li class="clearfix accountPrivate">
							<span><i class="red">*</i>银行卡复印件（只限对私账）电子版</span>
							<div class="sign-upload">
								<p>
									<input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
										   onclick="uploadPicture(
											   this,
											   '<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1125))?>',
											   'OfflineSignEnterprise_bank_account_image',
										   <?php echo isset($model->id) ? $model->id : '0' ?>)">
									<?php echo $form->hiddenField($model,'bank_account_image')?>
									<span class="prc-line" style="width: auto"><?php echo empty($model->bank_account_image) ? '未上传文件' : OfflineSignFile::getOldName($model->bank_account_image)?></span>
									<a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($model->bank_account_image) ? '#' : OfflineSignFile::getfileUrl($model->bank_account_image) ?>">预览</a>
								</p>
								<p>请确保图片清晰，并加盖公章</p>
								<?php echo $form->error($model,'bank_account_image'); ?>
							</div>
							<span class='switch'><i class="red">*</i>委托收款授权书电子版</span>
							<div class="sign-upload switch">
								<p>
									<input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
										   onclick="uploadPicture(this,
											   '<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1126))?>',
											   'OfflineSignEnterprise_entrust_receiv_image',
										   <?php echo isset($model->id) ? $model->id : '0' ?>)">
									<?php echo $form->hiddenField($model,'entrust_receiv_image')?>
									<span class="prc-line" style="width: auto"><?php echo empty($model->entrust_receiv_image) ? '未上传文件' : OfflineSignFile::getOldName($model->entrust_receiv_image)?></span>
									<a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($model->entrust_receiv_image) ? '#' : OfflineSignFile::getfileUrl($model->entrust_receiv_image) ?>">预览</a>
								</p>
								<p>请确保图片清晰，并加盖公章</p>
								<?php echo $form->error($model,'entrust_receiv_image'); ?>
							</div>
							<div class="clear switch"></div>
						</li>
						<li class="accountPrivate">
							<span><i class="red">*</i>收款人身份证电子版</span>
							<div class="sign-upload">
								<p>
								<input type="button" style="margin-right: 20px;" value="上传文件" class="btn-sign fl"
										   onclick="uploadPicture(
											   this,
											   '<?php echo Yii::app()->createAbsoluteUrl('agent/offlineUpload/offlineIndex',array('code'=>1127))?>',
											   'OfflineSignEnterprise_payee_identity_image',
										   <?php echo isset($model->id) ? $model->id : '0' ?>)">
									<?php echo $form->hiddenField($model,'payee_identity_image')?>
									<span class="prc-line" style="width: auto"><?php echo empty($model->payee_identity_image) ? '未上传文件' : OfflineSignFile::getOldName($model->payee_identity_image)?></span>
									<a class="fl" onclick="return _showBigPic(this)" href="<?php echo empty($model->payee_identity_image) ? '#' : OfflineSignFile::getfileUrl($model->payee_identity_image) ?>">预览</a>
								</p>
								<p>请确保图片清晰，并加盖公章</p>
								<?php echo $form->error($model,'payee_identity_image'); ?>
							</div>
						</li>
					</ul>
					<?php echo $form->hiddenField($model,'step')?>
				</div>
				<div class="sign-clear"></div>
				<div class="c30"></div>
				<div class="sign-btn">
					<?php echo CHtml::submitButton('上一步',array('class'=>'btn-sign','id'=>'lastStep'))?>
					<?php echo CHtml::submitButton('下一步',array('class'=>'btn-sign','id'=>'nextStep'))?>
				</div>

			</div>

		</div>
		<!-- com-box end -->
<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="application/javascript">
	$(document).ready(function(){
		var liansuo = $('.liansuo');
		var orx = $('#OfflineSignEnterprise_is_chain');
		if(orx.val() == 1){
			liansuo.show();
		}else{
			liansuo.hide();
		}
		orx.change(function(){
			if(orx.val() == 1){
				liansuo.show();
			}else {
				liansuo.hide();
			}
		});
	});
</script>
<script>
	$(document).ready(function(){
		<?php if(isset($model) && $model->error_field):?>
		<?php $modelError = json_decode($model->error_field,true);?>
		<?php foreach($modelError as $value):?>
		var str = '<?php echo $value?>';
		str = str.replace('e.','');
		str = '#OfflineSignEnterprise_' + str;
        if(str == '#OfflineSignEnterprise_bank_permit_image' || str == '#OfflineSignEnterprise_license_image' || str == '#OfflineSignEnterprise_tax_image' || str == '#OfflineSignEnterprise_identity_image'){
            $(str).parent().parent().prev().addClass('red');
        }else if(str == '#OfflineSignEnterprise_bank_district_id'){
            $(str).parent().children().addClass('red');
        }else if(str == '#OfflineSignEnterprise_account_pay_type'){
            $(str).prev().addClass('red');
        }else{
            $(str).addClass('red');
            $(str).prev().addClass('red');
        }
		<?php endforeach;?>
		<?php endif;?>

		$('#OfflineSignEnterprise_payee_identity_number').on('change',function(){
			var manId = $('#OfflineSignEnterprise_legal_man_identity');
			if($(this).val() == manId.val()){
				$('.switch').hide();
			}else{
				$('.switch').show();
			}
		});

		$('#OfflineSignEnterprise_payee_identity_number').change();
	});
</script>