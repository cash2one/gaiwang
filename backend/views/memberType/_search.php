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
                <th><?php echo $form->label($model, 'exchange'); ?></th>
                <td><?php echo $form->dropDownList($model, 'exchange', MemberType::getExchange(),  array('empty' => Yii::t('memberType', '选择是否兑换'), 'class' => 'text-input-bj middle')); ?></td>
            </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('memberType', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>