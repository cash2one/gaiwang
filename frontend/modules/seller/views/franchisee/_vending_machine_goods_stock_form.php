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

	<table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt10 sellerT3">
		<tbody>
		 <tr>
				<th width="20%"><?php echo Yii::t('sellerFranchisee','商品名称'); ?></th>
				<td width="80%">
					<?php echo $model->name; ?>
				</td>
			</tr>
			
			<tr>
				<th><?php echo Yii::t('sellerFranchisee','售价'); ?></th>
				<td>
					￥<?php echo $model->price; ?>
				</td>
			</tr>
			
			
			<tr>
				<th><?php echo Yii::t('sellerFranchisee','入\出库数量'); ?></th>
				<td>
					<?php echo $form->textField($model, 'stock_num', array('class' => 'inputtxt1','style'=>'width:300px;')); ?>
            		<?php echo $form->error($model, 'stock_num'); ?>
				</td>
			</tr>

			<!-- 
			<tr>
				<th><?php echo Yii::t('sellerFranchisee','是否减去\加上商城库存？'); ?></th>
				<td>
					<?php echo $form->checkBox($model, "update_mall") ?>
            		<?php echo $form->error($model, 'update_mall'); ?>
				</td>
			</tr>
			 -->
		</tbody>
	</table>
	<?php $this->endWidget(); ?>
	
	<div class="profileDo mt15">
		<a href="javascript:void(0);" class="sellerBtn03" onclick="$('#franchisee-vending-machine-goods-form').submit();"><span><?php echo $model->isNewRecord?Yii::t('sellerFranchisee', '添加'):Yii::t('sellerFranchisee', '确定');  ?></span></a>&nbsp;&nbsp;<a href="javascript:history.go(-1);" class="sellerBtn01"><span><?php echo Yii::t('sellerFranchisee','返回'); ?></span></a>
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
var onSelectGoods = function (id,name) {
    if (id) {
        $('#VendingMachineGoods_goods_id').val(id);
        $('#RefGoodsName').val(name);
		$('#VendingMachineGoods_name').val(name);
    }
};
", CClientScript::POS_HEAD);
?>
