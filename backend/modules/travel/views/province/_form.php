<?php
/**
 * @var $form CActiveForm
 * @var ProvinceController $this
 * @var Province $model
 */
$this->breadcrumbs = array(
    Yii::t('province', '省份') => array('admin'),
    $model->isNewRecord ? Yii::t('province', '新增') : Yii::t('province', '修改')
);
?>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'province-form',
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
                align="center"><?php echo $model->isNewRecord ? Yii::t('advert', '添加省份') : Yii::t('advert', '修改省份'); ?></td>
        </tr>
        </tbody>
        <tbody>
        <?php if ($model->isNewRecord || $model->creater): ?>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'nation_id'); ?>
            </th>
            <td class="odd">
                    <?php echo $form->dropDownList($model, 'nation_id', CHtml::listData(Nation::model()->findAll(),'id','name'),array('class' => 'text-input-bj  middle','prompt' => '选择国家')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <?php endif ?>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'name'); ?>
            </th>
            <td class="odd">
                <?php if (!$model->isNewRecord && !$model->creater): ?>
                    <?php echo $model->name ?>
                <?php else: ?>
                    <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle',)); ?>
                <?php endif ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'code'); ?>
            </th>
            <td class="odd">
                <?php if (!$model->isNewRecord && !$model->creater): ?>
                    <?php echo $model->code ?>
                <?php else: ?>
                    <?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle')); ?>
                <?php endif ?>
                <?php echo $form->error($model, 'code'); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'sort'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'sort'); ?>
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