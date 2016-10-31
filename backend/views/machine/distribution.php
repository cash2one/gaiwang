<?php
$this->breadcrumbs = array(
    Yii::t('machine', '加盟商管理 ') => array('admin'),
    Yii::t('machine', '利益分配'),
);

$form = $this->beginwidget('CActiveForm',array('id'=>'machine-Distribution',
					//'action'=>Yii::app()->createURL(),
		            'htmlOptions' => array('enctype' => 'multipart/form-data'),
			));
?>
<table  border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
         <tr>
            <th style="width:120px">
                <?php echo $form->labelEx($model, 'offConsumeNew'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offConsumeNew', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offConsumeNew'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offRefNew'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offRefNew', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offRefNew'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offRegion'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offRegion', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offRegion'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offProvince'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offProvince', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offProvince'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offCity'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offCity', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offCity'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offDistrict'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offDistrict', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offDistrict'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offMachineLine'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offMachineLine', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offMachineLine'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offMachineOperation'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offMachineOperation', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offMachineOperation'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'gateMachineRef'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'gateMachineRef', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'gateMachineRef'); ?>
            </td>
        </tr>
        <tr>
            <th>
                <?php echo $form->labelEx($model, 'offManeuver'); ?>：
            </th>
            <td>
                <?php echo $form->textField($model, 'offManeuver', array('class' => 'text-input-bj  least')); ?>%
                <?php echo $form->error($model, 'offManeuver'); ?>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')) ?>
            </td>
        </tr>
    </tbody>
</table>
<?php 
$this->endwidget();
?>
