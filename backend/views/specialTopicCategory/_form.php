<?php
/* @var $this SpecialTopicCategoryController */
/* @var $model SpecialTopicCategory */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come" id="tab1">
    <tr>
        <th width="100" align="right"><?php echo $form->labelEx($model, 'name'); ?></th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right"><?php echo $form->labelEx($model, 'thumbnail'); ?></th>
        <td>
            <?php echo $form->fileField($model, 'thumbnail'); ?>
            <?php echo $form->error($model, 'thumbnail', array(), false); ?>
            <span><font color='red'>请上传1200*50像素的图片</font></span>
            <?php
            if (!$model->isNewRecord)
                echo CHtml::image(ATTR_DOMAIN . '/' . $model->thumbnail, '', array('width' => '220px', 'height' => '70px'));
            ?>
        </td>
    </tr>
    <tr>
        <th width="100" align="right"><?php echo $form->labelEx($model, 'integral_ratio'); ?></th>
        <td>
            <?php echo $form->textField($model, 'integral_ratio', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'integral_ratio'); ?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('specialTopicCategory', '添加') : Yii::t('specialTopicCategory', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>