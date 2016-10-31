<div class="border-info search-form clearfix">
    <?php
       $form = $this->beginWidget('CActiveForm', array(
           // 'enableAjaxValidation' => true,
           'enableClientValidation' => true,
           'action' => Yii::app()->createUrl($this->route,array('id'=>$model->promotion_id)),
           'method'=>'get',
       ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'username') ?></th>
            <td><?php echo $form->textField($model, 'username', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <th><?php echo $form->label($model, 'gai_number') ?></th>
            <td><?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj  middle')); ?></td>
        </tr>
    </table>
    <table cellpadding="0" cellspacing="0" class="searchTable">
        <tr>
            <td><?php echo CHtml::submitButton(Yii:: t('member', '搜索'), array('class' => 'reg-sub')); ?></td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>

<div class="c10"></div>