<?php
/* @var $this FranchiseeBrandController */
/* @var $model FranchiseeBrand */
/* @var $form CActiveForm */
?>

<?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'franchiseeBrand-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
//        'clientOptions' => array(
//            'validateOnSubmit' => true, //客户端验证
//        ),
    ));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo Yii::t('franchisee', '加盟商品牌编辑'); ?></td>
    </tr>
    <tr><td colspan="2" class="odd"></td></tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'name'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'pinyin'); ?>
        </th>
        <td class="odd">
            <?php echo $form->textField($model, 'pinyin', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'pinyin'); ?>
        </td>
    </tr>
    <tr>
        <th class="even">
            <?php echo $form->labelEx($model, 'sort'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'sort'); ?>
        </td>
    </tr>
    <tr>
        <th class="even"></th>
        <td colspan="2" class="even">
            <?php echo CHtml::submitButton(Yii::t('brand', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>