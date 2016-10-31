<?php
/**
 * @var ViewSpotController $this
 * @var ViewSpot $model
 * @var CActiveForm $form
 */
$form = $this->beginWidget('CActiveForm', array(
    'method' => 'get',
));
?>
<div class="border-info clearfix">
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tbody>
        <tr>
            <th><?php echo $form->label($model, 'name'); ?>：</th>
            <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?></td>

            <th><?php echo $form->label($model, 'name_en'); ?>：</th>
            <td><?php echo $form->textField($model, 'name_en', array('class' => 'text-input-bj  middle')); ?></td>

            <td><?php echo CHtml::submitButton(Yii::t('citycard', '查询'), array('class' => 'regm-sub')); ?></td>
        </tr>
        </tbody>
    </table>
</div>
<?php $this->endWidget(); ?>
