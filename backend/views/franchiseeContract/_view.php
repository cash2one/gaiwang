<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchiseeContract-form',
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
        <tr> <th colspan="2" style="text-align: center" class="title-th"><?php echo Yii::t('franchisee', '查看补充协议用户'); ?></th></tr>

        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'member_name'); ?></th>
            <td>
                <?php echo CHtml::textField('member_name', $model->member_name, array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
            </td>
        </tr>  

        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'gai_number'); ?></th>
            <td>
                <?php echo CHtml::textField('gai_number', $model->gai_number, array('class' => 'text-input-bj middle', 'readonly' => 'true')); ?>
            </td>
        </tr>  

        <tr class='.tr-label'>
            <th class="odd label-ex"><label class="required"><?php echo Yii::t('franchiseecontract', '合同版本'); ?> <span class="required">*</span></label></th>
            <td>
            	<?php echo CHtml::textField('contract_type', Contract::showType($model->contract_type), array('class' => 'text-input-bj ', 'readonly' => 'true')); ?>
            	<?php echo CHtml::textField('contract_version', $model->contract_version, array('class' => 'text-input-bj ', 'readonly' => 'true')); ?>
            </td>
        </tr>

        <tr class='.tr-label'>
            <th class='label'><?php echo $form->labelEx($model, 'number'); ?></th>
            <td>
                <?php echo $form->textField($model, 'number', array('class' => 'text-input-bj  middle','readonly' => 'true')); ?>
            </td>
        </tr>

        <tr class='.tr-label'>
            <th class='label'><?php echo $form->labelEx($model, 'protocol_no'); ?></th>
            <td>
                <?php echo $form->textField($model, 'protocol_no', array('class' => 'text-input-bj  middle','readonly' => 'true')); ?>
            </td>
        </tr>

        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'a_name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'a_name', array('class' => 'text-input-bj  middle','readonly' => 'true')); ?>
            </td>
        </tr>
        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'a_address'); ?></th>
            <td>
                <?php echo $form->textField($model, 'a_address', array('class' => 'text-input-bj  middle','readonly' => 'true')); ?>
            </td>
        </tr>
         <tr  class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'b_name'); ?></th>
            <td>
                <?php echo $form->textField($model, 'b_name', array('class' => 'text-input-bj  middle','readonly' => 'true')); ?>
            </td>
        </tr>
        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'b_address'); ?></th>
            <td>
                <?php echo $form->textField($model, 'b_address', array('class' => 'text-input-bj  middle','readonly' => 'true')); ?>
            </td>
        </tr>
        <tr class='.tr-label'>
            <th class='label-ex'><?php echo $form->labelEx($model, 'original_contract_time'); ?></th>
            <td>
            	<?php echo $form->textField($model, 'original_contract_time', array('class' => 'text-input-bj  middle','readonly' => 'true','readonly' => 'true')); ?>
               
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>

