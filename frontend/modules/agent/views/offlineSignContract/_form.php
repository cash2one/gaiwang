<style>
	/*表单错误提示调整*/
	span{
		float: left;
	}
	input{float: left;}
	.errorMessage{float: left;}
	select{float: left;}
</style>
<div class="com-box">
	<!-- com-box -->
    <div class="toolbar img08"><?php echo CHtml::link(Yii::t('Public','返回'), $this->createURL('offlineSignStoreExtend/admin'), array('class' => 'button_05 floatRight')); ?></div>
	<div class="sign-contract">
		<div class="sign-top clearfix">
			<p><strong>请提交以下签约资质审核资料，审核成功后，该商户可享受盖网一系列优质服务。</strong></p>
			<p><strong>温馨提示：</strong><span class="red" style="float: inherit">*</span> 为必填项。支持上传的图片文件格式jpg、jpeg、gif、bmp，单张图片大小3M以内。</p>
			<?php if($this->action->id == 'update'):?>
			<p><strong>新增类型：</strong><?php  echo OfflineSignStore::getApplyType($model->apply_type)?><span><strong>企业名称：</strong></span><?php  echo $model->enterpriseName?></p>

			<?php endif;?>
			<div class="c10"></div>
			<div class="contract-list clearfix">
				<p class="on">1、合同信息<span></span></p>
				<p>2、企业与帐号信息<span></span></p>
				<p>3、盖机与店铺信息</p>
			</div>
		</div>
		<div class="c10"></div>

		<?php
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'offline-sign-contract-form',
            'enableAjaxValidation'=>true,
			'enableClientValidation' => true,
			'clientOptions' => array(
				'validateOnSubmit' => true,
			),
		)); ?>
		<div class="sign-conten">
			<!--会员与帐号信息-->
			<div class="sign-tableTitle">会员与帐号信息</div>
			<div class="sign-list">
				<ul>
					<li>
						<span>合同编号</span>
						<?php echo $model->number; ?>
					</li>
					<li>
						<span>甲方</span>
						<?php echo $form->textField($model,'a_name',array('class' => 'input ml' ,'disabled' => "true"))?>
                        <?php echo $form->error($model,'a_name'); ?>
						<span><i class="red">*</i>乙方</span>
						<?php echo $form->textField($model,'b_name',array('class' => 'input ml'));?>
						<?php echo $form->error($model,'b_name'); ?>
					<li>
						<span><i class="red">*</i>营业执照注册地区</span>
						<?php
						echo $form->dropDownList($model, 'province_id',Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
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
                                    $("#OfflineSignContract_city_id").html(data.dropDownCities);
                                    $("#OfflineSignContract_district_id").html(data.dropDownCounties);
                                }',
							)));
						?>
						<?php echo $form->error($model,'province_id'); ?>
						<?php
						echo $form->dropDownList($model, 'city_id', Region::getRegionByParentId($model->province_id), array(
							'prompt' => Yii::t('machine', '选择城市'),
							'class' => 'sign-select ml10',
							'ajax' => array(
								'type' => 'POST',
								'url' => $this->createUrl('region/updateArea'),
								'update' => '#OfflineSignContract_district_id',
								'data' => array(
									'city_id' => 'js:this.value',
									'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
								),
							)));
						?>
						<?php echo $form->error($model,'city_id'); ?>
						<?php
						echo $form->dropDownList($model, 'district_id', Region::getRegionByParentId($model->city_id), array(
							'class' => 'sign-select ml10',
							'prompt' => Yii::t('Public','选择区/县'),
						));
						?>
						<?php echo $form->error($model,'district_id'); ?>
					</li>
					<li><span><i class="red">*</i>营业执照注册地址</span>
						<?php echo $form->textField($model,'address',array('class' => 'input xl'));?>
						<?php echo $form->error($model,'address'); ?>
					</li>
					<li>
						<span>推广地区</span>
						<?php
						echo $form->dropDownList($model, 'p_province_id',Region::getRegionByParentId(Region::PROVINCE_PARENT_ID), array(
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
                                    $("#OfflineSignContract_p_city_id").html(data.dropDownCities);
                                    $("#OfflineSignContract_p_district_id").html(data.dropDownCounties);
                                }',
							)));
						?>
						<?php
						echo $form->dropDownList($model, 'p_city_id', Region::getRegionByParentId($model->p_province_id), array(
							'prompt' => Yii::t('machine', '选择城市'),
							'class' => 'sign-select ml10',
							'ajax' => array(
								'type' => 'POST',
								'url' => $this->createUrl('region/updateArea'),
								'update' => '#OfflineSignContract_p_district_id',
								'data' => array(
									'city_id' => 'js:this.value',
									'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
								),
							)));
						?>
						<?php
						echo $form->dropDownList($model, 'p_district_id', Region::getRegionByParentId($model->p_city_id), array(
							'class' => 'sign-select ml10',
							'prompt' => Yii::t('Public','选择区/县'),
						));
						?>
					</li>
					<li><span><i class="red">*</i>合作期限起始日期</span>
						<?php $model->begin_time = date('Y-m-d',$model->begin_time)?>
						<?php $model->begin_time = $model->begin_time =='1970-01-01'?"":$model->begin_time;?>
						<?php echo $form->textField($model, 'begin_time', array('class'=>'input ml','onclick'=>'WdatePicker({dateFmt:"yyyy-MM-dd"})'))?>
						<?php echo $form->error($model,'begin_time'); ?>
					</li>
					<li><span><i class="red">*</i>合同合作期限(月)</span>
						<?php echo $form->dropDownList($model,'contract_term',OfflineSignContract::getContractTerm(),array('class'=>'input sign-select','prompt' => '选择合同合作期限'))?>
                        <?php echo $form->error($model,'contract_term'); ?>
						<span>
                            <i class="red">*</i>合作期限结束日期
                        </span>
						<?php if(isset($model->end_time)) $model->end_time = date('Y-m-d',$model->end_time)?>
						<?php echo $form->textField($model, 'end_time', array('class' => 'input ml','disabled' => "true")); ?>
                        <?php echo $form->error($model,'end_time'); ?>
					</li>
					<li>
						<span><i class="red">*</i>签约类型</span>
						<?php echo $form->dropDownList($model,'sign_type',OfflineSignStoreExtend::getSignType(),array('class'=>'sign-select ml fl'))?>
						<?php echo $form->error($model,'sign_type')?>
						<span><i class="red">*</i>合同签订日期</span>
						<?php echo $form->textField($model,'sign_time',array('class'=>'input ml','onfocus' => "WdatePicker()"))?>
						<?php echo $form->error($model,'sign_time')?>
					</li>
					<li><span>销售开发人</span>
						<?php echo $form->textField($model,'machine_developer',array('class'=>'input ml'))?>
						<?php echo $form->error($model,'machine_developer')?>
						<span>合同跟进人</span>
						<?php echo $form->textField($model,'contract_linkman',array('class'=>'input ml'))?>
						<?php echo $form->error($model,'contract_linkman')?>
					</li>
					<li>
						<span><i class="red">*</i>企业GW号开通人</span>
						<?php echo $form->textField($model,'enterprise_proposer',array('class'=>'input ml'))?>
						<?php echo $form->error($model,'enterprise_proposer'); ?>
						<span><i class="red">*</i>企业GW号开通手机</span>
						<?php echo $form->textField($model,'mobile',array('class'=>'input ml'))?>
						<?php echo $form->error($model,'mobile'); ?>
					</li>
				</ul>
			</div>

			<!--乙方权益-->
			<div class="sign-tableTitle">乙方权益</div>
			<div class="select-list">
				<ul>
					<li>
						<div class="clearfix">
							<div class="left">
								<input id="OfflineSignContract_operation_type_one" type="radio" name="OfflineSignContract[operation_type]" value="<?php echo OfflineSignContract::OPERATION_TYPE_ONE?>">
								方式一
							</div>
							<div class="right">
								<p class="clearfix"><span>3小时高峰广告时间段</span>
									<?php echo $form->dropDownList($model,'ad_begin_time_hour_one',OfflineSignContract::getAdHour(),array('class'=>'sign-select mlt10'))?>
									<span class="mlt10">时</span>
									<?php echo $form->dropDownList($model,'ad_begin_time_minute_one',OfflineSignContract::getAdMiute(),array('class'=>'sign-select mlt10'))?>
									<span class="mlt10">至</span>
									<?php echo $form->dropDownList($model,'ad_end_time_hour_one',OfflineSignContract::getAdHour(),array('class'=>'sign-select mlt10','disabled' => "true"))?>
									<span class="mlt10">时</span>
									<?php echo $form->dropDownList($model,'ad_end_time_minute_one',OfflineSignContract::getAdMiute(),array('class'=>'sign-select mlt10','disabled' => "true"))?>
								</p>
								<p>广告时间段收益的15%</p>
							</div>
						</div>
					</li>
					<li>
						<div class="clearfix">
							<div class="left">
								<input id="OfflineSignContract_operation_type_two" type="radio" name="OfflineSignContract[operation_type]" value="<?php echo OfflineSignContract::OPERATION_TYPE_TWO?>">
								方式二
							</div>
							<div class="right">
								<p>支付三年的技术服务费<span class="mlt10">人民币</span><span class="mlt10 red">贰万伍仟元整（￥25000）</span></p>
								<p class="clearfix"><span>3小时高峰广告时间段</span>
									<?php echo $form->dropDownList($model,'ad_begin_time_hour_two',OfflineSignContract::getAdHour(),array('class'=>'sign-select mlt10'))?>
									<span class="mlt10">时</span>
									<?php echo $form->dropDownList($model,'ad_begin_time_minute_two',OfflineSignContract::getAdMiute(),array('class'=>'sign-select mlt10'))?>
									<span class="mlt10">至</span>
									<?php echo $form->dropDownList($model,'ad_end_time_hour_two',OfflineSignContract::getAdHour(),array('class'=>'sign-select mlt10','disabled' => "true"))?>
									<span class="mlt10">时</span>
									<?php echo $form->dropDownList($model,'ad_end_time_minute_two',OfflineSignContract::getAdMiute(),array('class'=>'sign-select mlt10','disabled' => "true"))?>
								</p>
								<p>广告时间段收益的<i class="red">25%</i></p>
							</div>
						</div>
					</li>
					<li>
						<div class="clearfix">
							<div class="left">
								<input id="OfflineSignContract_operation_type_three" type="radio" name="OfflineSignContract[operation_type]" value="<?php echo OfflineSignContract::OPERATION_TYPE_THREE?>" >
								方式三
							</div>
							<div class="right">
								<p>支付一年的技术服务费<span class="mlt10">人民币</span><span class="mlt10 red">壹万元整（￥10000）</span></p>
								<p style="color: red;">以后每年均须在与本合同签订日相同日期一次性等额支付年度技术服务费</p>
								<p class="clearfix"><span>3小时高峰广告时间段</span>
									<?php echo $form->dropDownList($model,'ad_begin_time_hour_three',OfflineSignContract::getAdHour(),array('class'=>'sign-select mlt10'))?>
									<span class="mlt10">时</span>
									<?php echo $form->dropDownList($model,'ad_begin_time_minute_three',OfflineSignContract::getAdMiute(),array('class'=>'sign-select mlt10'))?>
									<span class="mlt10">至</span>
									<?php echo $form->dropDownList($model,'ad_end_time_hour_three',OfflineSignContract::getAdHour(),array('class'=>'sign-select mlt10','disabled' => "true"))?>
									<span class="mlt10">时</span>
									<?php echo $form->dropDownList($model,'ad_end_time_minute_three',OfflineSignContract::getAdMiute(),array('class'=>'sign-select mlt10','disabled' => "true"))?>
								</p>
								<p>广告时间段收益的<i class="red">25%</i></p>
							</div>
						</div>
					</li>
				</ul>
			</div>

			<!--乙方银行信息-->
			<div class="sign-tableTitle">乙方银行信息</div>
			<div class="sign-list">
				<ul>
					<li>
						<span><i class="red">*</i>开户行名称</span>
						<?php echo $form->textField($model,'bank_name',array('class'=>'input cl'))?>
						<?php echo $form->error($model,'bank_name'); ?>
					</li>
					<li>
						<span><i class="red">*</i>账户名称</span>
						<?php echo $form->textField($model,'account_name',array('class'=>'input cl'))?>
						<?php echo $form->error($model,'account_name'); ?>
					</li>
					<li>
						<span><i class="red">*</i>银行账号</span>
						<?php echo $form->textField($model,'account',array('class'=>'input cl'))?>
						<?php echo $form->error($model,'account'); ?>
					</li>
				</ul>
			</div>

			<?php echo $form->hiddenField($model,'step')?>
			<div class="sign-clear"></div>
			<div class="c30"></div>
			<div class="sign-btn">
				<?php echo CHtml::submitButton('保存并进入下一步',array('class'=>'btn-sign','id'=>'nextStep'))?>
				<?php echo CHtml::submitButton('保存并打印合同信息',array('class'=>'btn-sign ml10','id'=>'lastStep','target'=>"_blank"))?>
			</div>

		</div>
		<?php $this->endWidget(); ?>
	</div>
	<!-- com-box end -->
</div>
<script type="text/javascript">
	$(document).ready(function(){
		//点击的是“保存并进入下一步”还是“保存并打印合同信息”
		var step = $('#OfflineSignContract_step');
		var lastStep = $('#lastStep');
		var nextStep = $('#nextStep');
		lastStep.click(function(){
			step.val(<?php echo OfflineSignEnterprise::LAST_STEP?>);
		});

		nextStep.click(function(){
			step.val(<?php echo OfflineSignEnterprise::NEXT_STEP?>);
		});

		//合同结束期限
		var term = $('#OfflineSignContract_contract_term');
		term.change(function(){
			var contractTerm = term.val();
			var benginTime = $('#OfflineSignContract_begin_time').val();
			var url = '<?php echo $this->createUrl('offlineSignContract/returnEndTime');?>';
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: url,
				data: {'YII_CSRF_TOKEN': '<?php echo Yii::app()->request->csrfToken ?>', contractTerm: contractTerm,benginTime:benginTime},
				success: function(data) {
					if (data) {
						$("#OfflineSignContract_end_time").val(data.endTiem);
					}
				}
			});
		});

		//编辑的时候选中方式1、2、3
		<?php
		switch($model->operation_type){
			case OfflineSignContract::OPERATION_TYPE_ONE:
		?>
		$('input[type="radio"][value="1"]').attr('checked','checked');
		<?php
			break;
			case OfflineSignContract::OPERATION_TYPE_TWO:
		?>
		$('input[type="radio"][value="2"]').attr('checked','checked');
		<?php
			break;
			case OfflineSignContract::OPERATION_TYPE_THREE:
		?>
		$('input[type="radio"][value="3"]').attr('checked','checked');
		<?php
			break;
		}
		?>

		/**
		 * 选中一种方式，设置默认广告时分，其他两种方式清空。
		 */
		var operationOne = $('#OfflineSignContract_operation_type_one');
		var operationTwo = $('#OfflineSignContract_operation_type_two');
		var operationThree = $('#OfflineSignContract_operation_type_three');
		operationOne.click(function(){
			var id = $(this).attr('id');
			clearTime(id);
		});
		operationTwo.click(function(){
			var id = $(this).attr('id');
			clearTime(id);
		});
		operationThree.click(function(){
			var id = $(this).attr('id');
			clearTime(id);
		});

		//方式一开始时间 小时
		beginHourOne = $('#OfflineSignContract_ad_begin_time_hour_one');
		beginHourOne.change(function(){
				var hourTime = parseInt(beginHourOne.val());
				var endHourTime = hourTime + 3 ;
				endHourTime = endHourTime >= 24 ? endHourTime-24 : endHourTime;
				$('#OfflineSignContract_ad_end_time_hour_one').val(endHourTime);
			}
		);

		//方式二开始时间 小时
		beginHourTwo = $('#OfflineSignContract_ad_begin_time_hour_two');
		beginHourTwo.change(function(){
				var hourTime = parseInt(beginHourTwo.val());
				var endHourTime = hourTime + 3 ;
				endHourTime = endHourTime >= 24 ? endHourTime-24 : endHourTime;
				$('#OfflineSignContract_ad_end_time_hour_two').val(endHourTime);
			}
		);

		//方式三开始时间 小时
		beginHourThree = $('#OfflineSignContract_ad_begin_time_hour_three');
		beginHourThree.change(function(){
				var hourTime = parseInt(beginHourThree.val());
				var endHourTime = hourTime + 3 ;
				endHourTime = endHourTime >= 24 ? endHourTime-24 : endHourTime;
				$('#OfflineSignContract_ad_end_time_hour_three').val(endHourTime);
			}
		);

		//方式一开始时间 分钟
		beginMinuteOne = $('#OfflineSignContract_ad_begin_time_minute_one');
		beginMinuteOne.change(function(){
				var minuteTime = parseInt(beginMinuteOne.val());
				$('#OfflineSignContract_ad_end_time_minute_one').val(minuteTime);
			}
		);

		//方式二开始时间 分钟
		beginMinuteTwo = $('#OfflineSignContract_ad_begin_time_minute_two');
		beginMinuteTwo.change(function(){
				var minuteTime = parseInt(beginMinuteTwo.val());
				$('#OfflineSignContract_ad_end_time_minute_two').val(minuteTime);
			}
		);
		//方式三开始时间 分钟
		beginMinuteThree = $('#OfflineSignContract_ad_begin_time_minute_three');
		beginMinuteThree.change(function(){
				var minuteTime = parseInt(beginMinuteThree.val());
				$('#OfflineSignContract_ad_end_time_minute_three').val(minuteTime);
			}
		);
		/**
		 * 创建的时候默认选中方式1
		 */
		<?php if($this->action->id == 'newFranchisee'):?>
		operationOne.click();
		<?php endif;?>
	});
</script>
<style>
	#OfflineSignContract_contract_term{
		height: 30px;
	}
</style>
<script>
	$(document).ready(function(){
		<?php if(isset($model) && $model->error_field):?>
		<?php $modelError = json_decode($model->error_field,true);?>
		<?php foreach($modelError as $value):?>
		var str = '<?php echo $value?>';
		str = str.replace('c.','');
		str = '#OfflineSignContract_' + str;
		$(str).addClass('red');
		$(str).prev().addClass('red');
		<?php endforeach;?>
		<?php endif;?>
	});

	/**
	 * 清空其他两种方式的广告时间
	 * @param id 选中方式的id
     */
	function clearTime(id){
		id = id.substr(id.lastIndexOf('_')+1);
		var beginHour = 'OfflineSignContract_ad_begin_time_hour_';
		var beginMinute = 'OfflineSignContract_ad_begin_time_minute_';
		var endHour = 'OfflineSignContract_ad_end_time_hour_';
		var endMinute = 'OfflineSignContract_ad_end_time_minute_';
		switch (id){
			case 'one':

				$('#'+beginHour+'one').val('0');
				$('#'+beginMinute+'one').val('0');
				beginHourOne.change();
				beginMinuteOne.change();

				$('#'+beginHour+'two').val('0');
				$('#'+beginMinute+'two').val('0');
				$('#'+endHour+'two').val('0');
				$('#'+endMinute+'two').val('0');
				$('#'+beginHour+'three').val('0');
				$('#'+beginMinute+'three').val('0');
				$('#'+endHour+'three').val('0');
				$('#'+endMinute+'three').val('0');
				break;
			case 'two':
				$('#'+beginHour+'two').val('0');
				$('#'+beginMinute+'two').val('0');
				beginHourTwo.change();
				beginMinuteTwo.change();

				$('#'+beginHour+'one').val('0');
				$('#'+beginMinute+'one').val('0');
				$('#'+endHour+'one').val('0');
				$('#'+endMinute+'one').val('0');
				$('#'+beginHour+'three').val('0');
				$('#'+beginMinute+'three').val('0');
				$('#'+endHour+'three').val('0');
				$('#'+endMinute+'three').val('0');
				break;
			case 'three':
				$('#'+beginHour+'three').val('0');
				$('#'+beginMinute+'three').val('0');
				beginHourThree.change();
				beginMinuteThree.change();


				$('#'+beginHour+'one').val('0');
				$('#'+beginMinute+'one').val('0');
				$('#'+endHour+'one').val('0');
				$('#'+endMinute+'one').val('0');
				$('#'+beginHour+'two').val('0');
				$('#'+beginMinute+'two').val('0');
				$('#'+endHour+'two').val('0');
				$('#'+endMinute+'two').val('0');
				break;
		}
	}
</script>
