<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
        <tr>
            <th><?php echo $form->label($model, 'title'); ?>：</th>
            <td><?php echo $form->textField($model, 'title', array('class' => 'text-input-bj  least')); ?></td>
            <th><?php echo $form->label($model, 'start_time'); ?>：</th>
            <td><?php 

            $model->start_time = $model->start_time == null ? "" : date("Y-m-d H:i:s",$model->start_time);
            $this->widget('comext.timepicker.timepicker', array(
	          		'model' => $model,
	          		'name' => 'start_time',
	          		//'select'=>'date',
	          ));?></td>
            <th><?php echo $form->label($model, 'end_time'); ?>：</th>
            <td><?php
            $model->end_time = $model->end_time == null ? "" : date("Y-m-d H:i:s",$model->end_time);
            $this->widget('comext.timepicker.timepicker', array(
	          		'model' => $model,
	          		'name' => 'end_time',
	          		//'select'=>'date',
	          )); ?></td>
            <th colspan="6" class="ta_c"><?php echo CHtml::submitButton(Yii::t('apphomepicture', '搜索'), array('class' => 'reg-sub')); ?></th>
        </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div><?php
