<?php
$form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
        ));
?>
<div class="border-info clearfix">
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
            <tr>
                <th><?php echo $form->label($model, 'rate_plan_name'); ?>：</th>
                <td><?php echo $form->textField($model, 'rate_plan_name', array('class' => 'text-input-bj  middle')); ?></td>
            </tr>
        </tbody>
    </table>




    <div class="row buttons">
        <td><?php echo CHtml::submitButton(Yii::t('hotel', '搜索'), array('class' => 'regm-sub')); ?></td>
    </div>
    <div class="c10"></div>
</div>
<?php $this->endWidget(); ?>