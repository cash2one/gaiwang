<?php
/**
 * @var $form CActiveForm
 * @var BaseInfoTypeController $this
 * @var BaseInfoType $model
 */
$this->breadcrumbs = array(
    Yii::t('baseInfoType', '静态信息类型') => array('admin'),
    $model->isNewRecord ? Yii::t('baseInfoType', '新增') : Yii::t('baseInfoType', '修改')
);
?>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'baseInfoType-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => false,
    ),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tbody>
        <tr>
            <td colspan="2" class="title-th even"
                align="center"><?php echo $model->isNewRecord ? Yii::t('baseInfoType', '添加静态信息类型') : Yii::t('baseInfoType', '修改静态信息类型'); ?></td>
        </tr>
        </tbody>
        <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'code'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'code'); ?>

            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'name'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>

        <tr>
            <th class="odd"></th>
            <td colspan="2" class="odd">
                <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('advert', '新增') : Yii::t('advert', '保存'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>