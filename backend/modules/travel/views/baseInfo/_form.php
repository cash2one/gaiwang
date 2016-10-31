<?php
/**
 * @var $form CActiveForm
 * @var BaseInfoController $this
 * @var BaseInfo $model
 */
$this->breadcrumbs = array(
    Yii::t('baseInfo', '静态信息') => array('admin'),
    $model->isNewRecord ? Yii::t('baseInfo', '新增') : Yii::t('baseInfo', '修改')
);
?>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'baseInfo-form',
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
                align="center"><?php echo $model->isNewRecord ? Yii::t('city', '添加静态信息') : Yii::t('city', '修改静态信息'); ?></td>
        </tr>
        </tbody>
        <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'key'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'key', array('class' => 'text-input-bj  middle',)); ?>
                <?php echo $form->error($model, 'key'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'code'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle',)); ?>
                <?php echo $form->error($model, 'code'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'type'); ?>
            </th>
            <td class="odd">
                <?php echo $form->dropDownList($model, 'type', CHtml::listData(BaseInfoType::model()->findAll(array('select'=>'name,code')),'code','name'), array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'type'); ?>
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