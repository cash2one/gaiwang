<?php
/* @var $this AssistantController */
/* @var $model Assistant */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

<div class="seachToolbar">
    <table width="95%" cellspacing="0" cellpadding="0" border="0" class="sellerT5">
        <tbody>
        <tr>

            <td>
                <th width="8%"><?php echo Yii::t('sellerAssistant','用户名'); ?>：</th>
            <td width="15%">
                <?php echo $form->textField($model,'username',array('class'=>'inputtxt1','style'=>'width:90%')); ?>
            </td>
            <th width="8%"><?php echo Yii::t('sellerAssistant','真实姓名'); ?>：</th>
            <td width="15%">
                <?php echo $form->textField($model,'real_name',array('class'=>'inputtxt1','style'=>'width:90%')); ?>
            </td>
            <th width="8%"><?php echo Yii::t('sellerAssistant','手机号码'); ?>：</th>
            <td>
                <?php echo $form->textField($model,'mobile',array('class'=>'inputtxt1','style'=>'width:50%')); ?>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <?php echo CHtml::submitButton(Yii::t('sellerAssistant','搜索'),array('class'=>'sellerBtn06')) ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<?php $this->endWidget(); ?>