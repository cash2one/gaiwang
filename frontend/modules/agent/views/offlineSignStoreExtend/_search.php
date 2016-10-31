<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */
/* @var $form CActiveForm */
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.panel form').submit(function(){
        var ajaxRequest = $(this).serialize();
        $.fn.yiiListView.update(
                'machine-advert-list',
                {data: ajaxRequest}
            )
	return false;
});
");
?>
<style>
	/*a#xxxxx{*/
	/*display: inline;*/
	/*padding: 4px;*/


	/*}*/

	a#xxxxx{
		display:inline;
		padding:3px 12px;
	}
	@-moz-document url-prefix() {
		a#xxxxx {
			padding:4px 12px;
		}
	}
</style>
<div class="wide form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>$this->createUrl('OfflineSignStoreExtend/admin'),
		'method'=>'get',
	)); ?>
	<table cellspacing="0" cellpadding="0" class="searchTable">
		<tbody>
        <?php echo CHtml::hiddenField("status",$model->status,array('id'=>'status'))?>
        <?php echo CHtml::hiddenField("apply_type",$model->apply_type,array('id'=>'apply_type'))?>
		<tr>
			<th><?php echo $form->label($model,'enTerName',array('for'=>'AppAdvert_name'))?></th>
			<td><?php echo $form->telField($model,'enTerName',array('class'=>'text-input-bj'))?></td>
			<td><?php echo CHtml::submitButton(Yii::t('Public', '搜索'), array('class' => 'btn-sign')); ?></td>
			<td><?php echo CHtml::link(Yii::t('OfflineSignStore','+ 新建签约'),array('OfflineSignStoreExtend/selectCreate'),array('id'=>'xxxxx','class'=>'btn-sign'))?></td>
		</tr>
		</tbody>
	</table>
	<?php $this->endWidget(); ?>

</div><!-- search-form -->