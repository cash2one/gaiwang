<div class="border-info clearfix search-form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>
    <table cellpadding="0" cellspacing="0" class="searchT01">
        <tr>
            <th ><?php echo Yii::t('abnormal','名称'); ?>：</th>
            <td><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle', 'style' => 'width:90%')); ?></td>
         <th ><?php echo Yii::t('abnormal','所属会员'); ?>：</th>
            <td><?php echo $form->textField($model, 'gai_number', array('class' => 'text-input-bj  middle', 'style' => 'width:90%')); ?></td>
        
        </tr>
       
        <tr>
            <th class="ta_c"><?php echo CHtml::submitButton(Yii::t('abnormal', '搜索'), array('class' => 'reg-sub')); ?>
     
            </th>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>
<style>
    #yw1{width: 120px;}
    #yw2{width: 120px;}
</style>