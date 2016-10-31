<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'appTopicHouse-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th style="width: 220px" class="odd">
            <?php echo $form->labelEx($model, 'title'); ?>
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
            <?php echo $form->labelEx($model, 'remark'); ?>
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'remark', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'remark'); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
            <?php echo $form->labelEx($model, 'link'); ?>
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'link', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'link'); ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right"><?php echo $form->labelEx($model, 'pictureUrl'); ?></th>
        <td>
            <?php echo $form->fileField($model, 'pictureUrl'); ?>
            <?php echo $form->error($model, 'pictureUrl', false); ?>
            *请上传不大于500K的图片，尺寸 1242*350
        </td>
    </tr>
    <tr>
        <th width="100" align="right"></th>
        <td>
            <?php
            if ($model->pictureUrl):?>
            <a onclick="return _showBigPic(this)" href="<?php echo ATTR_DOMAIN.DS.$model->pictureUrl ?>"><img style="'width' => '220px', 'height' => '70px'" src="<?php echo ATTR_DOMAIN.DS.$model->pictureUrl ?>"></a>
            <?php endif;?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right"><?php echo $form->labelEx($model, 'comHeadUrl'); ?></th>
        <td>
            <?php echo $form->fileField($model, 'comHeadUrl'); ?>
            <?php echo $form->error($model, 'comHeadUrl', false); ?>
            *请上传不大于500K的图片，尺寸 500*500
        </td>
    </tr>
    <tr>
        <th width="100" align="right"></th>
        <td>
            <?php
            if ($model->comHeadUrl):?>
                <a onclick="return _showBigPic(this)" href="<?php echo ATTR_DOMAIN.DS.$model->comHeadUrl ?>"><img style="'width' => '220px', 'height' => '70px'" src="<?php echo ATTR_DOMAIN.DS.$model->comHeadUrl ?>"></a>
            <?php endif;?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
            <?php echo $form->labelEx($model, 'description'); ?>
        </th>
        <td class="odd">
            <?php echo $form->textArea($model, 'description', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('appTopic', '保存') : Yii::t('appTopic', '更新'), array('class' => 'reg-sub','style')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>

<script src="/js/iframeTools.js" type="text/javascript"></script>
