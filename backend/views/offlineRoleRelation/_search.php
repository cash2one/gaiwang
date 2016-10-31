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
            	<th><?php echo $form->label($model, 'name'); ?></th>
                <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  least')); ?></td>
                <th><?php echo $form->label($model, 'agent_gai_number'); ?></th>
                <td><?php echo $form->textField($model, 'agent_gai_number', array('class' => 'text-input-bj  least')); ?></td>
                <th><?php echo $form->label($model, 'agent_mobile'); ?></th>
                <td><?php echo $form->textField($model, 'agent_mobile', array('class' => 'text-input-bj  least')); ?></td>
            </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('offlineRoleRelation', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>