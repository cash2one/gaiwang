<?php
/* @var $this ArticleCategoryController */
/* @var $model ArticleCategory */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'promotionStatistics-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>
<table width="100%" border="0" cellspacing="1" class="tab-come" cellpadding="0">
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'name'); ?>：
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'name', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'name'); ?>
        </td>
    </tr>
    
     <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'number'); ?>：
        </th>
        <td class="even">
           <?php echo $model->number;?>
           <?php echo $form->hiddenField($model, 'number', array('class' => 'text-input-bj middle','readOnly'=>'readOnly')); ?> 
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'remark'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->textArea($model, 'remark', array('class' => 'text-input-bj middle')); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'register_type'); ?>：
        </th>
        <td class="odd">
            <?php echo $form->dropDownList($model, 'register_type', PromotionChannels::getLoginType(), array('class' => 'text-input-bj middle')); ?>
        </td>
    </tr>
    <tr>
        <th class="odd"></th>
        <td class="odd">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('articleCategory', '添加') : Yii::t('articleCategory', '提交'), array('class' => 'reg-sub')); ?>  
           <?php if (empty($model->isNewRecord)):?>
           <a class = 'reg-sub' href="<?php echo Yii::app()->createUrl("PromotionStatistics/view",array("id"=>$model->id)) ?>">取消</a>
           <?php endif;?>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>