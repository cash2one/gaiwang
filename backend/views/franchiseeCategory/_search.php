<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'name'); ?></th>
            <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj least')); ?></td>
            <th>&nbsp;&nbsp; 时间</th>
            <td>
                <?php
                $this->widget('comext.timepicker.timepicker', array(
                    'model' => $model,
                    'name' => 'create_time',
                ));
                ?>
                到
            </td>
            <td><?php echo CHtml::submitButton(Yii::t('franchiseeCategory', '搜索'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>