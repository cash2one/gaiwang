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
                <th><?php echo $form->label($model, 'role_name'); ?></th>
                <td><?php echo $form->textField($model, 'role_name', array('class' => 'text-input-bj  least')); ?></td>
                <th><?php echo $form->label($model, 'rate'); ?></th>
                <td><?php echo $form->textField($model, 'rate', array('class' => 'text-input-bj  least')); ?></td>
            </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('offlineRole', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>