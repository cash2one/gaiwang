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
<div class="seachToolbar" style="margin-right: 1200px">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
        <tbody>
            <tr>
                <th><?php echo Yii::t('cityShow', '城市馆标题'); ?>：</th>
                <td width="40%"><?php echo $form->textField($model, 'title', array('style' => 'width:90%', 'class' => "inputtxt1")); ?></td>
                <td width="27%"> <?php echo CHtml::submitButton(Yii::t('cityShow', '搜索'), array('class' => 'sellerBtn06')); ?> &nbsp;&nbsp;
            </tr>
        </tbody>
    </table>
</div>
<?php $this->endWidget(); ?>