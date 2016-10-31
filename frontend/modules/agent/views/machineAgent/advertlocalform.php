<link rel="stylesheet" type="text/css" href="<?php echo AGENT_DOMAIN.'/agent'; ?>/css/machine.css?v=1" /> 
<div class="ctx">
    <div class="optPanel">
        <div class="toolbar img01">
			<?php echo Yii::t('machine', "编辑本地视频广告");?>
	        <?php echo CHtml::link(Yii::t('Public', '返回'),$this->createUrl('machineAgent/advertList',array('id'=>$machine_id,'adtype'=>MachineAdvertAgent::ADVERT_TYPE_VEDIO)),array('class'=>'button_05 floatRight'))?>
        </div>
    </div>
    <div class="ctxTable">
        <img id="imgSource" alt="<?php echo Yii::t('Public','原图');?>" src="" style="display:none;position:absolute;" />
		<?php 
        	Yii::app()->clientScript->registerScript('search', "
			$('#machine-advert-form').submit(function(){
		        $('#thumbnail_id').val($('".FileManageAgent::VALUE_NAME."thumbnail_id').val());
		        $('#file_id').val($('".FileManageAgent::VALUE_NAME."file_id').val());
				return true;
			});
			");
			$form=$this->beginWidget('CActiveForm', array(
				'id'=>'machineAdvertAgent-form',
				'enableAjaxValidation'=>true,
				'enableClientValidation'=>true,
			)); 
		?>
		
		<table width="100%" border="0" cellspacing="1" cellpadding="0" class="inputTable">
			<tbody>
			<tr class="caption">
				<td colspan="2"><?php Yii::t('Public', '基本信息')?></td>
		   	</tr>
			<tr>
				<td class="c1 width200"><?php echo $form->label($model, 'title')?>：</td>
				<td>
					<?php echo $form->textField($model, 'title', array('class'=>'inputbox  width200'))?><span class="required">*</span>
					<?php echo $form->error($model,'title'); ?>
				</td>
			</tr>
            <tr>
                <td class="c1"><?php echo $form->label($model, 'description')?>：</td>
                <td>
                	<?php echo $form->textArea($model, 'description', array('class'=>'inputarea width400','rows'=>3,'cols'=>2))?><span class="required">*</span>
					<?php echo $form->error($model,'description'); ?>
                </td>
            </tr>
            
            <tr>
            	<td class="c1"><?php echo $form->label($model,'coupon_name')?>：</td>
            	<td>
            		<?php echo $model->coupon_name;?>
            	</td>
            </tr>
            
            <tr>
                <td class="c1"><?php echo $form->label($model, 'use_status')?>：</td>
                <td>
                	<?php echo $model->use_status==1?Yii::t('Public','使用中'):Yii::t('Public','未使用');?>
                </td>
            </tr>
            <tr>
                <td class="c1"><?php echo $form->label($model, 'sort')?>：</td>
                <td>
                	<?php echo $form->textField($model, 'sort', array('class'=>'inputbox width200'))?><span class="required">*</span>
					<?php echo $form->error($model,'sort'); ?>
                </td>
            </tr>
		    
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    <div class="align-center">
    	<?php echo CHtml::submitButton($model->isNewRecord?Yii::t('Public', '添加'):Yii::t('Public', '保存'),array('class'=>'button_04'))?>&nbsp;&nbsp;&nbsp;
        <?php echo CHtml::link(Yii::t('Public', '返回'),$this->createUrl('machineAgent/advertList',array('id'=>$machine_id,'adtype'=>MachineAdvertAgent::ADVERT_TYPE_VEDIO)),array('class'=>'button_04'))?>
    </div>
<?php $this->endWidget();?>   
</div>
</div>