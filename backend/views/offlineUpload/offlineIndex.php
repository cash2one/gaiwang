<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/common.js" type="text/javascript"></script>
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/agent.css" rel="stylesheet" type="text/css">
<link href="<?php echo AGENT_DOMAIN; ?>/agent/css/reg.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery-1.5.1.min.js"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/jquery.artDialog.js?skin=blue" type="text/javascript"></script>
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/artDialog.iframeTools.js" type="text/javascript"></script>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'enctype'=>'multipart/form-data'
    ),
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
));
?>
上传文件：
<?php echo $form->fileField($model,'fileName')?>
<?php echo $form->error($model,'fileName')?>
<input type="submit" value="上传">
<?php if($error == 0):?>
    <div>上传成功</div>
    <input id="errorInfo" value="0" type="hidden" />
    <input id="urlInfo" value="<?php echo $url?>" type="hidden" />
    <input id="oldFileName" value="<?php echo $oldFileName?>" type="hidden" />
    <input id="newFileName" value="<?php echo $newFileName?>" type="hidden" />
<?php elseif($error == 1):?>
    <div>上传失败，请重新上传</div>
    <input id="errorInfo" value="1" type="hidden" />
<?php elseif($error == 2):?>
    <input id="errorInfo" value="2" type="hidden" />
<?php endif;?>
<?php $this->endWidget(); ?>
