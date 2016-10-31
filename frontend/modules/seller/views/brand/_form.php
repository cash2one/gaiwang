<?php
/* @var $this BrandController */
/* @var $model Brand */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => $this->id . '-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
));
?>

<div class="mainContent">
    <div class="toolbar">
        <h3><?php echo Yii::t('sellerBrand', '添加品牌') ?></h3>
    </div>

    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-top:7px;" class="sellerT3">
        <tbody><tr>
                <th width="10%"><?php echo $form->labelEx($model, 'name'); ?></th>
                <td width="90%">
                    <?php echo $form->textField($model, 'name', array('class' => 'inputtxt1', 'style' => 'width:330px')); ?>
                    <?php echo $form->error($model,'name') ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form->labelEx($model, 'code'); ?></th>
                <td> 
                    <?php echo $form->textField($model, 'code', array('class' => 'inputtxt1', 'style' => 'width:330px')); ?>
                    <?php echo $form->error($model,'code') ?>
                </td>	
            </tr>
            <tr>
                <th><?php echo $form->labelEx($model, 'logo'); ?></th>
                <td> 
                    <?php echo $form->FileField($model, 'logo', array('class' => 'text-input-bj middle')); ?>&nbsp;<span style="color: red">（<?php echo Yii::t('sellerBrand', '建议上传300*100像素的图片') ?>）</span>
                    <?php if (!$model->isNewRecord): ?>
                        <br />
                        <input type="hidden" name="oldImg" value="<?php echo $model->logo; ?>">
                        <img src="<?php echo IMG_DOMAIN; ?>/<?php echo $model->logo ?>" width="100" height="35"/>
                    <?php endif; ?>
                    <?php echo $form->error($model,'logo') ?>
                </td>	
            </tr>
        </tbody></table>
    <div class="mt15 profileDo"><?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('sellerBrand', '新增') :Yii::t('sellerBrand', '保存'), array('class' => 'sellerBtn06')); ?></div>
</div>

<?php $this->endWidget(); ?>


