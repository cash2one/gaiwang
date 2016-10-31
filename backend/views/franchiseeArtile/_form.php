<?php
/* @var $this FranchiseeArtileController */
/* @var $model FranchiseeArtile */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchisee-artile-form',
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
        <td colspan="2" class="title-th even" align="center"><?php echo Yii::t('brand', '修改品牌'); ?></td>
    </tr>
    <tr><td colspan="2" class="odd"></td></tr>
    <tr>
        <th style="width:120px" class="even">
            <?php echo $form->labelEx($model, 'title'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'title', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'title'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'thumbnail'); ?><span class="required">*</span>
        </th>
        <td class="odd">
            <?php //echo $form->FileField($model, 'thumbnail', array('class' => 'text-input-bj middle')); ?>
            <?php echo CHtml::activeFileField($model, 'thumbnail', array('class' => 'text-input-bj middle')); ?> 
            <?php if (!$model->isNewRecord): ?>
                <input type="hidden" name="oldImg" value="<?php echo $model->thumbnail; ?>">
                <img src="<?php echo ATTR_DOMAIN; ?>/<?php echo $model->thumbnail ?>" width="100" height="35"/>
            <?php endif; ?>  
            <?php echo $form->error($model, 'thumbnail'); ?>
        </td>
    </tr>
    <tr>
        <th class="even">
            <?php echo $form->labelEx($model, 'external_links'); ?>
        </th>
        <td class="even">
            <?php echo $form->textField($model, 'external_links', array('class' => 'text-input-bj middle')); ?>
            <?php echo $form->error($model, 'external_links'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'views'); ?>
        </th>
        <td class="odd">
            <?php echo $model->views ?>
            <?php echo $form->error($model, 'views'); ?>
        </td>
    </tr>
    <tr>
        <th class="even">
            <?php echo $form->labelEx($model, 'status'); ?>
        </th>
        <td class="even">
            <?php echo $form->radioButtonList($model, 'status', FranchiseeArtile::status(), array('separator' => '')); ?>
            <?php echo $form->error($model, 'status'); ?>
        </td>
    </tr>
    <tr>
        <th class="odd">
            <?php echo $form->labelEx($model, 'content'); ?>
        </th>
        <td class="odd">
            <?php
            $this->widget('comext.wdueditor.WDueditor', array(
                'model' => $model,
                'attribute' => 'content',
            ));
            ?>
            <?php echo $form->error($model, 'content'); ?>
        </td>
    </tr>
    <tr>
        <th class="even"></th>
        <td colspan="2" class="even">
            <?php echo CHtml::submitButton(Yii::t('brand', '保存'), array('class' => 'reg-sub')); ?>
        </td>
    </tr>
</table>

<?php $this->endWidget(); ?>
