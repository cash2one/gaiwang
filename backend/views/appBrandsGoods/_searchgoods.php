<?php
/* @var $this OfflineSignStoreExtendController */
/* @var $model OfflineSignStoreExtend */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    )); ?>
    <div class="border-info clearfix search-form">
        <table cellpadding="0" cellspacing="0" class="searchTable">
            <tbody>
            <?php echo CHtml::hiddenField("brands_id",$brandsId)?>
            <tr>
                <th><?php echo $form->label($appBrandsModel, 'enTerName'); ?>：</th>
                <td><?php echo $form->dropDownList($appBrandsModel, 'enTer',AppBrands::getEnterType())?></td>
                <td><?php echo $form->textField($appBrandsModel, 'enTerTit', array('class' => 'text-input-bj  least')); ?></td>
            </tr>
            </tbody>
            <table cellpadding="0" cellspacing="0" class="searchTable">
                <tbody>
                <?php //echo CHtml::hiddenField("title",$goodModel->title,array('id'=>'role'))?>
                <tr>
                    <th><?php echo $form->label($appBrandsModel, 'goods'); ?>：</th>
                    <td><?php echo $form->dropDownList($appBrandsModel, 'goods',AppBrands::getGoodsType())?></td>
                    <td><?php echo $form->textField($appBrandsModel, 'goodsTit', array('class' => 'text-input-bj  least')); ?></td>
                </tr>
               </tbody>
        </table>
        <div class="c10"></div>
        <?php echo CHtml::submitButton(Yii::t('hotelOrder', '搜索'), array('class' => 'reg-sub','id'=>'serach-btn')); ?>
    </div>
    <?php $this->endWidget(); ?>