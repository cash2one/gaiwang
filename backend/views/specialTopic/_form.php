<?php
/* @var $this SpecialTopicController */
/* @var $model SpecialTopic */
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
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('translateIdentify', '基本信息'); ?></th>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'name'); ?></th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th width="100" class="odd"><?php echo $form->labelEx($model, 'summary'); ?></th>
        <td>
            <?php echo $form->textArea($model, 'summary', array('class' => 'text-input-bj  text-area')); ?>
            <?php echo $form->error($model, 'summary'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'views'); ?></th>
        <td><?php echo isset($model->views) ? $model->views : 0; ?></td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'thumbnail'); ?></th>
        <td>
            <?php echo $form->fileField($model, 'thumbnail'); ?>
            <?php echo $form->error($model, 'thumbnail', array(), false); ?>
            <span><font color='red'>请上传小于2M的文件图片</font></span>
            <?php
            if (!$model->isNewRecord)
                echo CHtml::image(ATTR_DOMAIN . '/' . $model->thumbnail, '', array('width' => '220px', 'height' => '170px'));
            ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'start_time'); ?></th>
        <td>
            <?php
            if ($model->isNewRecord) {
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'start_time',
                    'options' => array(
                    ),
                    'htmlOptions' => array(
                        'class' => 'datefield text-input-bj middle hasDatepicker',
                    )
                ));
                echo $form->error($model, 'start_time');
            } else {
                echo "{$model->start_time}";
            }
            ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'end_time'); ?></th>
        <td>
            <?php
            if ($model->isNewRecord) {
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'end_time',
                    'options' => array(
                    ),
                    'htmlOptions' => array(
                        'class' => 'datefield text-input-bj middle hasDatepicker'
                    )
                ));
                echo $form->error($model, 'end_time');
            } else {
                echo "{$model->end_time}";
            }
            ?>
            <?php echo $form->error($model, 'end_time'); ?>
        </td>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'discount'); ?></th>
        <td>
            <?php echo $form->textField($model, 'discount', array('class' => 'text-input-bj  least')); ?>%
            <?php echo $form->error($model, 'discount'); ?>
        </td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('translateIdentify', 'SEO优化信息'); ?></th>
    </tr>
    <tr>
        <th style="width: 160px"><?php echo $form->labelEx($model, 'title'); ?></th>
        <td>
            <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 160px"><?php echo $form->labelEx($model, 'keywords'); ?></th>
        <td>
            <?php echo $form->textField($model, 'keywords', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'keywords'); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 160px"><?php echo $form->labelEx($model, 'description'); ?></th>
        <td>
            <?php echo $form->textField($model, 'description', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </td>
    </tr>
    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('specialTopic', '添加') : Yii::t('specialTopic', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
