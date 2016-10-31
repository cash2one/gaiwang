<?php
/* @var $this GuestbookController */
/* @var $model Guestbook */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'guestbook-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true, //客户端验证
    ),
        ));
?>

<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <td colspan="2" class="title-th even" align="center"><?php echo $model->isNewRecord ? Yii::t('brand', '商品咨询 ') : Yii::t('brand', '商品咨询编辑'); ?></td>
    </tr>
    <tr><td colspan="2" class="odd"></td></tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'gai_number'); ?>
        </th>
        <td class="even">
            <?php echo $model->gai_number ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'goodsName'); ?>
        </th>
        <td class="odd">
            <?php
//                Tool::pr($model->goods);
            ?>
            <?php echo isset($model->goods->name) ? $model->goods->name : ''; ?>
        </td>
    </tr>
    <tr>
        <th class="even">
            <?php echo $form->labelEx($model, 'description'); ?>
        </th>
        <td class="even">
            <?php echo $model->description ?>
        </td>
    </tr>
    <tr>
        <th class="odd"><?php echo $form->labelEx($model, 'content'); ?></th>
        <td class="odd">
            <?php echo $model->content ?>
        </td>
    </tr>
    <tr>
        <th class="even"><?php echo $form->labelEx($model, 'reply_content'); ?></th>
        <td class="even" style="padding:30px;">
            <?php echo $form->textArea($model, 'reply_content', array('class' => 'text-input-bj  text-area valid')); ?>
            <?php echo $form->error($model, 'reply_content'); ?>    
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'status'); ?>
        </th>
        <td class="odd">
            <?php echo $form->radioButtonList($model, 'status', Guestbook::status(), array('separator' => '')) ?>
            <?php echo $form->error($model, 'status'); ?>    
        </td>
    </tr>
    <tr>
        <th class="even"></th>
        <td colspan="2" class="even">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('brand', '新增 ') : Yii::t('brand', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>
