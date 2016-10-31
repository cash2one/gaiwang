
<div class="border-info search-form clearfix">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'name') ?></th>
            <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'gai_number') ?></th>
            <td><?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <?php echo $form->hiddenField($model,'referrals_id',array('class' => 'text-input-bj  middle')); ?>
    <?php echo CHtml::submitButton(Yii:: t('store', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>
</div>

<div class="c10"></div>

