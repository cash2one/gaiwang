<?php
/* @var $this OfflineSignMachineBelongController */
/* @var $model OfflineSignMachineBelong */
/* @var $form CActiveForm */
?>
<?php

    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
?>

    <div class="border-info clearfix search-form">
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tbody>
            <tr>
                <th><?php echo $form->label($model, 'belong_to'); ?>：</th>
                <td><?php echo $form->textField($model, 'belong_to', array('class' => 'text-input-bj  least')); ?></td>
            </tr>
            </tbody>
        </table>
        <?php echo CHtml::submitButton(Yii::t('offlinesignmachinebelong', '搜索'), array('class' => 'reg-sub')); ?>
    </div>
    <?php $this->endWidget(); ?>