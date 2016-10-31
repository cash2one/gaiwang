<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchisee-artile-form',
//    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
		<tbody><tr>
				<th width="10%"><?php echo $form->labelEx($model, 'title'); ?></th>
				<td width="90%">
					<?php echo $form->textField($model, 'title', array('class' => 'inputtxt1','style'=>'width:300px;')); ?>
            		<?php echo $form->error($model, 'title'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo $form->labelEx($model, 'thumbnail'); ?><span class="required">*</span></th>

				<td>
					<p><a href="javascript:void(0);" onclick="show_upload()" class="sellerBtn02"><span><?php echo Yii::t('sellerFranchisee','设置LOGO'); ?></span></a>
					<?php echo CHtml::activeFileField($model, 'thumbnail',array('id'=>'upfile','style'=>'display:none;')); ?> 
					&nbsp;&nbsp;
					<a href="javascript:void(0);" class="sellerBtn02" onclick="reset_upload()"><span><?php echo Yii::t('sellerFranchisee','重置'); ?></span></a>
					&nbsp;&nbsp;<span class="gray"><?php echo Yii::t('sellerFranchisee','(请上传640*250像素的图片)'); ?></span></p>
					<p class="mt10">
					<?php 
					if (!$model->isNewRecord){
						echo CHtml::hiddenField('oldImg', $model->thumbnail);
						echo CHtml::image(ATTR_DOMAIN . DS . $model->thumbnail, $model->title, array('width' => '640px', 'height' => '250px'));
					}
					?>
					</p>
					
					<script>
						function show_upload(){
							$("#upfile").show();
		
					    }
		
					    function reset_upload(){
					    	$("#upfile").val('');
					    	$("#upfile").hide();
						}
					
					</script>
					
				</td>
				
			</tr>
			<tr>
				<th><?php echo $form->labelEx($model, 'external_links'); ?></th>
				<td>
					<?php echo $form->textField($model, 'external_links', array('class' => 'inputtxt1','style'=>'width:300px;')); ?>
            		<?php echo $form->error($model, 'external_links'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo $form->labelEx($model, 'views'); ?></th>
				<td>
					<?php echo $model->views*1; ?>
            		<?php echo $form->error($model, 'views'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo $form->labelEx($model, 'status'); ?></th>
				<td>
					<?php echo $form->radioButtonList($model, 'status', FranchiseeArtile::status(), array('separator' => '')); ?>
            		<?php echo $form->error($model, 'status'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo $form->labelEx($model, 'content'); ?></th>
				<td id="contend_td">
					<?php
		            $this->widget('comext.wdueditor.WDueditor', array(
		                'model' => $model,
		                'attribute' => 'content',
		            ));
		            ?>
		            <?php echo $form->error($model, 'content'); ?>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="profileDo mt15">
		<a href="javascript:void(0);" class="sellerBtn03" onclick="$('#franchisee-artile-form').submit();"><span><?php echo $model->isNewRecord?Yii::t('sellerFranchisee', '添加'):Yii::t('sellerFranchisee', '确定');  ?></span></a>&nbsp;&nbsp;<a href="javascript:history.go(-1);" class="sellerBtn01"><span><?php echo Yii::t('sellerFranchisee','返回'); ?></span></a>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
//处理输入框提示错误的问题
$("#contend_td").mouseout(function(){
	var str=$(window.frames["baidu_editor_0"].document).find('body').find('p').html();
	if(str==undefined) str=$(document.getElementById("baidu_editor_0").contentDocument).find('body').find('p').html();
	if(str==undefined) return false;
	if(str=='<br>') str = ' ';
	$("#FranchiseeArtile_content").html(str);
	$("#FranchiseeArtile_content").blur();
});
</script>
