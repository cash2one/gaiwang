<?php

/**
 * @var $this HotelOrderController
 * @var $model HotelOrder
 * @var $form CActiveForm
 */
$this->breadcrumbs = array(
    Yii::t('hotelOrder', '酒店订单') => array('admin'),
    Yii::t('hotelOrder', '酒店订单确认'),
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
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => "js:function(form, data, hasError) {
                if (!hasError) {
                    var msg = '" . Yii::t('hotelOrder', '该订单供货价：') . "￥' + $('#HotelOrder_unit_gai_price').val();
                    if (!confirm(msg)) { return false };
                    {validJs}
                }
            }"
        ),
    ));
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab-come">
        <caption class=" title-th"><?php echo Yii::t('hotelOrder', '确认酒店供货单价(元/每间每晚)'); ?></caption>
        <tbody>
        <tr>
            <th class="even"><?php echo $form->labelEx($model, 'settled_time'); ?>：</th>
            <td class="even">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'settled_time',
                    'language' => 'zh_cn',
                    'options' => array(
                        'defaultDate' => '+1w',
                        'dateFormat' => 'yy-mm-dd',
                        'numberOfMonths' => 2,
                        'changeMonth' => true,
                        'minDate' => date('Y-m-d'),
                    ),
                    'htmlOptions' => array(
                        'value' => date('Y-m-d', $model->settled_time),
                        'class' => 'text-input-bj middle',
                        'readonly' => 'readonly',
                        'onchange' => 'change();',
                    )
                ));
                ?>
                <?php echo $form->error($model, 'settled_time'); ?>
            </td>
            <th class="even"><?php echo $form->labelEx($model, 'leave_time'); ?>:</th>
            <td class="even">
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'leave_time',
                    'language' => 'zh_cn',
                    'options' => array(
                        'defaultDate' => '+1w',
                        'dateFormat' => 'yy-mm-dd',
                        'numberOfMonths' => 2,
                        'changeMonth' => true,
                        'minDate' => date('Y-m-d', strtotime('+1day')),
                    ),
                    'htmlOptions' => array(
                        'value' => date('Y-m-d', $model->leave_time),
                        'class' => 'text-input-bj middle',
                        'readonly' => 'readonly',
                        'onchange' => 'change();',
                    )
                ));
                ?>
                <?php echo $form->error($model, 'leave_time'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'rooms'); ?>：</th>
            <td class="odd" colspan="3">
                <?php echo $form->textField($model, 'rooms', array('class' => 'text-input-bj middle', 'onchange' => 'change();')); ?>
                <?php echo $form->error($model, 'rooms'); ?>
            </td>
        </tr>
        <tr>
            <th class="even"><?php echo Yii::t('hotelOrder', '入住酒店(可选)'); ?>：</th>
            <td class="even" colspan="3">
                <input type="hidden" value="0" id="p_flag_id">
                <?php echo $form->labelEx($model, 'hotel_id'); ?>：
                <?php echo $form->dropDownList($model, 'hotel_id', array(), array('class' => 'text-input-bj  middle valid', 'id' => 'hotel_options_box')); ?>
                <?php echo $form->labelEx($model, 'room_id'); ?>：
                <?php echo $form->dropDownList($model, 'room_id', array(), array('class' => 'text-input-bj  middle valid', 'id' => 'room_options_box')); ?>&nbsp;&nbsp;
                <?php echo Yii::t('hotelOrder', '该客房单价'); ?> ：￥<span id="room_unit_price" class="jf"><?php echo $model->unit_price; ?></span>&nbsp;&nbsp;
                <?php echo Yii::t('hotelOrder', '该订单总价'); ?> ：￥<span id="order_total_price" class="jf"><?php echo $model->total_price; ?></span>
                <?php echo $form->error($model, 'hotel_id', array('inputID' => 'hotel_options_box')); ?>
                <?php echo $form->error($model, 'room_id', array('inputID' => 'room_options_box')); ?>
                <?php echo $form->hiddenField($model, 'unit_price'); ?>
                <?php echo $form->error($model, 'unit_price'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><?php echo Yii::t('hotelOrder', '变更数据'); ?>：</th>
            <td class="odd" colspan="3">
                <?php echo Yii::t('hotelOrder', '客房差额'); ?>：￥<span id="room_chae" class="jf">0</span>&nbsp;&nbsp;
                <?php echo Yii::t('hotelOrder', '总价差额'); ?>: ￥<span id="total_chae" class="jf">0</span>&nbsp;&nbsp;
                <?php echo Yii::t('hotelOrder', '应退还'); ?>：￥<span id="return_chae" class="jf">0</span>
            </td>
        </tr>
        <tr>
            <th class="even"><?php echo $form->labelEx($model, 'price_radio'); ?>：</th>
            <td class="even" colspan="3">
                <?php echo $form->textField($model, 'price_radio', array('class' => 'text-input-bj middle', 'onkeyup' => 'change();')); ?>
                <?php echo $form->error($model, 'price_radio'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'unit_gai_price'); ?>：</th>
            <td class="odd" colspan="3">
                <?php echo $form->textField($model, 'unit_gai_price', array('class' => 'text-input-bj middle', 'onkeyup' => 'change();')); ?>
                <?php echo $form->error($model, 'unit_gai_price', array(), true, $model->is_lottery == HotelOrder::IS_LOTTERY_NO); ?>
            </td>
        </tr>
        <tr>
            <th class="even"><?php echo HotelRoom::model()->getAttributeLabel('estimate_back_credits'); ?>：</th>
            <td class="even" colspan="3">
                <?php echo $model->room->estimate_back_credits * HotelCalculate::liveDays($model->leave_time, $model->settled_time); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><?php echo $form->label($model, 'amount_returned'); ?>：</th>
            <td class="odd" colspan="3">
                <span id="return_integeal">
                    <font color="red"><?php echo Common::convertSingle($model->amount_returned, $model->member->type_id); ?></font>
                </span>
            </td>
        </tr>
        <tr>
            <th class="even"><?php echo $form->labelEx($model, 'hotel_provider_id'); ?>：</th>
            <td class="even" colspan="3">
                <?php
                    echo $form->dropDownList($model, 'hotel_provider_id', HotelProvider::getProviderOptions(),
                        array('prompt' => Yii::t('hotelOrder', '请选择供应商'), 'class' => 'text-input-bj middle valid')
                    );
                ?>
                <?php echo $form->error($model, 'hotel_provider_id'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"></th>
            <td class="odd" colspan="3"><?php echo CHtml::submitButton(Yii::t('hotelOrder', '提交'), array('class' => 'reg-sub')); ?></td>
        </tr>
        </tbody>
    </table>
    <script type="text/javascript" language="javascript" src="js/iframeTools.source.js"></script>
    <script type="text/javascript">
        function change() {
            jQuery.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo Yii::app()->createAbsoluteUrl('/hotelOrder/roomChange', array('id' => $model->id)); ?>',
                data: $('#hotelOrder-form').serialize(),
                success: function (res, textStatus, jqXHR) {
                    if (res) {
                        $('#room_chae').text(res.room_chae);
                        $('#total_chae').text(res.total_chae);
                        $('#return_chae').text(res.return_chae);
                        $('#order_total_price').text(res.total_price);
                        $('#return_integeal font').text(res.integeal);
                        ChangeData = res.hotel_data;
                        OptionsChange('p_flag_id', 'hotel_options_box', res.hotel_id);
                        OptionsChange('hotel_options_box', 'room_options_box', res.room_id);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(errorThrown)
                },
                cache: false
            });
        }
    </script>
<?php $this->endWidget(); ?>
<?php
    Yii::app()->clientScript->registerScript('HotelVerify', "

        $(function () {
            OptionsChange('p_flag_id', 'hotel_options_box', '" . $model->hotel_id . "');
            OptionsChange('hotel_options_box', 'room_options_box', '" . $model->room_id . "');
            RoomChange();

            $('#hotel_options_box').change(function(){
                OptionsChange('hotel_options_box', 'room_options_box');
                RoomChange();
            });

            $('#room_options_box').change(function(){
                RoomChange();
            });
        });

        var ChangeData = " . $hotelScope . ";
        var RoomChange = function () {
            var flag = $('#room_options_box').val();
            for (var i = 0; i < ChangeData.length; i++) {
                if (ChangeData[i].id == flag && ChangeData[i].price != 0) {
                    $('#room_unit_price').text(ChangeData[i].price);
                    $('#HotelOrder_unit_gai_price').val(ChangeData[i].estimatePrice);
                }
            }
            change();
        };

        var OptionsChange = function (flagId, wrap, selected) {
            var options = [];
            var flag = $('#' + flagId).val();
            for (var i = 0; i < ChangeData.length; i++) {
                if (ChangeData[i].flag == flag) {
                    if (selected && selected == ChangeData[i].id) {
                        options.push('<option selected=\'selected\' value =\"' + ChangeData[i].id + '\">' + ChangeData[i].name + '</option>');
                    } else {
                        options.push('<option value =\'' + ChangeData[i].id + '\'>' + ChangeData[i].name + '</option>');
                    }
                }
            }
            $('#' + wrap).html('');
            $('#' + wrap).html(options.join('')).attr('style', 'zoom:1');
            delete options;
            options = null;
        };


    ", CClientScript::POS_HEAD);
?>