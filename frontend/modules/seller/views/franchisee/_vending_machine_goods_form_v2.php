<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchisee-vending-machine-goods-form',
//    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>
<style>
    .regm-sub{
        border:1px solid #ccc;
        background: #fff;
        padding: 5px;
        border-radius: 3px;
        cursor: pointer;
    }
</style>
	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
		<tbody>
		
		

		 <tr>
				<th width="10%"><?php echo $form->labelEx($model, 'name'); ?></th>
				<td width="90%">
					<?php echo $form->textField($model, 'name', array('class' => 'inputtxt1','style'=>'width:300px;')); ?>
            		<?php echo $form->error($model, 'name'); ?>
				</td>
			</tr>
			
			 <tr>
				<th width="10%"><?php echo $form->labelEx($model, 'price'); ?></th>
				<td width="90%">
					<?php echo $form->textField($model, 'price', array('class' => 'inputtxt1','style'=>'width:300px;')); ?>
            		<?php echo $form->error($model, 'price'); ?>
				</td>
			</tr>
			
			
			<tr>
				<th><?php echo $form->labelEx($model, 'thumb'); ?></th>
				<td id="uploadTd">
				
					<?php if($model->isNewRecord) :?>
					<img id="thumbImg" width="400px" style="display: none" src="<?php echo $model->thumb?>" /> 
					<?php endif;?>
					
            		<?php
		                $this->widget('seller.widgets.CUploadPic', array(
		                    'attribute' => 'thumb',
		                    'model' => $model,
		                    'form' => $form,
							'upload_width' => '232',
							'upload_height' => '190',
		                    'num' => 1,
		                    'btn_value' => Yii::t('sellerFranchisee', '选择上传'),
		                    'render' => '_upload',
		                    'folder_name' => 'files',
		                    'include_artDialog' => false,
		                ));
		             ?>
		             (请上传 232*190 的图片)
		             
		             <?php echo $form->error($model, 'thumb'); ?>
				</td>
			</tr>
			
			 <script type="text/javascript">
	                	$('#_imgBut_VendingMachineGoods_thumb').mousedown(function(){
	                		$("#thumbImg").remove();
	                		$("#VendingMachineGoods_thumb").val('');
	                	});
	          </script>
			
			
			<tr>
				<th><?php echo $form->labelEx($model, 'size'); ?></th>
				<td>
					<?php echo $form->textField($model, 'size', array('class' => 'inputtxt1','style'=>'width:300px;')); ?>
            		<?php echo $form->error($model, 'size'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo $form->labelEx($model, 'status'); ?></th>
				<td>
					<?php echo $form->radioButtonList($model, 'status', VendingMachineGoods::getStatus()); ?>
            		<?php echo $form->error($model, 'status'); ?>
				</td>
			</tr>
			
		</tbody>
	</table>
	<?php $this->endWidget(); ?>
	
	<div class="profileDo mt15">
		<a href="javascript:void(0);" class="sellerBtn03" onclick="$('#franchisee-vending-machine-goods-form').submit();"><span><?php echo $model->isNewRecord?Yii::t('sellerFranchisee', '添加'):Yii::t('sellerFranchisee', '确定');  ?></span></a>&nbsp;&nbsp;<a href="<?php echo $this->createUrl('franchisee/vendingMachineGoodsList',array('mid'=>$_GET['mid'])); ?>" class="sellerBtn01"><span><?php echo Yii::t('sellerFranchisee','返回'); ?></span></a>
	</div>
	
<script type="text/javascript" language="javascript" src="<?php echo DOMAIN ?>/js/iframeTools.source.js"></script>
<?php
Yii::app()->clientScript->registerScript('franchiseeVendingMachine', "
var dialog = null;
jQuery(function($) {
    $('#seachRefMem').click(function() {
        dialog = art.dialog.open('" . $this->createAbsoluteUrl('goods/ajaxList') . "', { 'id': 'selectGoods', title: '搜索商品', width: '1000px', height: '520px', lock: true });
    })
})
 var doClose = function() {
                if (null != dialog) {
                    dialog.close();
                }
            };
var onSelectGoods = function (id,name,thumb,spec_id) {
    if (id) {
        $('#VendingMachineGoods_goods_id').val(id);
		$('#VendingMachineGoods_spec_id').val(spec_id);
        $('#RefGoodsName').val(name);
		$('#VendingMachineGoods_name').val(name);
		$('#VendingMachineGoods_thumb').val(thumb);
		$('#thumbImg').show();
		$('#thumbImg').attr('src','".IMG_DOMAIN."'+'/'+thumb);
    }
};
	                		        		
", CClientScript::POS_HEAD);
?>
