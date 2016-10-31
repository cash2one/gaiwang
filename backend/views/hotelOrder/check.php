<?php

/**
 * @var $this HotelOrderController
 * @var $model HotelOrder
 * @var CActiveForm $form
 */
$this->breadcrumbs = array(
    Yii::t('hotelOrder', '酒店订单') => array('admin'),
    Yii::t('hotelOrder', '酒店订单核对'),
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
    $form = $this->beginWidget('CActiveForm', array(
        'id' => $this->id . '-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => "js:function(form, data, hasError) {
                if (hasError == false) {
                    var msg = '" . Yii::t('hotelOrder', '该订单供货价：') . "￥' + $('#HotelOrder_unit_gai_price').val();
                    return !confirm(msg) ? false : true;
                }
            }"
        ),
    ));
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
        <caption class=" title-th"><?php echo Yii::t('hotelOrder', '核对酒店供货商信息'); ?></caption>
        <tbody>
        <tr>
            <th class="even"><?php echo $form->labelEx($model, 'price_radio'); ?>：</th>
            <td class="even">
                <?php echo $form->textField($model, 'price_radio', array('class' => 'text-input-bj middle', 'onkeyup' => 'change();')); ?>
                <?php echo $form->error($model, 'price_radio'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'unit_gai_price'); ?>：</th>
            <td class="odd">
                <?php echo $form->textField($model, 'unit_gai_price', array('class' => 'text-input-bj middle', 'onkeyup' => 'change();')); ?>
                <?php echo $form->error($model, 'unit_gai_price'); ?>
            </td>
        </tr>
        <tr>
            <th class="even"><?php echo $form->labelEx($model, 'hotel_provider_id'); ?>：</th>
            <td class="even">
                <?php
                    echo $form->dropDownList($model, 'hotel_provider_id', HotelProvider::getProviderOptions(),
                        array('prompt' => Yii::t('hotelOrder', '请选择供应商'), 'class' => 'text-input-bj middle valid')
                    );
                ?>
                <?php echo $form->error($model, 'hotel_provider_id'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'check_remark'); ?>：</th>
            <td class="odd">
                <?php echo $form->textArea($model, 'check_remark', array('class' => 'text-input-bj text-area', 'style' => 'width: 400px;')) ?>
                <?php echo $form->error($model, 'check_remark'); ?>
            </td>
        </tr>
        <tr>
            <th class="even"></th>
            <td class="even">
                <?php echo CHtml::submitButton(Yii::t('hotelOrder', '提交'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
        </tbody>
    </table>
<?php $this->endWidget(); ?>