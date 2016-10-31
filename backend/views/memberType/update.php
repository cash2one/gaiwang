<?php
$this->breadcrumbs = array(
    Yii::t('memberType', '会员类型') => array('admin'),
    Yii::t('memberType', '编辑')
);
?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'memberType-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('memberType', '添加会员类型') : Yii::t('memberType', '修改会员类型'); ?></td></tr></tbody>
    <tbody>
        <tr><th colspan="2" class="odd"></th></tr>
        <tr>
            <th style="width: 220px" class="even"><?php echo $form->labelEx($model, 'name'); ?></th>
            <td class="even">
                <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle', 'disabled' => 'disabled')); ?>
                <?php echo $form->error($model, 'name'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'exchange'); ?></th>
            <td class="odd">
                <?php echo $form->radioButtonList($model, 'exchange', MemberType::getExchange(), array('separator' => '')); ?>
                <?php echo $form->error($model, 'exchange'); ?>
            </td>
        </tr>  
        <tr>
            <th class="even"><?php echo $form->labelEx($model, 'ratio'); ?></th>
            <td class="even">
                <?php echo $form->textField($model, 'ratio', array('class' => 'text-input-bj middle','onkeyup' => "clearNoNum(this)")); ?>
                <?php echo $form->error($model, 'ratio'); ?>
            </td>
        </tr>
        <tr>
            <th class="odd"><?php echo $form->labelEx($model, 'sort'); ?></th>
            <td class="odd">
                <?php echo $form->textField($model, 'sort', array('class' => 'text-input-bj middle')); ?>
            </td>
        </tr>

        <tr>
            <th class="odd"></th>
            <td class="odd"><?php echo CHtml::submitButton(Yii::t('memberType', '编辑'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<script language="JavaScript" type="text/javascript">
    function clearNoNum(obj){   
        obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符
        obj.value = obj.value.replace(/^\./g,"");  //验证第一个字符是数字而不是. 
        obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的.   
        obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
    }
</script>

