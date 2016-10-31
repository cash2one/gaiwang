<?php
$this->breadcrumbs=array(
Yii::t('GameStore','店铺管理')=> array('view'),
Yii::t('GameStore','游戏公告'),
);
?>

<div class="toolbar">
    <h3><?php echo Yii::t('GameStore','游戏公告'); ?></h3>
</div>
<h3 class="mt15 tableTitle"><?php echo Yii::t('sellerFranchisee','游戏公告信息'); ?></h3>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'gameStore-form',
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
				<th><?php echo $form->labelEx($model, 'content'); ?></th>
				<td id="contend_td">
					<?php
//                    echo $form->textField($model, 'content', array('class' => 'inputtxt1','style'=>'width:300px;'));
                    $this->widget('ext.editor.WDueditor', array(
                        'model' => $model,
                        'base_url' => 'http://seller.'.SHORT_DOMAIN,
                        'attribute' => 'content',
                        'save_path' => 'uploads/files', //默认是'attachments/UE_uploads'
                        'url' => IMG_DOMAIN . '/files' //默认是ATTR_DOMAIN.'/UE_uploads'
                    ));
		            ?>
		            <?php echo $form->error($model, 'content'); ?>
				</td>
			</tr>
        <tr>
            <th width="10%"><?php echo $form->labelEx($model, 'status'); ?></th>
            <td width="90%">
                <?php echo $form->checkBox($model, 'status', array('class' => 'inputtxt1')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </td>
        </tr>
		</tbody>
	</table>
	<div class="profileDo mt15">
		<a href="javascript:void(0);" class="sellerBtn03" onclick="$('#gameStore-form').submit();">
            <span><?php echo Yii::t('sellerFranchisee', '确定');  ?></span>
        </a>
        &nbsp;&nbsp;<a href="javascript:history.go(-1);" class="sellerBtn01"><span><?php echo Yii::t('sellerFranchisee','返回'); ?></span></a>
	</div>

<?php $this->endWidget(); ?>

<script type="text/javascript">
//处理输入框提示错误的问题
$("#contend_td").mouseout(function(){
	var str=$(window.frames["baidu_editor_0"].document).find('body').html();
	if(str==undefined) str=$(document.getElementById("baidu_editor_0").contentDocument).find('body').html();
	if(str==undefined) return false;
	if(str=='<br>') str = ' ';
	$("#GameNotice_content").html(str);
	$("#GameNotice_content").blur();
    $("#edui1_wordcount").hide();
});

</script>
