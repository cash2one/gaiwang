<script>
    if (typeof success != 'undefined') {
        parent.location.reload();
        art.dialog.close();
    }
</script>

<?php
/** @var CActiveForm $form */
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'enterprise-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
    <table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
        <tr>
            <th style="text-align: right">
                <?php echo $form->labelEx($model, 'service_id'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'service_id', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'service_id') ?>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton(Yii::t('enterprise', '提交'), array('class' => 'reg-sub')) ?>
            </td>
        </tr>
    </table>
<?php $this->endWidget(); ?>