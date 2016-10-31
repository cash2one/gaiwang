<?php
/* @var $this AppTopicCarCommentController */
/* @var $model AppTopicCarComment */
/* @var $form CActiveForm */
?>


<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'app-topic-car-comment-form',
    'enableClientValidation' => true,
    'enableAjaxValidation'=>false,
    'clientOptions' => array(
        'validateOnSubmit' => true,

    ),

    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">
    <tbody>
    <tr><th colspan="2" class="title-th even">编辑评论</th></tr>
    <tr>
        <th><?php echo $form->labelEx($model, 'content'); ?></th>
        <td>
            <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>100));?>
            <?php echo $form->error($model, 'content'); ?><br/>
        </td>
    </tr>

    </tbody>
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="0" class="tab-come">

    <tr>
        <th class="odd"></th>
        <td colspan="2" class="odd">
            <?php echo CHtml::submitButton(Yii::t('appTopicCar', '保存'), array('class' => 'reg-sub','style')); ?>
        </td>
    </tr>

</table>

<?php $this->endWidget(); ?>

