<?php
//发送邮件设置 视图
/* @var $form  CActiveForm */
?>
<style>
    th.title-th  {text-align: center;}
</style>
<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
        <tr>
            <th style="width: 180px">
                <?php echo $form->labelEx($model, 'host'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'host', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'host'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 180px">
                <?php echo $form->labelEx($model, 'port'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'port', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'port'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 180px">
                <?php echo $form->labelEx($model, 'fromMail'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'fromMail', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'fromMail'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 180px">
                <?php echo $form->labelEx($model, 'fromName'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'fromName', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'fromName'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 180px">
                <?php echo $form->labelEx($model, 'username'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'username', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'username'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 180px">
                <?php echo $form->labelEx($model, 'password'); ?>：
            </th>
            <td>
                <?php echo $form->passwordField($model, 'password', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </td>
        </tr>
        <tr>
            <th style="width: 180px">
                <?php echo $form->labelEx($model, 'identity'); ?>：
            </th>
            <td>
                <?php echo $form->radioButtonList($model,'identity',$model::identity(),array('separator'=>''))?>
                <?php echo $form->error($model, 'identity'); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')) ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
