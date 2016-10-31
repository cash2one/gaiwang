<?php
$this->breadcrumbs = array(
    Yii::t('advertPicture', '广告位图片') => array('admin', 'advert_id' => $model->advert_id),
    $model->isNewRecord ? Yii::t('advertPicture', '新增') : Yii::t('advertPicture', '修改')
);
?>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'advertPicture-form',
    'enableAjaxValidation' => true,
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
        <td colspan="2" class="title-th even"
            align="center"><?php echo $model->isNewRecord ? Yii::t('advertPicture', '添加广告') : Yii::t('advertPicture', '修改广告'); ?></td>
    </tr>
    </tbody>
    <tbody>
    <tr>
        <th style="width: 220px" class="odd">
            <?php echo $form->labelEx($model, 'advert_id'); ?>
        </th>
        <td class="odd">
            <?php echo $model->advert->name; ?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="even">
            <?php echo $form->labelEx($model, 'title'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
            <?php echo $form->labelEx($model, 'start_time'); ?>
        </th>
        <td class="odd">
            <?php $this->widget('comext.timepicker.timepicker', array('model' => $model, 'name' => 'start_time')); ?>
            <?php echo $form->error($model, 'start_time'); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="even">
            <?php echo $form->labelEx($model, 'end_time'); ?>
        </th>
        <td class="even">
            <?php $this->widget('comext.timepicker.timepicker', array('model' => $model, 'name' => 'end_time')); ?>
            <span><font color="red">结束时间不填则为永不过期</font></span>
            <?php echo $form->error($model, 'end_time'); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
            <?php echo $form->labelEx($model, 'status'); ?>
        </th>
        <td class="odd">
            <?php echo $form->radioButtonList($model, 'status', AdvertPicture::getStatus(), array('separator' => '')); ?>
            <?php echo $form->error($model, 'status'); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="even">
            <?php echo $form->labelEx($model, 'link'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'link', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'link'); ?>
        </td>
    </tr>

    <tr>
        <th style="width: 220px" class="odd">
            <?php echo $form->labelEx($model, 'picture'); ?>
        </th>
        <td class="odd">
            <?php echo $form->fileField($model, 'picture') ?>
            <?php echo $form->error($model, 'picture'); ?>
            <?php if (!$model->isNewRecord): ?>
                <?php echo CHtml::image(ATTR_DOMAIN . '/' . $model->picture, $model->title, array('width' => '200px')); ?>
            <?php endif; ?>
        </td>
    </tr>

    <tr>
        <th style="width: 220px" class="even">
            <?php echo $form->labelEx($model, 'background'); ?>
        </th>
        <td class="even">
            <?php
            $this->widget('comext.colorpicker.EColorPicker', array(
                    'model' => $model,
                    'attribute' => 'background',
                    'mode' => 'selector',
                    'selector' => 'colorSelector',
                    'value' => $model->background,
                    'fade' => false,
                    'slide' => false,
                    'curtain' => true,
                )
            );
            ?>
            <?php echo $form->error($model, 'background'); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
            <?php echo $form->labelEx($model, 'target'); ?>
        </th>
        <td class="odd">
            <?php echo $form->radioButtonList($model, 'target', AdvertPicture::getTarget(), array('separator' => '')); ?>
        </td>
    </tr>
    <tr>
        <th style="width: 220px" class="odd">
            <?php echo $form->labelEx($model, 'sort'); ?>
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj  middle')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('advertPicture', '新增') : Yii::t('advertPicture', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        toggleTr($('input[name="Advert[direction]"]:checked').val());
    });
    function toggleTr(value) {
        $("#cityTr").hide();
        $("#categoryTr").hide();
        if (value === '1') {
            $("#cityTr").show();
        } else if (value === '2') {
            $("#categoryTr").show();
        }
    }
</script>