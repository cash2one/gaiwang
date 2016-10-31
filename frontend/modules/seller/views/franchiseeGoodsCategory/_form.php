<?php
/* @var $this ScategoryController */
/* @var $model Scategory */
/* @var $form CActiveForm */
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'franchiseeGoodsCategory-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
        ));
?>

<div class="mainContent">
    <div class="toolbar">
        <h3><?php echo $model->isNewRecord ? Yii::t('franchiseeGoodsCategory', '新增线下商品分类') : Yii::t('franchiseeGoodsCategory', '编辑线下商品分类') ?></h3>
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
                    <?php echo $form->dropDownList($model, 'parent_id', FranchiseeGoodsCategory::getListData($franchisee_id), array('prompt' => Yii::t('franchiseeGoodsCategory', '顶级分类'))); ?>
                </td>
            </tr>


        </tbody></table>
    <div class="mt15 profileDo"> 
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('franchiseeGoodsCategory', '新增') : Yii::t('franchiseeGoodsCategory', '保存'), array('class' => 'sellerInputBtn01')); ?>
    </div>
</div>

<?php $this->endWidget(); ?>



