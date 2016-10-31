<?php
/** @var $model CashHistoryConfigForm */
/** @var $form CActiveForm */
?>

<?php $form = $this->beginWidget('CActiveForm', $formConfig); ?>
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr>
        <th colspan="2" style="text-align: center" class="title-th">
            <?php echo Yii::t('home', '白名单'); ?>
        </th>
    </tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'whiteList'); ?></th>
        <td>
            <?php echo $form->textArea($model, 'whiteList', array('class' => 'text-input-bj','rows'=>10,'cols'=>180)); ?>
            <!--  
            <textArea row='10' cols='180' name="CashHistory[whiteList]"><?php echo $model->whiteList;?></textArea>
           -->
            <?php echo $form->error($model, 'whiteList'); ?>
            (<?php echo Yii::t('home','多个gw号以英文逗号分隔') ?>)
        </td>
    </tr> 
    <tr>
        <th></th>
        <td>
            <?php echo CHtml::submitButton(Yii::t('home', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>
