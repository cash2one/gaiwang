<?php
Yii::app()->clientScript->registerScript('search', "
$('#filemanage-search-form form').submit(function(){
        var ajaxRequest = $(this).serialize();
        $('#myShow').hide().html('');
        $.fn.yiiListView.update(
                'filemanage_list',
                {data: ajaxRequest}
            )
	return false;
});
");
?>
<style>
.search { height:40px; margin: 0 0 0 12px;}
.search ul li{ float:left; line-height:35px; padding:3px;}
/* 文本框 */
.inputbox { border:1px solid #b5b8c8;color:#333;height:24px;line-height:24px;margin-right:10px;padding:0px 5px;background:#fff url(/agent/images/textboxbg.jpg) repeat-x;}
</style>
<div class="wide form" id="filemanage-search-form" style="margin:0 0 0 7px;border:1px solid #ccc;width:560px;">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action'=>$this->createUrl($this->route),
		'method'=>'get',
	)); ?>
		<div class="search">
			<ul>
				<li><?php echo $form->dropDownList($model,'create_time',FileManageAgent::getFileQueryDate());?></li>
				<li><?php echo $form->textField($model,'filename',array('class'=>'inputbox'))?></li>
				<li><?php echo CHtml::submitButton(Yii::t('FileManage', '搜索'),array('class'=>'submit_button01'))?></li>
			</ul>
		</div>
		<div style="clear:both;"></div>
	<?php $this->endWidget(); ?>
</div>