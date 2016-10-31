<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<div class="seachToolbar">

    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
        <tbody>
            <tr>
                <th width="10%"><?php echo Yii::t('sellerOrder', '订单编号'); ?>：</th>
                <td width="12%"><?php echo $form->textField($model, 'code', array('style' => 'width:90%', 'class' => "inputtxt1")); ?></td>
                <th width="10%"><?php echo Yii::t('sellerOrder', '商品名称'); ?>：</th>
                <td width="12%"><?php echo $form->textField($model, 'goods_name', array('style' => 'width:90%', 'class' => "inputtxt1")); ?></td>
                <th width="10%"><?php echo Yii::t('sellerOrder', '下单时间'); ?>：</th>
                <td width="20%">
                    <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'create_time',
                        'options' => array(
                            'dateFormat' => Yii::t('sellerOrder','yy-mm-dd'),
                            'changeMonth' => true,
                            'changeYear' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt1',
							'style' => 'width:35%',
                        )
                    ));
                    ?>  -  <?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $model,
                        'attribute' => 'end_time',
                        'language' => 'zh_cn',
                        'options' => array(
                            'dateFormat' => Yii::t('sellerOrder','yy-mm-dd'),
                            'changeMonth' => true,
                            'changeYear' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => 'readonly',
                            'class' => 'inputtxt1',
							'style' => 'width:35%',
                        )
                    ));
                    ?>
                </td>
                <td width="26%"> <?php echo CHtml::submitButton(Yii::t('sellerOrder', '搜索'), array('class' => 'sellerBtn06')); ?> &nbsp;&nbsp;
                <?php echo CHtml::button(Yii::t('sellerOrder', "导出EXCEL"),array('class'=>'sellerBtn07','onclick'=>'getExcel()'))?>
            </tr>
            <tr>
                <th><?php echo Yii::t('sellerOrder', '状态'); ?>：</th>
                <td colspan="6">
                    <?php echo $form->radioButtonList($model, 'status', Order::status(), array('separator' => '　 '))
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

</div>
<?php $this->endWidget(); ?>