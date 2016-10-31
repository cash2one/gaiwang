<?php
/* @var $this MachineController */
/* @var $model Machine */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'machine-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('machine', '添加推荐者 ') : Yii::t('machine', '修改推荐者'); ?></td>
    </tr>
    <tr><td colspan="2" class="odd"></td></tr>
    <?php foreach ($role as $val):?>
    <tr>
        <th class="even" style="width:120px">
            <label for="Machine_ROLE_GATEWANG"><?php echo $val['role_name']?></label>        
        </th>
        <td class="even">
            <input type="text" value="<?php echo isset($val['value']) ? $val['value'] : ''?>"  name="Machine[<?php echo $val['role_id']?>]" class="text-input-bj middle">
        </td>
    </tr>
    <?php endforeach;?>   
    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton(Yii::t('machine', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>          

<?php $this->endWidget(); ?>
