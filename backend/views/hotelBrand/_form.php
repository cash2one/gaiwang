<?php
/**
 * @var HotelBrandController $this
 * @var HotelBrand $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th width="120px">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right">
            <?php echo $form->label($model, 'logo', array('required' => true)); ?>：
        </th>
        <td>
            <?php echo $form->FileField($model, 'logo', array('class' => 'text-input-bj middle')); ?>
            <?php if (!$model->isNewRecord): ?>
                <?php echo CHtml::hiddenField('oldImg', $model->logo)?>
                <?php
                    echo CHtml::image(Tool::showImg(ATTR_DOMAIN . "/" . $model->logo, "c_fill,h_80,w_100"), $model->name, array('width' => 100, 'height' => 80));
                ?>
            <?php endif; ?>
            <?php echo $form->error($model, 'logo', array(), false); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right">
            <?php echo $form->labelEx($model, 'description'); ?>：
        </th>
        <td>
            <?php echo $form->textArea($model, 'description', array('class' => 'text-area text-area2')); ?>
            <?php echo $form->error($model, 'description'); ?>
        </td>
    </tr>
    <tr>
        <th width="130px" align="right">
            <?php echo $form->labelEx($model, 'sort'); ?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj short')); ?>
            <?php echo $form->error($model, 'sort'); ?>
            <span><font color="red">通用排序，以倒序规则形式，最大值255</font></span>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('hotelBrand', '新增') : Yii::t('hotelBrand', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr> 
</table>
<?php $this->endWidget(); ?>