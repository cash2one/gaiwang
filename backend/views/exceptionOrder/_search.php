<?php
/* @var $this OrderController */
/* @var $model Order */
/* @var $form CActiveForm */
?>
<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>
<div class="border-info clearfix">
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo $form->label($model,'code'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>64,'class'=>'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody></table>
   
    <div class="c10">
    </div>
    <?php echo CHtml::submitButton('搜索',array('class'=>'reg-sub')) ?>
</div>
<div class="c10">
</div>
<?php $this->endWidget(); ?>
<script>
    $(":input[name$=create]").addClass('least').removeClass('middle');
</script>