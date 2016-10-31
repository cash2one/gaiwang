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
            <th><?php echo $form->label($model, 'name'); ?>：</th>
            <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  least')); ?></td>
            <th><?php echo $form->label($model, 'order'); ?>：</th>
            <td><?php echo $form->textField($model, 'order', array('class' => 'text-input-bj  least')); ?></td>
            <th><?php echo $form->label($model, 'is_publish'); ?>：</th>
            <td><?php echo $form->dropDownList($model, 'is_publish', AppHotCategory::getPublish(), array('prompt' => '全部')); ?></td>
            <th colspan="6" class="ta_c"><?php echo CHtml::submitButton(Yii::t('franchisee', '搜索'), array('class' => 'reg-sub')); ?></th>
        </tr>
        </tbody>
    </table>
    <?php $this->endWidget(); ?>
</div>
