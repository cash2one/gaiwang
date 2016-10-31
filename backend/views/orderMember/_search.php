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
                <?php echo $form->textField($model,'code',array('size'=>30,'maxlength'=>60,'class'=>'text-input-bj  middle')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('order','会员GW号'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'member_id',array('size'=>11,'maxlength'=>11,'class'=>'text-input-bj  least')); ?>
            </td>
        </tr>
        </tbody></table>     
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('order','联系方式'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'mobile',array('size'=>11,'maxlength'=>11,'class'=>'text-input-bj  least')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo Yii::t('order','姓名'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model,'real_name',array('size'=>11,'maxlength'=>11,'class'=>'text-input-bj  least')); ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo $form->label($model,'create_time'); ?>：
            </th>
            <td colspan="2">
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'create_time',
                    'select'=>'date',
                ));
                ?> -
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'end_time',
                    'select'=>'date'
                ));
                ?>
            </td>
        </tr>
        </tbody></table>
    <table cellspacing="0" cellpadding="0" class="searchTable">
        <tbody><tr>
            <th align="right">
                <?php echo $form->label($model,'sex'); ?>：
            </th>
            <td colspan="2" id="tdOrderStatus">
                <?php echo $form->radioButtonList($model,'sex',$model::getMemberSex(),
                    array('empty'=>array('0'=>Yii::t('order','全部')),'separator'=>'')) ?>
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