<?php
/* @var $this GuestbookController */
/* @var $model Guestbook */
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
            <th align="right"><?php echo $form->label($model, 'goodsName'); ?>：</th>
            <td><?php echo $form->textField($model, 'goodsName', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'gai_number'); ?>：</th>
            <td><?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'reply'); ?>：</th>
            <td>
                <?php echo $form->radioButtonList($model, 'reply', Guestbook::isReply(), array('separator' => '')) ?>
            </td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th align="right"><?php echo $form->label($model, 'status'); ?>：</th>
            <td>
                <?php echo $form->radioButtonList($model, 'status', Guestbook::status(), array('separator' => '')) ?>
            </td>
        </tr>
    </table>
    <?php echo CHtml::submitButton(Yii::t('guestbook', '搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>

</div>