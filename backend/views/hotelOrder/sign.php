<?php

/**
 * @var $this HotelOrderController
 * @var $model HotelOrder
 * @var $form CActiveForm
 */
$this->breadcrumbs = array(
    Yii::t('hotelOrder', '酒店订单') => array('admin'),
    Yii::t('hotelOrder', '酒店订单签收'),
);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
    <caption class=" title-th"><?php echo Yii::t('hotelOrder', '酒店基本信息'); ?></caption>
    <tbody>
    <tr>
        <th class="even"><?php echo $model->getAttributeLabel('code'); ?>：</th>
        <td class="even"><?php echo $model->code; ?></td>
        <th class="even"><?php echo $model->getAttributeLabel('hotel_name'); ?>:</th>
        <td class="even"><?php echo $model->hotel_name; ?></td>
        <th class="even"><?php echo $model->getAttributeLabel('room_name'); ?>：</th>
        <td class="even"><?php echo $model->room_name; ?></td>
    </tr>
    <tr>
        <th class="odd"><?php echo $model->getAttributeLabel('settled_time'); ?>：</th>
        <td class="odd">
            <?php
            echo Yii::t('hotelOrder', '{st} 至 {lt} 一共 {day} 天', array(
                '{st}' => date('Y-m-d', $model->settled_time),
                '{lt}' => date('Y-m-d', $model->leave_time),
                '{day}' => '<span class="jf">' . HotelCalculate::liveDays($model->leave_time, $model->settled_time) . '</span>',
            ));
            ?>
        </td>
        <th class="odd"><?php echo $model->getAttributeLabel('rooms'); ?>：</th>
        <td class="odd">共<span class="jf"><?php echo $model->rooms; ?></span>间</td>
        <th class="odd"><?php echo $model->getAttributeLabel('is_lottery'); ?>：</th>
        <td class="odd"><?php echo HotelOrder::getIsLottery($model->is_lottery); ?></td>
    </tr>
    <tr>
        <th class="even"><?php echo $model->getAttributeLabel('unit_price'); ?>：</th>
        <td class="even"><span class="jf"><?php echo HtmlHelper::formatPrice($model->unit_price); ?></span></td>
        <th class="even"><?php echo $model->getAttributeLabel('total_price'); ?>：</th>
        <td class="even"><span class="jf"><?php echo HtmlHelper::formatPrice($model->total_price); ?></span></td>
        <th class="even"></th>
        <td class="even"></td>
    </tr>
    </tbody>
</table>

<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <caption class=" title-th"><?php echo Yii::t('hotelOrder', '酒店订单签收'); ?></caption>
    <tbody>
        <tr>
            <th>签收人：</th>
            <td>
                <?php echo Yii::app()->user->name; ?>
            </td>
        </tr>
        <tr>
            <th ><?php echo $form->labelEx($model, 'sign_remark'); ?>:</th>
            <td>
                <?php echo $form->textArea($model,'sign_remark',array('rows'=>10, 'cols'=>100)); ?>
                <?php echo $form->error($model, 'sign_remark'); ?>
            </td>
        </tr>
        <tr>
            <th></th>
            <td  colspan="2" ><?php echo CHtml::submitButton(Yii::t('hotelOrder', '提交'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
