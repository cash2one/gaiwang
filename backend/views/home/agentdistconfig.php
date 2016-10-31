<?php 
//代理分配比率设置 视图
/* @var $form  CActiveForm */
/* @var $model agentDistConfigForm */
?>
<style>
   th.title-th  {text-align: center;}
</style>

<?php $form = $this->beginWidget('CActiveForm',$formConfig);?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th colspan="2"  class="title-th even">
            <?php echo Yii::t('home','代理分配比率设置'); ?>
        </th>
    </tr>
    <tr>
        <th style="width: 180px">
            <?php echo $form->labelEx($model,'province');?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'province',array('class'=>'text-input-bj  least')); ?>%
            <?php echo $form->error($model,'province');?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'city');?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'city',array('class'=>'text-input-bj  least')); ?>%
            <?php echo $form->error($model,'city');?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'district');?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'district',array('class'=>'text-input-bj  least')); ?>%
            <?php echo $form->error($model,'district');?>
        </td>
    </tr>
    <tr>
        <th colspan="2"  class="title-th even">
            <?php echo Yii::t('home','手续费分配比率设置'); ?>
        </th>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'factDist');?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'factDist',array('class'=>'text-input-bj  least')); ?>%
            <?php echo $form->error($model,'factDist');?>（<?php echo Yii::t('home','指拿出来进行分配的比率，剩余的进入盖网通'); ?>）
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'factProvince');?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'factProvince',array('class'=>'text-input-bj  least')); ?>%
            <?php echo $form->error($model,'factProvince');?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'factCity');?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'factCity',array('class'=>'text-input-bj  least')); ?>%
            <?php echo $form->error($model,'factCity');?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'factDistrict');?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'factDistrict',array('class'=>'text-input-bj  least')); ?>%
            <?php echo $form->error($model,'factDistrict');?>
        </td>
    </tr>
    <tr>
        <th>
            <?php echo $form->labelEx($model,'factPerson');?>：
        </th>
        <td>
            <?php echo $form->textField($model, 'factPerson',array('class'=>'text-input-bj  least')); ?>%
            <?php echo $form->error($model,'factPerson');?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton(Yii::t('home','保存'),array('class'=>'reg-sub'))?>
        </td>
    </tr>
    </tbody>
</table>

<?php $this->endWidget(); ?>
