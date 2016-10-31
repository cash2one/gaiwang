<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'city_id'); ?></th>
            <td><?php echo $form->textField($model, 'city_id', array('class' => 'text-input-bj  middle')); ?></td>
            <td><?php echo CHtml::submitButton(Yii::t('franchiseeActivityCity', '搜索'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>