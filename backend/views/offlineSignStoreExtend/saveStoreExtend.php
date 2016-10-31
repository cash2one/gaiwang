<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<!-- <link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css"> -->
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/uploadImg.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/pdf.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="/css/reg.css" />
<link rel="stylesheet" type="text/css" href="/css/jqtransform.css">
<script type="text/javascript" src="/js/jquery.jqtransform.js"></script>
<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */



$this->menu=array(
    array('label'=>'List OfflineSignStoreExtend', 'url'=>array('index')),
    array('label'=>'Create OfflineSignStoreExtend', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#offline-sign-store-extend-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php
if(empty($check)) {
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'offline-sign-info-update-form',
        'action' => '/?r=offline-sign-store-extend/look-data',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        ),
    ));
}else{
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'offline-sign-info-update-form',
        'action' => '/?r=offline-sign-store-extend/look-data&check=save&id='.$storeExtendId,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        ),
    ));
}

?>



<div id="confirmArea">
    <style>
        .aui_buttons{
            text-align: center;
        }
        .buttonOff{
            width: 55px;
        }
    </style>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="tab-come">
        <tbody>
        <tr class="confirmTR" style="background:#FFF;">
            <td>
                <?php echo $form->textArea($model, 'lookData', array('class' => 'input_2')); ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="c10"></div>

<div class="audit-btn">
    <input type="submit" value="保存" id="btnSignBack-s" class="btnSignBack"/>
</div>
<div class="c10"></div>
<div class="grid-view" id="article-grid"></div>
<?php $this->endWidget(); ?>