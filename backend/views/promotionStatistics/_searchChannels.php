<div class="border-info search-form clearfix">
    <?php
       $form = $this->beginWidget('CActiveForm', array(
           // 'enableAjaxValidation' => true,
           'enableClientValidation' => true,
           'action' => Yii::app()->createUrl($this->route),
           'method'=>'get',
       ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'name') ?></th>
            <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td><?php echo CHtml::submitButton(Yii:: t('member', '搜索'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>

<?php echo CHtml::button('添加渠道', array('class' => 'regm-sub', 'onclick' => 'location.href = \'' . Yii::app()->createUrl('PromotionStatistics/create') . "'")); ?>
<div class="c10"></div>