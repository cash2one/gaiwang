<?php
/**
 * @var RatePlanController $this
 * @var HotelRatePlan $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('ActiveForm', array(
    'id' => 'ratePlan-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, // 客户端验证
    ),
));
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th class="title-th even" colspan="2" style="text-align: center;"><?php echo Yii::t('hotel', '基本信息及属性'); ?></th>
    </tr>
            <?php echo $form->hiddenField($model, 'hotel_id', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->hiddenField($model, 'room_id', array('class' => 'text-input-bj long')); ?>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'rate_plan_name'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'rate_plan_name', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'rate_plan_name'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'bed_type'); ?>：</th>
        <td>
            <?php echo $form->dropDownList($model, 'bed_type', BaseInfo::getBaseInfo('BedTypeCode'),array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'bed_type'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'commend_level'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'commend_level', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'commend_level'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'pay_method'); ?>：</th>
        <td>
            <?php echo $form->dropDownList($model, 'pay_method',BaseInfo::getBaseInfo('PaymethodCode') ,array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'pay_method'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'supply_name'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'supply_name', array('class' => 'text-input-bj long')); ?>
            <?php echo $form->error($model, 'supply_name'); ?>
        </td>
    </tr>
    <tr>
        <th width="120px" align="right"><?php echo $form->labelEx($model, 'notices'); ?>：</th>
        <td>
            <?php echo $form->textField($model, 'notices', array('class' => 'text-input-bj long')); ?><span>(即为取消条款)</span>
            <?php echo $form->error($model, 'notices'); ?>
        </td>
    </tr>




    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton($model->isNewRecord ? '新增' : '保存', array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
