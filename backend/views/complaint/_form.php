<?php
/* @var $this ComplaintController */
/* @var $model Complaint */
/* @var $form CActiveForm */
?>

<?php $this->breadcrumbs = array(Yii::t('complaint', '投诉建议') => array('admin'), Yii::t('complaint', '查看')); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'complaint-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo  Yii::t('Complaint', '查看投诉建议'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'linkman'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'linkman', array('class' => 'text-input-bj  middle','disabled'=>'disabled')); ?>
            </td>
        </tr>
		<tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'mobile'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj  middle','disabled'=>'disabled')); ?>
            </td>
        </tr>
        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'content'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textArea($model, 'content', array('rows'=>'8','cols'=>'60','class' => 'text-input-bj','disabled'=>'disabled')); ?>
            </td>
        </tr>

        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'source'); ?>
            </th>
            <td class="even">
                <?php $model->source=Complaint::showSource($model->source);
                      echo $form->textField($model, 'source', array('class' => 'text-input-bj  middle','disabled'=>'disabled')); ?>
            </td>
        </tr>
        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'create_time'); ?>
            </th>
            <td class="odd">
                <?php $model->create_time=date("Y-m-d H:i:s", $model->create_time); 
                echo $form->textField($model, 'create_time', array('class' => 'text-input-bj  middle','disabled'=>'disabled')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>

</div><!-- form -->