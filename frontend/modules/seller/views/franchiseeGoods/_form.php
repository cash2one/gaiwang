<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchiseeGoods-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>

<script type="text/javascript" src="/js/swf/js/artDialog.js?skin=blue"></script>
<script type="text/javascript" src="/js/swf/js/artDialog.iframeTools.js"></script>
<script type="text/javascript" src="/js/swf/js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
		<tbody>
		
		<tr>
	        <th><?php echo $form->labelEx($model,'franchisee_goods_category_id'); ?></th>
	        <td>
	            <?php echo $form->hiddenField($model,'franchisee_goods_category_id') ?>
	            <?php
	            if(!empty($model->franchisee_goods_category_id)){
	            
		            $cat = FranchiseeGoodsCategory::model()->findByPk($model->franchisee_goods_category_id);
		            echo $cat->name;
	            ?>
	            |
	            <?php 
	            }
	            
	            echo CHtml::link($model->isNewRecord? Yii::t('sellerGoods', '选择'):Yii::t('sellerGoods', '重新选择'), $this->createUrl('selectCategory',array('id'=>$model->id)));
	            ?>
	        </td>
    	</tr>
		
		<tr>
				<th width="10%"><?php echo $form->labelEx($model, 'name'); ?></th>
				<td width="90%">
					<?php echo $form->textField($model, 'name', array('class' => 'inputtxt1','style'=>'width:300px;')); ?>
            		<?php echo $form->error($model, 'name'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo $form->labelEx($model, 'thumbnail'); ?></th>

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
						echo CHtml::image(IMG_DOMAIN . DS . $model->thumbnail, $model->name, array('width' => '320px'));
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
	        <th><?php echo Yii::t('sellerFranchisee', '图片列表：') ?></th>
	        <td>
	            <span>请上传商品图片，最多可上传20张</span>
            	<?php 
            		$this->widget('seller.widgets.CUploadPic',array(
            			'form' => $form,
            			'model' => $model,
            			'attribute' => 'path',
            			'num' => 30,
//             			'upload_height' => 200,
//             			'upload_width' => 200,
            			'folder_name' => 'files',
            		));
            	?>
	        </td>
    	</tr>
			

			<tr>
				<th><?php echo $form->labelEx($model, 'discount'); ?></th>
				<td>
					<?php echo $form->textField($model, 'discount', array('class' => 'inputtxt1','style'=>'width:300px;')); ?>
            		<?php echo $form->error($model, 'discount'); ?>
				</td>
			</tr>

			<tr>
				<th><?php echo $form->labelEx($model, 'member_price'); ?></th>
				<td>
					<?php echo $form->textField($model, 'member_price', array('class' => 'inputtxt1','style'=>'width:300px;')); ?>
            		<?php echo $form->error($model, 'member_price'); ?>
				</td>
			</tr>


			<tr>
				<th><?php echo $form->labelEx($model, 'seller_price'); ?></th>
				<td>
					<?php echo $form->textField($model, 'seller_price', array('class' => 'inputtxt1','style'=>'width:300px;')); ?>
            		<?php echo $form->error($model, 'seller_price'); ?>
				</td>
			</tr>

			<tr>
				<th><?php echo $form->labelEx($model, 'status'); ?></th>
				<td>
					<?php echo $form->radioButtonList($model, 'status', FranchiseeGoods::getStatus(), array('separator' => '')); ?>
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
		<a href="javascript:void(0);" class="sellerBtn03" onclick="$('#franchiseeGoods-form').submit();"><span><?php echo $model->isNewRecord?Yii::t('sellerFranchiseeGoods', '添加'):Yii::t('sellerFranchiseeGoods', '确定');  ?></span></a>&nbsp;&nbsp;<a href="javascript:history.go(-1);" class="sellerBtn01"><span><?php echo Yii::t('sellerFranchisee','返回'); ?></span></a>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
//处理输入框提示错误的问题
$("#contend_td").mouseout(function(){
	var str=$(window.frames["baidu_editor_0"].document).find('body').find('p').html();
	if(str==undefined) str=$(document.getElementById("baidu_editor_0").contentDocument).find('body').find('p').html();
	if(str==undefined) return false;
	if(str=='<br>') str = ' ';
	$("#FranchiseeGoods_content").html(str);
	$("#FranchiseeGoods_content").blur();
});
</script>
