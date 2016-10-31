<?php
/* @var $this SpecValueController */
/* @var $model SpecValue */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'specValue-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('specValue', '添加商品规格值 ') : Yii::t('specValue', '修改商品规格值'); ?></td>
    </tr>
    <tr><td colspan="2" class="odd"></td></tr>
    <tr>
        <th class="even">
            <?php echo $form->labelEx($model, 'name'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <?php if ($model->spec->type == 2): ?>
        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'thumbnail'); ?>
            </th>
            <td class="odd">
                <?php echo $form->FileField($model, 'thumbnail', array('class' => 'text-input-bj middle')); ?>
                <?php if (!$model->isNewRecord): ?>
                    <input type="hidden" name="oldImg" value="<?php echo $model->thumbnail; ?>">
                    <img src="<?php echo ATTR_DOMAIN; ?>/<?php echo $model->thumbnail ?>" width="25" height="25"/>
                <?php endif; ?>
                <?php echo $form->error($model, 'thumbnail'); ?>
            </td>
        </tr>
    <?php endif; ?>
    <tr>
        <th style="width:120px" class="odd">
            <?php echo $form->labelEx($model, 'sort'); ?>
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>

    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('specValue', '新增 ') : Yii::t('specValue', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>