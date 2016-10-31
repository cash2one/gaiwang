<?php
/* @var $this PrepaidCardController */
/* @var $model PrepaidCard */
/* @var $form CActiveForm */
?>
<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'member_id'); ?></th>
            <td><?php echo $form->textField($model, 'member_id', array('class' => 'text-input-bj  least')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'use_time'); ?></th>
            <td>
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'use_time',
                    'language' => 'zh_cn',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth' => true,
                    ),
                    'htmlOptions' => array(
                        'readonly' => 'readonly',
                        'class' => 'text-input-bj  least',
                    )
                ));
                ?> -
                <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'endTime',
                    'language' => 'zh_cn',
                    'options' => array(
                        'dateFormat' => 'yy-mm-dd',
                        'changeMonth' => true,
                    ),
                    'htmlOptions' => array(
                        'readonly' => 'readonly',
                        'class' => 'text-input-bj  least',
                    )
                ));
                ?>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'value'); ?></th>
            <td>
                <?php echo $form->textField($model, 'value', array('class' => 'text-input-bj  least')); ?> -
                <?php echo $form->textField($model, 'maxValue', array('class' => 'text-input-bj  least')); ?>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>            
                <th><?php echo $form->label($model, 'mobile'); ?></th>
                <td><?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj  least')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <?php if ($this->action->id !== 'detail'): ?>
                <th><?php echo $form->label($model, 'owner_id'); ?></th>
                <td><?php echo $form->textField($model, 'owner_id', array('class' => 'text-input-bj  least')); ?></td>
            </tr>
        </table>    
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tr>
                <th><?php echo $form->label($model, 'is_recon'); ?></th>
                <td><?php echo $form->radioButtonList($model, 'is_recon', PrepaidCard::getRecon(), array('separator' => '', 'empty' => Yii::t('prepaidCard', '全部'))); ?></td>
            <?php endif; ?>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td><?php echo CHtml::submitButton(Yii::t('prepaidCard', '搜索'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>