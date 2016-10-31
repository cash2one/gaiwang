<?php
/* @var $this ScategoryController */
/* @var $model Scategory */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'scategory-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<div class="mainContent">
    <div class="toolbar">
        <h3><?php echo $model->isNewRecord ? Yii::t('sellerScategory', '新增宝贝分类') : Yii::t('sellerScategory', '编辑宝贝分类') ?></h3>
    </div>
    <table width="100%" cellspacing="0" cellpadding="0" border="0" class="mt15 sellerT3">
        <tbody>
            <tr>
                <th width="10%"><b class="red">*</b><?php echo $form->labelEx($model, 'name'); ?></th>
                <td width="90%">
					<?php echo $form->textField($model, 'name', array('style' => 'width:145px', 'class' => 'inputtxt1')); ?>
                	<?php echo $form->error($model, 'name'); ?>
                
                </td>
            </tr>
            <tr>
                <th><?php echo $form->labelEx($model, 'parent_id'); ?></th>
                <td>
                    <?php echo $form->dropDownList($model, 'parent_id', Scategory::getListData($this->getSession('storeId')), array('prompt' => Yii::t('sellerScategory', '顶级分类'))); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form->labelEx($model, 'description'); ?></th>
                <td>
                	<?php echo $form->textArea($model, 'description', array('style' => 'width:80%; height:100px;', 'class' => 'textareaTxt1')); ?>
                	<?php echo $form->error($model, 'description'); ?>
                </td>
            </tr>

        </tbody></table>
    <div class="mt15 profileDo"> 
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('sellerScategory', '新增') : Yii::t('sellerScategory', '保存'), array('class' => 'sellerInputBtn01')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>



