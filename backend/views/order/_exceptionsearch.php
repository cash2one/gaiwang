<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>
<?php $form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>

    <div class="border-info clearfix">
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody>
            <tr>
                <th>
                    <?php echo Yii::t('order','异常状态'); ?>：
                </th>
                <td id="tdStatus">
                    <?php echo $form->radioButtonList($model, 'exception',
                        array(
                            Yii::t('order', '下单未支付'),
                            Yii::t('order', '支付未发货'),
                            Yii::t('order', '发货未签收')
                        ),array('separator'=>' ')); ?>
                </td>
            </tr>
            </tbody>
        </table>
        <table cellspacing="0" cellpadding="0" class="searchTable">
            <tbody>
            <tr>
                <th>
                    <?php echo Yii::t('order','异常时间'); ?>：
                </th>
                <td>
                    <?php echo $form->textField($model,'exception_time',array(
                        'class'=>'datefield text-input-bj least','onkeyup'=>'value=value.replace(/[^\d]/g,\'\')')) ?>
                    <?php echo Yii::t('order','天'); ?>
                </td>
            </tr>
            </tbody>
        </table>
        <?php echo CHtml::submitButton(Yii::t('order','搜索'),array('class'=>'reg-sub')) ?>
    </div>
<?php $this->endWidget(); ?>