<?php
Yii::app()->clientScript->registerScript('search', "
$('#machineMonitorAgent-form').submit(function(){
        var ajaxRequest = $(this).serialize();
        $.fn.yiiListView.update(
                'MachineMonitorAgent-listview',
                {data: ajaxRequest}
            )
	return false;
});
");
?>
<div class="wide form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
    	'id' => 'machineMonitorAgent-form',
        'method' => 'get',
    ));
    ?>
    <div class='panel'>
        <table cellpadding='0' cellspacing='0' class='searchTable'>
            <tr>
                <td class='align-right'><?php echo $form->label($model, 'machine_name'); ?>：</td>
                <td>
                    <?php echo $form->textField($model, 'machine_name', array('id' => 'txtMachineName', 'size' => 56, 'maxlength' => 56, 'class' => 'inputbox width200')); ?>
                    <?php echo $form->hiddenField($model, 'status', array('id' => 'appStatus', 'size' => 56, 'maxlength' => 56, 'value' => 2)); ?>
                </td>
                <td class="align-right"> <?php echo $form->label($model, 'create_time'); ?>：</td>
                <td>
                    <?php echo $form->textField($model, 'create_time', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox width150', 'onfocus' => "WdatePicker()")); ?>-
                    <?php echo $form->textField($model, 'create_time_end', array('size' => 10, 'maxlength' => 10, 'class' => 'inputbox width150', 'onfocus' => "WdatePicker()")); ?>
                </td>
                <td colspan="2">
                    &nbsp;&nbsp;<?php echo CHtml::submitButton('Search', array('value' => Yii::t('Public','搜索'), 'class' => 'button_04', 'id' => 'btn_search')); ?>
                </td>
            </tr>
        </table>
    </div>
    <?php $this->endWidget(); ?>
</div>