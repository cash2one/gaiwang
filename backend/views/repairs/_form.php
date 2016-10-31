<?php
/* @var $this RepairsController */
/* @var $model Repairs */
/* @var $form CActiveForm */
?>

<?php $this->breadcrumbs = array(Yii::t('repairs', '电话报修') => array('admin'), Yii::t('repairs', '查看')); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'repairs-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody><tr><td colspan="2" class="title-th even" align="center"><?php echo  Yii::t('advert', '查看电话报修'); ?></td></tr></tbody>
    <tbody>
        <tr>
            <th style="width: 220px" class="odd">
                <?php echo $form->labelEx($model, 'merchant'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'merchant', array('class' => 'text-input-bj  middle','disabled'=>'disabled')); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'address'); ?>
            </th>
            <td class="even">
                <?php echo $form->textField($model, 'address', array('class' => 'text-input-bj  middle','disabled'=>'disabled')); ?>
            </td>
        </tr>
		<tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'mobile'); ?>
            </th>
            <td class="odd">
                <?php echo $form->textField($model, 'mobile', array('class' => 'text-input-bj  middle','disabled'=>'disabled')); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'content'); ?>
            </th>
            <td class="even">
                <?php echo $form->textArea($model, 'content', array('rows'=>'8','cols'=>'60','class' => 'text-input-bj','disabled'=>'disabled')); ?>
            </td>
        </tr>

        <tr>
            <th class="odd">
                <?php echo $form->labelEx($model, 'status'); ?>
            </th>
            <td class="odd">
                <?php $model->status=Repairs::showStatus($model->status);
                      echo $form->textField($model, 'status', array('class' => 'text-input-bj  middle','disabled'=>'disabled')); ?>
            </td>
        </tr>
        <tr>
            <th class="even">
                <?php echo $form->labelEx($model, 'create_time'); ?>
            </th>
            <td class="even">
                <?php $model->create_time=date("Y-m-d H:i:s", $model->create_time);
                      echo $form->textField($model, 'create_time', array('class' => 'text-input-bj  middle','disabled'=>'disabled')); ?>
            </td>
        </tr>
    </tbody>
</table>
<?php $this->endWidget(); ?>

</div><!-- form -->