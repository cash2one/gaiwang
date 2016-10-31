<?php 
	$cs = Yii::app()->clientScript;
	$baseUrl = AGENT_DOMAIN.'/agent';
	
	$cs->registerScriptFile($baseUrl. "/js/artDialog.js?skin=blue");
	$cs->registerScriptFile($baseUrl. "/js/artDialog.iframeTools.js");				//弹出框调用远程文件插件
?>
<script>
//绑定加盟商
function selectBizName(){
	art.dialog.open("<?php echo $this->createUrl('productAgent/showBiz')?>",{
		title: "<?php echo Yii::t('Franchisee','选择加盟商')?>",
		lock: true,
		width: 880,
		height: 610,
		init:function(){},
	        okVal: '<?php echo Yii::t('Public','确定')?>',	
                ok:function(){
			var iframe = this.iframe.contentWindow;
			if(!iframe.document.body){
				alert("iframe还没有加载完毕!");
				return false;
			}
			var biz_id = $(iframe.document.getElementById('franchisee-grid')).find('input[class="select-on-check"]:checked').val();

			if(biz_id==<?php echo $model->id?>){
				alert("<?php echo Yii::t('Franchisee','不能选择自己')?>!");
				return false;
			}
				
			if(biz_id){
				$.post(
					"<?php echo CHtml::normalizeUrl(array('productAgent/getBizInfo'))?>",
					{"<?php echo Yii::app()->request->csrfTokenName?>": "<?php echo Yii::app()->request->csrfToken?>",id:biz_id},
					function(data){
						$("#Auditing_parent_id").val(biz_id);
						$("#biz_name").val(data.name);
					},
					"json"
				);
			}
		},
                cancelVal: '<?php echo Yii::t('Public','取消')?>',
		cancel:true
	});
}
</script>
<div class="line container_fluid">
    <div class="row_fluid line">
        <div class="vip_title red">
            <p class="unit fl"><?php echo Yii::t('Franchisee', '编辑加盟商关键信息')?></p>
        </div>
        <div class="line table_white">
        	<?php 
        		$form=$this->beginWidget('CActiveForm', array(
					'id'=>'franchiseeAgent-form',
					'enableAjaxValidation'=>true,
					'enableClientValidation'=>true,
				)); 
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table5">
                    <tr class="table1_title" bgcolor="#fcfcfc">
                        <td colspan="2"><?php echo Yii::t('Franchisee', '审核信息')?></td>
                    </tr>
                    <tr>
                        <td width="12%" align="right"><?php echo Yii::t('Franchisee','状态')?>：</td>
                        <td width="88%" align="left" class="table_form_right"><?php echo Auditing::getStatus($model->status)?></td>
                    </tr>
                    <tr class="table1_title" bgcolor="#fcfcfc">
                        <td colspan="2"><?php echo Yii::t('Franchisee','加盟商关键信息')?></td>
                    </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'apply_name'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'apply_name',array('class'=>'input_box')); ?><span style="color: Red" class="fl">* </span>
								<?php echo $form->error($model,'apply_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'alias_name'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'alias_name',array('class'=>'input_box')); ?><span style="color: Red" class="fl">* </span>
								<?php echo $form->error($model,'alias_name'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'member_id'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'member_id',array('class'=>'input_box')); ?><span style="color: Red" class="fl">* </span>
								<?php echo $form->error($model,'member_id'); ?>
								<p class="unit tips tips_icon1"><?php echo Yii::t('Franchisee', '请输入完整的会员编号')?></p>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'parent_id'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->hiddenField($model,'parent_id',array('class'=>'input_box','readonly'=>true)); ?>
								<?php echo CHtml::textField('Auditing[parentname]',$model->parentname,array('id'=>'biz_name','class'=>'input_box','readonly'=>true));?>
								<?php echo CHtml::button(Yii::t('Public', '搜索'),array('class'=>'btn1 btn_large13','onclick'=>'selectBizName()'))?>
								<?php echo $form->error($model,'parent_id'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'max_machine'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'max_machine',array('class'=>'input_box')); ?>
								<?php echo $form->error($model,'max_machine'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'gai_discount'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'gai_discount',array('class'=>'input_box')); ?><span class="fl">%</span> <span class="fl" style="color: Red">*</span>
								<?php echo $form->error($model,'gai_discount'); ?>
                                <p class="unit tips tips_icon1"><?php echo Yii::t('Franchisee','请输入0-100')?></p>
                            </td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo $form->label($model,'member_discount'); ?>：</td>
                            <td align="left" class="table_form_right">
								<?php echo $form->textField($model,'member_discount',array('class'=>'input_box')); ?><span class="fl">%</span> <span class="fl" style="color: Red">*</span>
								<?php echo $form->error($model,'member_discount'); ?>
                                <p class="unit tips tips_icon1"><?php echo Yii::t('Franchisee','请输入0-100')?></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo CHtml::submitButton(Yii::t('Franchisee','暂存'),array('class'=>'btn1 btn_large03','id'=>'wait','name'=>'wait'))?>
                                <?php echo CHtml::submitButton(Yii::t('Franchisee', '申请'),array('class'=>'btn1 btn_large13','id'=>'apply','name'=>'apply')); ?>
                            </td>
                        </tr>
                </table>
		<?php $this->endWidget(); ?>      
		</div>
    </div>
</div>