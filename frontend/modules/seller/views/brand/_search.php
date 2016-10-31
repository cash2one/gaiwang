<?php
/* @var $this BrandController */
/* @var $model Brand */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createAbsoluteUrl($this->route),
    'method' => 'post',
        ));
?>

<div class="seachToolbar">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
        <tbody><tr>
                <th width="10%"><?php echo $form->label($model, 'code'); ?>：</th>
                <td width="30%"><?php echo $form->textField($model, 'code', array('class' => 'inputtxt1', 'style' => 'width:90%')); ?></td>
                <th width="10%"><?php echo $form->label($model, 'name'); ?>：</th>
                <td width="30%"><?php echo $form->textField($model, 'name', array('class' => 'inputtxt1', 'style' => 'width:90%')); ?></td>
                <td width="20%"><?php echo CHtml::submitButton(Yii::t('sellerBrand', '搜索'), array('class' => 'sellerBtn06')); ?></td>

            </tr>
        </tbody>
    </table>
</div>
<?php $this->endWidget(); ?>


