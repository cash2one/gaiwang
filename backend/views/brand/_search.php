<?php
/* @var $this BrandController */
/* @var $model Brand */
/* @var $form CActiveForm */
?> 

<div class="border-info clearfix search-form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="searchT01">
        <tbody>
        <tr>
            <th ><?php echo $form->label($model, 'name'); ?>：</th>
            <td ><?php echo $form->textField($model, 'name', array('class' => 'text-input-bj  middle','style'=>'width:90%')); ?></td>
            
            <th ><?php echo $form->label($model, 'code'); ?>：</th>
            <td ><?php echo $form->textField($model, 'code', array('class' => 'text-input-bj  least' ,'style'=>'width:90%')); ?></td>
            
            <th ><?php echo $form->label($model, 'storeName'); ?>：</th>
            <td ><?php echo $form->textField($model, 'storeName', array('class' => 'text-input-bj  middle','style'=>'width:90%')); ?></td>
            
            <th ><?php echo $form->label($model, 'mobile'); ?>：</th>
            <td ><?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj  middle','style'=>'width:90%')); ?></td>
            
            <th ><?php echo $form->label($model, '审核状态'); ?>：</th>
            <td ><?php echo $form->radioButtonList($model, 'status', Brand::Status(), array('separator' => '')); ?></td>
        </tr>
        </tbody>
    </table>
    <?php echo CHtml::submitButton(Yii::t('brand','搜索'), array('class' => 'reg-sub')); ?>
    <?php $this->endWidget(); ?>

</div>