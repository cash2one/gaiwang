<?php
//发送邮件设置 视图
/* @var $form  CActiveForm */
?>
<style>
    th.title-th  {text-align: center;}
    .long{width:200px;}
    .tab-come td{ text-align: center; position: relative;}
    .txtarea{width:300px;}
</style>
<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <thead>
        <tr class="tab-reg-title">
            <th class="title-th" style="width:8%"><?php echo Yii::t('home', '级别')?></th>
            <th class="title-th" style="width:50%"><?php echo Yii::t('home', '红包金额')?></th>
            <th class="title-th" style="width:30%;text-align:left"><?php echo Yii::t('home', '百分比')?></th>
        </tr>
    </thead>   
       <tbody>
        <tr>
            <td style="width:8%">1</td>
            <td  style="width:50%">
                <?php echo $form->textField($model, 'money1', array('class' => 'text-input-bj long')); ?>
                <?php echo $form->error($model, 'money1'); ?>
            </td>
            <td style="width:30%;text-align: left">
                <?php echo $form->textField($model, 'ratio1', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'ratio1'); ?>
            </td>
        </tr>
        <tr>
            <td style="width:8%">2</td>
            <td  style="width:40%">
                <?php echo $form->textField($model, 'money2', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'money2'); ?>
            </td>
            <td style="text-align:left;width:40%">
                <?php echo $form->textField($model, 'ratio2', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'ratio2'); ?>
            </td>
        </tr>
        <tr>
            <td>3</td>
            <td>
                <?php echo $form->textField($model, 'money3', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'money3'); ?>
            </td>
            <td style="text-align:left">
                <?php echo $form->textField($model, 'ratio3', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'ratio3'); ?>
            </td>
        </tr>
        <tr>
            <td>4</td>
            <td>
                <?php echo $form->textField($model, 'money4', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'money4'); ?>
            </td>
            <td style="text-align:left">
                <?php echo $form->textField($model, 'ratio4', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'ratio4'); ?>
            </td>
        </tr>
        <tr>
            <td>5</td>
            <td>
                <?php echo $form->textField($model, 'money5', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'money5'); ?>
            </td>
            <td style="text-align:left">
                <?php echo $form->textField($model, 'ratio5', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'ratio5'); ?>
            </td>
        </tr>
        <tr>
            <td>6</td>
            <td>
                <?php echo $form->textField($model, 'money6', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'money6'); ?>
            </td>
            <td style="text-align:left">
                <?php echo $form->textField($model, 'ratio6', array('class' => 'text-input-bj  long')); ?>
                <?php echo $form->error($model, 'ratio6'); ?>
            </td>
        </tr>
        <tr><td></td><td></td><td></td></tr>
        <tr>
            <td><?php echo $form->label($model, 'rules'); ?>:</td>
            <td style="text-align:left;">
                <?php echo $form->textArea($model, 'rules', array('class' => 'text-input-bj txtarea','cols'=>'60')); ?>
                <?php echo $form->error($model, 'rules'); ?>
            </td>
        </tr>
        
        <tr>
            <td colspan="3">
                <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')) ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
