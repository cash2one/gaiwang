<link href="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css">
<script src="<?php echo AGENT_DOMAIN; ?>/agent/js/fancybox/jquery.fancybox-1.3.4.js"></script>
<div class="t-sub">
    <a class="regm-sub" href="javascript:history.back()">返回列表</a>                                            </div>
<?php
$this->breadcrumbs = array(Yii::t('AppTopic', '专题'), Yii::t('AppTopicHouse', '添加专题图片'));
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'article-form',
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th width="100" align="right"><?php echo $form->labelEx($model, 'titlePicture'); ?></th>
        <td>
            <?php echo $form->fileField($model, 'titlePicture'); ?>
            <?php echo $form->error($model, 'titlePicture', false); ?>
             *请上传1242*160的图片
        </td>
    </tr>
    <tr>
        <th width="100" align="right"></th>
        <td>
            <?php
            if ($filePath):?>
                <a onclick="return _showBigPic(this)" href="<?php echo ATTR_DOMAIN.DS.$filePath ?>"><img style="'width' => '220px', 'height' => '70px'" src="<?php echo ATTR_DOMAIN.DS.$filePath ?>"></a>
            <?php endif;?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td><?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')); ?></td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>