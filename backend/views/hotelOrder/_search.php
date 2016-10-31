<?php
/**
 * @var $this HotelOrderController
 * @var $model HotelOrder
 * @var $form CActiveForm
 */
$action = $this->getAction()->getId();
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'hotel-order-form',
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
));
?>
    <div class="border-info clearfix search-form">
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tbody>
            <tr>
                <th align="right"><?php echo $form->label($model, 'code'); ?></th>
                <td><?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  middle')); ?></td>
            </tr>
            </tbody>
        </table>
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tbody>
            <tr>
                <th align="right"><?php echo $form->label($model, 'hotelName'); ?></th>
                <td><?php echo $form->textField($model, 'hotelName', array('class' => 'text-input-bj  middle')); ?></td>
            </tr>
            </tbody>
        </table>
        <?php if ($action != 'checkingList'): ?>
            <table cellpadding="0" cellspacing="0" class="searchTable">
                <tbody>
                <tr>
                    <th align="right"><?php echo $form->label($model, 'memberNumber'); ?></th>
                    <td><?php echo $form->textField($model, 'memberNumber', array('class' => 'text-input-bj  middle')); ?></td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if ($action == 'admin' || $action == 'checkList'): ?>
            <table cellpadding="0" cellspacing="0" class="searchTable">
                <tbody>
                <tr>
                    <th align="right"><?php echo ($action == 'admin'|| $action == 'checkList')  ? $form->label($model, 'settled_time') : $form->label($model, 'complete_time'); ?></th>
                    <td>
                        <?php
                            $this->widget('comext.timepicker.timepicker', array(
                                'model' => $model,
                                'name' => 'startTime',
                                'select' => 'date',
                            ));
                        ?> -
                        <?php
                            $this->widget('comext.timepicker.timepicker', array(
                                'model' => $model,
                                'name' => 'endTime',
                                'select' => 'date',
                            ));
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" class="searchTable">
                <tbody>
                <tr>
                    <th align="right"><?php echo $form->label($model, 'create_time') ?></th>
                    <td>
                        <?php
                        $this->widget('comext.timepicker.timepicker', array(
                            'model' => $model,
                            'name' => 'createTimeStart',
                            'select' => 'date',
                        ));
                        ?> -
                        <?php
                        $this->widget('comext.timepicker.timepicker', array(
                            'model' => $model,
                            'name' => 'createTimeEnd',
                            'select' => 'date',
                        ));
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if ($action == 'admin'): ?>
            <table cellpadding="0" cellspacing="0" class="searchTable">
                <tbody>
                <tr>
                    <th align="right"><?php echo Yii::t('hotelOrder', '总价格'); ?></th>
                    <td>
                        <?php echo $form->textField($model, 'minPrice', array('class' => 'text-input-bj  least')); ?> -
                        <?php echo $form->textField($model, 'maxPrice', array('class' => 'text-input-bj  least')); ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" class="searchTable">
                <tbody>
                <tr>
                    <th align="right"><?php echo $form->label($model, 'status'); ?></th>
                    <td>
                        <?php echo $form->radioButtonList($model, 'status', HotelOrder::getOrderStatus(), array('empty' => Yii::t('hotelOrder', '全部'), 'separator' => '')); ?>
                    </td>
                </tr>
                </tbody>
            </table>
            <table cellpadding="0" cellspacing="0" class="searchTable">
                <tbody>
                <tr>
                    <th align="right"><?php echo $form->label($model, 'timeout'); ?></th>
                    <td><?php echo $form->checkBox($model, 'timeout') ?></td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if ($action == 'admin' || $action == 'newList'): ?>
            <table cellpadding="0" cellspacing="0" class="searchTable">
                <tbody>
                <tr>
                    <th align="right"><?php echo $form->label($model, 'pay_status'); ?></th>
                    <td>
                        <?php echo $form->radioButtonList($model, 'pay_status', HotelOrder::getPayStatus(), array('empty' => Yii::t('hotelOrder', '全部'), 'separator' => '')); ?>
                    </td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <?php if ($action == 'newList' || $action == 'verifyList'): ?>
            <table cellpadding="0" cellspacing="0" class="searchTable">
                <tbody>
                <tr>
                    <th align="right"><?php echo $form->label($model, 'sortWay'); ?>：</th>
                    <td id="tdOrder">
                        <?php echo $form->dropDownList($model, 'sortWay', HotelOrder::getSortWay(), array('separator' => '', 'class' => 'text-input-bj middle')); ?>
                    </td>
                </tr>
                </tbody>
            </table>
        <?php endif; ?>
        <div class="c10"></div>
        <?php echo CHtml::submitButton(Yii::t('hotelOrder', '搜索'), array('class' => 'reg-sub')); ?>
    </div>
<?php $this->endWidget(); ?>

<?php
    Yii::app()->clientScript->registerCss('colorCss', "
        .tab-reg td.textColor_blue     { color: blue }
        .tab-reg td.textColor_fuchsia  { color: fuchsia }
        .tab-reg td.textColor_red      { color: red }
        .tab-reg td.textColor_green    { color: green }
    ");
?>