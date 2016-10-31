<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'gftNopwdPayLimitSetting-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
<style type="text/css">
.tr-label{
    height:50px;
}
.label-ex{
    width:20%;
}
</style>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come" >
    <tbody>

        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'pay_limit'); ?></th>
            <td>
                <?php echo $form->textField($model, 'pay_limit', array('class' => 'text-input-bj  middle')); ?>
                <?php echo $form->error($model, 'pay_limit'); ?>
            </td>
        </tr>
   
        <tr class='.tr-label'>
            <th class='label-ex'></th>
            <td><?php 
                $butName = $model->isNewRecord ? '添加' : '编辑';
                $id = $model->isNewRecord ? 'reg_sub' : 'confirm_btn';
                echo CHtml::submitButton(Yii::t('GftNopwdPayConfig', $butName), array('class' => 'reg-sub','id'=>$id)); 
            ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
