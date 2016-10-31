<?php
$this->breadcrumbs = array(
    '军旅专题红包奖励' => array('votered'),
    '红包奖励'
);
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
            <input class="text-input-bj" name="Vote[member_id]" id="Vote_member_id" type="hidden">
        </tr>
    </table>

    <?php echo CHtml::submitButton('红包奖励', array('class' => 'regm-sub')); ?>
    <?php $this->endWidget(); ?>
</div>