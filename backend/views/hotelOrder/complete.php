<?php
/**
 * @var $this HotelOrderController
 * @var $model HotelOrder
 * @var $form CActiveForm
 */
$this->breadcrumbs = array(
    Yii::t('hotelOrder', '酒店订单') => array('admin'),
    Yii::t('hotelOrder', '完成酒店订单'),
);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
    <caption class=" title-th"><?php echo Yii::t('hotelOrder', '酒店基本信息'); ?></caption>
    <tbody>
        <tr>
            <th class="even"><?php echo $model->getAttributeLabel('code'); ?>：</th>
            <td class="even"><?php echo $model->code; ?></td>
            <th class="even"><?php echo Hotel::model()->getAttributeLabel('name'); ?>:</th>
            <td class="even"><?php echo $model->hotel_name; ?></td>
            <th class="even"><?php echo HotelRoom::model()->getAttributeLabel('name'); ?>：</th>
            <td class="even"><?php echo $model->room_name; ?></td>
        </tr>
        <tr>
            <th class="odd"><?php echo $model->getAttributeLabel('unit_price'); ?>:</th>
            <td class="odd"><span class="jf">¥<?php echo $model->unit_price; ?></span></td>
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
            <th class="odd"><?php echo $model->getAttributeLabel('is_lottery'); ?>：</th>
            <td class="odd"><?php echo HotelOrder::getIsLottery($model->is_lottery); ?></td>
        </tr>
        <tr>
            <th class="even"><?php echo $model->getAttributeLabel('unit_gai_price'); ?>：</th>
            <td class="even"><span class="jf">¥<?php echo $model->unit_gai_price; ?></span></td>
            <th class="even"><?php echo $model->getAttributeLabel('confirm_time'); ?>：</th>
            <td class="even"><?php echo date('Y-m-d H:i:s', $model->confirm_time); ?></td>
            <th class="even"><?php echo Yii::t('hotelOrder', '自动完成时间'); ?>：</th>
            <td class="even">
                <?php
                $autoComplete = $this->getConfig('hotelparams', 'autoComplete');
                echo date('Y-m-d H:i:s', $model->confirm_time + (86400 * $autoComplete));
                ?>
            </td>
        </tr>
    </tbody>
</table>
<div class="c10">
</div>
<?php
$form = $this->beginWidget('ActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
    <caption class=" title-th"><?php echo Yii::t('hotelOrder', '确认客户入住时间'); ?></caption>
    <tbody>
        <tr>
            <th class="even"><?php echo $model->getAttributeLabel('live_time'); ?>：</th>
            <td class="even">
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'id' => 'HotelOrder_live_time',
                    'model' => $model,
                    'name' => 'live_time',
                    'select' => 'datetime',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth' => true,
                    ),
                ));
                ?>
                <?php echo $form->error($model, 'live_time'); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="odd">
                <?php echo $form->hiddenField($model, 'confirm_time'); ?>
                <?php echo CHtml::submitButton(Yii::t('hotelOrder', '提交'), array('class' => 'reg-sub')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>